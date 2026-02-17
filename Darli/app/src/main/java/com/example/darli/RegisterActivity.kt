package com.example.darli

import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.View
import android.widget.Toast
import androidx.activity.result.contract.ActivityResultContracts
import androidx.appcompat.app.AppCompatActivity
import com.bumptech.glide.Glide
import com.example.darli.api.ApiConfig
import com.example.darli.databinding.ActivityRegisterBinding
import com.example.darli.models.LoginModel
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import androidx.appcompat.app.AlertDialog
import java.io.File
import java.io.FileOutputStream

class RegisterActivity : AppCompatActivity() {
    private lateinit var binding: ActivityRegisterBinding
    private var imageUri: Uri? = null
    private var userId: Int = -1
    private var currentStep = 1

    private val selectImageLauncher = registerForActivityResult(ActivityResultContracts.GetContent()) { uri ->
        uri?.let {
            imageUri = it
            binding.profileImage.setImageURI(imageUri)
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityRegisterBinding.inflate(layoutInflater)
        setContentView(binding.root)

        userId = intent.getIntExtra("USER_ID", -1)
        if (userId == -1) {
            Toast.makeText(this, "Sesi tidak valid", Toast.LENGTH_SHORT).show()
            finish()
            return
        }

        setupViews()
        setupListeners()
        updateUIForStep()
    }

    private fun setupDropdown() {
        // Dropdown removed
    }

    private fun setupViews() {
        val name = intent.getStringExtra("USER_NAME")
        val yearIn = intent.getStringExtra("USER_YEAR_IN")
        val yearOut = intent.getStringExtra("USER_YEAR_OUT")
        val address = intent.getStringExtra("USER_ADDRESS")
        val phone = intent.getStringExtra("USER_PHONE")
        val job = intent.getStringExtra("USER_JOB")
        val location = intent.getStringExtra("USER_LOCATION")
        val email = intent.getStringExtra("USER_EMAIL")
        val bio = intent.getStringExtra("USER_BIO")
        val instagram = intent.getStringExtra("USER_INSTAGRAM")
        val linkedin = intent.getStringExtra("USER_LINKEDIN")
        val education = intent.getStringExtra("USER_EDUCATION")
        val nia = intent.getStringExtra("USER_NIA")

        binding.etFullName.setText(name)
        binding.etTahunMasuk.setText(yearIn ?: "Pilih")
        binding.etTahunTamat.setText(yearOut ?: "Pilih")
        binding.etPekerjaan.setText(job)
        binding.etLokasi.setText(location)
        binding.etBio.setText(bio)
        
        binding.etNIA.setText(nia ?: "-")
        binding.etEmail.setText(email)
        binding.etWhatsapp.setText(phone)
        binding.etAlamat.setText(address)
        binding.etInstagram.setText(instagram)
        binding.etLinkedIn.setText(linkedin)
        binding.etPendidikanLanjutan.setText(education)
    }

    private fun setupListeners() {
        binding.btnBack.setOnClickListener {
            if (currentStep > 1) {
                currentStep--
                updateUIForStep()
            } else {
                finish()
            }
        }

        binding.btnBackStep.setOnClickListener {
            currentStep--
            updateUIForStep()
        }

        binding.btnSelectImage.setOnClickListener {
            showPhotoSourceDialog()
        }

        binding.profileImage.setOnClickListener {
            showPhotoSourceDialog()
        }

        binding.btnNext.setOnClickListener {
            if (validateStep1()) {
                currentStep = 2
                updateUIForStep()
            }
        }

        binding.btnSubmit.setOnClickListener {
            if (validateStep2()) {
                uploadData()
            }
        }
    }

    private fun showPhotoSourceDialog() {
        val options = arrayOf("Galeri", "Google Drive / File Lainnya")
        val builder = AlertDialog.Builder(this)
        builder.setTitle("Pilih Sumber Foto")
        builder.setItems(options) { _, which ->
            when (which) {
                0 -> selectImageLauncher.launch("image/*")
                1 -> selectImageLauncher.launch("*/*") // Full picker for Drive/Files
            }
        }
        builder.show()
    }

    private fun updateUIForStep() {
        if (currentStep == 1) {
            binding.step1Container.visibility = View.VISIBLE
            binding.step2Container.visibility = View.GONE
            binding.btnNext.visibility = View.VISIBLE
            binding.btnSubmit.visibility = View.GONE
            binding.btnBackStep.visibility = View.GONE
            binding.tvStepIndicator.text = "Step 1/2"
            binding.registrationProgress.progress = 50
            binding.tvProgressPercent.text = "50%"
        } else {
            binding.step1Container.visibility = View.GONE
            binding.step2Container.visibility = View.VISIBLE
            binding.btnNext.visibility = View.GONE
            binding.btnSubmit.visibility = View.VISIBLE
            binding.btnBackStep.visibility = View.VISIBLE
            binding.tvStepIndicator.text = "Step 2/2"
            binding.registrationProgress.progress = 100
            binding.tvProgressPercent.text = "100%"
        }
    }

    private fun validateStep1(): Boolean {
        val name = binding.etFullName.text.toString().trim()
        val job = binding.etPekerjaan.text.toString().trim()
        val location = binding.etLokasi.text.toString().trim()

        if (name.isEmpty()) {
            binding.tilFullName.error = "Nama Lengkap wajib diisi"
            return false
        }
        binding.tilFullName.error = null

        if (job.isEmpty()) {
            binding.tilPekerjaan.error = "Profesi wajib diisi"
            return false
        }
        binding.tilPekerjaan.error = null

        if (location.isEmpty()) {
            binding.tilLokasi.error = "Lokasi wajib diisi"
            return false
        }
        binding.tilLokasi.error = null

        return true
    }

    private fun validateStep2(): Boolean {
        val email = binding.etEmail.text.toString().trim()
        val phone = binding.etWhatsapp.text.toString().trim()
        val address = binding.etAlamat.text.toString().trim()

        if (email.isEmpty()) {
            binding.tilEmail.error = "Email wajib diisi"
            return false
        }
        binding.tilEmail.error = null

        if (phone.isEmpty()) {
            binding.tilWhatsapp.error = "Nomor WhatsApp wajib diisi"
            return false
        }
        binding.tilWhatsapp.error = null

        if (address.isEmpty()) {
            binding.tilAlamat.error = "Alamat wajib diisi"
            return false
        }
        binding.tilAlamat.error = null

        return true
    }

    private fun uploadData() {
        binding.btnSubmit.isEnabled = false
        binding.btnSubmit.text = "Menyimpan..."

        val apiService = ApiConfig.getApiService()

        val idUserBody = userId.toString().toRequestBody("text/plain".toMediaTypeOrNull())
        val namaBody = binding.etFullName.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val alamatBody = binding.etAlamat.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val noHpBody = binding.etWhatsapp.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val pekerjaanBody = binding.etPekerjaan.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val lokasiBody = binding.etLokasi.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val emailBody = binding.etEmail.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val bioBody = (binding.etBio.text.toString().trim()).toRequestBody("text/plain".toMediaTypeOrNull())
        val instagramBody = binding.etInstagram.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val linkedinBody = binding.etLinkedIn.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val pendidikanLanjutanBody = binding.etPendidikanLanjutan.text.toString().trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val tahunMasukBody = (intent.getStringExtra("USER_YEAR_IN") ?: "").trim().toRequestBody("text/plain".toMediaTypeOrNull())
        val tahunTamatBody = (intent.getStringExtra("USER_YEAR_OUT") ?: "").trim().toRequestBody("text/plain".toMediaTypeOrNull())

        var imageMultipart: MultipartBody.Part? = null
        imageUri?.let { uri ->
            val file = uriToFile(uri)
            val requestImageFile = file.asRequestBody("image/*".toMediaTypeOrNull())
            imageMultipart = MultipartBody.Part.createFormData("file", file.name, requestImageFile)
        }

        apiService.updateProfile(
            idUserBody, namaBody, alamatBody, noHpBody, pekerjaanBody, lokasiBody, emailBody, bioBody, 
            instagramBody, linkedinBody, pendidikanLanjutanBody, tahunMasukBody, tahunTamatBody, imageMultipart
        ).enqueue(object : Callback<LoginModel> {
            override fun onResponse(call: Call<LoginModel>, response: Response<LoginModel>) {
                binding.btnSubmit.isEnabled = true
                binding.btnSubmit.text = "Simpan & Masuk"

                if (response.isSuccessful) {
                    val responseBody = response.body()
                    if (responseBody != null && responseBody.response_code == 200) {
                        Toast.makeText(this@RegisterActivity, "Profil berhasil dilengkapi!", Toast.LENGTH_SHORT).show()
                        
                        // Update Session with new data is usually done on next login or by refreshing session
                        // For now, redirect to MainActivity
                        val intent = Intent(this@RegisterActivity, MainActivity::class.java).apply {
                            putExtra("SHOW_MENU_FRAGMENT", true)
                            flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
                        }
                        startActivity(intent)
                        finish()
                    } else {
                        Toast.makeText(this@RegisterActivity, responseBody?.message ?: "Gagal update profile", Toast.LENGTH_SHORT).show()
                    }
                } else {
                    val errorBody = response.errorBody()?.string()
                    val errorMessage = try {
                        val jsonObject = org.json.JSONObject(errorBody)
                        jsonObject.getString("message")
                    } catch (e: Exception) {
                        response.message()
                    }
                    Toast.makeText(this@RegisterActivity, "Gagal: $errorMessage (${response.code()})", Toast.LENGTH_LONG).show()
                    android.util.Log.e("RegisterActivity", "Server Error: $errorBody")
                }
            }

            override fun onFailure(call: Call<LoginModel>, t: Throwable) {
                binding.btnSubmit.isEnabled = true
                binding.btnSubmit.text = "Simpan & Masuk"
                Toast.makeText(this@RegisterActivity, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun uriToFile(selectedImg: Uri): File {
        val contentResolver = contentResolver
        val myFile = createCustomTempFile(contentResolver)
    
        val inputStream = contentResolver.openInputStream(selectedImg) as java.io.InputStream
        val outputStream = FileOutputStream(myFile)
        val buf = ByteArray(1024)
        var len: Int
        while (inputStream.read(buf).also { len = it } > 0) outputStream.write(buf, 0, len)
        outputStream.close()
        inputStream.close()
    
        return myFile
    }

    private fun createCustomTempFile(context: android.content.ContentResolver): File {
        val storageDir: File? = getExternalFilesDir(android.os.Environment.DIRECTORY_PICTURES)
        return File.createTempFile(System.currentTimeMillis().toString(), ".jpg", storageDir)
    }
}
