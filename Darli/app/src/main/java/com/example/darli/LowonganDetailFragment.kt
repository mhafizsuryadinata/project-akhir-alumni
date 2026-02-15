package com.example.darli
 
 import android.os.Bundle
 import android.view.LayoutInflater
 import android.view.View
 import android.view.ViewGroup
 import android.widget.TextView
 import android.widget.ImageView
 import android.widget.Toast
 import androidx.fragment.app.Fragment
 import com.bumptech.glide.Glide
 import com.example.darli.data.model.Lowongan
 import com.google.android.material.button.MaterialButton
 import com.google.android.material.tabs.TabLayout
 import androidx.navigation.fragment.findNavController
import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.provider.OpenableColumns
import com.example.darli.data.network.ApiClient
import com.example.darli.data.model.ApplyResponse
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream
 
 class LowonganDetailFragment : Fragment() {
 
     private lateinit var sessionManager: SessionManager
     private var lowongan: Lowongan? = null
     private var selectedFileUri: Uri? = null
     private var selectedFileName: String? = null
 
     companion object {
         private const val ARG_LOWONGAN = "arg_lowongan"
         private const val PICK_FILE_REQUEST = 1001
 
         fun newInstance(lowongan: Lowongan): LowonganDetailFragment {
             val fragment = LowonganDetailFragment()
             val args = Bundle()
             args.putSerializable(ARG_LOWONGAN, lowongan)
             fragment.arguments = args
             return fragment
         }
     }
 
     override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == PICK_FILE_REQUEST && resultCode == Activity.RESULT_OK) {
            data?.data?.let { uri ->
                selectedFileUri = uri
                selectedFileName = getFileName(uri)
                Toast.makeText(requireContext(), "File terpilih: $selectedFileName", Toast.LENGTH_SHORT).show()
            }
        }
    }

    private fun getFileName(uri: Uri): String {
        var result: String? = null
        if (uri.scheme == "content") {
            val cursor = requireContext().contentResolver.query(uri, null, null, null, null)
            try {
                if (cursor != null && cursor.moveToFirst()) {
                    val nameIndex = cursor.getColumnIndex(OpenableColumns.DISPLAY_NAME)
                    if (nameIndex != -1) {
                        result = cursor.getString(nameIndex)
                    }
                }
            } finally {
                cursor?.close()
            }
        }
        if (result == null) {
            result = uri.path
            val cut = result?.lastIndexOf('/')
            if (cut != -1 && cut != null) {
                result = result.substring(cut + 1)
            }
        }
        return result ?: "file"
    }

    private fun showApplyDialog() {
        val dialogView = LayoutInflater.from(requireContext()).inflate(R.layout.dialog_apply_job, null)
        val etCoverLetter = dialogView.findViewById<android.widget.EditText>(R.id.etCoverLetter)
        val btnSelectCV = dialogView.findViewById<MaterialButton>(R.id.btnSelectCV)
        val tvSelectedFile = dialogView.findViewById<TextView>(R.id.tvSelectedFile)

        if (selectedFileName != null) {
            tvSelectedFile.text = selectedFileName
            tvSelectedFile.visibility = View.VISIBLE
        }

        btnSelectCV.setOnClickListener {
            val intent = Intent(Intent.ACTION_GET_CONTENT)
            intent.type = "*/*"
            val mimeTypes = arrayOf("application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
            intent.putExtra(Intent.EXTRA_MIME_TYPES, mimeTypes)
            startActivityForResult(intent, PICK_FILE_REQUEST)
        }

        com.google.android.material.dialog.MaterialAlertDialogBuilder(requireContext())
            .setTitle("Lamar Lowongan")
            .setView(dialogView)
            .setPositiveButton("Kirim Lamaran") { dialog, _ ->
                val coverLetter = etCoverLetter.text.toString()
                performApply(coverLetter)
                dialog.dismiss()
            }
            .setNegativeButton("Batal") { dialog, _ ->
                dialog.dismiss()
            }
            .show()
    }

    private fun performApply(coverLetter: String) {
        val job = lowongan ?: return
        val userId = sessionManager.getUserId() ?: return

        val mediaType = "text/plain".toMediaTypeOrNull()
        val lowonganIdBody = job.id.toString().toRequestBody(mediaType)
        val userIdBody = userId.toString().toRequestBody(mediaType)
        val coverLetterBody = coverLetter.toRequestBody(mediaType)

        var cvPart: MultipartBody.Part? = null
        selectedFileUri?.let { uri ->
            val file = getFileFromUri(uri)
            if (file != null) {
                val requestFile = file.asRequestBody(requireContext().contentResolver.getType(uri)?.toMediaTypeOrNull())
                cvPart = MultipartBody.Part.createFormData("cv", file.name, requestFile)
            }
        }

        Toast.makeText(requireContext(), "Mengirim lamaran...", Toast.LENGTH_SHORT).show()

        ApiClient.instance.applyLowongan(lowonganIdBody, userIdBody, coverLetterBody, cvPart)
            .enqueue(object : Callback<ApplyResponse> {
                override fun onResponse(call: Call<ApplyResponse>, response: Response<ApplyResponse>) {
                    if (response.isSuccessful) {
                        Toast.makeText(requireContext(), response.body()?.message ?: "Lamaran berhasil dikirim", Toast.LENGTH_LONG).show()
                        selectedFileUri = null
                        selectedFileName = null
                    } else {
                        Toast.makeText(requireContext(), "Gagal: ${response.message()}", Toast.LENGTH_SHORT).show()
                    }
                }

                override fun onFailure(call: Call<ApplyResponse>, t: Throwable) {
                    Toast.makeText(requireContext(), "Error: ${t.message}", Toast.LENGTH_SHORT).show()
                    t.printStackTrace()
                }
            })
    }

    private fun getFileFromUri(uri: Uri): File? {
        try {
            val inputStream = requireContext().contentResolver.openInputStream(uri) ?: return null
            val file = File(requireContext().cacheDir, getFileName(uri))
            val outputStream = FileOutputStream(file)
            inputStream.copyTo(outputStream)
            inputStream.close()
            outputStream.close()
            return file
        } catch (e: Exception) {
            e.printStackTrace()
            return null
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_lowongan_detail, container, false)
        sessionManager = SessionManager(requireContext())

        // Retrieve Data
        lowongan = arguments?.getSerializable(ARG_LOWONGAN) as? Lowongan

        setupUI(view)

        return view
    }
 
     private fun setupUI(view: View) {
         val ivLogo = view.findViewById<ImageView>(R.id.ivLogo)
         val tvTitle = view.findViewById<TextView>(R.id.tvJobTitle)
         val tvCompany = view.findViewById<TextView>(R.id.tvCompanyInfo)
         val tvLocation = view.findViewById<TextView>(R.id.tvLocation)
         val tvSalary = view.findViewById<TextView>(R.id.tvSalary)
         val tvDeadline = view.findViewById<TextView>(R.id.tvDeadline)
         val tvDescription = view.findViewById<TextView>(R.id.tvDescription)
         val btnAction = view.findViewById<MaterialButton>(R.id.btnAction)
         val btnBack = view.findViewById<ImageView>(R.id.btnBack)
         val tabLayout = view.findViewById<TabLayout>(R.id.tabLayout)
 
         btnBack.setOnClickListener {
             findNavController().popBackStack()
         }
 
         lowongan?.let { job ->
             tvTitle.text = job.judul
             tvCompany.text = "${job.perusahaan} • ${job.tipe_pekerjaan ?: "N/A"}"
             tvLocation.text = job.lokasi ?: "Remote"
             tvSalary.text = job.gaji ?: "Undisclosed"
             tvDeadline.text = "Berakhir: ${job.tanggal_tutup ?: "-"}"
             tvDescription.text = job.deskripsi ?: "Tidak ada deskripsi."
             
             // Initial Tab State (Description)
             updateTabContent(0, job, tvDescription)
 
             if (!job.logo.isNullOrEmpty()) {
                 val imageUrl = job.logo.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
                 Glide.with(this)
                     .load(imageUrl)
                     .placeholder(R.drawable.ic_work)
                     .error(R.drawable.ic_work)
                     .into(ivLogo)
             }
 
             // Owner Check
             val currentUserId = sessionManager.getUserId()
             if (job.user_id == currentUserId) {
                 btnAction.text = "Manage Vacancy"
                 btnAction.setBackgroundColor(resources.getColor(R.color.brand_secondary)) // Use secondary color for manage
                 btnAction.setOnClickListener {
                     // Navigate to Manage Vacancy Fragment
                     val bundle = Bundle().apply {
                         putSerializable("arg_lowongan", job)
                     }
                     findNavController().navigate(R.id.manageVacancyFragment, bundle)
                 }
             } else {
                 btnAction.text = "Lamar Sekarang"
                 btnAction.setOnClickListener {
                     showApplyDialog()
                 }
             }
             
             // Tab Listener
             tabLayout.addOnTabSelectedListener(object : TabLayout.OnTabSelectedListener {
                 override fun onTabSelected(tab: TabLayout.Tab?) {
                     updateTabContent(tab?.position ?: 0, job, tvDescription)
                 }
                 override fun onTabUnselected(tab: TabLayout.Tab?) {}
                 override fun onTabReselected(tab: TabLayout.Tab?) {}
             })
         }
     }
     
     private fun updateTabContent(position: Int, job: Lowongan, tvContent: TextView) {
         when (position) {
             0 -> { // Deskripsi
                 tvContent.text = job.deskripsi ?: "Tidak ada deskripsi."
             }
             1 -> { // Kualifikasi
                 tvContent.text = job.kualifikasi ?: "Tidak ada data kualifikasi."
             }
             2 -> { // Benefit (No data yet)
                 tvContent.text = "Informasi benefit belum tersedia."
             }
         }
     }
 }
