package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.Lowongan
import java.text.SimpleDateFormat
import java.util.Locale
import java.util.Date

class LowonganAdapter(
    private var lowonganList: List<Lowongan>,
    private val onItemClick: (Lowongan) -> Unit
) : RecyclerView.Adapter<LowonganAdapter.LowonganViewHolder>() {

    class LowonganViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val ivLogo: ImageView = view.findViewById(R.id.ivCompanyLogo)
        val tvTitle: TextView = view.findViewById(R.id.tvJobTitle)
        val tvCompany: TextView = view.findViewById(R.id.tvCompanyName)
        val tvSalary: TextView = view.findViewById(R.id.tvJobSalary)
        val tvDeadline: TextView = view.findViewById(R.id.tvDeadline)
        val btnDetail: Button = view.findViewById(R.id.btnDetailJob)
        
        // Tags
        val tvTag1: TextView = view.findViewById(R.id.tvTag1)
        val tvTag2: TextView = view.findViewById(R.id.tvTag2)
        val tvTag3: TextView = view.findViewById(R.id.tvTag3)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): LowonganViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_lowongan, parent, false)
        return LowonganViewHolder(view)
    }

    override fun onBindViewHolder(holder: LowonganViewHolder, position: Int) {
        val job = lowonganList[position]
        
        holder.tvTitle.text = job.judul ?: "Tanpa Judul"
        holder.tvCompany.text = job.perusahaan ?: "-"
        holder.tvSalary.text = job.gaji ?: "Undisclosed"
        
        // Format Deadline
        if (!job.tanggal_tutup.isNullOrEmpty()) {
            holder.tvDeadline.text = "Berakhir: ${job.tanggal_tutup}"
        } else {
            holder.tvDeadline.text = "Segera"
        }

        // Bind Tags
        holder.tvTag1.text = job.tipe_pekerjaan ?: "N/A" // e.g. Full-time
        holder.tvTag2.text = job.lokasi ?: "Remote"      // e.g. Jakarta
        holder.tvTag3.visibility = View.GONE             // Hide 3rd tag for now as we lack data

        if (!job.logo.isNullOrEmpty()) {
            val imageUrl = job.logo.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
            Glide.with(holder.itemView.context)
                .load(imageUrl)
                .placeholder(R.drawable.ic_work)
                .error(R.drawable.ic_work)
                .into(holder.ivLogo)
        } else {
            holder.ivLogo.setImageResource(R.drawable.ic_work)
        }

        holder.btnDetail.setOnClickListener { onItemClick(job) }
        holder.itemView.setOnClickListener { onItemClick(job) }
    }

    override fun getItemCount() = lowonganList.size

    fun updateData(newList: List<Lowongan>) {
        lowonganList = newList
        notifyDataSetChanged()
    }
}
