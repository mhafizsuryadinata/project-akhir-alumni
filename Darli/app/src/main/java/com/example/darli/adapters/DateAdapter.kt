package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.core.content.ContextCompat
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.R
import java.text.SimpleDateFormat
import java.util.*

class DateAdapter(
    private val days: List<Date>,
    private val onDateSelected: (Date) -> Unit
) : RecyclerView.Adapter<DateAdapter.DateViewHolder>() {

    private var selectedPosition = -1

    init {
        // Default select today if in list
        val today = Calendar.getInstance().apply {
            set(Calendar.HOUR_OF_DAY, 0)
            set(Calendar.MINUTE, 0)
            set(Calendar.SECOND, 0)
            set(Calendar.MILLISECOND, 0)
        }.time

        selectedPosition = days.indexOfFirst { 
            val cal1 = Calendar.getInstance().apply { time = it }
            val cal2 = Calendar.getInstance().apply { time = today }
            cal1.get(Calendar.DAY_OF_YEAR) == cal2.get(Calendar.DAY_OF_YEAR) &&
            cal1.get(Calendar.YEAR) == cal2.get(Calendar.YEAR)
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): DateViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_date, parent, false)
        return DateViewHolder(view)
    }

    override fun onBindViewHolder(holder: DateViewHolder, position: Int) {
        holder.bind(days[position], position == selectedPosition)
    }

    override fun getItemCount(): Int = days.size

    inner class DateViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        private val tvDayName: TextView = itemView.findViewById(R.id.tvDayName)
        private val tvDateNumber: TextView = itemView.findViewById(R.id.tvDateNumber)

        fun bind(date: Date, isSelected: Boolean) {
            val dayNameFormat = SimpleDateFormat("EEE", Locale.getDefault())
            val dayNumberFormat = SimpleDateFormat("dd", Locale.getDefault())

            tvDayName.text = dayNameFormat.format(date)
            tvDateNumber.text = dayNumberFormat.format(date)

            if (isSelected) {
                tvDateNumber.setBackgroundResource(R.drawable.bg_date_selected)
                tvDateNumber.setTextColor(ContextCompat.getColor(itemView.context, R.color.white))
            } else {
                tvDateNumber.setBackgroundResource(R.drawable.bg_date_unselected)
                tvDateNumber.setTextColor(ContextCompat.getColor(itemView.context, R.color.black))
            }

            itemView.setOnClickListener {
                if (selectedPosition != adapterPosition) {
                    val oldPosition = selectedPosition
                    selectedPosition = adapterPosition
                    notifyItemChanged(oldPosition)
                    notifyItemChanged(selectedPosition)
                    onDateSelected(date)
                }
            }
        }
    }
    
    fun getSelectedDate(): Date? {
        return if (selectedPosition != -1) days[selectedPosition] else null
    }
}
