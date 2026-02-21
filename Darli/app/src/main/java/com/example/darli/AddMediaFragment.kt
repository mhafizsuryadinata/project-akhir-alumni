package com.example.darli

import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.*
import androidx.fragment.app.Fragment
import com.bumptech.glide.Glide
import com.example.darli.data.model.AlbumMediaResponse
import com.example.darli.data.network.ApiClient
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream
import androidx.navigation.fragment.findNavController
import androidx.fragment.app.setFragmentResult

class AddMediaFragment : Fragment() {

    private val PICK_MEDIA_REQUEST = 102
    private var selectedMediaUri: Uri? = null
    private var albumId: Int = -1

    private lateinit var ivPreview: ImageView
    private lateinit var ivVideoIcon: ImageView
    private lateinit var llPrompt: LinearLayout
    private lateinit var etCaption: EditText
    private lateinit var flLoading: FrameLayout
    private lateinit var sessionManager: SessionManager

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        albumId = arguments?.getInt("album_id") ?: -1
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_add_media, container, false)

        sessionManager = SessionManager(requireContext())

        ivPreview = view.findViewById(R.id.ivPreview)
        ivVideoIcon = view.findViewById(R.id.ivVideoIcon)
        llPrompt = view.findViewById(R.id.llPrompt)
        etCaption = view.findViewById(R.id.etCaption)
        flLoading = view.findViewById(R.id.flLoading)

        view.findViewById<ImageButton>(R.id.btnClose).setOnClickListener {
            findNavController().navigateUp()
        }

        view.findViewById<Button>(R.id.btnCancel).setOnClickListener {
            findNavController().navigateUp()
        }

        view.findViewById<FrameLayout>(R.id.flFilePicker).setOnClickListener {
            openMediaPicker()
        }

        view.findViewById<Button>(R.id.btnUpload).setOnClickListener {
            uploadMedia()
        }

        return view
    }

    private fun openMediaPicker() {
        val intent = Intent(Intent.ACTION_GET_CONTENT).apply {
            type = "*/*"
            putExtra(Intent.EXTRA_MIME_TYPES, arrayOf("image/*", "video/*"))
        }
        startActivityForResult(Intent.createChooser(intent, "Pilih Foto atau Video"), PICK_MEDIA_REQUEST)
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == PICK_MEDIA_REQUEST && resultCode == Activity.RESULT_OK && data != null) {
            selectedMediaUri = data.data
            selectedMediaUri?.let { uri ->
                llPrompt.visibility = View.GONE
                ivPreview.visibility = View.VISIBLE
                
                val mimeType = context?.contentResolver?.getType(uri) ?: ""
                if (mimeType.startsWith("video")) {
                    ivVideoIcon.visibility = View.VISIBLE
                    // For video, we show a standard icon or thumbnail if possible
                    ivPreview.setImageResource(R.drawable.bg_rounded_pill_white_alpha)
                } else {
                    ivVideoIcon.visibility = View.GONE
                    Glide.with(this).load(uri).centerCrop().into(ivPreview)
                }
            }
        }
    }

    private fun uploadMedia() {
        val uri = selectedMediaUri
        if (uri == null) {
            Toast.makeText(requireActivity().applicationContext, "Pilih file terlebih dahulu", Toast.LENGTH_SHORT).show()
            return
        }

        val file = getFileFromUri(uri) ?: return
        val mimeType = context?.contentResolver?.getType(uri) ?: "image/jpeg"
        val tipe = if (mimeType.contains("video")) "video" else "foto"
        val caption = etCaption.text.toString().trim().ifEmpty { "Uploaded from Android" }

        flLoading.visibility = View.VISIBLE
        val btnUpload = view?.findViewById<Button>(R.id.btnUpload)
        btnUpload?.isEnabled = false

        val requestFile = file.asRequestBody(mimeType.toMediaTypeOrNull())
        val body = MultipartBody.Part.createFormData("file", file.name, requestFile)
        
        val albumIdBody = albumId.toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val idUserBody = sessionManager.getUserId().toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val tipeBody = tipe.toRequestBody("text/plain".toMediaTypeOrNull())
        val descBody = caption.toRequestBody("text/plain".toMediaTypeOrNull())

        ApiClient.instance.storeMedia(albumIdBody, idUserBody, tipeBody, descBody, body)
            .enqueue(object : Callback<com.example.darli.data.model.GeneralResponse> {
                override fun onResponse(call: Call<com.example.darli.data.model.GeneralResponse>, response: Response<com.example.darli.data.model.GeneralResponse>) {
                    if (!isAdded) return
                    flLoading.visibility = View.GONE
                    btnUpload?.isEnabled = true
                    if (response.isSuccessful) {
                        // 1. Notify AlbumDetailFragment to refresh
                        val result = Bundle().apply { putBoolean("refresh", true) }
                        setFragmentResult("upload_result", result)

                        // 2. Navigate back immediately
                        findNavController().navigateUp()

                        // 3. Try to show toast (at activity level)
                        activity?.let {
                            Toast.makeText(it.applicationContext, "Media berhasil diupload!", Toast.LENGTH_LONG).show()
                        }
                    } else {
                        context?.let {
                            Toast.makeText(it.applicationContext, "Gagal upload: ${response.code()}", Toast.LENGTH_SHORT).show()
                        }
                    }
                }

                override fun onFailure(call: Call<com.example.darli.data.model.GeneralResponse>, t: Throwable) {
                    if (!isAdded) return
                    flLoading.visibility = View.GONE
                    btnUpload?.isEnabled = true
                    context?.let {
                        Toast.makeText(it.applicationContext, "Kesalahan: ${t.message}", Toast.LENGTH_SHORT).show()
                    }
                }
            })
    }

    private fun getFileFromUri(uri: Uri): File? {
        return try {
            val inputStream = context?.contentResolver?.openInputStream(uri) ?: return null
            val mimeType = context?.contentResolver?.getType(uri)
            val extension = when {
                mimeType == "video/mp4" -> ".mp4"
                mimeType == "image/png" -> ".png"
                mimeType == "image/webp" -> ".webp"
                mimeType == "image/jpeg" -> ".jpg"
                else -> ".jpg"
            }
            val file = File(context?.cacheDir, "upload_" + System.currentTimeMillis() + extension)
            inputStream.use { input ->
                FileOutputStream(file).use { output ->
                    input.copyTo(output)
                }
            }
            file
        } catch (e: Exception) {
            null
        }
    }
}
