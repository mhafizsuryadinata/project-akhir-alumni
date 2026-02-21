package com.example.darli.adapters

import android.content.Context
import android.content.Intent
import android.net.Uri
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.darli.R
import com.example.darli.data.model.KontakUstadz
import de.hdodenhof.circleimageview.CircleImageView

class SupportTeamAdapter(
    private var list: List<KontakUstadz>
) : RecyclerView.Adapter<SupportTeamAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imgPhoto: CircleImageView = view.findViewById(R.id.imgUstadzPhoto)
        val tvName: TextView = view.findViewById(R.id.tvUstadzName)
        val tvRole: TextView = view.findViewById(R.id.tvUstadzRole)
        val btnWhatsapp: ImageButton = view.findViewById(R.id.btnWhatsapp)
        val btnEmail: ImageButton = view.findViewById(R.id.btnEmail)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_support_team, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val ustadz = list[position]

        holder.tvName.text = ustadz.nama
        val roleText = if (!ustadz.bidang.isNullOrEmpty()) {
            "${ustadz.jabatan} (${ustadz.bidang})"
        } else {
            ustadz.jabatan
        }
        holder.tvRole.text = roleText.uppercase()

        if (!ustadz.foto.isNullOrEmpty()) {
            val imageUrl = ustadz.foto.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
            Glide.with(holder.itemView.context)
                .load(imageUrl)
                .placeholder(R.drawable.ic_profile_placeholder)
                .error(R.drawable.ic_profile_placeholder)
                .into(holder.imgPhoto)
        } else {
            holder.imgPhoto.setImageResource(R.drawable.ic_profile_placeholder)
        }

        holder.btnWhatsapp.setOnClickListener {
            openWhatsApp(holder.itemView.context, ustadz.no_hp)
        }

        holder.btnEmail.setOnClickListener {
            if (!ustadz.email.isNullOrEmpty()) {
                val intent = Intent(Intent.ACTION_SENDTO).apply {
                    data = Uri.parse("mailto:${ustadz.email}")
                }
                try { holder.itemView.context.startActivity(intent) } catch (_: Exception) {}
            }
        }
    }

    override fun getItemCount() = list.size

    fun updateData(newList: List<KontakUstadz>) {
        list = newList
        notifyDataSetChanged()
    }

    private fun openWhatsApp(context: Context, number: String) {
        try {
            val formattedNumber = if (number.startsWith("0")) {
                "62" + number.substring(1)
            } else {
                number.replace("+", "")
            }
            val intent = Intent(Intent.ACTION_VIEW)
            intent.data = Uri.parse("https://api.whatsapp.com/send?phone=$formattedNumber")
            context.startActivity(intent)
        } catch (_: Exception) {}
    }
}
