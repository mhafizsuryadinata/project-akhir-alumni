package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.data.model.CommentListResponse
import com.example.darli.data.network.ApiClient
import com.google.android.material.floatingactionbutton.ExtendedFloatingActionButton
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class CommentListFragment : Fragment() {

    private lateinit var rvComments: RecyclerView
    private lateinit var adapter: CommentAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_comment_list, container, false)

        initViews(view)
        fetchComments()

        return view
    }

    private fun initViews(view: View) {
        rvComments = view.findViewById(R.id.rvComments)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
        
        rvComments.layoutManager = LinearLayoutManager(context)
        
        val sessionManager = SessionManager(requireContext())
        val currentUserId = sessionManager.getUserId()

        adapter = CommentAdapter(emptyList(), currentUserId) { comment ->
            showDeleteConfirmation(comment)
        }
        rvComments.adapter = adapter

        view.findViewById<View>(R.id.btnBack).setOnClickListener {
            parentFragmentManager.popBackStack()
        }

        view.findViewById<ExtendedFloatingActionButton>(R.id.fabAddComment).setOnClickListener {
            findNavController().navigate(R.id.addCommentFragment)
        }
    }

    private fun fetchComments() {
        progressBar.visibility = View.VISIBLE
        tvEmpty.visibility = View.GONE

        ApiClient.instance.getComments().enqueue(object : Callback<CommentListResponse> {
            override fun onResponse(call: Call<CommentListResponse>, response: Response<CommentListResponse>) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    val comments = response.body()?.content ?: emptyList()
                    if (comments.isEmpty()) {
                        tvEmpty.visibility = View.VISIBLE
                    } else {
                        adapter.updateData(comments)
                    }
                } else {
                    Toast.makeText(context, "Gagal mengambil data", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<CommentListResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Terjadi kesalahan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun showDeleteConfirmation(comment: com.example.darli.data.model.Comment) {
        androidx.appcompat.app.AlertDialog.Builder(requireContext())
            .setTitle("Hapus Komentar")
            .setMessage("Apakah Anda yakin ingin menghapus komentar ini?")
            .setPositiveButton("Hapus") { _, _ ->
                deleteComment(comment)
            }
            .setNegativeButton("Batal", null)
            .show()
    }

    private fun deleteComment(comment: com.example.darli.data.model.Comment) {
        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()

        progressBar.visibility = View.VISIBLE
        ApiClient.instance.deleteComment(comment.id, userId).enqueue(object : Callback<com.example.darli.data.model.StoreCommentResponse> {
            override fun onResponse(
                call: Call<com.example.darli.data.model.StoreCommentResponse>,
                response: Response<com.example.darli.data.model.StoreCommentResponse>
            ) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful && response.body()?.response_code == 200) {
                    Toast.makeText(context, "Komentar berhasil dihapus", Toast.LENGTH_SHORT).show()
                    fetchComments()
                } else {
                    val errorMsg = response.body()?.message ?: "Gagal menghapus komentar"
                    Toast.makeText(context, errorMsg, Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<com.example.darli.data.model.StoreCommentResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Terjadi kesalahan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
