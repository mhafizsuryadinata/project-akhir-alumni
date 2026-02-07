package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import android.util.Log
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.EventAdapter
import com.example.darli.data.model.EventResponse
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class EventFragment : Fragment() {

    private lateinit var rvEvent: RecyclerView
    private lateinit var adapter: EventAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var layoutError: LinearLayout
    private lateinit var btnRetry: Button
    private lateinit var btnBack: ImageView

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_event, container, false)

        rvEvent = view.findViewById(R.id.rvEvent)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
        layoutError = view.findViewById(R.id.layoutError)
        btnRetry = view.findViewById(R.id.btnRetry)
        
        btnRetry.setOnClickListener { fetchEvents() }
        btnBack = view.findViewById(R.id.btnBack)

        setupRecyclerView()
        fetchEvents()

        btnBack.setOnClickListener {
            parentFragmentManager.beginTransaction()
                .replace(R.id.nav_host_fragment, MenuFragment())
                .commit()
        }

        return view
    }

    private fun setupRecyclerView() {
        adapter = EventAdapter(emptyList()) { event ->
            // Detail event could be implemented here or dialog
            Toast.makeText(context, "Detail: ${event.title}", Toast.LENGTH_SHORT).show()
        }
        rvEvent.layoutManager = LinearLayoutManager(context)
        rvEvent.adapter = adapter
    }

    private fun fetchEvents() {
        progressBar.visibility = View.VISIBLE
        layoutError.visibility = View.GONE

        Log.d("DarliDebug", "Fetching events from: ${ApiClient.instance.toString()}") // Basic check

        ApiClient.instance.getEvents().enqueue(object : Callback<EventResponse> {
            override fun onResponse(
                call: Call<EventResponse>,
                response: Response<EventResponse>
            ) {
                progressBar.visibility = View.GONE
                Log.d("DarliDebug", "Response Code: ${response.code()}")
                
                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    Log.d("DarliDebug", "Event List Size: ${list.size}")
                    
                    if (list.isNotEmpty()) {
                        adapter.updateData(list)
                        layoutError.visibility = View.GONE
                    } else {
                        tvEmpty.text = "Belum ada agenda kegiatan"
                        layoutError.visibility = View.VISIBLE
                    }
                } else {
                    Log.e("DarliDebug", "Error Body: ${response.errorBody()?.string()}")
                    tvEmpty.text = "Gagal memuat data (${response.code()})"
                    layoutError.visibility = View.VISIBLE
                    Toast.makeText(context, "Gagal memuat event", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<EventResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Log.e("DarliDebug", "onFailure: ${t.message}", t)
                tvEmpty.text = "Gagal terhubung: ${t.message}"
                layoutError.visibility = View.VISIBLE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
