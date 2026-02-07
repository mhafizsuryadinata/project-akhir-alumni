package com.example.darli.models

data class LoginModel(
    val content: Content,
    val message: String,
    val response_code: Int
) {
    data class Content(
        val active: Any?,
        val alamat: String?,
        val angkatan: String?,
        val created_at: String?,
        val email: String?,
        val foto: String?,
        val id_user: Int,
        val is_complete: Int,
        val lokasi: String?,
        val nama: String?,
        val no_hp: String?,
        val nomor_nia: String?,
        val pekerjaan: String?,
        val profile: String?,
        val role: String,
        val updated_at: String?,
        val username: String,
        val bio: String?,
        val instagram: String?,
        val linkedin: String?,
        val pendidikan_lanjutan: String?, // Maps to 'education' in session
        val tahun_masuk: Int?, // Maps to 'year_in'
        val tahun_tamat: Int?  // Maps to 'year_out'
    )
}