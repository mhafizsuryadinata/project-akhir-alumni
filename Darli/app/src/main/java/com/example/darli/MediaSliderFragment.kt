package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.TextView
import androidx.fragment.app.Fragment
import androidx.viewpager2.widget.ViewPager2
import com.example.darli.adapters.FullscreenMediaAdapter
import com.example.darli.data.model.AlbumMediaItem
import com.google.gson.Gson
import com.google.gson.reflect.TypeToken

class MediaSliderFragment : Fragment() {

    private var initialPosition: Int = 0
    private var mediaList: List<AlbumMediaItem> = emptyList()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        
        val listJson = arguments?.getString("media_list") ?: "[]"
        val type = object : TypeToken<List<AlbumMediaItem>>() {}.type
        mediaList = Gson().fromJson(listJson, type)
        
        initialPosition = arguments?.getInt("initial_position") ?: 0
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_media_slider, container, false)
        
        val viewPager = view.findViewById<ViewPager2>(R.id.viewPagerMedia)
        val tvCounter = view.findViewById<TextView>(R.id.tvMediaCounter)
        val btnClose = view.findViewById<ImageButton>(R.id.btnCloseFullscreen)
        
        val adapter = FullscreenMediaAdapter(mediaList)
        viewPager.adapter = adapter
        
        viewPager.setCurrentItem(initialPosition, false)
        tvCounter.text = "${initialPosition + 1} / ${mediaList.size}"
        
        viewPager.registerOnPageChangeCallback(object : ViewPager2.OnPageChangeCallback() {
            override fun onPageSelected(position: Int) {
                super.onPageSelected(position)
                tvCounter.text = "${position + 1} / ${mediaList.size}"
            }
        })
        
        btnClose.setOnClickListener {
            parentFragmentManager.popBackStack()
        }

        return view
    }
}
