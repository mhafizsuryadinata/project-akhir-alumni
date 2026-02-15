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
import com.example.darli.data.model.Event

class EventAdapter(
    private var events: List<Event>,
    private val currentUserId: Int,
    private val onDetailClick: (Event) -> Unit,
    private val onRegisterClick: (Event) -> Unit,
    private val onEditClick: (Event) -> Unit,
    private val onDeleteClick: (Event) -> Unit
) : RecyclerView.Adapter<EventAdapter.EventViewHolder>() {

    class EventViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val ivEventImage: ImageView = itemView.findViewById(R.id.ivEventImage)
        val tvYourEvent: TextView = itemView.findViewById(R.id.tvYourEvent)
        val tvEventLocation: TextView = itemView.findViewById(R.id.tvEventLocation)
        val tvEventTitle: TextView = itemView.findViewById(R.id.tvEventTitle)
        val tvEventDate: TextView = itemView.findViewById(R.id.tvEventDate)
        
        val layoutButtonsRegister: View = itemView.findViewById(R.id.layoutButtonsRegister)
        val btnRegister: Button = itemView.findViewById(R.id.btnRegister)
        val btnDetails: Button = itemView.findViewById(R.id.btnDetails)
        
        val layoutButtonsOwner: View = itemView.findViewById(R.id.layoutButtonsOwner)
        val btnEdit: Button = itemView.findViewById(R.id.btnEdit)
        val btnDelete: Button = itemView.findViewById(R.id.btnDelete)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): EventViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_event, parent, false)
        return EventViewHolder(view)
    }

    override fun onBindViewHolder(holder: EventViewHolder, position: Int) {
        val event = events[position]
        
        holder.tvEventTitle.text = event.title
        holder.tvEventLocation.text = event.location
        holder.tvEventDate.text = "${event.date} • ${event.time} WIB" // Assuming date is formatted

        // Image loading
        if (!event.image.isNullOrEmpty()) {
             Glide.with(holder.itemView.context)
                 .load(event.image)
                 .placeholder(R.color.gray_light)
                 .error(R.color.gray_light)
                 .centerCrop()
                 .into(holder.ivEventImage)
        } else {
             holder.ivEventImage.setImageResource(R.color.gray_light)
        }
        
        // Ownership Check
        val isOwner = event.user_id == currentUserId
        
        if (isOwner) {
            holder.tvYourEvent.visibility = View.VISIBLE
            holder.layoutButtonsRegister.visibility = View.GONE
            holder.layoutButtonsOwner.visibility = View.VISIBLE
        } else {
            holder.tvYourEvent.visibility = View.GONE
            holder.layoutButtonsRegister.visibility = View.VISIBLE
            holder.layoutButtonsOwner.visibility = View.GONE
            
            if (event.is_joined == true) {
                 holder.btnRegister.text = "Terdaftar"
                 holder.btnRegister.isEnabled = false
            } else {
                 holder.btnRegister.text = "Daftar"
                 holder.btnRegister.isEnabled = true
            }
        }

        holder.btnDetails.setOnClickListener { onDetailClick(event) }
        holder.btnRegister.setOnClickListener { onRegisterClick(event) }
        holder.btnEdit.setOnClickListener { onEditClick(event) }
        holder.btnDelete.setOnClickListener { onDeleteClick(event) }
    }

    override fun getItemCount(): Int = events.size
    
    fun updateData(newEvents: List<Event>) {
        events = newEvents
        notifyDataSetChanged()
    }
}
