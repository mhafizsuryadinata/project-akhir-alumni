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

class LowonganAdapter(
    private var lowonganList: List<Lowongan>,
    private val onItemClick: (Lowongan) -> Unit
) : RecyclerView.Adapter<LowonganAdapter.LowonganViewHolder>() {

    class LowonganViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val ivLogo: ImageView = view.findViewById(R.id.ivCompanyLogo)
        val tvTitle: TextView = view.findViewById(R.id.tvJobTitle)
        val tvCompany: TextView = view.findViewById(R.id.tvCompanyName)
        val tvType: TextView = view.findViewById(R.id.tvJobType)
        val tvLocation: TextView = view.findViewById(R.id.tvJobLocation)
        val tvSalary: TextView = view.findViewById(R.id.tvJobSalary)
        val tvDeadline: TextView = view.findViewById(R.id.tvDeadline)
        val btnDetail: Button = view.findViewById(R.id.btnDetailJob)
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
        holder.tvType.text = job.tipe_pekerjaan ?: "-"
        holder.tvLocation.text = job.lokasi ?: "-"
        holder.tvSalary.text = job.gaji ?: "-"
        holder.tvDeadline.text = "Berakhir: ${job.tanggal_tutup ?: "-"}"

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
