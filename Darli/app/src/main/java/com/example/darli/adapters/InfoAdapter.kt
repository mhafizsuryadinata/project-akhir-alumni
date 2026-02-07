package com.example.darli.adapters

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.InfoPondok

class InfoAdapter(
    private var infoList: List<InfoPondok>,
    private val onItemClick: (InfoPondok) -> Unit
) : RecyclerView.Adapter<InfoAdapter.InfoViewHolder>() {

    class InfoViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val ivImage: ImageView = view.findViewById(R.id.ivInfoImage)
        val tvType: TextView = view.findViewById(R.id.tvInfoType)
        val tvDate: TextView = view.findViewById(R.id.tvInfoDate)
        val tvTitle: TextView = view.findViewById(R.id.tvInfoTitle)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): InfoViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_info_pondok, parent, false)
        return InfoViewHolder(view)
    }

    override fun onBindViewHolder(holder: InfoViewHolder, position: Int) {
        val info = infoList[position]
        
        holder.tvTitle.text = info.judul
        holder.tvDate.text = info.created_at
        holder.tvType.text = info.jenis

        if (!info.gambar.isNullOrEmpty()) {
            holder.ivImage.visibility = View.VISIBLE
            val imageUrl = info.gambar.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
            
            Glide.with(holder.itemView.context)
                .load(imageUrl)
                .placeholder(android.R.color.darker_gray)
                .error(android.R.color.darker_gray)
                .into(holder.ivImage)
        } else {
            holder.ivImage.visibility = View.GONE
        }

        holder.itemView.setOnClickListener {
            onItemClick(info)
        }
    }

    override fun getItemCount() = infoList.size

    fun updateData(newList: List<InfoPondok>) {
        infoList = newList
        notifyDataSetChanged()
    }
}
