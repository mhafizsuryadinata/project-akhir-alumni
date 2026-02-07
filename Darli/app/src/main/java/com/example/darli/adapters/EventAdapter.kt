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
import java.text.SimpleDateFormat
import java.util.Locale

class EventAdapter(
    private var eventList: List<Event>,
    private val onItemClick: (Event) -> Unit
) : RecyclerView.Adapter<EventAdapter.EventViewHolder>() {

    class EventViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvMonth: TextView = view.findViewById(R.id.tvEventMonth)
        val tvDay: TextView = view.findViewById(R.id.tvEventDay)
        val tvTitle: TextView = view.findViewById(R.id.tvEventTitle)
        val tvLocation: TextView = view.findViewById(R.id.tvEventLocation)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): EventViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_event_vertical, parent, false)
        return EventViewHolder(view)
    }

    override fun onBindViewHolder(holder: EventViewHolder, position: Int) {
        val event = eventList[position]
        
        holder.tvTitle.text = event.title ?: "Tanpa Judul"
        holder.tvLocation.text = event.location ?: "-"

        // Parse Date (Assuming ISO format or similar)
        val dateStr = event.date ?: ""
        if (dateStr.length >= 10) {
            try {
                val sdf = SimpleDateFormat("yyyy-MM-dd", Locale.getDefault())
                val dateObj = sdf.parse(dateStr)
                dateObj?.let {
                    holder.tvMonth.text = SimpleDateFormat("MMM", Locale.ENGLISH).format(it).uppercase()
                    holder.tvDay.text = SimpleDateFormat("dd", Locale.ENGLISH).format(it)
                }
            } catch (e: Exception) {
                 holder.tvMonth.text = "DEC"
                 holder.tvDay.text = "15"
            }
        }

        holder.itemView.setOnClickListener {
            onItemClick(event)
        }
    }

    override fun getItemCount() = eventList.size

    fun updateData(newList: List<Event>) {
        eventList = newList
        notifyDataSetChanged()
    }
}
