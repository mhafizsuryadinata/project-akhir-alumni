package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.example.darli.data.model.Event
import com.example.darli.data.network.ApiClient
import com.example.darli.data.network.ApiService
import com.google.android.material.button.MaterialButton
import com.google.gson.Gson
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class EventDetailFragment : Fragment() {

    private lateinit var event: Event
    private lateinit var btnRegister: MaterialButton

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_event_detail, container, false)
        
        // Retrieve Event data
        val eventJson = arguments?.getString("event_json")
        if (eventJson != null) {
            event = Gson().fromJson(eventJson, Event::class.java)
            setupViews(view)
        } else {
            Toast.makeText(context, "Data acara tidak ditemukan", Toast.LENGTH_SHORT).show()
            findNavController().popBackStack()
        }

        return view
    }

    private fun setupViews(view: View) {
        val toolbar = view.findViewById<androidx.appcompat.widget.Toolbar>(R.id.toolbar)
        toolbar.setNavigationOnClickListener { findNavController().popBackStack() }

        val ivHeader = view.findViewById<ImageView>(R.id.ivDetailHeader)
        val tvTitle = view.findViewById<TextView>(R.id.tvDetailTitle)
        val tvDate = view.findViewById<TextView>(R.id.tvDetailDate)
        val tvTime = view.findViewById<TextView>(R.id.tvDetailTime)
        val tvLocation = view.findViewById<TextView>(R.id.tvDetailLocation)
        val tvDesc = view.findViewById<TextView>(R.id.tvDetailDescription)
        val tvCreator = view.findViewById<TextView>(R.id.tvCreator)
        btnRegister = view.findViewById(R.id.btnDetailRegister)

        tvTitle.text = event.title
        tvDate.text = event.date
        tvTime.text = "${event.time} WIB"
        tvLocation.text = event.location
        tvDesc.text = event.description
        tvCreator.text = "Oleh: ${event.creator_name ?: "Admin"}"

        if (!event.image.isNullOrEmpty()) {
            Glide.with(requireContext())
                .load(event.image)
                .placeholder(R.color.gray_light)
                .error(R.color.gray_light)
                .centerCrop()
                .into(ivHeader)
        }

        updateRegisterButtonState()

        btnRegister.setOnClickListener {
            performRegistration()
        }
    }

    private fun updateRegisterButtonState() {
        val sessionManager = SessionManager(requireContext())
        val currentUserId = sessionManager.getUserId()

        if (event.user_id == currentUserId) {
            btnRegister.text = "Anda Pemilik Acara"
            btnRegister.isEnabled = false
            btnRegister.setBackgroundColor(resources.getColor(android.R.color.darker_gray, null))
        } else if (event.is_joined == true) {
            btnRegister.text = "Anda Sudah Terdaftar"
            btnRegister.isEnabled = false
            btnRegister.setBackgroundColor(resources.getColor(R.color.green_primary, null)) // Assuming green exists or use generic
        } else {
            btnRegister.text = "Daftar Sekarang"
            btnRegister.isEnabled = true
        }
    }

    private fun performRegistration() {
        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()
        
        // Disable button to prevent double clicks
        btnRegister.isEnabled = false
        btnRegister.text = "Memproses..."

        val request = ApiService.JoinEventRequest(
            event_id = event.id,
            user_id = userId
        )

        ApiClient.instance.joinEvent(request).enqueue(object : Callback<ApiService.JoinEventResponse> {
            override fun onResponse(
                call: Call<ApiService.JoinEventResponse>,
                response: Response<ApiService.JoinEventResponse>
            ) {
                if (response.isSuccessful && response.body()?.response_code == 200) {
                    Toast.makeText(context, "Berhasil mendaftar acara!", Toast.LENGTH_SHORT).show()
                    // Update local state and button
                    // Note: Event object is immutable-ish data class usually, but let's assume valid
                    // ideally we re-fetch or update local model. 
                    // For now, hack the button state
                    btnRegister.text = "Anda Sudah Terdaftar"
                    btnRegister.setBackgroundColor(resources.getColor(R.color.green_primary, null)) 
                } else {
                    btnRegister.isEnabled = true
                    btnRegister.text = "Daftar Sekarang"
                    val msg = response.body()?.message ?: "Gagal mendaftar"
                    Toast.makeText(context, msg, Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<ApiService.JoinEventResponse>, t: Throwable) {
                btnRegister.isEnabled = true
                btnRegister.text = "Daftar Sekarang"
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
