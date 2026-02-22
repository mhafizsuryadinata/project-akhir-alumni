package com.example.darli

import android.app.Activity
import android.app.DatePickerDialog
import android.app.TimePickerDialog
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.provider.MediaStore
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.*
import androidx.activity.result.contract.ActivityResultContracts
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.example.darli.data.model.GeneralResponse
import com.example.darli.data.network.ApiClient
import com.example.darli.data.network.ApiService
import com.google.android.material.textfield.TextInputEditText
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream
import java.text.SimpleDateFormat
import java.util.*

class AddEventFragment : Fragment() {

    private lateinit var etTitle: TextInputEditText
    private lateinit var spinnerCategory: Spinner
    private lateinit var etDate: TextInputEditText
    private lateinit var etTime: TextInputEditText
    private lateinit var etLocation: TextInputEditText
    private lateinit var etDescription: TextInputEditText
    private lateinit var ivEventImage: ImageView
    private lateinit var btnSelectImage: Button
    private lateinit var btnSubmit: Button
    
    private var selectedImageUri: Uri? = null
    private val calendar = Calendar.getInstance()

    private val getContent = registerForActivityResult(ActivityResultContracts.StartActivityForResult()) { result ->
        if (result.resultCode == Activity.RESULT_OK) {
            val data: Intent? = result.data
            selectedImageUri = data?.data
            ivEventImage.setImageURI(selectedImageUri)
            ivEventImage.scaleType = ImageView.ScaleType.CENTER_CROP
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_add_event, container, false)
        
        initViews(view)
        setupCategorySpinner()
        setupListeners(view)
        
        return view
    }

    private fun initViews(view: View) {
        etTitle = view.findViewById(R.id.etTitle)
        spinnerCategory = view.findViewById(R.id.spinnerCategory)
        etDate = view.findViewById(R.id.etDate)
        etTime = view.findViewById(R.id.etTime)
        etLocation = view.findViewById(R.id.etLocation)
        etDescription = view.findViewById(R.id.etDescription)
        ivEventImage = view.findViewById(R.id.ivEventImage)
        btnSelectImage = view.findViewById(R.id.btnSelectImage)
        btnSubmit = view.findViewById(R.id.btnSubmit)
    }

    private fun setupCategorySpinner() {
        val categories = arrayOf("Reuni", "Pengajian", "Seminar", "Olahraga", "Lainnya")
        val adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_item, categories)
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        spinnerCategory.adapter = adapter
    }

    private fun setupListeners(view: View) {
        view.findViewById<ImageButton>(R.id.btnBack).setOnClickListener {
            findNavController().popBackStack()
        }

        etDate.setOnClickListener { showDatePicker() }
        etTime.setOnClickListener { showTimePicker() }
        
        btnSelectImage.setOnClickListener {
            val intent = Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI)
            getContent.launch(intent)
        }

        btnSubmit.setOnClickListener { submitEvent() }
    }

    private fun showDatePicker() {
        val datePickerDialog = DatePickerDialog(
            requireContext(),
            { _, year, month, dayOfMonth ->
                calendar.set(Calendar.YEAR, year)
                calendar.set(Calendar.MONTH, month)
                calendar.set(Calendar.DAY_OF_MONTH, dayOfMonth)
                val sdf = SimpleDateFormat("yyyy-MM-dd", Locale.getDefault())
                etDate.setText(sdf.format(calendar.time))
            },
            calendar.get(Calendar.YEAR),
            calendar.get(Calendar.MONTH),
            calendar.get(Calendar.DAY_OF_MONTH)
        )
        datePickerDialog.show()
    }

    private fun showTimePicker() {
        val timePickerDialog = TimePickerDialog(
            requireContext(),
            { _, hourOfDay, minute ->
                calendar.set(Calendar.HOUR_OF_DAY, hourOfDay)
                calendar.set(Calendar.MINUTE, minute)
                val sdf = SimpleDateFormat("HH:mm", Locale.getDefault())
                etTime.setText(sdf.format(calendar.time))
            },
            calendar.get(Calendar.HOUR_OF_DAY),
            calendar.get(Calendar.MINUTE),
            true
        )
        timePickerDialog.show()
    }

    private fun submitEvent() {
        val title = etTitle.text.toString().trim()
        val category = spinnerCategory.selectedItem.toString()
        val date = etDate.text.toString().trim()
        val time = etTime.text.toString().trim()
        val location = etLocation.text.toString().trim()
        val description = etDescription.text.toString().trim()

        if (title.isEmpty() || date.isEmpty() || time.isEmpty() || location.isEmpty() || description.isEmpty()) {
            Toast.makeText(context, "Harap isi semua field wajib", Toast.LENGTH_SHORT).show()
            return
        }

        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()

        val idUserPart = userId.toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val titlePart = title.toRequestBody("text/plain".toMediaTypeOrNull())
        val categoryPart = category.toRequestBody("text/plain".toMediaTypeOrNull())
        val datePart = date.toRequestBody("text/plain".toMediaTypeOrNull())
        val timePart = time.toRequestBody("text/plain".toMediaTypeOrNull())
        val locationPart = location.toRequestBody("text/plain".toMediaTypeOrNull())
        val descriptionPart = description.toRequestBody("text/plain".toMediaTypeOrNull())

        var imagePart: MultipartBody.Part? = null
        selectedImageUri?.let { uri ->
            val file = getFileFromUri(uri)
            if (file != null) {
                val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                imagePart = MultipartBody.Part.createFormData("image", file.name, requestFile)
            }
        }

        // Show loading
        btnSubmit.isEnabled = false
        btnSubmit.text = "Mengirim..."

        ApiClient.instance.storeEvent(
            idUserPart, titlePart, categoryPart, datePart, timePart, locationPart, descriptionPart, imagePart
        ).enqueue(object : Callback<GeneralResponse> {
            override fun onResponse(call: Call<GeneralResponse>, response: Response<GeneralResponse>) {
                btnSubmit.isEnabled = true
                btnSubmit.text = "Buat Acara"
                
                if (response.isSuccessful && response.body()?.response_code == 200) {
                    Toast.makeText(context, "Acara berhasil dibuat! Menunggu persetujuan admin.", Toast.LENGTH_LONG).show()
                    findNavController().popBackStack()
                } else {
                    Toast.makeText(context, "Gagal membuat acara: ${response.message()}", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<GeneralResponse>, t: Throwable) {
                btnSubmit.isEnabled = true
                btnSubmit.text = "Buat Acara"
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
    
    private fun getFileFromUri(uri: Uri): File? {
        return try {
            val contentResolver = requireContext().contentResolver
            val inputStream = contentResolver.openInputStream(uri) ?: return null
            val file = File(requireContext().cacheDir, "temp_image_${System.currentTimeMillis()}.jpg")
            val outputStream = FileOutputStream(file)
            inputStream.copyTo(outputStream)
            inputStream.close()
            outputStream.close()
            file
        } catch (e: Exception) {
            e.printStackTrace()
            null
        }
    }
}
