package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.GalleryItem

class CampusLifeAdapter(private val items: List<GalleryItem>) :
    RecyclerView.Adapter<CampusLifeAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imageView: ImageView = view.findViewById(R.id.imgCampusLife)
        val titleView: TextView = view.findViewById(R.id.tvCampusLifeTitle)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_campus_life, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = items[position]
        holder.titleView.text = item.title ?: "Kegiatan"
        
        Glide.with(holder.itemView.context)
            .load(item.image)
            .placeholder(R.drawable.bg_rounded_pill_white_alpha) // Placeholder
            .error(R.drawable.bg_rounded_pill_white_alpha)
            .centerCrop()
            .into(holder.imageView)
    }

    override fun getItemCount() = items.size
}
