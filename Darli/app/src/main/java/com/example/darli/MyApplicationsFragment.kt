package com.example.darli

import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.ProgressBar
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.MyApplicationsAdapter
import com.example.darli.data.model.MyApplicationsResponse
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class MyApplicationsFragment : Fragment() {

    private lateinit var rvMyApplications: RecyclerView
    private lateinit var adapter: MyApplicationsAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var layoutEmpty: View
    private lateinit var btnBack: ImageView
    private lateinit var sessionManager: SessionManager

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_my_applications, container, false)
        sessionManager = SessionManager(requireContext())

        rvMyApplications = view.findViewById(R.id.rvMyApplications)
        progressBar = view.findViewById(R.id.progressBar)
        layoutEmpty = view.findViewById(R.id.layoutEmpty)
        btnBack = view.findViewById(R.id.btnBack)

        setupRecyclerView()
        fetchData()

        btnBack.setOnClickListener {
            findNavController().popBackStack()
        }

        return view
    }

    private fun setupRecyclerView() {
        adapter = MyApplicationsAdapter(emptyList()) { application ->
            // Detail logic if needed, for now just show a toast or stay here
            Toast.makeText(requireContext(), "Status: ${application.final_status}", Toast.LENGTH_SHORT).show()
        }
        rvMyApplications.layoutManager = LinearLayoutManager(context)
        rvMyApplications.adapter = adapter
    }

    private fun fetchData() {
        val userId = sessionManager.getUserId()
        if (userId == -1) {
            Toast.makeText(requireContext(), "User session error", Toast.LENGTH_SHORT).show()
            return
        }

        progressBar.visibility = View.VISIBLE
        layoutEmpty.visibility = View.GONE

        ApiClient.instance.getMyApplications(userId).enqueue(object : Callback<MyApplicationsResponse> {
            override fun onResponse(
                call: Call<MyApplicationsResponse>,
                response: Response<MyApplicationsResponse>
            ) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    val list = response.body()?.content ?: emptyList()
                    if (list.isNotEmpty()) {
                        adapter.updateData(list)
                        layoutEmpty.visibility = View.GONE
                    } else {
                        layoutEmpty.visibility = View.VISIBLE
                    }
                } else {
                    Toast.makeText(requireContext(), "Gagal memuat data", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<MyApplicationsResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(requireContext(), "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
