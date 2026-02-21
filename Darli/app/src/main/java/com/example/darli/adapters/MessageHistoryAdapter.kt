package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.LinearLayout
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.R
import com.example.darli.data.model.ContactMessage

class MessageHistoryAdapter(
    private var list: List<ContactMessage>
) : RecyclerView.Adapter<MessageHistoryAdapter.ViewHolder>() {

    private val expandedPositions = mutableSetOf<Int>()

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvDate: TextView = view.findViewById(R.id.tvMsgDate)
        val tvStatus: TextView = view.findViewById(R.id.tvMsgStatus)
        val tvSubject: TextView = view.findViewById(R.id.tvMsgSubject)
        val tvPreview: TextView = view.findViewById(R.id.tvMsgPreview)
        val layoutReply: LinearLayout = view.findViewById(R.id.layoutReply)
        val tvReplyDate: TextView = view.findViewById(R.id.tvReplyDate)
        val tvReplyContent: TextView = view.findViewById(R.id.tvReplyContent)
        val tvToggleReply: TextView = view.findViewById(R.id.tvToggleReply)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_message_history, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val msg = list[position]

        holder.tvDate.text = msg.created_at ?: "-"
        holder.tvSubject.text = msg.subject
        holder.tvPreview.text = msg.message

        val hasReply = !msg.admin_reply.isNullOrEmpty()

        if (hasReply) {
            holder.tvStatus.text = "DIBALAS"
            holder.tvStatus.setTextColor(0xFF059669.toInt())
            holder.tvStatus.setBackgroundColor(0xFFECFDF5.toInt())
            holder.tvReplyContent.text = msg.admin_reply
            holder.tvReplyDate.text = msg.replied_at ?: "-"
            holder.tvToggleReply.text = "Lihat Balasan"
            holder.tvToggleReply.visibility = View.VISIBLE
        } else {
            holder.tvStatus.text = "MENUNGGU"
            holder.tvStatus.setTextColor(0xFFF59E0B.toInt())
            holder.tvStatus.setBackgroundColor(0xFFFEF3C7.toInt())
            holder.tvToggleReply.visibility = View.GONE
        }

        val isExpanded = expandedPositions.contains(position)
        holder.layoutReply.visibility = if (isExpanded && hasReply) View.VISIBLE else View.GONE
        holder.tvToggleReply.text = if (isExpanded) "Sembunyikan" else "Lihat Balasan"

        holder.tvToggleReply.setOnClickListener {
            val pos = holder.adapterPosition
            if (pos == RecyclerView.NO_POSITION) return@setOnClickListener

            if (expandedPositions.contains(pos)) {
                expandedPositions.remove(pos)
            } else {
                expandedPositions.add(pos)
            }
            notifyItemChanged(pos)
        }
    }

    override fun getItemCount() = list.size

    fun updateData(newList: List<ContactMessage>) {
        list = newList
        expandedPositions.clear()
        notifyDataSetChanged()
    }
}
