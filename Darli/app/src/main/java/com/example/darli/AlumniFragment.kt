package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.AlumniAdapter
import com.example.darli.data.model.Alumni

import android.widget.ProgressBar
import android.widget.Toast
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class AlumniFragment : Fragment() {

    private lateinit var rvAlumni: RecyclerView
    private lateinit var alumniAdapter: AlumniAdapter
    private lateinit var progressBar: ProgressBar

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_alumni, container, false)

        rvAlumni = view.findViewById(R.id.rvAlumni)
        progressBar = view.findViewById(R.id.progressBar)
        
        setupRecyclerView()
        setupListeners()
        fetchAlumniData()

        return view
    }

    private fun setupRecyclerView() {
        alumniAdapter = AlumniAdapter(emptyList()) { alumni ->
            // Navigate to Detail using Navigation Component
            val bundle = android.os.Bundle().apply {
                putString("name", alumni.name ?: "Alumni")
                putString("job", alumni.profession ?: "-")
                putString("angkatan", alumni.batch ?: "-")
                putString("bio", alumni.bio ?: "")
                putString("loc", alumni.location ?: "-")
                putString("email", alumni.email ?: "-")
                putString("phone", alumni.contact ?: "-")
                putString("photo", alumni.imageUrl ?: "")
                putString("address", alumni.address ?: "-")
                putString("instagram", alumni.instagram ?: "")
                putString("linkedin", alumni.linkedin ?: "")
                putString("education", alumni.education ?: "-")
                putString("year_in", alumni.yearIn ?: "?")
                putString("year_out", alumni.yearOut ?: "?")
            }
            findNavController().navigate(R.id.alumniDetailFragment, bundle)
        }

        rvAlumni.apply {
            layoutManager = LinearLayoutManager(context)
            adapter = alumniAdapter
        }
    }

    private fun fetchAlumniData() {
        progressBar.visibility = View.VISIBLE
        ApiClient.instance.getAlumniList().enqueue(object : Callback<List<Alumni>> {
            override fun onResponse(
                call: Call<List<Alumni>>,
                response: Response<List<Alumni>>
            ) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    val alumniData = response.body() ?: emptyList()
                    alumniAdapter.updateData(alumniData)
                } else {
                    Toast.makeText(context, "Gagal mengambil data alumni", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<List<Alumni>>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun setupListeners() {
        // Implement filters if needed
    }
}
