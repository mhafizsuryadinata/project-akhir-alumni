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
import com.example.darli.data.model.Alumni

class AlumniAdapter(
    private var alumniList: List<Alumni>,
    private val onItemClick: (Alumni) -> Unit
) : RecyclerView.Adapter<AlumniAdapter.AlumniViewHolder>() {

    class AlumniViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val ivPhoto: ImageView = itemView.findViewById(R.id.imgAlumni)
        val tvName: TextView = itemView.findViewById(R.id.tvName)
        val tvBatch: TextView = itemView.findViewById(R.id.tvBatch)
        val tvProfession: TextView = itemView.findViewById(R.id.tvProfession)
        val tvLocation: TextView = itemView.findViewById(R.id.tvLocation)
        val btnViewProfile: Button = itemView.findViewById(R.id.btnViewProfile)
        val btnChat: ImageView = itemView.findViewById(R.id.btnChat)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): AlumniViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_alumni_card, parent, false)
        return AlumniViewHolder(view)
    }

    override fun onBindViewHolder(holder: AlumniViewHolder, position: Int) {
        val alumni = alumniList[position]

        holder.tvName.text = alumni.name ?: "-"
        holder.tvProfession.text = alumni.profession ?: "-"
        holder.tvLocation.text = alumni.location ?: "-"

        // Format batch label
        val batchYear = alumni.yearOut ?: alumni.batch ?: "-"
        holder.tvBatch.text = "ANGKATAN $batchYear"

        val imageUrl = if (!alumni.imageUrl.isNullOrEmpty()) {
            alumni.imageUrl.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
        } else {
            ""
        }

        Glide.with(holder.itemView.context)
            .load(imageUrl)
            .placeholder(R.drawable.ic_profile_placeholder)
            .error(R.drawable.ic_profile_placeholder)
            .circleCrop()
            .into(holder.ivPhoto)

        holder.btnViewProfile.setOnClickListener {
            onItemClick(alumni)
        }

        holder.itemView.setOnClickListener {
            onItemClick(alumni)
        }
    }

    override fun getItemCount(): Int = alumniList.size

    fun updateData(newList: List<Alumni>) {
        alumniList = newList
        notifyDataSetChanged()
    }
}
