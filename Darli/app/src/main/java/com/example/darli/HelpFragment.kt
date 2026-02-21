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
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.FaqAdapter
import com.example.darli.adapters.MessageHistoryAdapter
import com.example.darli.adapters.SupportTeamAdapter
import com.example.darli.data.model.ContactMessageResponse
import com.example.darli.data.model.FaqResponse
import com.example.darli.data.model.GeneralResponse
import com.example.darli.data.model.KontakUstadzResponse
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

class HelpFragment : Fragment() {

    private lateinit var sessionManager: SessionManager
    private lateinit var etName: EditText
    private lateinit var etEmail: EditText
    private lateinit var etMessage: EditText
    private lateinit var tvAttachmentName: TextView
    private lateinit var ivAttachmentPreview: ImageView
    private lateinit var spinnerSubject: Spinner

    // RecyclerViews
    private lateinit var rvSupportTeam: RecyclerView
    private lateinit var rvMessages: RecyclerView
    private lateinit var rvFaq: RecyclerView

    // Adapters
    private lateinit var supportTeamAdapter: SupportTeamAdapter
    private lateinit var messageHistoryAdapter: MessageHistoryAdapter
    private lateinit var faqAdapter: FaqAdapter

    // Loading/Empty states
    private lateinit var progressTeam: ProgressBar
    private lateinit var tvEmptyTeam: TextView
    private lateinit var progressMessages: ProgressBar
    private lateinit var tvEmptyMessages: TextView
    private lateinit var tvMessageCount: TextView
    private lateinit var progressFaq: ProgressBar
    private lateinit var tvEmptyFaq: TextView

    private val PICK_FILE_REQUEST = 103
    private var selectedFileUri: Uri? = null

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        return inflater.inflate(R.layout.fragment_help, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        sessionManager = SessionManager(requireContext())

        // Initialize Views
        val btnBack: ImageView = view.findViewById(R.id.btnBack)
        etName = view.findViewById(R.id.etName)
        etEmail = view.findViewById(R.id.etEmail)
        etMessage = view.findViewById(R.id.etMessage)
        tvAttachmentName = view.findViewById(R.id.tvAttachmentName)
        ivAttachmentPreview = view.findViewById(R.id.ivAttachmentPreview)
        spinnerSubject = view.findViewById(R.id.spinnerSubject)
        val layoutAttachment: LinearLayout = view.findViewById(R.id.layoutAttachment)
        val btnSendMessage: com.google.android.material.button.MaterialButton = view.findViewById(R.id.btnSendMessage)

        // RecyclerViews
        rvSupportTeam = view.findViewById(R.id.rvSupportTeam)
        rvMessages = view.findViewById(R.id.rvMessages)
        rvFaq = view.findViewById(R.id.rvFaq)

        // Loading/Empty
        progressTeam = view.findViewById(R.id.progressTeam)
        tvEmptyTeam = view.findViewById(R.id.tvEmptyTeam)
        progressMessages = view.findViewById(R.id.progressMessages)
        tvEmptyMessages = view.findViewById(R.id.tvEmptyMessages)
        tvMessageCount = view.findViewById(R.id.tvMessageCount)
        progressFaq = view.findViewById(R.id.progressFaq)
        tvEmptyFaq = view.findViewById(R.id.tvEmptyFaq)

        // Setup Back Button
        btnBack.setOnClickListener {
            findNavController().navigateUp()
        }

        // Auto-fill from Session
        val user = sessionManager.getUserDetails()
        etName.setText(user["name"])
        etEmail.setText(user["email"])

        // Setup Attachment Picker
        layoutAttachment.setOnClickListener {
            openFilePicker()
        }

        // Setup Send Button
        btnSendMessage.setOnClickListener {
            sendMessage()
        }

        setupSpinner()
        setupRecyclerViews()
        fetchSupportTeam()
        fetchFaqs()
        fetchMessages()
    }

    private fun setupSpinner() {
        val subjects = arrayOf(
            "Pilih subjek...",
            "Informasi Alumni",
            "Bantuan Teknis",
            "Event & Kegiatan",
            "Lowongan Kerja",
            "Lainnya"
        )

        val adapter = ArrayAdapter(
            requireContext(),
            android.R.layout.simple_spinner_item,
            subjects
        )
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        spinnerSubject.adapter = adapter
    }

