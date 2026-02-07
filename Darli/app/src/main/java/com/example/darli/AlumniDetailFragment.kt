package com.example.darli

import android.content.ClipData
import android.content.ClipboardManager
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.example.darli.data.model.Alumni
import com.google.android.material.button.MaterialButton
import com.google.android.material.chip.Chip
import com.google.android.material.chip.ChipGroup
import de.hdodenhof.circleimageview.CircleImageView

class AlumniDetailFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_alumni_detail, container, false)

        // Bind Views
        val btnBack: ImageView = view.findViewById(R.id.btnBack)
        val tvHeaderTitle: TextView = view.findViewById(R.id.tvHeaderTitle)
        val imgProfile: CircleImageView = view.findViewById(R.id.imgProfile)
        
        val tvDetailName: TextView = view.findViewById(R.id.tvDetailName)
        val tvDetailPeriod: TextView = view.findViewById(R.id.tvDetailPeriod)
        val tvDetailProfession: TextView = view.findViewById(R.id.tvDetailProfession)
        val tvDetailAddress: TextView = view.findViewById(R.id.tvDetailAddress)
        val tvDetailBio: TextView = view.findViewById(R.id.tvDetailBio)
        val tvDetailEducation: TextView = view.findViewById(R.id.tvDetailEducation)
        
        // Social Media Views (Bio Section)
        val layoutInstagramApp: View = view.findViewById(R.id.layoutInstagramApp)
        val tvInstagramApp: TextView = view.findViewById(R.id.tvInstagramApp)
        
        val layoutLinkedinApp: View = view.findViewById(R.id.layoutLinkedinApp)
        val tvLinkedinApp: TextView = view.findViewById(R.id.tvLinkedinApp)
        
        // Bottom Action Buttons
        val btnSendEmail: MaterialButton = view.findViewById(R.id.btnSendEmail)
        val btnContactWhatsApp: MaterialButton = view.findViewById(R.id.btnContactWhatsApp)
        
        // Map Views
        val wvMap: android.webkit.WebView = view.findViewById(R.id.wvMap)
        val progressBarMap: android.widget.ProgressBar = view.findViewById(R.id.progressBarMap)
        val viewMapOverlay: View = view.findViewById(R.id.viewMapOverlay)
        
        tvHeaderTitle.text = "PROFIL ALUMNI"

        // Get data from arguments
        arguments?.let { args ->
            // ... (existing args retrieval) ...
            val name = args.getString("name", "Alumni")
            val profession = args.getString("job", "-")
            val bio = args.getString("bio", "")
            val email = args.getString("email", "-")
            val phone = args.getString("phone", "-")
            val photo = args.getString("photo", "")
            val address = args.getString("address", "-")
            val instagram = args.getString("instagram", "")
            val linkedin = args.getString("linkedin", "")
            val education = args.getString("education", "")
            val yearIn = args.getString("year_in", "?")
            val yearOut = args.getString("year_out", "?")

            tvDetailName.text = name
            tvDetailPeriod.text = "Alumni $yearIn - $yearOut"
            tvDetailProfession.text = if (profession.isNotEmpty()) profession.uppercase() else "-"
            tvDetailAddress.text = if (address.isNotEmpty()) address.uppercase() else "-"
            tvDetailBio.text = if (bio.isNotEmpty()) bio else "Belum ada pesan singkat atau bio."
            
            // Set Education
            if (education.isNotEmpty() && education != "-") {
                tvDetailEducation.text = education
            } else {
                tvDetailEducation.text = "Belum ada data pendidikan lanjutan."
            }

            // Load photo
            if (photo.isNotEmpty()) {
                val finalUrl = photo.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
                Glide.with(this)
                    .load(finalUrl)
                    .placeholder(R.drawable.ic_profile_placeholder)
                    .error(R.drawable.ic_profile_placeholder)
                    .into(imgProfile)
            }
            
            // Social Media Logic
            if (instagram.isNotEmpty() && instagram != "-") {
                layoutInstagramApp.visibility = View.VISIBLE
                tvInstagramApp.text = instagram
                layoutInstagramApp.setOnClickListener {
                     openUrl("https://instagram.com/" + instagram.replace("@", "").replace("https://instagram.com/", ""))
                }
            } else {
                layoutInstagramApp.visibility = View.GONE
            }

            if (linkedin.isNotEmpty() && linkedin != "-") {
                layoutLinkedinApp.visibility = View.VISIBLE
                tvLinkedinApp.text = linkedin
                layoutLinkedinApp.setOnClickListener {
                    var url = linkedin
                    if (!url.startsWith("http")) {
                        url = "https://$url"
                    }
                    openUrl(url)
                }
            } else {
                layoutLinkedinApp.visibility = View.GONE
            }

            // Bottom Actions
            btnContactWhatsApp.setOnClickListener {
                if (phone.isNotEmpty() && phone != "-") {
                     openWhatsApp(phone)
                } else {
                    Toast.makeText(context, "Nomor WhatsApp tidak tersedia", Toast.LENGTH_SHORT).show()
                }
            }
            
            btnSendEmail.setOnClickListener {
                if (email.isNotEmpty() && email != "-") {
                    sendEmail(email)
                } else {
                    Toast.makeText(context, "Email tidak tersedia", Toast.LENGTH_SHORT).show()
                }
            }
            
            // Map Logic
            val mapQuery = if (address.isNotEmpty() && address != "-") address else "Padang, Indonesia"
            val mapUrl = "https://www.google.com/maps?q=" + Uri.encode(mapQuery) + "&output=embed"
            
            val mapHtml = """
                <html>
                    <body style="margin: 0; padding: 0;">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0;" 
                            src="$mapUrl" 
                            allowfullscreen>
                        </iframe>
                    </body>
                </html>
            """.trimIndent()
            
            wvMap.settings.javaScriptEnabled = true
            wvMap.webViewClient = object : android.webkit.WebViewClient() {
                override fun onPageFinished(view: android.webkit.WebView?, url: String?) {
                    super.onPageFinished(view, url)
                    progressBarMap.visibility = View.GONE
                }
            }
            wvMap.loadDataWithBaseURL(null, mapHtml, "text/html", "utf-8", null)
            
            // Interaction: Click overlay opens real map app
            viewMapOverlay.setOnClickListener {
                 val gmmIntentUri = Uri.parse("geo:0,0?q=" + Uri.encode(mapQuery))
                 val mapIntent = Intent(Intent.ACTION_VIEW, gmmIntentUri)
                 mapIntent.setPackage("com.google.android.apps.maps")
                 try {
                     startActivity(mapIntent)
                 } catch (e: Exception) {
                      openUrl("https://www.google.com/maps/search/?api=1&query=" + Uri.encode(mapQuery))
                 }
            }
        }

        btnBack.setOnClickListener {
            findNavController().popBackStack()
        }

        return view
    }



    private fun openWhatsApp(number: String) {
        try {
            val cleanNumber = number.replace("+", "").replace("-", "").replace(" ", "")
            val formattedNumber = if (cleanNumber.startsWith("0")) {
                "62" + cleanNumber.substring(1)
            } else {
                cleanNumber
            }
            val intent = Intent(Intent.ACTION_VIEW)
            intent.data = Uri.parse("https://api.whatsapp.com/send?phone=$formattedNumber")
            startActivity(intent)
        } catch (e: Exception) {
            Toast.makeText(context, "Tidak dapat membuka WhatsApp", Toast.LENGTH_SHORT).show()
        }
    }
    
    private fun openUrl(url: String) {
        try {
            val intent = Intent(Intent.ACTION_VIEW)
            intent.data = Uri.parse(url)
            startActivity(intent)
        } catch (e: Exception) {
            Toast.makeText(context, "Tidak dapat membuka URL", Toast.LENGTH_SHORT).show()
        }
    }

    private fun copyToClipboard(label: String, text: String) {
        val clipboard = requireContext().getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
        val clip = ClipData.newPlainText(label, text)
        clipboard.setPrimaryClip(clip)
    }

    private fun sendEmail(email: String) {
        try {
            val intent = Intent(Intent.ACTION_SENDTO)
            intent.data = Uri.parse("mailto:$email")
            startActivity(intent)
        } catch (e: Exception) {
            Toast.makeText(context, "Tidak dapat membuka aplikasi email", Toast.LENGTH_SHORT).show()
        }
    }

    companion object {
        fun newInstance(alumni: Alumni): AlumniDetailFragment {
            val fragment = AlumniDetailFragment()
            val args = Bundle()
            args.putString("name", alumni.name ?: "Alumni")
            args.putString("job", alumni.profession ?: "-")
            args.putString("angkatan", alumni.batch ?: "-")
            args.putString("bio", alumni.bio ?: "")
            args.putString("loc", alumni.location ?: "-")
            args.putString("email", alumni.email ?: "-")
            args.putString("phone", alumni.contact ?: "-")
            args.putString("photo", alumni.imageUrl ?: "")
            args.putString("address", alumni.address ?: "-")
            args.putString("instagram", alumni.instagram ?: "")
            args.putString("linkedin", alumni.linkedin ?: "")
            args.putString("education", alumni.education ?: "-")
            fragment.arguments = args
            return fragment
        }
    }
}

