package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.EditText
import android.widget.RatingBar
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.example.darli.data.model.StoreCommentResponse
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class AddCommentFragment : Fragment() {

    private lateinit var etComment: EditText
    private lateinit var ratingBar: RatingBar
    private lateinit var btnSubmit: Button

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_add_comment, container, false)

        etComment = view.findViewById(R.id.etComment)
        ratingBar = view.findViewById(R.id.ratingBar)
        btnSubmit = view.findViewById(R.id.btnSubmit)

        view.findViewById<View>(R.id.btnBack).setOnClickListener {
            findNavController().popBackStack()
        }

        btnSubmit.setOnClickListener {
            submitComment()
        }

        return view
    }

    private fun submitComment() {
        val comment = etComment.text.toString().trim()
        val rating = ratingBar.rating.toInt()

        if (comment.isEmpty()) {
            etComment.error = "Komentar tidak boleh kosong"
            return
        }

        if (rating == 0) {
            Toast.makeText(context, "Silakan berikan rating bintang", Toast.LENGTH_SHORT).show()
            return
        }

        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()

        if (userId == -1) {
            Toast.makeText(context, "Sesi berakhir, silakan login kembali", Toast.LENGTH_SHORT).show()
            return
        }

        btnSubmit.isEnabled = false
        btnSubmit.text = "Mengirim..."

        ApiClient.instance.storeComment(userId, comment, rating).enqueue(object : Callback<StoreCommentResponse> {
            override fun onResponse(call: Call<StoreCommentResponse>, response: Response<StoreCommentResponse>) {
                btnSubmit.isEnabled = true
                btnSubmit.text = "Kirim Masukan"
                
                if (response.isSuccessful) {
                    Toast.makeText(context, response.body()?.message ?: "Berhasil", Toast.LENGTH_LONG).show()
                    findNavController().popBackStack()
                } else {
                    Toast.makeText(context, "Gagal mengirim data", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<StoreCommentResponse>, t: Throwable) {
                btnSubmit.isEnabled = true
                btnSubmit.text = "Kirim Masukan"
                Toast.makeText(context, "Terjadi kesalahan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
