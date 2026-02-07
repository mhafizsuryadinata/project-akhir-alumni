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
import com.google.android.material.button.MaterialButton
import com.google.android.material.chip.Chip
import com.google.android.material.chip.ChipGroup
import de.hdodenhof.circleimageview.CircleImageView

class UstadzDetailFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_profile_detail, container, false)

        // Bind Views
        val btnBack: ImageView = view.findViewById(R.id.btnBack)
        val tvHeaderTitle: TextView = view.findViewById(R.id.tvHeaderTitle)
        val imgProfile: CircleImageView = view.findViewById(R.id.imgProfile)
        val tvName: TextView = view.findViewById(R.id.tvName)
        val tvRole: TextView = view.findViewById(R.id.tvRole)
        val tvProfession: TextView = view.findViewById(R.id.tvProfession)
        val tvBadge: TextView = view.findViewById(R.id.tvBadge)
        val tvPhoneNumber: TextView = view.findViewById(R.id.tvPhoneNumber)
        val tvEmail: TextView = view.findViewById(R.id.tvEmail)
        val chipGroupExpertise: ChipGroup = view.findViewById(R.id.chipGroupExpertise)
        val tvAbout: TextView = view.findViewById(R.id.tvAbout)
        val btnContactWhatsApp: MaterialButton = view.findViewById(R.id.btnContactWhatsApp)
        val btnSendEmail: MaterialButton = view.findViewById(R.id.btnSendEmail)
        val btnCopyPhone: ImageView = view.findViewById(R.id.btnCopyPhone)
        val btnCopyEmail: ImageView = view.findViewById(R.id.btnCopyEmail)
        val tvCareerTitle: TextView = view.findViewById(R.id.tvCareerTitle)

        tvHeaderTitle.text = "Ustadz Profile"
        tvCareerTitle.text = "Expertise & Focus"

        // Get data from arguments
        arguments?.let { args ->
            val name = args.getString("nama", "Ustadz")
            val jabatan = args.getString("jabatan", "-")
            val bidang = args.getString("bidang", "")
            val noHp = args.getString("no_hp", "-")
            val email = args.getString("email", "-")
            val foto = args.getString("foto", "")

            tvName.text = name
            tvRole.text = jabatan
            tvProfession.text = "Pengajar Pondok Pesantren"
            tvBadge.text = "VERIFIED USTADZ"
            tvPhoneNumber.text = noHp
            tvEmail.text = email ?: "-"
            tvAbout.text = "Ustadz $name adalah pengajar di Pondok Pesantren Dar El-Ilmi dengan jabatan sebagai $jabatan."

            // Load photo
            if (foto.isNotEmpty()) {
                val finalUrl = foto.replace("localhost", "10.0.2.2").replace("127.0.0.1", "10.0.2.2")
                Glide.with(this)
                    .load(finalUrl)
                    .placeholder(R.drawable.ic_profile_placeholder)
                    .error(R.drawable.ic_profile_placeholder)
                    .into(imgProfile)
            }

            // Set expertise chips
            chipGroupExpertise.removeAllViews()
            if (!bidang.isNullOrEmpty()) {
                bidang.split(",").forEach { expertise ->
                    val chip = Chip(requireContext())
                    chip.text = expertise.trim()
                    chip.setChipBackgroundColorResource(R.color.light_gray)
                    chip.setTextColor(resources.getColor(R.color.text_primary, null))
                    chip.setChipIconResource(R.drawable.ic_graduation_cap)
                    chip.setChipIconTintResource(R.color.text_secondary)
                    chipGroupExpertise.addView(chip)
                }
            }

            // WhatsApp button
            btnContactWhatsApp.setOnClickListener {
                openWhatsApp(noHp)
            }

            // Email button
            btnSendEmail.setOnClickListener {
                sendEmail(email ?: "")
            }

            // Copy phone
            btnCopyPhone.setOnClickListener {
                copyToClipboard("Phone", noHp)
                Toast.makeText(context, "Nomor HP disalin", Toast.LENGTH_SHORT).show()
            }

            // Copy email
            btnCopyEmail.setOnClickListener {
                copyToClipboard("Email", email ?: "")
                Toast.makeText(context, "Email disalin", Toast.LENGTH_SHORT).show()
            }
        }

        btnBack.setOnClickListener {
            findNavController().popBackStack()
        }

        return view
    }

    private fun openWhatsApp(number: String) {
        try {
            val formattedNumber = if (number.startsWith("0")) {
                "62" + number.substring(1)
            } else {
                number.replace("+", "").replace("-", "").replace(" ", "")
            }
            val intent = Intent(Intent.ACTION_VIEW)
            intent.data = Uri.parse("https://api.whatsapp.com/send?phone=$formattedNumber")
            startActivity(intent)
        } catch (e: Exception) {
            Toast.makeText(context, "Tidak dapat membuka WhatsApp", Toast.LENGTH_SHORT).show()
        }
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

    private fun copyToClipboard(label: String, text: String) {
        val clipboard = requireContext().getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
        val clip = ClipData.newPlainText(label, text)
        clipboard.setPrimaryClip(clip)
    }

    companion object {
        fun newInstance(
            nama: String,
            jabatan: String,
            bidang: String?,
            noHp: String,
            email: String?,
            foto: String?
        ): UstadzDetailFragment {
            val fragment = UstadzDetailFragment()
            val args = Bundle()
            args.putString("nama", nama)
            args.putString("jabatan", jabatan)
            args.putString("bidang", bidang ?: "")
            args.putString("no_hp", noHp)
            args.putString("email", email ?: "-")
            args.putString("foto", foto ?: "")
            fragment.arguments = args
            return fragment
        }
    }
}
