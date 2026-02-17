package com.example.darli

import android.animation.Animator
import android.animation.AnimatorListenerAdapter
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.navigation.fragment.findNavController
import com.example.darli.data.network.ApiClient
import com.example.darli.data.model.*
import com.bumptech.glide.Glide
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.text.SimpleDateFormat
import java.util.*

class MenuFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_menu, container, false)

        setupUI(view)
        setupListeners(view)
        fetchAllData(view)
        animateContent(view)

        return view
    }

    private fun animateContent(view: View) {
        val viewsToAnimate = listOf(
            view.findViewById<View>(R.id.cardStatsHeader),
            view.findViewById<View>(R.id.statsRow2),
            view.findViewById<View>(R.id.cardNewsHighlight),
            view.findViewById<View>(R.id.tvQuickActionsTitle),
            view.findViewById<View>(R.id.gridQuickActions)
        )

        // Initial state
        viewsToAnimate.forEach {
            it.alpha = 0f
            it.translationY = 50f
        }

        // Staggered animation
        viewsToAnimate.forEachIndexed { index, v ->
            v.animate()
                .alpha(1f)
                .translationY(0f)
                .setDuration(500)
                .setStartDelay(100L * index)
                .start()
        }

        // Pulse notification bell
        val notificationBtn = view.findViewById<View>(R.id.btnNotification)
        notificationBtn.animate()
            .scaleX(1.1f)
            .scaleY(1.1f)
            .setDuration(1000)
            .setListener(object : AnimatorListenerAdapter() {
                override fun onAnimationEnd(animation: Animator) {
                    notificationBtn.animate()
                        .scaleX(1f)
                        .scaleY(1f)
                        .setDuration(1000)
                        .setStartDelay(2000)
                        .setListener(this)
                        .start()
                }
            }).start()
    }

    private fun setupUI(view: View) {
        val sessionManager = SessionManager(requireContext())
        val userDetails = sessionManager.getUserDetails()
        
        val name = userDetails["name"] ?: "Alumni"
        val photoUrl = userDetails["photo"] ?: ""

        view.findViewById<TextView>(R.id.tvUserName).text = name
        
        if (photoUrl.isNotEmpty()) {
            var finalUrl = photoUrl.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
            if (!finalUrl.startsWith("http")) {
                finalUrl = "http://10.0.2.2:8000/" + finalUrl
            }
            Glide.with(this)
                .load(finalUrl)
                .placeholder(R.drawable.ic_profile_placeholder)
                .into(view.findViewById<ImageView>(R.id.imgProfile))
        }

        // Set dynamic date pill
        val dateFormat = SimpleDateFormat("d MMMM", Locale("id", "ID"))
        view.findViewById<TextView>(R.id.tvDatePill).text = dateFormat.format(Date())
    }

    private fun setupListeners(view: View) {
        // Notification
        view.findViewById<View>(R.id.btnNotification).setOnClickListener {
            Toast.makeText(context, "Fitur notifikasi akan segera hadir!", Toast.LENGTH_SHORT).show()
        }

        // Quick Actions
        view.findViewById<View>(R.id.cardUstadz).setOnClickListener {
            findNavController().navigate(R.id.kontakUstadzFragment)
        }
        view.findViewById<View>(R.id.cardComments).setOnClickListener {
            findNavController().navigate(R.id.commentListFragment)
        }
        view.findViewById<View>(R.id.cardHelp).setOnClickListener {
            // Placeholder: Open WhatsApp or Contact Info
             Toast.makeText(context, "Silakan hubungi Admin via WhatsApp.", Toast.LENGTH_SHORT).show()
        }
        view.findViewById<View>(R.id.cardGallery).setOnClickListener {
            findNavController().navigate(R.id.galleryFragment)
        }

        // News Highlight
        view.findViewById<View>(R.id.btnReadMore).setOnClickListener {
            findNavController().navigate(R.id.infoFragment)
        }
    }

    private fun fetchAllData(view: View) {
        fetchDashboardStats(view)
        fetchInfoPondok(view)
    }

    private fun fetchDashboardStats(view: View) {
        ApiClient.instance.getStats().enqueue(object : Callback<StatsResponse> {
            override fun onResponse(call: Call<StatsResponse>, response: Response<StatsResponse>) {
                if (response.isSuccessful) {
                    response.body()?.let { data ->
                        view.findViewById<TextView>(R.id.tvStatTotalAlumni).text = String.format("%,d", data.totalAlumni)
                        view.findViewById<TextView>(R.id.tvStatActiveNetworks).text = data.totalTeachers.toString() // Placeholder
                        view.findViewById<TextView>(R.id.tvStatUpcomingEvents).text = data.totalEvents.toString()
                    }
                }
            }
            override fun onFailure(call: Call<StatsResponse>, t: Throwable) {}
        })
    }

    private fun fetchInfoPondok(view: View) {
        ApiClient.instance.getInfoPondok().enqueue(object : Callback<InfoPondokResponse> {
            override fun onResponse(call: Call<InfoPondokResponse>, response: Response<InfoPondokResponse>) {
                if (response.isSuccessful) {
                    response.body()?.content?.let { list ->
                        if (list.isNotEmpty()) {
                            val highlight = list[0]
                            view.findViewById<TextView>(R.id.tvNewsTitle).text = highlight.judul
                            view.findViewById<TextView>(R.id.tvNewsDescription).text = highlight.konten
                            
                            val photoUrl = highlight.gambar ?: ""
                            if (photoUrl.isNotEmpty()) {
                                val finalUrl = photoUrl.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
                                Glide.with(this@MenuFragment)
                                    .load(finalUrl)
                                    .into(view.findViewById<ImageView>(R.id.ivNewsImage))
                            }
                        }
                    }
                }
            }
            override fun onFailure(call: Call<InfoPondokResponse>, t: Throwable) {}
        })
    }
}