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
import android.text.Editable
import android.text.TextWatcher
import android.widget.EditText
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.LowonganAdapter
import com.example.darli.data.model.Lowongan
import com.example.darli.data.model.LowonganResponse
import com.example.darli.data.network.ApiClient
import androidx.navigation.fragment.findNavController
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class LowonganFragment : Fragment() {

    private lateinit var rvLowongan: RecyclerView
    private lateinit var adapter: LowonganAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var layoutError: LinearLayout
    private lateinit var btnBack: ImageView
    private lateinit var fabAddLowongan: com.google.android.material.floatingactionbutton.ExtendedFloatingActionButton
    private lateinit var etSearch: EditText
    private lateinit var chipAll: TextView
    private lateinit var chipTech: TextView
    private lateinit var chipFinance: TextView
    private lateinit var chipBumn: TextView

    private var fullLowonganList: List<Lowongan> = emptyList()
    private var currentSearchQuery: String = ""
    private var currentCategory: String = "Semua"

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_lowongan, container, false)

        rvLowongan = view.findViewById(R.id.rvLowongan)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
        layoutError = view.findViewById(R.id.layoutError)
        val btnMyApplications = view.findViewById<ImageView>(R.id.btnMyApplications)
        btnBack = view.findViewById(R.id.btnBack)
        fabAddLowongan = view.findViewById(R.id.fabAddLowongan)
        etSearch = view.findViewById(R.id.etSearch)
        chipAll = view.findViewById(R.id.chipAll)
        chipTech = view.findViewById(R.id.chipTech)
        chipFinance = view.findViewById(R.id.chipFinance)
        chipBumn = view.findViewById(R.id.chipBumn)

        setupRecyclerView()
        setupListeners()
        fetchData()

        btnBack.setOnClickListener {
            findNavController().popBackStack()
        }

        btnMyApplications.setOnClickListener {
            findNavController().navigate(R.id.myApplicationsFragment)
        }

        fabAddLowongan.setOnClickListener {
            findNavController().navigate(R.id.addLowonganFragment)
        }

        return view
    }

    private fun setupListeners() {
        etSearch.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {
                currentSearchQuery = s.toString()
                filterData()
            }
            override fun afterTextChanged(s: Editable?) {}
        })

        chipAll.setOnClickListener { selectCategory("Semua") }
        chipTech.setOnClickListener { selectCategory("Teknologi") }
        chipFinance.setOnClickListener { selectCategory("Keuangan") }
        chipBumn.setOnClickListener { selectCategory("BUMN") }
    }

    private fun selectCategory(category: String) {
        currentCategory = category
        updateChipStyles()
        filterData()
    }

    private fun updateChipStyles() {
        val activeBg = R.drawable.bg_chip_active
        val inactiveBg = R.drawable.bg_chip_inactive
        val activeText = resources.getColor(R.color.white, null)
        val inactiveText = resources.getColor(R.color.gray_700, null)

        val chips = mapOf(
            "Semua" to chipAll,
            "Teknologi" to chipTech,
            "Keuangan" to chipFinance,
            "BUMN" to chipBumn
        )

        chips.forEach { (cat, view) ->
            if (cat == currentCategory) {
                view.setBackgroundResource(activeBg)
                view.setTextColor(activeText)
            } else {
                view.setBackgroundResource(inactiveBg)
                view.setTextColor(inactiveText)
            }
        }
    }

    private fun filterData() {
        val filteredList = fullLowonganList.filter { job ->
            val matchesSearch = job.judul?.contains(currentSearchQuery, ignoreCase = true) == true ||
                    job.perusahaan?.contains(currentSearchQuery, ignoreCase = true) == true ||
                    job.deskripsi?.contains(currentSearchQuery, ignoreCase = true) == true

            val matchesCategory = if (currentCategory == "Semua") {
                true
            } else {
                job.judul?.contains(currentCategory, ignoreCase = true) == true ||
                job.perusahaan?.contains(currentCategory, ignoreCase = true) == true ||
                job.deskripsi?.contains(currentCategory, ignoreCase = true) == true
            }

            matchesSearch && matchesCategory
        }

        adapter.updateData(filteredList)
        
        if (filteredList.isEmpty()) {
            tvEmpty.text = if (currentSearchQuery.isNotEmpty()) "Pencarian tidak ditemukan" else "Belum ada lowongan"
            layoutError.visibility = View.VISIBLE
            rvLowongan.visibility = View.GONE
        } else {
            layoutError.visibility = View.GONE
            rvLowongan.visibility = View.VISIBLE
        }
    }

    private fun setupRecyclerView() {
        adapter = LowonganAdapter(emptyList()) { job ->
            val bundle = Bundle().apply {
                putSerializable("arg_lowongan", job)
            }
            findNavController().navigate(R.id.lowonganDetailFragment, bundle)
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
                    fullLowonganList = list
                    Log.d("DarliDebug", "Lowongan List Size: ${list.size}")
                    
                    filterData()
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
