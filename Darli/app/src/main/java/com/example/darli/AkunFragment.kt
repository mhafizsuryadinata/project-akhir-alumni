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

class AkunFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_akun, container, false)
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
            Toast.makeText(context, "Fitur ini akan segera hadir", Toast.LENGTH_SHORT).show()
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
        val name = view.findViewById<EditText>(R.id.etName).text.toString()
        val address = view.findViewById<EditText>(R.id.etAddress).text.toString()
        val phone = view.findViewById<EditText>(R.id.etPhone).text.toString()
        val job = view.findViewById<EditText>(R.id.etJob).text.toString()
        val email = view.findViewById<EditText>(R.id.etEmail).text.toString()
        val location = view.findViewById<EditText>(R.id.etLocation).text.toString()
        val bio = view.findViewById<EditText>(R.id.etBio).text.toString()
        val instagram = view.findViewById<EditText>(R.id.etInstagram).text.toString()
        val linkedin = view.findViewById<EditText>(R.id.etLinkedin).text.toString()
        val education = view.findViewById<EditText>(R.id.etEducation).text.toString()

        ApiClient.instance.updateProfile(
            userId, name, address, phone, job, location, email, bio, instagram, linkedin, education
        ).enqueue(object : Callback<com.example.darli.data.model.AlumniUpdateResponse> {
            override fun onResponse(call: Call<com.example.darli.data.model.AlumniUpdateResponse>, 
                                  response: Response<com.example.darli.data.model.AlumniUpdateResponse>) {
                if (response.isSuccessful && response.body()?.responseCode == 200) {
                    Toast.makeText(context, "Profil berhasil diperbarui", Toast.LENGTH_SHORT).show()
                    response.body()?.content?.let { it ->
                        val sessionManager = SessionManager(requireContext())
                        sessionManager.updateUserDetails(
                            it.name, it.batch, it.imageUrl, it.email, 
                            it.contact, it.profession, it.location, it.location,
                            it.bio, it.instagram, it.linkedin, it.education
                        )
                    }
                } else {
                    Toast.makeText(context, "Gagal memperbarui profil", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<com.example.darli.data.model.AlumniUpdateResponse>, t: Throwable) {
                Toast.makeText(context, "Terjadi kesalahan jaringan", Toast.LENGTH_SHORT).show()
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
            val finalUrl = photo.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
            Glide.with(this)
                .load(finalUrl)
                .placeholder(R.drawable.ic_profile_placeholder)
                .error(R.drawable.ic_profile_placeholder)
                .into(profileImage)
        }
    }
}
