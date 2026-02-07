package com.example.darli

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.appcompat.widget.Toolbar
import androidx.fragment.app.Fragment
import com.bumptech.glide.Glide
import com.example.darli.data.model.InfoPondok

class InfoDetailFragment : Fragment() {

    private var info: InfoPondok? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {
            info = it.getSerializable("info") as? InfoPondok
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_info_detail, container, false)
        setupUI(view)
        return view
    }

    private fun setupUI(view: View) {
        val toolbar = view.findViewById<Toolbar>(R.id.toolbar)
        toolbar.setNavigationOnClickListener {
            requireActivity().onBackPressed()
        }

        info?.let { item ->
            view.findViewById<TextView>(R.id.tvDetailTitle).text = item.judul
            view.findViewById<TextView>(R.id.tvDetailContent).text = item.konten
            view.findViewById<TextView>(R.id.tvDetailType).text = item.jenis.uppercase()
            view.findViewById<TextView>(R.id.tvDetailDate).text = item.created_at

            val imageView = view.findViewById<ImageView>(R.id.ivDetailImage)
            if (!item.gambar.isNullOrEmpty()) {
                val imageUrl = item.gambar.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
                Glide.with(this)
                    .load(imageUrl)
                    .placeholder(R.drawable.logo_darli)
                    .into(imageView)
            }
        }
    }
}
