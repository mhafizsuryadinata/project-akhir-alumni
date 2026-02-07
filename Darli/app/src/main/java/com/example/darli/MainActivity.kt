package com.example.darli

import android.content.Intent
import android.content.res.ColorStateList
import android.graphics.Color
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.view.View
import android.view.ViewTreeObserver
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.navigation.NavController
import androidx.navigation.fragment.NavHostFragment
import androidx.navigation.ui.setupWithNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.viewpager2.widget.ViewPager2
import com.example.darli.adapters.ImageSliderAdapter
import com.example.darli.data.model.CommentListResponse
import com.example.darli.data.network.ApiClient
import com.google.android.material.bottomnavigation.BottomNavigationView
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class MainActivity : AppCompatActivity() {

    private lateinit var sessionManager: SessionManager
    private lateinit var navController: NavController

    private var allTestimonials = listOf<com.example.darli.data.model.Comment>()
    private var isTestimonialsExpanded = false

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        sessionManager = SessionManager(this)
        
        window.statusBarColor = ContextCompat.getColor(this, R.color.web_primary)
        window.decorView.systemUiVisibility = 0 

        val navHostFragment = supportFragmentManager.findFragmentById(R.id.nav_host_fragment) as NavHostFragment
        navController = navHostFragment.navController

        val bottomNavigationView = findViewById<BottomNavigationView>(R.id.bottom_navigation)
        bottomNavigationView.setupWithNavController(navController)

        if (sessionManager.isLoggedIn()) {
            showLoggedInState()
        } else {
            showLandingState()
        }
    }

    // Hero Image Slider Logic
    private val heroImages = listOf(
        R.drawable.alumni3,
        R.drawable.a1,
        R.drawable.a2,
        R.drawable.a3,
        R.drawable.a4,
        R.drawable.a5
    )
    private var currentHeroImageIndex = 0
    private val heroImageHandler = Handler(Looper.getMainLooper())
    private val heroImageRunnable = object : Runnable {
        override fun run() {
            val ivHero = findViewById<ImageView>(R.id.ivHeroBackground)
            if (ivHero != null && ivHero.visibility == View.VISIBLE) {
                currentHeroImageIndex = (currentHeroImageIndex + 1) % heroImages.size
                
                ivHero.animate().alpha(0f).setDuration(500).withEndAction {
                    ivHero.setImageResource(heroImages[currentHeroImageIndex])
                    ivHero.animate().alpha(1f).setDuration(500).start()
                }.start()
                
                heroImageHandler.postDelayed(this, 5000)
            }
        }
    }

    private fun startHeroImageSlider() {
        // Stop any existing callbacks first
        stopHeroImageSlider()
        heroImageHandler.postDelayed(heroImageRunnable, 5000)
    }

    private fun stopHeroImageSlider() {
        heroImageHandler.removeCallbacks(heroImageRunnable)
    }

    private fun showLoggedInState() {
        stopHeroImageSlider()
        findViewById<View>(R.id.landing_view).visibility = View.GONE
        findViewById<View>(R.id.appBarLayout).visibility = View.GONE
        findViewById<View>(R.id.nav_host_fragment).visibility = View.VISIBLE
        findViewById<View>(R.id.nav_divider).visibility = View.VISIBLE
        findViewById<View>(R.id.card_bottom_nav).visibility = View.VISIBLE
    }

    private fun showLandingState() {
        findViewById<View>(R.id.landing_view).visibility = View.VISIBLE
        findViewById<View>(R.id.appBarLayout).visibility = View.VISIBLE
        findViewById<View>(R.id.nav_host_fragment).visibility = View.GONE
        findViewById<View>(R.id.nav_divider).visibility = View.GONE
        findViewById<View>(R.id.card_bottom_nav).visibility = View.GONE
        setupLoginButton()
        fetchTestimonials()
        
        // Start slider
        startHeroImageSlider()
    }
    
    // Restored missing methods
    private fun fetchTestimonials() {
        val rvTestimonials = findViewById<RecyclerView>(R.id.rvTestimonials)
        val tvToggle = findViewById<TextView>(R.id.tvToggleTestimonials)
        if (rvTestimonials == null || tvToggle == null) return

        rvTestimonials.layoutManager = LinearLayoutManager(this)
        fetchStats()
        fetchCampusLife()

        ApiClient.instance.getComments().enqueue(object : Callback<CommentListResponse> {
            override fun onResponse(call: Call<CommentListResponse>, response: Response<CommentListResponse>) {
                if (response.isSuccessful) {
                    val comments = response.body()?.content ?: emptyList()
                    // TEMPORARY DEBUG: Show all comments, ignoring status
                    allTestimonials = comments
                        .sortedByDescending { it.created_at }
                        .take(5) // Take top 5 newest

                    if (allTestimonials.isNotEmpty()) {
                        updateTestimonialsDisplay(rvTestimonials, tvToggle)
                        tvToggle.setOnClickListener {
                            isTestimonialsExpanded = !isTestimonialsExpanded
                            updateTestimonialsDisplay(rvTestimonials, tvToggle)
                        }
                    }
                }
            }
            override fun onFailure(call: Call<CommentListResponse>, t: Throwable) { }
        })
    }

    private fun updateTestimonialsDisplay(rv: RecyclerView, tvToggle: TextView) {
        val displayList = if (isTestimonialsExpanded) allTestimonials else allTestimonials.take(1)
        rv.adapter = CommentAdapter(displayList, -1) { }
        if (allTestimonials.size > 1) {
            tvToggle.visibility = View.VISIBLE
            tvToggle.text = if (isTestimonialsExpanded) "Sembunyikan" else "Lihat Komentar Lainnya"
        } else {
            tvToggle.visibility = View.GONE
        }
    }

    private fun setupLoginButton() {
        val loginIntent = Intent(this, LoginActivity::class.java)
        findViewById<View>(R.id.btnJoinHero)?.setOnClickListener {
            startActivity(loginIntent)
            overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out)
        }
        findViewById<View>(R.id.btnJoinHeroBtn)?.setOnClickListener {
            startActivity(loginIntent)
            overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out)
        }
    }
    
    // ... existing networking methods ...

    override fun onPause() {
        super.onPause()
        stopHeroImageSlider()
    }

    override fun onResume() {
        super.onResume()
        if (!sessionManager.isLoggedIn()) {
            startHeroImageSlider()
        }
    }
    
    private fun fetchStats() {
        ApiClient.instance.getStats().enqueue(object : Callback<com.example.darli.data.model.StatsResponse> {
            override fun onResponse(call: Call<com.example.darli.data.model.StatsResponse>, response: Response<com.example.darli.data.model.StatsResponse>) {
                if (response.isSuccessful) {
                    response.body()?.let {
                        findViewById<TextView>(R.id.tvCountAlumni)?.text = "${it.totalAlumni}+"
                        findViewById<TextView>(R.id.tvCountTeachers)?.text = "${it.totalTeachers}+"
                        findViewById<TextView>(R.id.tvCountEvents)?.text = "${it.totalEvents}+"
                        findViewById<TextView>(R.id.tvCountJobs)?.text = "${it.totalJobs}+"
                    }
                }
            }
            override fun onFailure(call: Call<com.example.darli.data.model.StatsResponse>, t: Throwable) { }
        })
    }

    private fun fetchCampusLife() {
        ApiClient.instance.getGallery().enqueue(object : Callback<com.example.darli.data.model.GalleryResponse> {
            override fun onResponse(call: Call<com.example.darli.data.model.GalleryResponse>, response: Response<com.example.darli.data.model.GalleryResponse>) {
                if (response.isSuccessful) {
                    val items = response.body()?.content ?: emptyList()
                    val rvCampus = findViewById<RecyclerView>(R.id.rvCampusLife)
                    rvCampus?.let {
                        it.layoutManager = LinearLayoutManager(this@MainActivity, LinearLayoutManager.HORIZONTAL, false)
                        it.adapter = com.example.darli.adapters.CampusLifeAdapter(items)
                    }
                }
            }
            override fun onFailure(call: Call<com.example.darli.data.model.GalleryResponse>, t: Throwable) { }
        })
    }
}