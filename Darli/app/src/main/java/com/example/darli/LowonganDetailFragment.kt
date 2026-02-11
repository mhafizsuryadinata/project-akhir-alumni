package com.example.darli
 
 import android.os.Bundle
 import android.view.LayoutInflater
 import android.view.View
 import android.view.ViewGroup
 import android.widget.TextView
 import android.widget.ImageView
 import android.widget.Toast
 import androidx.fragment.app.Fragment
 import com.bumptech.glide.Glide
 import com.example.darli.data.model.Lowongan
 import com.google.android.material.button.MaterialButton
 import com.google.android.material.tabs.TabLayout
 
 class LowonganDetailFragment : Fragment() {
 
     private lateinit var sessionManager: SessionManager
     private var lowongan: Lowongan? = null
 
     companion object {
         private const val ARG_LOWONGAN = "arg_lowongan"
 
         fun newInstance(lowongan: Lowongan): LowonganDetailFragment {
             val fragment = LowonganDetailFragment()
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
         val view = inflater.inflate(R.layout.fragment_lowongan_detail, container, false)
         sessionManager = SessionManager(requireContext())
 
         // Retrieve Data
         lowongan = arguments?.getSerializable(ARG_LOWONGAN) as? Lowongan
 
         setupUI(view)
 
         return view
     }
 
     private fun setupUI(view: View) {
         val ivLogo = view.findViewById<ImageView>(R.id.ivLogo)
         val tvTitle = view.findViewById<TextView>(R.id.tvJobTitle)
         val tvCompany = view.findViewById<TextView>(R.id.tvCompanyInfo)
         val tvLocation = view.findViewById<TextView>(R.id.tvLocation)
         val tvSalary = view.findViewById<TextView>(R.id.tvSalary)
         val tvDeadline = view.findViewById<TextView>(R.id.tvDeadline)
         val tvDescription = view.findViewById<TextView>(R.id.tvDescription)
         val btnAction = view.findViewById<MaterialButton>(R.id.btnAction)
         val btnBack = view.findViewById<ImageView>(R.id.btnBack)
         val tabLayout = view.findViewById<TabLayout>(R.id.tabLayout)
 
         btnBack.setOnClickListener {
             parentFragmentManager.popBackStack()
         }
 
         lowongan?.let { job ->
             tvTitle.text = job.judul
             tvCompany.text = "${job.perusahaan} • ${job.tipe_pekerjaan ?: "N/A"}"
             tvLocation.text = job.lokasi ?: "Remote"
             tvSalary.text = job.gaji ?: "Undisclosed"
             tvDeadline.text = "Berakhir: ${job.tanggal_tutup ?: "-"}"
             tvDescription.text = job.deskripsi ?: "Tidak ada deskripsi."
             
             // Initial Tab State (Description)
             updateTabContent(0, job, tvDescription)
 
             if (!job.logo.isNullOrEmpty()) {
                 val imageUrl = job.logo.replace("127.0.0.1", "10.0.2.2").replace("localhost", "10.0.2.2")
                 Glide.with(this)
                     .load(imageUrl)
                     .placeholder(R.drawable.ic_work)
                     .error(R.drawable.ic_work)
                     .into(ivLogo)
             }
 
             // Owner Check
             val currentUserId = sessionManager.getUserId()
             if (job.user_id == currentUserId) {
                 btnAction.text = "Manage Vacancy"
                 btnAction.setBackgroundColor(resources.getColor(R.color.brand_secondary)) // Use secondary color for manage
                 btnAction.setOnClickListener {
                     // Navigate to Manage Vacancy Fragment
                     parentFragmentManager.beginTransaction()
                         .replace(R.id.nav_host_fragment, ManageVacancyFragment.newInstance(job))
                         .addToBackStack(null)
                         .commit()
                 }
             } else {
                 btnAction.text = "Lamar Sekarang"
                 btnAction.setOnClickListener {
                     Toast.makeText(context, "Fitur Lamar akan segera hadir!", Toast.LENGTH_SHORT).show()
                 }
             }
             
             // Tab Listener
             tabLayout.addOnTabSelectedListener(object : TabLayout.OnTabSelectedListener {
                 override fun onTabSelected(tab: TabLayout.Tab?) {
                     updateTabContent(tab?.position ?: 0, job, tvDescription)
                 }
                 override fun onTabUnselected(tab: TabLayout.Tab?) {}
                 override fun onTabReselected(tab: TabLayout.Tab?) {}
             })
         }
     }
     
     private fun updateTabContent(position: Int, job: Lowongan, tvContent: TextView) {
         when (position) {
             0 -> { // Deskripsi
                 tvContent.text = job.deskripsi ?: "Tidak ada deskripsi."
             }
             1 -> { // Kualifikasi
                 tvContent.text = job.kualifikasi ?: "Tidak ada data kualifikasi."
             }
             2 -> { // Benefit (No data yet)
                 tvContent.text = "Informasi benefit belum tersedia."
             }
         }
     }
 }
