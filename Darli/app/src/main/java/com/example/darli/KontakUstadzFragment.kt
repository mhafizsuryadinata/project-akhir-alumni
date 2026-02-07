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
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.UstadzAdapter
import com.example.darli.data.model.KontakUstadzResponse
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class KontakUstadzFragment : Fragment() {

    private lateinit var rvUstadz: RecyclerView
    private lateinit var adapter: UstadzAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var btnBack: ImageView

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_kontak_ustadz, container, false)

        rvUstadz = view.findViewById(R.id.rvUstadz)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
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
        adapter = UstadzAdapter(emptyList()) { ustadz ->
            // Navigate to detail fragment
            val bundle = android.os.Bundle().apply {
                putString("nama", ustadz.nama)
                putString("jabatan", ustadz.jabatan)
                putString("bidang", ustadz.bidang ?: "")
                putString("no_hp", ustadz.no_hp)
                putString("email", ustadz.email ?: "-")
                putString("foto", ustadz.foto ?: "")
            }
            findNavController().navigate(R.id.ustadzDetailFragment, bundle)
        }
        rvUstadz.layoutManager = LinearLayoutManager(context)
        rvUstadz.adapter = adapter
    }

    private fun fetchData() {
        progressBar.visibility = View.VISIBLE
        tvEmpty.visibility = View.GONE

        ApiClient.instance.getKontakUstadz().enqueue(object : Callback<KontakUstadzResponse> {
            override fun onResponse(
                call: Call<KontakUstadzResponse>,
                response: Response<KontakUstadzResponse>
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
                    Toast.makeText(context, "Gagal memuat data", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<KontakUstadzResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
