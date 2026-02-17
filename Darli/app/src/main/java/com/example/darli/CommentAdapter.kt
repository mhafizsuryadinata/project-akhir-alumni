package com.example.darli

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.RatingBar
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.data.model.Comment

class CommentAdapter(
    private var comments: List<Comment>,
    private val currentUserId: Int,
    private val onDeleteClickListener: (Comment) -> Unit
) : RecyclerView.Adapter<CommentAdapter.CommentViewHolder>() {

    class CommentViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val ivUserPhoto: ImageView = view.findViewById(R.id.ivUserPhoto)
        val tvUserName: TextView = view.findViewById(R.id.tvUserName)
        val tvContent: TextView = view.findViewById(R.id.tvContent)
        val ratingBar: RatingBar = view.findViewById(R.id.ratingBar)
        val tvDate: TextView = view.findViewById(R.id.tvDate)
        
        val tvToggleReplies: TextView = view.findViewById(R.id.tvToggleReplies)
        val llRepliesContainer: android.widget.LinearLayout = view.findViewById(R.id.llRepliesContainer)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): CommentViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_comment, parent, false)
        return CommentViewHolder(view)
    }

    override fun onBindViewHolder(holder: CommentViewHolder, position: Int) {
        val comment = comments[position]
        
        holder.tvUserName.text = comment.user_name
        holder.tvContent.text = comment.content
        holder.ratingBar.rating = comment.rating.toFloat()
        holder.tvDate.text = comment.created_at

        // 1. Profile Photo
        if (!comment.user_photo.isNullOrEmpty()) {
             var photoPath = comment.user_photo
             
             // Remove leading slash
             if (photoPath.startsWith("/")) {
                 photoPath = photoPath.substring(1)
             }

             val baseUrl = "http://10.0.2.2:8000/" 
             var finalUrl = if (photoPath.startsWith("http")) {
                 photoPath
             } else {
                 baseUrl + photoPath
             }

             // Handle localhost for emulator
             finalUrl = finalUrl.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
             
             Glide.with(holder.itemView.context)
                .load(finalUrl)
                .placeholder(R.drawable.ic_profile_placeholder)
                .error(R.drawable.ic_profile_placeholder)
                .into(holder.ivUserPhoto)
        } else {
            holder.ivUserPhoto.setImageResource(R.drawable.ic_profile_placeholder)
        }

        // 2. Replies Logic
        holder.llRepliesContainer.removeAllViews()
        val replies = mutableListOf<View>()

        // Admin Reply
        if (!comment.admin_reply.isNullOrEmpty()) {
            val replyView = LayoutInflater.from(holder.itemView.context).inflate(R.layout.item_comment_reply, holder.llRepliesContainer, false)
            replyView.findViewById<TextView>(R.id.tvReplySender).text = "Admin"
            replyView.findViewById<TextView>(R.id.tvReplyContent).text = comment.admin_reply
            replyView.findViewById<TextView>(R.id.tvReplyDate).text = comment.admin_reply_date ?: ""
            replies.add(replyView)
        }

        // Mudir Reply
        if (!comment.mudir_reply.isNullOrEmpty()) {
            val replyView = LayoutInflater.from(holder.itemView.context).inflate(R.layout.item_comment_reply, holder.llRepliesContainer, false)
            replyView.findViewById<TextView>(R.id.tvReplySender).text = "Pimpinan"
            replyView.findViewById<TextView>(R.id.tvReplyContent).text = comment.mudir_reply
             replyView.findViewById<TextView>(R.id.tvReplyDate).text = comment.mudir_reply_date ?: ""
            replies.add(replyView)
        }

        // Other Replies
        comment.replies.forEach { reply ->
            val replyView = LayoutInflater.from(holder.itemView.context).inflate(R.layout.item_comment_reply, holder.llRepliesContainer, false)
            replyView.findViewById<TextView>(R.id.tvReplySender).text = reply.user_name
            replyView.findViewById<TextView>(R.id.tvReplyContent).text = reply.content
            replyView.findViewById<TextView>(R.id.tvReplyDate).text = reply.created_at
            replies.add(replyView)
        }

        // 3. Toggle Visibility
        if (replies.isNotEmpty()) {
            holder.tvToggleReplies.visibility = View.VISIBLE
            holder.tvToggleReplies.text = "Lihat ${replies.size} Balasan"
            
            // Add views but keep container GONE initially
            replies.forEach { holder.llRepliesContainer.addView(it) }
            holder.llRepliesContainer.visibility = View.GONE

            var isExpanded = false
            holder.tvToggleReplies.setOnClickListener {
                isExpanded = !isExpanded
                if (isExpanded) {
                    holder.llRepliesContainer.visibility = View.VISIBLE
                    holder.tvToggleReplies.text = "Sembunyikan Balasan"
                } else {
                     holder.llRepliesContainer.visibility = View.GONE
                     holder.tvToggleReplies.text = "Lihat ${replies.size} Balasan"
                }
            }
        } else {
            holder.tvToggleReplies.visibility = View.GONE
            holder.llRepliesContainer.visibility = View.GONE
        }
    }

    override fun getItemCount() = comments.size

    fun updateData(newComments: List<Comment>) {
        comments = newComments
        notifyDataSetChanged()
    }
}
