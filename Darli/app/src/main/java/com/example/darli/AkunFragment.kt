package com.example.darli

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.EditText
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import com.bumptech.glide.Glide
import de.hdodenhof.circleimageview.CircleImageView
import com.example.darli.data.network.ApiClient
import com.example.darli.data.model.Alumni
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

import androidx.lifecycle.lifecycleScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import androidx.activity.result.contract.ActivityResultContracts
import android.net.Uri
import androidx.appcompat.app.AlertDialog
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import java.io.File
import java.io.FileOutputStream

class AkunFragment : Fragment() {

    private lateinit var imagePickerLauncher: androidx.activity.result.ActivityResultLauncher<String>

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_akun, container, false)
        
        imagePickerLauncher = registerForActivityResult(ActivityResultContracts.GetContent()) { uri ->
            uri?.let {
                uploadPhoto(view, it)
            }
        }

        setupViews(view)
        return view
    }

    private fun setupViews(view: View) {
        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()
        
        // Initial setup from session
        val userDetails = sessionManager.getUserDetails()
        val details = userDetails
        updateUI(view, 
            details["name"] ?: "", 
            details["batch"] ?: "", 
            details["email"] ?: "", 
            details["phone"] ?: "", 
            details["job"] ?: "", 
            details["location"] ?: "", 
            details["address"] ?: "", 
            details["photo"] ?: "", 
            details["year_in"] ?: "", 
            details["year_out"] ?: "", 
            details["bio"] ?: "", 
            details["instagram"] ?: "", 
            details["linkedin"] ?: "", 
            details["education"] ?: ""
        )

        // Fetch latest from DB
        fetchLatestData(view, userId.toString())

        view.findViewById<View>(R.id.btnBack)?.setOnClickListener {
            activity?.onBackPressed()
        }

        view.findViewById<Button>(R.id.btnChangePhoto).setOnClickListener {
            showPhotoSourceDialog()
        }

        view.findViewById<Button>(R.id.btnShareProfile).setOnClickListener {
            val details = sessionManager.getUserDetails()
            val name = details["name"]
            val batch = details["batch"]
            val job = details["job"]
            val phone = details["phone"]
            
            val shareBody = "Halo, saya $name, Alumni Angkatan $batch.\n\nPekerjaan: $job\n\nHubungi saya: $phone"
            val sharingIntent = Intent(Intent.ACTION_SEND)
            sharingIntent.type = "text/plain"
            sharingIntent.putExtra(Intent.EXTRA_SUBJECT, "Profil Alumni Darli")
            sharingIntent.putExtra(Intent.EXTRA_TEXT, shareBody)
            startActivity(Intent.createChooser(sharingIntent, "Bagikan Profil Melalui"))
        }

        view.findViewById<Button>(R.id.btnSaveChanges).setOnClickListener {
            saveProfile(view, userId.toString())
        }

        view.findViewById<Button>(R.id.btnLogout).setOnClickListener {
            sessionManager.logout()
            val intent = Intent(activity, MainActivity::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
            startActivity(intent)
        }
    }

    private fun fetchLatestData(view: View, userId: String) {
        ApiClient.instance.getAlumniDetail(userId).enqueue(object : Callback<Alumni> {
            override fun onResponse(call: Call<Alumni>, response: Response<Alumni>) {
                if (response.isSuccessful) {
                    val data = response.body()
                    data?.let {
                        updateUI(view, it.name ?: "", it.batch ?: "", it.email ?: "", 
                                 it.contact ?: "", it.profession ?: "", it.location ?: "", 
                                 it.address ?: "", it.imageUrl ?: "", 
                                 it.yearIn ?: "", it.yearOut ?: "", it.bio ?: "",
                                 it.instagram ?: "", it.linkedin ?: "", it.education ?: "")
                        
                        val sessionManager = SessionManager(requireContext())
                        sessionManager.updateUserDetails(
                            it.name, it.batch, it.imageUrl, it.email, 
                            it.contact, it.profession, it.location, it.address,
                            it.bio, it.instagram, it.linkedin, it.education
                        )
                    }
                }
            }

            override fun onFailure(call: Call<Alumni>, t: Throwable) {}
        })
    }

    private fun saveProfile(view: View, userId: String) {
        val name = view.findViewById<EditText>(R.id.etName).text.toString().trim()
        val address = view.findViewById<EditText>(R.id.etAddress).text.toString().trim()
        val phone = view.findViewById<EditText>(R.id.etPhone).text.toString().trim()
        val job = view.findViewById<EditText>(R.id.etJob).text.toString().trim()
        val email = view.findViewById<EditText>(R.id.etEmail).text.toString().trim()
        val location = view.findViewById<EditText>(R.id.etLocation).text.toString().trim()
        val bio = view.findViewById<EditText>(R.id.etBio).text.toString().trim()
        val instagram = view.findViewById<EditText>(R.id.etInstagram).text.toString().trim()
        val linkedin = view.findViewById<EditText>(R.id.etLinkedin).text.toString().trim()
        val education = view.findViewById<EditText>(R.id.etEducation).text.toString().trim()

        val sessionManager = SessionManager(requireContext())
        val userDetails = sessionManager.getUserDetails()
        val yearIn = userDetails["year_in"] ?: ""
        val yearOut = userDetails["year_out"] ?: ""

        val idUserBody = userId.toRequestBody("text/plain".toMediaTypeOrNull())
        val namaBody = name.toRequestBody("text/plain".toMediaTypeOrNull())
        val alamatBody = address.toRequestBody("text/plain".toMediaTypeOrNull())
        val noHpBody = phone.toRequestBody("text/plain".toMediaTypeOrNull())
        val pekerjaanBody = job.toRequestBody("text/plain".toMediaTypeOrNull())
        val lokasiBody = location.toRequestBody("text/plain".toMediaTypeOrNull())
        val emailBody = email.toRequestBody("text/plain".toMediaTypeOrNull())
        val bioBody = bio.toRequestBody("text/plain".toMediaTypeOrNull())
        val instagramBody = instagram.toRequestBody("text/plain".toMediaTypeOrNull())
        val linkedinBody = linkedin.toRequestBody("text/plain".toMediaTypeOrNull())
        val educationBody = education.toRequestBody("text/plain".toMediaTypeOrNull())
        val yearInBody = yearIn.toRequestBody("text/plain".toMediaTypeOrNull())
        val yearOutBody = yearOut.toRequestBody("text/plain".toMediaTypeOrNull())

        ApiClient.instance.updateProfile(
            idUserBody, namaBody, alamatBody, noHpBody, pekerjaanBody, lokasiBody, emailBody, bioBody, 
            instagramBody, linkedinBody, educationBody, yearInBody, yearOutBody, null
        ).enqueue(object : Callback<com.example.darli.data.model.AlumniUpdateResponse> {
            override fun onResponse(call: Call<com.example.darli.data.model.AlumniUpdateResponse>, 
                                  response: Response<com.example.darli.data.model.AlumniUpdateResponse>) {
                if (response.isSuccessful && response.body()?.responseCode == 200) {
                    Toast.makeText(context, "Profil berhasil diperbarui", Toast.LENGTH_SHORT).show()
                    response.body()?.content?.let { it ->
                        val sessionManager = SessionManager(requireContext())
                        sessionManager.updateUserDetails(
                            it.name, it.batch, it.imageUrl, it.email, 
                            it.contact, it.profession, it.location, it.address,
                            it.bio, it.instagram, it.linkedin, it.education
                        )
                    }
                } else {
                    val errorBody = response.errorBody()?.string() ?: response.body()?.toString()
                    android.util.Log.e("AkunFragment", "Update failed: code=${response.code()} body=$errorBody")
                    val errorMsg = try {
                        val json = org.json.JSONObject(errorBody ?: "")
                        json.optString("message", "Gagal memperbarui profil")
                    } catch (e: Exception) {
                        "Gagal memperbarui profil (${response.code()})"
                    }
                    Toast.makeText(context, errorMsg, Toast.LENGTH_LONG).show()
                }
            }

            override fun onFailure(call: Call<com.example.darli.data.model.AlumniUpdateResponse>, t: Throwable) {
                android.util.Log.e("AkunFragment", "Network error", t)
                Toast.makeText(context, "Terjadi kesalahan jaringan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun updateUI(view: View, name: String, batch: String, email: String, 
                          phone: String, job: String, location: String, 
                          address: String, photo: String, yearIn: String, yearOut: String,
                          bio: String, instagram: String, linkedin: String, education: String) {
        
        view.findViewById<TextView>(R.id.userNameAkun).text = name
        view.findViewById<TextView>(R.id.userBatchAkun).text = "Angkatan $yearIn - $yearOut"
        
        view.findViewById<EditText>(R.id.etName).setText(name)
        view.findViewById<EditText>(R.id.etAddress).setText(address)
        view.findViewById<EditText>(R.id.etPhone).setText(phone)
        view.findViewById<TextView>(R.id.tvYearIn).text = yearIn
        view.findViewById<TextView>(R.id.tvYearOut).text = yearOut

        view.findViewById<EditText>(R.id.etJob).setText(job)
        view.findViewById<EditText>(R.id.etEmail).setText(email)
        view.findViewById<EditText>(R.id.etLocation).setText(location)
        view.findViewById<EditText>(R.id.etBio).setText(bio)
        view.findViewById<EditText>(R.id.etInstagram).setText(instagram)
        view.findViewById<EditText>(R.id.etLinkedin).setText(linkedin)
        view.findViewById<EditText>(R.id.etEducation).setText(education)

        val profileImage = view.findViewById<CircleImageView>(R.id.profileImageAkun)
        if (!photo.isNullOrEmpty()) {
            var finalUrl = photo.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
            if (!finalUrl.startsWith("http")) {
                finalUrl = "http://10.0.2.2:8000/" + finalUrl
            }
            Glide.with(this)
                .load(finalUrl)
                .placeholder(R.drawable.ic_profile_placeholder)
                .error(R.drawable.ic_profile_placeholder)
                .into(profileImage)
        }
    }
    private fun showPhotoSourceDialog() {
        val options = arrayOf("Galeri", "Google Drive / File Lainnya")
        val builder = AlertDialog.Builder(requireContext())
        builder.setTitle("Pilih Sumber Foto")
        builder.setItems(options) { _, which ->
            when (which) {
                0 -> imagePickerLauncher.launch("image/*")
                1 -> imagePickerLauncher.launch("*/*") // Open general picker for Drive/Files
            }
        }
        builder.show()
    }

    private fun uploadPhoto(view: View, uri: Uri) {
        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId().toString()

        // Use lifecycleScope to run in background
        lifecycleScope.launch(Dispatchers.IO) {
            val file = uriToFile(uri)
            
            withContext(Dispatchers.Main) {
                if (file == null) {
                    Toast.makeText(context, "Gagal memproses gambar", Toast.LENGTH_SHORT).show()
                    return@withContext
                }

                val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                val body = MultipartBody.Part.createFormData("foto", file.name, requestFile)
                val userIdPart = userId.toRequestBody("text/plain".toMediaTypeOrNull())

                Toast.makeText(context, "Mengunggah foto...", Toast.LENGTH_SHORT).show()

                ApiClient.instance.updateProfilePhoto(userIdPart, body).enqueue(object : Callback<com.example.darli.data.model.AlumniUpdateResponse> {
                    override fun onResponse(call: Call<com.example.darli.data.model.AlumniUpdateResponse>, 
                                          response: Response<com.example.darli.data.model.AlumniUpdateResponse>) {
                        if (response.isSuccessful && response.body()?.responseCode == 200) {
                            Toast.makeText(context, "Foto profil berhasil diperbarui", Toast.LENGTH_SHORT).show()
                            val updatedAlumni = response.body()?.content
                            updatedAlumni?.let { it ->
                                updateUI(view, it.name ?: "", it.batch ?: "", it.email ?: "", 
                                         it.contact ?: "", it.profession ?: "", it.location ?: "", 
                                         it.address ?: "", it.imageUrl ?: "", 
                                         it.yearIn ?: "", it.yearOut ?: "", it.bio ?: "",
                                         it.instagram ?: "", it.linkedin ?: "", it.education ?: "")
                                
                                sessionManager.updateUserDetails(
                                    it.name, it.batch, it.imageUrl, it.email, 
                                    it.contact, it.profession, it.location, it.address,
                                    it.bio, it.instagram, it.linkedin, it.education
                                )
                            }
                        } else {
                            val msg = response.body()?.message ?: "Gagal memperbarui foto"
                            Toast.makeText(context, msg, Toast.LENGTH_SHORT).show()
                        }
                    }

                    override fun onFailure(call: Call<com.example.darli.data.model.AlumniUpdateResponse>, t: Throwable) {
                        Toast.makeText(context, "Kesalahan jaringan: ${t.message}", Toast.LENGTH_SHORT).show()
                    }
                })
            }
        }
    }

    private fun uriToFile(uri: Uri): File? {
        val context = requireContext()
        // Use a unique name to avoid conflicts
        val filename = "profile_${System.currentTimeMillis()}.jpg"
        val file = File(context.cacheDir, filename)
        
        try {
            val inputStream = context.contentResolver.openInputStream(uri) ?: return null
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

