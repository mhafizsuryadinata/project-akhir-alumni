package com.example.darli

import android.content.ClipboardManager
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.View
import android.view.WindowManager
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import com.example.darli.databinding.ActivityLoginBinding
import com.google.android.material.snackbar.Snackbar

class LoginActivity : AppCompatActivity() {
    private lateinit var binding: ActivityLoginBinding

    private fun showLoading(isLoading: Boolean) {
        binding.loginButton.isEnabled = !isLoading
        binding.loginButton.text = if (isLoading) "Loading..." else "MASUK"
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        // Set status bar color to transparent
        window.apply {
            addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS)
            statusBarColor = ContextCompat.getColor(this@LoginActivity, android.R.color.transparent)
            decorView.systemUiVisibility = View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN
        }

        // Setup back button
        binding.btnBack.setOnClickListener {
            onBackPressed()
        }

        // Setup login button click
        binding.loginButton.setOnClickListener {
            val username = binding.usernameEditText.text.toString().trim()
            val nisn = binding.passwordEditText.text.toString().trim()

            if (username.isEmpty()) {
                Toast.makeText(this, "Username harus diisi", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            if (nisn.isEmpty()) {
                Toast.makeText(this, "NIA harus diisi", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            showLoading(true)
            
            val apiService = com.example.darli.api.ApiConfig.getApiService()
            apiService.login(username, nisn).enqueue(object : retrofit2.Callback<com.example.darli.models.LoginModel> {
                override fun onResponse(
                    call: retrofit2.Call<com.example.darli.models.LoginModel>,
                    response: retrofit2.Response<com.example.darli.models.LoginModel>
                ) {
                    showLoading(false)
                    if (response.isSuccessful) {
                        val responseBody = response.body()
                        if (responseBody != null && responseBody.response_code == 200) {
                            // Login Berhasil
                            val user = responseBody.content
                            
                            // Save to Session
                            val sessionManager = SessionManager(this@LoginActivity)
                            sessionManager.createLoginSession(
                                user.id_user,
                                user.nama ?: "",
                                user.angkatan ?: "",
                                user.foto ?: "",
                                user.email ?: "",
                                user.no_hp ?: "",
                                user.pekerjaan ?: "",
                                user.lokasi ?: "",
                                user.alamat ?: "",
                                user.role,
                                user.bio ?: "",
                                user.instagram ?: "",
                                user.linkedin ?: "",
                                user.pendidikan_lanjutan ?: "",
                                user.tahun_masuk?.toString() ?: "", 
                                user.tahun_tamat?.toString() ?: ""  
                            )

                            // Validasi tambahan: Cek apakah data penting benar-benar terisi
                            val isDataComplete = !user.nama.isNullOrEmpty() && 
                                               (user.tahun_masuk != null && user.tahun_masuk != 0) &&
                                               !user.alamat.isNullOrEmpty() &&
                                               !user.no_hp.isNullOrEmpty() &&
                                               !user.pekerjaan.isNullOrEmpty() &&
                                               !user.lokasi.isNullOrEmpty() &&
                                               !user.email.isNullOrEmpty()

                            if (user.is_complete == 1 && isDataComplete) {
                                val intent = Intent(this@LoginActivity, MainActivity::class.java).apply {
                                    putExtra("SHOW_MENU_FRAGMENT", true)
                                    flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
                                }
                                startActivity(intent)
                                finish()
                            } else {
                                val intent = Intent(this@LoginActivity, RegisterActivity::class.java).apply {
                                    putExtra("USER_ID", user.id_user)
                                    putExtra("USER_NAME", user.nama)
                                    putExtra("USER_YEAR_IN", user.tahun_masuk?.toString())
                                    putExtra("USER_YEAR_OUT", user.tahun_tamat?.toString())
                                    putExtra("USER_ADDRESS", user.alamat)
                                    putExtra("USER_PHONE", user.no_hp)
                                    putExtra("USER_JOB", user.pekerjaan)
                                    putExtra("USER_LOCATION", user.lokasi)
                                    putExtra("USER_EMAIL", user.email)
                                    putExtra("USER_BIO", user.bio)
                                    putExtra("USER_INSTAGRAM", user.instagram)
                                    putExtra("USER_LINKEDIN", user.linkedin)
                                    putExtra("USER_EDUCATION", user.pendidikan_lanjutan)
                                    putExtra("USER_NIA", user.nomor_nia)
                                    flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
                                }
                                startActivity(intent)
                                finish()
                            }
                        } else {
                            Snackbar.make(binding.root, responseBody?.message ?: "Login gagal", Snackbar.LENGTH_LONG).show()
                        }
                    } else {
                        Snackbar.make(binding.root, "Gagal terhubung ke server: ${response.message()}", Snackbar.LENGTH_LONG).show()
                    }
                }

                override fun onFailure(call: retrofit2.Call<com.example.darli.models.LoginModel>, t: Throwable) {
                    showLoading(false)
                    Snackbar.make(binding.root, "Error: ${t.message}", Snackbar.LENGTH_LONG).show()
                }
            })
        }

        // Setup WhatsApp link click
        binding.btnRegister.setOnClickListener {
            val adminNumber = "6282284029382" // Use country code for WhatsApp link
            val message = "Assalamu'alaikum Admin Dar el-Ilmi, saya alumni yang ingin menanyakan terkait akun portal alumni..."
            val url = "https://api.whatsapp.com/send?phone=$adminNumber&text=${Uri.encode(message)}"
            
            try {
                val intent = Intent(Intent.ACTION_VIEW)
                intent.data = Uri.parse(url)
                startActivity(intent)
            } catch (e: Exception) {
                // Fallback: Copy number
                val clipboard = getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
                val clip = android.content.ClipData.newPlainText("Admin Number", "082284029382")
                clipboard.setPrimaryClip(clip)
                Toast.makeText(this, "Nomor Admin disalin (WhatsApp tidak terdeteksi)", Toast.LENGTH_SHORT).show()
            }
        }
    }
}