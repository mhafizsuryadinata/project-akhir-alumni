package com.example.darli

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.CampusLifeAdapter
import com.example.darli.data.network.ApiClient
import com.example.darli.data.model.GalleryResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class GalleryFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_gallery, container, false)

        view.findViewById<ImageButton>(R.id.btnBack).setOnClickListener {
            parentFragmentManager.popBackStack()
        }

        fetchGallery(view)

        return view
    }

    private fun fetchGallery(view: View) {
        val recyclerView = view.findViewById<RecyclerView>(R.id.rvGallery)
        
        ApiClient.instance.getGallery().enqueue(object : Callback<GalleryResponse> {
            override fun onResponse(call: Call<GalleryResponse>, response: Response<GalleryResponse>) {
                if (response.isSuccessful) {
                    val items = response.body()?.content ?: emptyList()
                    recyclerView.adapter = CampusLifeAdapter(items)
                }
            }

            override fun onFailure(call: Call<GalleryResponse>, t: Throwable) {
                // Silently fail
            }
        })
    }
}
