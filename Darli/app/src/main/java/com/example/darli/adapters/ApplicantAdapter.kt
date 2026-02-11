package com.example.darli.adapters
 
 import android.view.LayoutInflater
 import android.view.View
 import android.view.ViewGroup
 import android.widget.ImageView
 import android.widget.TextView
 import android.widget.Toast
 import androidx.recyclerview.widget.RecyclerView
 import com.bumptech.glide.Glide
 import com.example.darli.R
 import com.example.darli.data.model.Applicant
 import com.google.android.material.button.MaterialButton
 
 class ApplicantAdapter(
     private val applicants: List<Applicant>
 ) : RecyclerView.Adapter<ApplicantAdapter.ApplicantViewHolder>() {
 
     class ApplicantViewHolder(view: View) : RecyclerView.ViewHolder(view) {
         val ivPhoto: ImageView = view.findViewById(R.id.ivApplicantPhoto)
         val tvName: TextView = view.findViewById(R.id.tvApplicantName)
         val tvClass: TextView = view.findViewById(R.id.tvApplicantClass)
         val tvTime: TextView = view.findViewById(R.id.tvAppliedTime)
         val btnDownload: MaterialButton = view.findViewById(R.id.btnDownloadCv)
         val btnReject: MaterialButton = view.findViewById(R.id.btnReject)
         val btnAccept: MaterialButton = view.findViewById(R.id.btnAccept)
     }
 
     override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ApplicantViewHolder {
         val view = LayoutInflater.from(parent.context)
             .inflate(R.layout.item_applicant, parent, false)
         return ApplicantViewHolder(view)
     }
 
     override fun onBindViewHolder(holder: ApplicantViewHolder, position: Int) {
         val applicant = applicants[position]
         
         holder.tvName.text = applicant.name
         holder.tvClass.text = "Class of ${applicant.year} • ${applicant.major}"
         holder.tvTime.text = applicant.timeAgo
         
         holder.ivPhoto.setImageResource(R.drawable.ic_profile_placeholder) // Placeholder for now
 
         holder.btnDownload.setOnClickListener {
             Toast.makeText(holder.itemView.context, "Downloading CV...", Toast.LENGTH_SHORT).show()
         }
         
         holder.btnReject.setOnClickListener {
             Toast.makeText(holder.itemView.context, "Applicant Rejected", Toast.LENGTH_SHORT).show()
         }
         
         holder.btnAccept.setOnClickListener {
             Toast.makeText(holder.itemView.context, "Applicant Accepted", Toast.LENGTH_SHORT).show()
         }
     }
 
     override fun getItemCount() = applicants.size
 }
