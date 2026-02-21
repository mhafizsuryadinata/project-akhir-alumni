package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.AlbumMediaItem

class AlbumMediaAdapter(
    private var items: List<AlbumMediaItem>,
    private val onItemClick: (AlbumMediaItem) -> Unit,
    private val onItemLongClick: (AlbumMediaItem) -> Unit
) : RecyclerView.Adapter<AlbumMediaAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imgContent: ImageView = view.findViewById(R.id.imgMediaContent)
        val icVideo: ImageView = view.findViewById(R.id.icVideoType)
        val tvPending: TextView = view.findViewById(R.id.tvPendingStatus)
        val icSelected: ImageView = view.findViewById(R.id.icSelected)
    }

    private val selectedItems = mutableSetOf<AlbumMediaItem>()
    var isSelectionMode = false 
        private set

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_album_media, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = items[position]

        // Load thumbnail/image
        Glide.with(holder.itemView.context)
            .load(item.filePath)
            .placeholder(R.drawable.bg_rounded_pill_white_alpha)
            .centerCrop()
            .into(holder.imgContent)

        // Show video icon if applicable
        holder.icVideo.visibility = if (item.tipe == "video") View.VISIBLE else View.GONE

        // Show pending status if not approved by both admin and pimpinan
        val isPending = item.statusAdmin != "approved" || item.statusPimpinan != "approved"
        holder.tvPending.visibility = if (isPending) View.VISIBLE else View.GONE

        // Handle selection state
        holder.icSelected.visibility = if (selectedItems.contains(item)) View.VISIBLE else View.GONE

        holder.itemView.setOnClickListener { 
            if (isSelectionMode) {
                toggleSelection(item)
            } else {
                onItemClick(item) 
            }
        }
        
        holder.itemView.setOnLongClickListener {
            if (!isSelectionMode) {
                isSelectionMode = true
                toggleSelection(item)
                onItemLongClick(item)
            }
            true // Consume the long click event
        }
    }

    override fun getItemCount() = items.size

    fun updateData(newItems: List<AlbumMediaItem>) {
        items = newItems
        notifyDataSetChanged()
    }

    private fun toggleSelection(item: AlbumMediaItem) {
        if (selectedItems.contains(item)) {
            selectedItems.remove(item)
            if (selectedItems.isEmpty()) {
                isSelectionMode = false
            }
        } else {
            selectedItems.add(item)
        }
        notifyDataSetChanged()
    }

    fun getSelectedItems(): List<AlbumMediaItem> = selectedItems.toList()

    fun clearSelection() {
        selectedItems.clear()
        isSelectionMode = false
        notifyDataSetChanged()
    }
}
