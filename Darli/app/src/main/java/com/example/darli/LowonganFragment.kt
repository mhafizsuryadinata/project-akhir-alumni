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
import com.example.darli.adapters.LowonganAdapter
import com.example.darli.data.model.LowonganResponse
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class LowonganFragment : Fragment() {

    private lateinit var rvLowongan: RecyclerView
    private lateinit var adapter: LowonganAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var layoutError: LinearLayout
    private lateinit var btnRetry: Button
    private lateinit var btnBack: ImageView

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_lowongan, container, false)

        rvLowongan = view.findViewById(R.id.rvLowongan)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
        layoutError = view.findViewById(R.id.layoutError)
        btnRetry = view.findViewById(R.id.btnRetry)

        btnRetry.setOnClickListener { fetchData() }
        btnBack = view.findViewById(R.id.btnBack)

        setupRecyclerView()
        fetchData()

        btnBack.setOnClickListener {
            parentFragmentManager.beginTransaction()
                .replace(R.id.nav_host_fragment, MenuFragment())
                .commit()
        }

        return view
    }

    private fun setupRecyclerView() {
        adapter = LowonganAdapter(emptyList()) { job ->
            // Handle detail click
            parentFragmentManager.beginTransaction()
                .replace(R.id.nav_host_fragment, LowonganDetailFragment.newInstance(job))
                .addToBackStack(null)
                .commit()
        }
        rvLowongan.layoutManager = LinearLayoutManager(context)
        rvLowongan.adapter = adapter
    }

    private fun fetchData() {
        progressBar.visibility = View.VISIBLE
        layoutError.visibility = View.GONE

        Log.d("DarliDebug", "Fetching lowongan from: ${ApiClient.instance.toString()}")

        ApiClient.instance.getLowongan().enqueue(object : Callback<LowonganResponse> {
            override fun onResponse(
                call: Call<LowonganResponse>,
                response: Response<LowonganResponse>
            ) {
                progressBar.visibility = View.GONE
                Log.d("DarliDebug", "Response Code: ${response.code()}")

                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    Log.d("DarliDebug", "Lowongan List Size: ${list.size}")
                    
                    if (list.isNotEmpty()) {
                        adapter.updateData(list)
                        layoutError.visibility = View.GONE
                    } else {
                        tvEmpty.text = "Belum ada lowongan aktif"
                        layoutError.visibility = View.VISIBLE
                    }
                } else {
                    Log.e("DarliDebug", "Error Body: ${response.errorBody()?.string()}")
                    tvEmpty.text = "Gagal memuat lowongan (${response.code()})"
                    layoutError.visibility = View.VISIBLE
                    Toast.makeText(context, "Gagal memuat lowongan", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<LowonganResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Log.e("DarliDebug", "onFailure: ${t.message}", t)
                tvEmpty.text = "Gagal terhubung: ${t.message}"
                layoutError.visibility = View.VISIBLE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