    private fun setupRecyclerViews() {
        // Support Team - Horizontal
        supportTeamAdapter = SupportTeamAdapter(emptyList())
        rvSupportTeam.layoutManager = LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false)
        rvSupportTeam.adapter = supportTeamAdapter

        // Messages - Vertical
        messageHistoryAdapter = MessageHistoryAdapter(emptyList())
        rvMessages.layoutManager = LinearLayoutManager(context)
        rvMessages.adapter = messageHistoryAdapter

        // FAQ - Vertical
        faqAdapter = FaqAdapter(emptyList())
        rvFaq.layoutManager = LinearLayoutManager(context)
        rvFaq.adapter = faqAdapter
    }

    private fun fetchSupportTeam() {
        progressTeam.visibility = View.VISIBLE
        tvEmptyTeam.visibility = View.GONE

        ApiClient.instance.getKontakUstadz().enqueue(object : Callback<KontakUstadzResponse> {
            override fun onResponse(call: Call<KontakUstadzResponse>, response: Response<KontakUstadzResponse>) {
                if (!isAdded) return
                progressTeam.visibility = View.GONE
                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    if (list.isNotEmpty()) {
                        supportTeamAdapter.updateData(list)
                        tvEmptyTeam.visibility = View.GONE
                    } else {
                        tvEmptyTeam.visibility = View.VISIBLE
                    }
                }
            }

            override fun onFailure(call: Call<KontakUstadzResponse>, t: Throwable) {
                if (!isAdded) return
                progressTeam.visibility = View.GONE
                tvEmptyTeam.visibility = View.VISIBLE
            }
        })
    }

    private fun fetchFaqs() {
        progressFaq.visibility = View.VISIBLE
        tvEmptyFaq.visibility = View.GONE

        ApiClient.instance.getFaqs().enqueue(object : Callback<FaqResponse> {
            override fun onResponse(call: Call<FaqResponse>, response: Response<FaqResponse>) {
                if (!isAdded) return
                progressFaq.visibility = View.GONE
                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    if (list.isNotEmpty()) {
                        faqAdapter.updateData(list)
                        tvEmptyFaq.visibility = View.GONE
                    } else {
                        tvEmptyFaq.visibility = View.VISIBLE
                    }
                }
            }

            override fun onFailure(call: Call<FaqResponse>, t: Throwable) {
                if (!isAdded) return
                progressFaq.visibility = View.GONE
                tvEmptyFaq.visibility = View.VISIBLE
            }
        })
    }

    private fun fetchMessages() {
        val userId = sessionManager.getUserId()
        if (userId == -1) return
        progressMessages.visibility = View.VISIBLE
        tvEmptyMessages.visibility = View.GONE

        ApiClient.instance.getMyMessages(userId).enqueue(object : Callback<ContactMessageResponse> {
            override fun onResponse(call: Call<ContactMessageResponse>, response: Response<ContactMessageResponse>) {
                if (!isAdded) return
                progressMessages.visibility = View.GONE
                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    tvMessageCount.text = "${list.size} Pesan"
                    if (list.isNotEmpty()) {
                        messageHistoryAdapter.updateData(list)
                        tvEmptyMessages.visibility = View.GONE
                    } else {
                        tvEmptyMessages.visibility = View.VISIBLE
                    }
                }
            }

            override fun onFailure(call: Call<ContactMessageResponse>, t: Throwable) {
                if (!isAdded) return
                progressMessages.visibility = View.GONE
                tvEmptyMessages.visibility = View.VISIBLE
            }
        })
    }

    private fun sendMessage() {
        val userId = sessionManager.getUserId()
        if (userId == -1) {
            Toast.makeText(context, "Sesi login tidak ditemukan", Toast.LENGTH_SHORT).show()
            return
        }
        val subject = spinnerSubject.selectedItem?.toString() ?: ""
        val message = etMessage.text.toString().trim()

        if (subject == "Pilih subjek..." || subject.isEmpty()) {
            Toast.makeText(context, "Silakan pilih subjek pesan", Toast.LENGTH_SHORT).show()
            return
        }
        if (message.isEmpty()) {
            Toast.makeText(context, "Pesan tidak boleh kosong", Toast.LENGTH_SHORT).show()
            return
        }

        val idUserBody = userId.toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val subjectBody = subject.toRequestBody("text/plain".toMediaTypeOrNull())
        val messageBody = message.toRequestBody("text/plain".toMediaTypeOrNull())

        var attachmentPart: MultipartBody.Part? = null
        selectedFileUri?.let { uri ->
            try {
                val inputStream = requireContext().contentResolver.openInputStream(uri)
                val tempFile = File.createTempFile("attachment_", ".tmp", requireContext().cacheDir)
                FileOutputStream(tempFile).use { output ->
                    inputStream?.copyTo(output)
                }
                val requestFile = tempFile.asRequestBody("application/octet-stream".toMediaTypeOrNull())
                attachmentPart = MultipartBody.Part.createFormData("attachment", getFileName(uri), requestFile)
            } catch (e: Exception) {
                e.printStackTrace()
            }
        }

        val btnSend = view?.findViewById<com.google.android.material.button.MaterialButton>(R.id.btnSendMessage)
        btnSend?.isEnabled = false
        btnSend?.text = "Mengirim..."

        ApiClient.instance.sendContactMessage(idUserBody, subjectBody, messageBody, attachmentPart)
            .enqueue(object : Callback<GeneralResponse> {
                override fun onResponse(call: Call<GeneralResponse>, response: Response<GeneralResponse>) {
                    if (!isAdded) return
                    btnSend?.isEnabled = true
                    btnSend?.text = "Kirim Pesan"

                    if (response.isSuccessful && response.body()?.response_code == 200) {
                        Toast.makeText(context, "Pesan berhasil dikirim!", Toast.LENGTH_SHORT).show()
                        etMessage.text.clear()
                        spinnerSubject.setSelection(0)
                        selectedFileUri = null
                        tvAttachmentName.text = "Maks 5MB (JPG, PNG, PDF, DOCX)"
                        ivAttachmentPreview.setColorFilter(resources.getColor(android.R.color.darker_gray))
                        fetchMessages() // Refresh message list
                    } else {
                        Toast.makeText(context, "Gagal mengirim pesan", Toast.LENGTH_SHORT).show()
                    }
                }

                override fun onFailure(call: Call<GeneralResponse>, t: Throwable) {
                    if (!isAdded) return
                    btnSend?.isEnabled = true
                    btnSend?.text = "Kirim Pesan"
                    Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
                }
            })
    }

    private fun openFilePicker() {
        val intent = Intent(Intent.ACTION_GET_CONTENT).apply {
            type = "*/*"
            putExtra(Intent.EXTRA_MIME_TYPES, arrayOf("image/jpeg", "image/png", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
        }
        startActivityForResult(Intent.createChooser(intent, "Pilih Lampiran"), PICK_FILE_REQUEST)
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == PICK_FILE_REQUEST && resultCode == Activity.RESULT_OK && data != null) {
            selectedFileUri = data.data
            selectedFileUri?.let { uri ->
                tvAttachmentName.text = getFileName(uri)
                ivAttachmentPreview.setColorFilter(resources.getColor(R.color.web_primary))
            }
        }
    }

    private fun getFileName(uri: Uri): String {
        var result: String? = null
        if (uri.scheme == "content") {
            val cursor = requireContext().contentResolver.query(uri, null, null, null, null)
            try {
                if (cursor != null && cursor.moveToFirst()) {
                    val index = cursor.getColumnIndex(android.provider.OpenableColumns.DISPLAY_NAME)
                    if (index != -1) {
                        result = cursor.getString(index)
                    }
                }
            } finally {
                cursor?.close()
            }
        }
        if (result == null) {
            result = uri.path
            val cut = result?.lastIndexOf('/') ?: -1
            if (cut != -1) {
                result = result?.substring(cut + 1)
            }
        }
        return result ?: "file"
    }
}
