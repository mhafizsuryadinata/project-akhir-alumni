package com.example.darli.adapters

import android.content.Intent
import android.net.Uri
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.AlbumMediaItem
import com.example.darli.utils.ZoomableImageView

class FullscreenMediaAdapter(
    private val mediaList: List<AlbumMediaItem>
) : RecyclerView.Adapter<RecyclerView.ViewHolder>() {

    companion object {
        private const val TYPE_IMAGE = 0
        private const val TYPE_VIDEO = 1
    }

    override fun getItemViewType(position: Int): Int {
        return if (mediaList[position].tipe == "video") TYPE_VIDEO else TYPE_IMAGE
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): RecyclerView.ViewHolder {
        return if (viewType == TYPE_IMAGE) {
            val view = LayoutInflater.from(parent.context).inflate(R.layout.item_fullscreen_image, parent, false)
            ImageViewHolder(view)
        } else {
            val view = LayoutInflater.from(parent.context).inflate(R.layout.item_fullscreen_video, parent, false)
            VideoViewHolder(view)
        }
    }

    override fun onBindViewHolder(holder: RecyclerView.ViewHolder, position: Int) {
        val media = mediaList[position]
        if (holder is ImageViewHolder) {
            Glide.with(holder.itemView.context)
                .load(media.filePath)
                .into(holder.imageView)
        } else if (holder is VideoViewHolder) {
            // For video, we might just show a thumbnail and play button that opens external intent for now
            // Or use a VideoView if preferred
            Glide.with(holder.itemView.context)
                .load(media.filePath) // Glide can fetch video frames
                .into(holder.thumbnailView)
                
            holder.playButton.setOnClickListener {
                val intent = Intent(Intent.ACTION_VIEW, Uri.parse(media.filePath))
                intent.setDataAndType(Uri.parse(media.filePath), "video/*")
                holder.itemView.context.startActivity(intent)
            }
        }
    }

    override fun getItemCount(): Int = mediaList.size

    class ImageViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imageView: ZoomableImageView = view.findViewById(R.id.zoomableImageView)
    }

    class VideoViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val thumbnailView: ImageView = view.findViewById(R.id.ivVideoThumbnail)
        val playButton: ImageView = view.findViewById(R.id.ivPlayButton)
    }
}
