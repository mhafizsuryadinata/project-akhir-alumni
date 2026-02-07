package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import androidx.annotation.DrawableRes
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.bumptech.glide.load.resource.drawable.DrawableTransitionOptions
import com.example.darli.R

class ImageSliderAdapter(
    private val images: List<Int> // Daftar resource gambar
) : RecyclerView.Adapter<ImageSliderAdapter.ImageSliderViewHolder>() {

    // ViewHolder untuk menampung view dari setiap item slider
    inner class ImageSliderViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val imageView: ImageView = itemView.findViewById(R.id.imageViewSlide)
    }

    // Membuat ViewHolder baru
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ImageSliderViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_slider_image, parent, false)
        return ImageSliderViewHolder(view)
    }

    // Mengikat data ke ViewHolder
    override fun onBindViewHolder(holder: ImageSliderViewHolder, position: Int) {
        val imageRes = images.getOrNull(position) ?: return
        
        // Menggunakan Glide untuk memuat gambar dengan animasi
        Glide.with(holder.itemView.context)
            .load(imageRes)
            .centerCrop()
            .diskCacheStrategy(com.bumptech.glide.load.engine.DiskCacheStrategy.ALL)
            .transition(DrawableTransitionOptions.withCrossFade())
            .error(android.R.drawable.ic_menu_gallery) // Gambar default jika error
            .into(holder.imageView)
    }

    // Mengembalikan jumlah item dalam daftar
    override fun getItemCount(): Int = images.size
}
