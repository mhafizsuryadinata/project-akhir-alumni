package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.bumptech.glide.load.resource.bitmap.CenterCrop
import com.bumptech.glide.load.resource.bitmap.RoundedCorners
import com.example.darli.R
import com.example.darli.data.model.AlbumItem

class AlbumAdapter(
    private var items: List<AlbumItem>,
    private val onItemClick: ((AlbumItem) -> Unit)? = null
) : RecyclerView.Adapter<AlbumAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imgCover: ImageView = view.findViewById(R.id.imgAlbumCover)
        val tvTitle: TextView = view.findViewById(R.id.tvAlbumTitle)
        val tvPhotoCount: TextView = view.findViewById(R.id.tvPhotoCount)
        val tvVideoCount: TextView = view.findViewById(R.id.tvVideoCount)
        val icVideoCount: ImageView = view.findViewById(R.id.icVideoCount)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_album, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = items[position]

        holder.tvTitle.text = item.namaAlbum ?: "Album"
        holder.tvPhotoCount.text = item.photoCount.toString()

        if (item.videoCount > 0) {
            holder.tvVideoCount.text = item.videoCount.toString()
            holder.tvVideoCount.visibility = View.VISIBLE
            holder.icVideoCount.visibility = View.VISIBLE
        } else {
            holder.tvVideoCount.visibility = View.GONE
            holder.icVideoCount.visibility = View.GONE
        }

        Glide.with(holder.itemView.context)
            .load(item.coverUrl)
            .placeholder(R.drawable.bg_circle_blue_light)
            .error(R.drawable.bg_circle_blue_light)
            .centerCrop()
            .into(holder.imgCover)

        holder.itemView.setOnClickListener {
            onItemClick?.invoke(item)
        }
    }

    override fun getItemCount() = items.size

    fun updateData(newItems: List<AlbumItem>) {
        items = newItems
        notifyDataSetChanged()
    }
}
