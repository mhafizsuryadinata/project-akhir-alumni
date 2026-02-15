package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.MyApplication

class MyApplicationsAdapter(
    private var list: List<MyApplication>,
    private val onClick: (MyApplication) -> Unit
) : RecyclerView.Adapter<MyApplicationsAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val ivLogo: ImageView = view.findViewById(R.id.ivLogo)
        val tvJobTitle: TextView = view.findViewById(R.id.tvJobTitle)
        val tvCompany: TextView = view.findViewById(R.id.tvCompany)
        val tvStatus: TextView = view.findViewById(R.id.tvStatus)
        val tvAppliedDate: TextView = view.findViewById(R.id.tvAppliedDate)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_my_application, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = list[position]
        holder.tvJobTitle.text = item.judul_lowongan
        holder.tvCompany.text = item.perusahaan
        holder.tvAppliedDate.text = "Dilamar pada: ${item.applied_at}"
        holder.tvStatus.text = item.final_status

        // Status Background/Color Logic
        when (item.final_status.lowercase()) {
            "diterima", "accepted", "lulus" -> {
                holder.tvStatus.setBackgroundResource(R.drawable.bg_chip_status_accepted)
            }
            "ditolak", "rejected" -> {
                holder.tvStatus.setBackgroundResource(R.drawable.bg_chip_status_rejected)
            }
            else -> {
                holder.tvStatus.setBackgroundResource(R.drawable.bg_chip_status_pending)
            }
        }

        if (!item.logo.isNullOrEmpty()) {
            val imageUrl = item.logo.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
            Glide.with(holder.itemView.context)
                .load(imageUrl)
                .placeholder(R.drawable.ic_work)
                .error(R.drawable.ic_work)
                .into(holder.ivLogo)
        } else {
            holder.ivLogo.setImageResource(R.drawable.ic_work)
        }

        holder.itemView.setOnClickListener { onClick(item) }
    }

    override fun getItemCount(): Int = list.size

    fun updateData(newList: List<MyApplication>) {
        list = newList
        notifyDataSetChanged()
    }
}
