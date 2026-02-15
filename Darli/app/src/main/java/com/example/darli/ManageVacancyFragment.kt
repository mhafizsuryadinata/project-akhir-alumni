package com.example.darli
 
 import android.os.Bundle
 import android.view.LayoutInflater
 import android.view.View
 import android.view.ViewGroup
 import android.widget.ImageView
 import android.widget.TextView
 import android.widget.Toast
 import androidx.fragment.app.Fragment
 import androidx.navigation.fragment.findNavController
 import androidx.recyclerview.widget.LinearLayoutManager
 import androidx.recyclerview.widget.RecyclerView
 import com.example.darli.adapters.ApplicantAdapter
 import com.example.darli.data.model.Applicant
 import com.example.darli.data.model.Lowongan
 
 class ManageVacancyFragment : Fragment() {
 
     private var lowongan: Lowongan? = null
 
     companion object {
         private const val ARG_LOWONGAN = "arg_lowongan"
 
         fun newInstance(lowongan: Lowongan): ManageVacancyFragment {
             val fragment = ManageVacancyFragment()
             val args = Bundle()
             args.putSerializable(ARG_LOWONGAN, lowongan)
             fragment.arguments = args
             return fragment
         }
     }
 
     override fun onCreateView(
         inflater: LayoutInflater, container: ViewGroup?,
         savedInstanceState: Bundle?
     ): View? {
         val view = inflater.inflate(R.layout.fragment_manage_vacancy, container, false)
         
         lowongan = arguments?.getSerializable(ARG_LOWONGAN) as? Lowongan
         
         setupUI(view)
         
         return view
     }
 
     private fun setupUI(view: View) {
         val btnBack = view.findViewById<ImageView>(R.id.btnBack)
         val tvTitle = view.findViewById<TextView>(R.id.tvJobTitle)
         val tvCompany = view.findViewById<TextView>(R.id.tvCompany)
         val tvLocation = view.findViewById<TextView>(R.id.tvLocation)
         val tvType = view.findViewById<TextView>(R.id.tvJobType)
         val tvStatus = view.findViewById<TextView>(R.id.tvStatus)
         val rvApplicants = view.findViewById<RecyclerView>(R.id.rvApplicants)
 
         btnBack.setOnClickListener {
             findNavController().popBackStack()
         }
 
         lowongan?.let { job ->
             tvTitle.text = job.judul
             tvCompany.text = job.perusahaan
             tvLocation.text = job.lokasi ?: "Remote"
             tvType.text = job.tipe_pekerjaan ?: "Full-time"
             tvStatus.text = job.status ?: "Active"
         }
 
         // Mock Applicants
         val applicants = listOf(
             Applicant(1, "Ahmad Fauzi", "2018", "Marketing", "2h ago", null),
             Applicant(2, "Siti Rahma", "2019", "Computer Science", "5h ago", null),
             Applicant(3, "Budi Santoso", "2020", "Design", "1d ago", null)
         )
 
         rvApplicants.layoutManager = LinearLayoutManager(context)
         rvApplicants.adapter = ApplicantAdapter(applicants)
     }
 }
