package com.example.darli

import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.provider.MediaStore
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.LinearLayout
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.AlbumMediaAdapter
import com.example.darli.data.network.ApiClient
import com.example.darli.data.model.AlbumMediaResponse
import com.example.darli.data.model.AlbumMediaItem
import com.google.gson.Gson
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream

class AlbumDetailFragment : Fragment() {

    private var albumId: Int = 0
    private var albumName: String = ""
    private lateinit var adapter: AlbumMediaAdapter
    private lateinit var sessionManager: SessionManager
    private val PICK_IMAGE_VIDEO = 1001

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        albumId = arguments?.getInt("album_id") ?: 0
        albumName = arguments?.getString("album_name") ?: "Album"
    }

    private var currentMediaList: List<AlbumMediaItem> = emptyList()

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_album_detail, container, false)
        sessionManager = SessionManager(requireContext())

        view.findViewById<TextView>(R.id.tvAlbumName).text = albumName
        view.findViewById<ImageButton>(R.id.btnBack).setOnClickListener {
            parentFragmentManager.popBackStack()
        }

        val recyclerView = view.findViewById<RecyclerView>(R.id.rvMedia)
        adapter = AlbumMediaAdapter(emptyList(), { media ->
            if (adapter.isSelectionMode) {
                updateActionMode(view)
            } else {
                openMediaSlider(media)
            }
        }, { media ->
            updateActionMode(view)
        })
        recyclerView.adapter = adapter

        view.findViewById<View>(R.id.fabAddMedia).setOnClickListener {
            openPicker()
        }

        view.findViewById<ImageButton>(R.id.btnActionMenu).setOnClickListener {
            showActionMenu()
        }

        fetchMedia(view)

        return view
    }

    private fun updateActionMode(view: View) {
        val btnActionMenu = view.findViewById<ImageButton>(R.id.btnActionMenu)
        btnActionMenu.visibility = View.VISIBLE
    }

    private fun showActionMenu() {
        val selectedItems = adapter.getSelectedItems()
        val options = if (selectedItems.isNotEmpty()) {
            arrayOf("Urutkan (Terbaru/Terlama)", "Bagikan (${selectedItems.size})", "Download (${selectedItems.size})", "Batal Pilih")
        } else {
            arrayOf("Urutkan (Terbaru/Terlama)")
        }

        AlertDialog.Builder(requireContext())
            .setTitle("Opsi")
            .setItems(options) { _, which ->
                val optionText = options[which]
                when {
                    optionText.startsWith("Urutkan") -> toggleSort()
                    optionText.startsWith("Bagikan") -> shareSelectedMedia(selectedItems)
                    optionText.startsWith("Download") -> downloadSelectedMedia(selectedItems)
                    optionText == "Batal Pilih" -> clearSelection()
                }
            }
            .show()
    }

    private var isSortDescending = true

    private fun toggleSort() {
        isSortDescending = !isSortDescending
        val sortedList = if (isSortDescending) {
            currentMediaList.sortedByDescending { it.id }
        } else {
            currentMediaList.sortedBy { it.id }
        }
        adapter.updateData(sortedList)
    }

    private fun clearSelection() {
        adapter.clearSelection()
        view?.findViewById<ImageButton>(R.id.btnActionMenu)?.visibility = View.VISIBLE
    }

    private fun shareSelectedMedia(mediaList: List<AlbumMediaItem>) {
        if (mediaList.isEmpty()) return
        val intent = Intent(Intent.ACTION_SEND_MULTIPLE)
        intent.type = "*/*"
        
        // Use text links for sharing instead of file providers for simplicity for now
        val links = mediaList.joinToString("\n") { it.filePath ?: "" }
        intent.putExtra(Intent.EXTRA_TEXT, "Lihat media ini di Alumni Gallery:\n$links")
        
        startActivity(Intent.createChooser(intent, "Bagikan via"))
        clearSelection()
    }

    private fun downloadSelectedMedia(mediaList: List<AlbumMediaItem>) {
        if (mediaList.isEmpty()) return
        mediaList.forEach { media ->
            val intent = Intent(Intent.ACTION_VIEW, Uri.parse(media.filePath))
            startActivity(intent)
        }
        Toast.makeText(context, "Membuka link download untuk ${mediaList.size} item...", Toast.LENGTH_SHORT).show()
        clearSelection()
    }

    private fun fetchMedia(view: View) {
        val progressBar = view.findViewById<ProgressBar>(R.id.progressBar)
        val emptyState = view.findViewById<LinearLayout>(R.id.emptyState)
        
        progressBar.visibility = View.VISIBLE
        
        val idUser = sessionManager.getUserId().toString()
        
        ApiClient.instance.getAlbumMedia(albumId, idUser).enqueue(object : Callback<AlbumMediaResponse> {
            override fun onResponse(call: Call<AlbumMediaResponse>, response: Response<AlbumMediaResponse>) {
                if (!isAdded) return
                progressBar.visibility = View.GONE
                
                if (response.isSuccessful) {
                    currentMediaList = response.body()?.content ?: emptyList()
                    adapter.updateData(currentMediaList)
                    emptyState.visibility = if (currentMediaList.isEmpty()) View.VISIBLE else View.GONE
                } else {
                    Toast.makeText(context, "Gagal memuat media", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<AlbumMediaResponse>, t: Throwable) {
                if (!isAdded) return
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Kesalahan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun openMediaSlider(media: AlbumMediaItem) {
        val position = currentMediaList.indexOf(media)
        if (position != -1) {
            val bundle = Bundle().apply {
                putString("media_list", Gson().toJson(currentMediaList))
                putInt("initial_position", position)
            }
            findNavController().navigate(R.id.mediaSliderFragment, bundle)
        }
    }

    private fun openPicker() {
        val intent = Intent(Intent.ACTION_PICK)
        intent.type = "*/*"
        intent.putExtra(Intent.EXTRA_MIME_TYPES, arrayOf("image/*", "video/*"))
        startActivityForResult(intent, PICK_IMAGE_VIDEO)
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == PICK_IMAGE_VIDEO && resultCode == Activity.RESULT_OK) {
            data?.data?.let { uri ->
                uploadMedia(uri)
            }
        }
    }

    private fun uploadMedia(uri: Uri) {
        val file = getFileFromUri(uri) ?: return
        val mimeType = context?.contentResolver?.getType(uri) ?: "image/jpeg"
        val tipe = if (mimeType.contains("video")) "video" else "foto"

        val requestFile = file.asRequestBody(mimeType.toMediaTypeOrNull())
        val body = MultipartBody.Part.createFormData("file", file.name, requestFile)
        
        val albumIdBody = albumId.toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val idUserBody = sessionManager.getUserId().toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val tipeBody = tipe.toRequestBody("text/plain".toMediaTypeOrNull())
        val descBody = "Uploaded from app".toRequestBody("text/plain".toMediaTypeOrNull())

        Toast.makeText(context, "Mengunggah...", Toast.LENGTH_SHORT).show()

        ApiClient.instance.storeMedia(albumIdBody, idUserBody, tipeBody, descBody, body)
            .enqueue(object : Callback<AlbumMediaResponse> {
                override fun onResponse(call: Call<AlbumMediaResponse>, response: Response<AlbumMediaResponse>) {
                    if (!isAdded) return
                    if (response.isSuccessful) {
                        Toast.makeText(context, "Upload berhasil! Menunggu moderasi.", Toast.LENGTH_LONG).show()
                        fetchMedia(requireView())
                    } else {
                        Toast.makeText(context, "Gagal upload: ${response.code()}", Toast.LENGTH_SHORT).show()
                    }
                }

                override fun onFailure(call: Call<AlbumMediaResponse>, t: Throwable) {
                    if (!isAdded) return
                    Toast.makeText(context, "Kesalahan upload: ${t.message}", Toast.LENGTH_SHORT).show()
                }
            })
    }

    private fun getFileFromUri(uri: Uri): File? {
        val inputStream = context?.contentResolver?.openInputStream(uri) ?: return null
        val file = File(context?.cacheDir, "upload_temp_" + System.currentTimeMillis())
        val outputStream = FileOutputStream(file)
        inputStream.copyTo(outputStream)
        outputStream.close()
        inputStream.close()
        return file
    }
}
