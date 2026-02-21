package com.example.darli

import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.provider.MediaStore
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.*
import androidx.fragment.app.Fragment
import com.bumptech.glide.Glide
import com.example.darli.data.model.GeneralResponse
import com.example.darli.data.network.ApiClient
import androidx.navigation.fragment.findNavController
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream

class AddAlbumFragment : Fragment() {

    private val PICK_IMAGE_REQUEST = 101
    private var selectedImageUri: Uri? = null

    private lateinit var ivCoverPreview: ImageView
    private lateinit var llUploadPrompt: LinearLayout
    private lateinit var etNamaAlbum: EditText
    private lateinit var spinnerKategori: Spinner
    private lateinit var etTahun: EditText
    private lateinit var etDeskripsi: EditText
    private lateinit var flLoading: FrameLayout
    private lateinit var sessionManager: SessionManager

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_add_album, container, false)

        sessionManager = SessionManager(requireContext())

        view.findViewById<ImageButton>(R.id.btnBack).setOnClickListener {
            findNavController().popBackStack()
        }

        ivCoverPreview = view.findViewById(R.id.ivCoverPreview)
        llUploadPrompt = view.findViewById(R.id.llUploadPrompt)
        etNamaAlbum = view.findViewById(R.id.etNamaAlbum)
        spinnerKategori = view.findViewById(R.id.spinnerKategori)
        etTahun = view.findViewById(R.id.etTahun)
        etDeskripsi = view.findViewById(R.id.etDeskripsi)
        flLoading = view.findViewById(R.id.flLoading)

        setupSpinner()

        view.findViewById<FrameLayout>(R.id.flImagePicker).setOnClickListener {
            openImagePicker()
        }

        view.findViewById<Button>(R.id.btnSubmit).setOnClickListener {
            submitAlbum()
        }

        return view
    }

    private fun setupSpinner() {
        val categories = arrayOf("Pilih Kategori", "Reuni", "Kegiatan Pesantren", "Foto Angkatan", "Event")
        val adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_item, categories)
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        spinnerKategori.adapter = adapter
    }

    private fun openImagePicker() {
        val intent = Intent(Intent.ACTION_GET_CONTENT).apply {
            type = "image/*"
        }
        startActivityForResult(Intent.createChooser(intent, "Pilih Cover Album"), PICK_IMAGE_REQUEST)
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == PICK_IMAGE_REQUEST && resultCode == Activity.RESULT_OK && data != null) {
            selectedImageUri = data.data
            selectedImageUri?.let {
                llUploadPrompt.visibility = View.GONE
                ivCoverPreview.visibility = View.VISIBLE
                Glide.with(this).load(it).centerCrop().into(ivCoverPreview)
            }
        }
    }

    private fun submitAlbum() {
        val namaAlbum = etNamaAlbum.text.toString().trim()
        val kategoriPosition = spinnerKategori.selectedItemPosition
        val tahun = etTahun.text.toString().trim()
        val deskripsi = etDeskripsi.text.toString().trim()

        if (namaAlbum.isEmpty()) {
            Toast.makeText(context, "Nama Album harus diisi", Toast.LENGTH_SHORT).show()
            return
        }

        if (kategoriPosition == 0) {
            Toast.makeText(context, "Silakan pilih kategori", Toast.LENGTH_SHORT).show()
            return
        }

        val kategori = spinnerKategori.selectedItem.toString()
        val idUser = sessionManager.getUserId().toString()

        flLoading.visibility = View.VISIBLE

        val idUserPart = idUser.toRequestBody("text/plain".toMediaTypeOrNull())
        val namaAlbumPart = namaAlbum.toRequestBody("text/plain".toMediaTypeOrNull())
        val kategoriPart = kategori.toRequestBody("text/plain".toMediaTypeOrNull())
        
        var tahunPart: okhttp3.RequestBody? = null
        if (tahun.isNotEmpty()) {
            tahunPart = tahun.toRequestBody("text/plain".toMediaTypeOrNull())
        }
        
        var deskripsiPart: okhttp3.RequestBody? = null
        if (deskripsi.isNotEmpty()) {
            deskripsiPart = deskripsi.toRequestBody("text/plain".toMediaTypeOrNull())
        }

        var imagePart: MultipartBody.Part? = null
        selectedImageUri?.let { uri ->
            val file = getFileFromUri(uri)
            if (file != null) {
                val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                imagePart = MultipartBody.Part.createFormData("cover", file.name, requestFile)
            }
        }

        ApiClient.instance.storeAlbum(
            idUserPart,
            namaAlbumPart,
            kategoriPart,
            tahunPart,
            deskripsiPart,
            imagePart
        ).enqueue(object : Callback<GeneralResponse> {
            override fun onResponse(call: Call<GeneralResponse>, response: Response<GeneralResponse>) {
                if (!isAdded) return
                flLoading.visibility = View.GONE

                if (response.isSuccessful) {
                    Toast.makeText(context, "Album berhasil dibuat dan menunggu persetujuan", Toast.LENGTH_LONG).show()
                    findNavController().popBackStack()
                } else {
                    Toast.makeText(context, "Gagal menambahkan album", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<GeneralResponse>, t: Throwable) {
                if (!isAdded) return
                flLoading.visibility = View.GONE
                Toast.makeText(context, "Kesalahan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun getFileFromUri(uri: Uri): File? {
        val inputStream = context?.contentResolver?.openInputStream(uri) ?: return null
        val file = File(context?.cacheDir, "cover_album_" + System.currentTimeMillis() + ".jpg")
        val outputStream = FileOutputStream(file)
        inputStream.copyTo(outputStream)
        outputStream.close()
        inputStream.close()
        return file
    }
}
