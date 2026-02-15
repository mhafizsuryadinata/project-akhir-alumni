package com.example.darli

import android.app.Activity
import android.app.DatePickerDialog
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
import java.util.*

class AddLowonganFragment : Fragment() {

    private lateinit var etJudul: EditText
    private lateinit var etPerusahaan: EditText
    private lateinit var etLokasi: EditText
    private lateinit var spinnerTipe: AutoCompleteTextView
    private lateinit var spinnerLevel: AutoCompleteTextView
    private lateinit var etDeskripsi: EditText
    private lateinit var etKualifikasi: EditText
    private lateinit var etBenefit: EditText
    private lateinit var etGajiMin: EditText
    private lateinit var etGajiMax: EditText
    private lateinit var etEmail: EditText
    private lateinit var etWebsite: EditText
    private lateinit var etTanggalTutup: EditText
    private lateinit var btnUploadLogo: Button
    private lateinit var tvLogoPath: TextView
    private lateinit var btnSave: Button
    private lateinit var btnBack: ImageView

    private var selectedImageUri: Uri? = null
    private lateinit var sessionManager: SessionManager

    private val pickImageLauncher = registerForActivityResult(ActivityResultContracts.StartActivityForResult()) { result ->
        if (result.resultCode == Activity.RESULT_OK) {
            selectedImageUri = result.data?.data
            tvLogoPath.text = selectedImageUri?.path ?: "Logo dipilih"
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_add_lowongan, container, false)
        sessionManager = SessionManager(requireContext())

        initViews(view)
        setupSpinners()
        setupListeners()

        return view
    }

    private fun initViews(view: View) {
        etJudul = view.findViewById(R.id.etJudul)
        etPerusahaan = view.findViewById(R.id.etPerusahaan)
        etLokasi = view.findViewById(R.id.etLokasi)
        spinnerTipe = view.findViewById(R.id.spinnerTipe)
        spinnerLevel = view.findViewById(R.id.spinnerLevel)
        etDeskripsi = view.findViewById(R.id.etDeskripsi)
        etKualifikasi = view.findViewById(R.id.etKualifikasi)
        etBenefit = view.findViewById(R.id.etBenefit)
        etGajiMin = view.findViewById(R.id.etGajiMin)
        etGajiMax = view.findViewById(R.id.etGajiMax)
        etEmail = view.findViewById(R.id.etEmail)
        etWebsite = view.findViewById(R.id.etWebsite)
        etTanggalTutup = view.findViewById(R.id.etTanggalTutup)
        btnUploadLogo = view.findViewById(R.id.btnUploadLogo)
        tvLogoPath = view.findViewById(R.id.tvLogoPath)
        btnSave = view.findViewById(R.id.btnSave)
        btnBack = view.findViewById(R.id.btnBack)
    }

    private fun setupSpinners() {
        val tipeOptions = arrayOf("Full Time", "Part Time", "Freelance", "Internship")
        val levelOptions = arrayOf("Entry Level", "Mid Level", "Senior Level", "Manager", "Director")

        val tipeAdapter = ArrayAdapter(requireContext(), android.R.layout.simple_dropdown_item_1line, tipeOptions)
        spinnerTipe.setAdapter(tipeAdapter)

        val levelAdapter = ArrayAdapter(requireContext(), android.R.layout.simple_dropdown_item_1line, levelOptions)
        spinnerLevel.setAdapter(levelAdapter)
    }

    private fun setupListeners() {
        btnBack.setOnClickListener { findNavController().popBackStack() }

        etTanggalTutup.setOnClickListener { showDatePicker() }

        btnUploadLogo.setOnClickListener {
            val intent = Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI)
            pickImageLauncher.launch(intent)
        }

