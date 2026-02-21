package com.example.darli.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.R
import com.example.darli.data.model.Faq

class FaqAdapter(
    private var list: List<Faq>
) : RecyclerView.Adapter<FaqAdapter.ViewHolder>() {

    private val expandedPositions = mutableSetOf<Int>()

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvQuestion: TextView = view.findViewById(R.id.tvFaqQuestion)
        val tvAnswer: TextView = view.findViewById(R.id.tvFaqAnswer)
        val ivChevron: ImageView = view.findViewById(R.id.ivFaqChevron)
        val layoutHeader: View = view.findViewById(R.id.layoutFaqHeader)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_faq, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val faq = list[position]

        holder.tvQuestion.text = faq.question
        holder.tvAnswer.text = faq.answer

        val isExpanded = expandedPositions.contains(position)
        holder.tvAnswer.visibility = if (isExpanded) View.VISIBLE else View.GONE
        holder.ivChevron.rotation = if (isExpanded) 270f else 90f

        holder.layoutHeader.setOnClickListener {
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

    fun updateData(newList: List<Faq>) {
        list = newList
        expandedPositions.clear()
        notifyDataSetChanged()
    }
}
