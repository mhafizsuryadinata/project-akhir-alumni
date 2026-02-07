package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.InfoAdapter
import com.example.darli.data.model.InfoPondok
import com.example.darli.data.model.InfoPondokResponse
import com.example.darli.data.network.ApiClient
import androidx.navigation.fragment.findNavController
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class InfoFragment : Fragment() {

    private lateinit var rvInfo: RecyclerView
    private lateinit var adapter: InfoAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var btnBack: ImageView

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_info, container, false)

        rvInfo = view.findViewById(R.id.rvInfo)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
        btnBack = view.findViewById(R.id.btnBack)

        setupRecyclerView()
        fetchInfoPondok()

        btnBack.setOnClickListener {
            parentFragmentManager.beginTransaction()
                .replace(R.id.nav_host_fragment, MenuFragment())
                .commit()
        }

        return view
    }

    private fun setupRecyclerView() {
        adapter = InfoAdapter(emptyList()) { info ->
            val bundle = Bundle()
            bundle.putSerializable("info", info)
            findNavController().navigate(R.id.infoDetailFragment, bundle)
        }
        rvInfo.layoutManager = LinearLayoutManager(context)
        rvInfo.adapter = adapter
    }

    private fun fetchInfoPondok() {
        progressBar.visibility = View.VISIBLE
        tvEmpty.visibility = View.GONE

        ApiClient.instance.getInfoPondok().enqueue(object : Callback<InfoPondokResponse> {
            override fun onResponse(
                call: Call<InfoPondokResponse>,
                response: Response<InfoPondokResponse>
            ) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    if (list.isNotEmpty()) {
                        adapter.updateData(list)
                        tvEmpty.visibility = View.GONE
                    } else {
                        tvEmpty.visibility = View.VISIBLE
                    }
                } else {
                    Toast.makeText(context, "Gagal memuat info", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<InfoPondokResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