        btnSave.setOnClickListener { validateAndSave() }
    }

    private fun showDatePicker() {
        val calendar = Calendar.getInstance()
        val datePicker = DatePickerDialog(requireContext(), { _, year, month, dayOfMonth ->
            val selectedDate = String.format("%04d-%02d-%02d", year, month + 1, dayOfMonth)
            etTanggalTutup.setText(selectedDate)
        }, calendar.get(Calendar.YEAR), calendar.get(Calendar.MONTH), calendar.get(Calendar.DAY_OF_MONTH))
        datePicker.datePicker.minDate = System.currentTimeMillis() - 1000
        datePicker.show()
    }

    private fun validateAndSave() {
        val judul = etJudul.text.toString()
        val perusahaan = etPerusahaan.text.toString()
        val lokasi = etLokasi.text.toString()
        val tipe = spinnerTipe.text.toString()
        val level = spinnerLevel.text.toString()
        val deskripsi = etDeskripsi.text.toString()
        val kualifikasi = etKualifikasi.text.toString()
        val email = etEmail.text.toString()
        val tanggalTutup = etTanggalTutup.text.toString()

        if (judul.isEmpty() || perusahaan.isEmpty() || lokasi.isEmpty() || tipe.isEmpty() || 
            level.isEmpty() || deskripsi.isEmpty() || kualifikasi.isEmpty() || email.isEmpty() || tanggalTutup.isEmpty()) {
            Toast.makeText(requireContext(), "Harap isi semua bidang wajib (*)", Toast.LENGTH_SHORT).show()
            return
        }

        saveLowongan()
    }

    private fun saveLowongan() {
        btnSave.isEnabled = false
        btnSave.text = "Menyimpan..."

        val userId = sessionManager.getUserId().toString()

        // Required fields
        val judul = etJudul.text.toString().toPart()
        val perusahaan = etPerusahaan.text.toString().toPart()
        val tipePekerjaan = spinnerTipe.text.toString().toPart()
        val lokasi = etLokasi.text.toString().toPart()
        val deskripsi = etDeskripsi.text.toString().toPart()
        val kualifikasi = etKualifikasi.text.toString().toPart()
        val emailKontak = etEmail.text.toString().toPart()
        val tanggalTutup = etTanggalTutup.text.toString().toPart()
        val level = spinnerLevel.text.toString().toPart()
        val postedBy = userId.toPart()

        // Optional fields — only send if not empty (empty strings cause validation errors)
        val benefit = etBenefit.text.toString().toPartOrNull()
        val gajiMin = etGajiMin.text.toString().toPartOrNull()
        val gajiMax = etGajiMax.text.toString().toPartOrNull()
        val website = etWebsite.text.toString().toPartOrNull()

        var logoPart: MultipartBody.Part? = null
        selectedImageUri?.let { uri ->
            val file = getFileFromUri(uri)
            if (file != null) {
                val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                logoPart = MultipartBody.Part.createFormData("logo_perusahaan", file.name, requestFile)
            }
        }

        ApiClient.instance.storeLowongan(
            judul,
            perusahaan,
            tipePekerjaan,
            lokasi,
            deskripsi,
            kualifikasi,
            benefit,
            gajiMin,
            gajiMax,
            emailKontak,
            website,
            tanggalTutup,
            level,
            postedBy,
            logoPart
        ).enqueue(object : Callback<GeneralResponse> {
            override fun onResponse(call: Call<GeneralResponse>, response: Response<GeneralResponse>) {
                btnSave.isEnabled = true
                btnSave.text = "Simpan Lowongan"
                if (response.isSuccessful && response.body()?.response_code == 200) {
                    Toast.makeText(requireContext(), response.body()?.message ?: "Lowongan berhasil disimpan", Toast.LENGTH_LONG).show()
                    findNavController().popBackStack()
                } else {
                    Toast.makeText(requireContext(), "Gagal: ${response.body()?.message ?: response.message()}", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<GeneralResponse>, t: Throwable) {
                btnSave.isEnabled = true
                btnSave.text = "Simpan Lowongan"
                Toast.makeText(requireContext(), "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun String.toPart(): RequestBody {
        return this.toRequestBody("text/plain".toMediaTypeOrNull())
    }

    private fun String.toPartOrNull(): RequestBody? {
        return if (this.isBlank()) null else this.toPart()
    }

    private fun getFileFromUri(uri: Uri): File? {
        try {
            val inputStream = requireContext().contentResolver.openInputStream(uri) ?: return null
            val file = File(requireContext().cacheDir, "temp_logo_${System.currentTimeMillis()}.jpg")
            val outputStream = FileOutputStream(file)
            inputStream.use { input ->
                outputStream.use { output ->
                    input.copyTo(output)
                }
            }
            return file
        } catch (e: Exception) {
            e.printStackTrace()
            return null
        }
    }
}
