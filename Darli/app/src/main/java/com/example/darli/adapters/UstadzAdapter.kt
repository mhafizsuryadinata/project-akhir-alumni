package com.example.darli.adapters

import android.content.Context
import android.content.Intent
import android.net.Uri
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.KontakUstadz
import de.hdodenhof.circleimageview.CircleImageView

class UstadzAdapter(
    private var ustadzList: List<KontakUstadz>,
    private val onItemClick: (KontakUstadz) -> Unit = {}
) : RecyclerView.Adapter<UstadzAdapter.UstadzViewHolder>() {

    class UstadzViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imgUstadz: CircleImageView = view.findViewById(R.id.imgUstadz)
        val tvName: TextView = view.findViewById(R.id.tvName)
        val tvJabatan: TextView = view.findViewById(R.id.tvJabatan)
        val tvBidang: TextView = view.findViewById(R.id.tvBidang)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): UstadzViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_ustadz_card, parent, false)
        return UstadzViewHolder(view)
    }

    override fun onBindViewHolder(holder: UstadzViewHolder, position: Int) {
        val ustadz = ustadzList[position]
        
        holder.tvName.text = ustadz.nama
        holder.tvJabatan.text = ustadz.jabatan
        holder.tvBidang.text = ustadz.bidang ?: "-"

        if (!ustadz.foto.isNullOrEmpty()) {
            val imageUrl = ustadz.foto.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
            
            Glide.with(holder.itemView.context)
                .load(imageUrl)
                .placeholder(R.drawable.ic_profile_placeholder)
                .error(R.drawable.ic_profile_placeholder)
                .into(holder.imgUstadz)
        } else {
            holder.imgUstadz.setImageResource(R.drawable.ic_profile_placeholder)
        }

        holder.itemView.setOnClickListener {
            onItemClick(ustadz)
        }
    }

    override fun getItemCount() = ustadzList.size

    fun updateData(newList: List<KontakUstadz>) {
        ustadzList = newList
        notifyDataSetChanged()
    }

    companion object {
        fun openWhatsApp(context: Context, number: String) {
            try {
                val formattedNumber = if (number.startsWith("0")) {
                    "62" + number.substring(1)
                } else {
                    number
                }
                val intent = Intent(Intent.ACTION_VIEW)
                intent.data = Uri.parse("https://api.whatsapp.com/send?phone=$formattedNumber")
                context.startActivity(intent)
            } catch (e: Exception) {
                // Handle error
            }
        }
    }
}
