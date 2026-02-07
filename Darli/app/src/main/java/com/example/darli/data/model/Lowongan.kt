package com.example.darli.data.model

data class Lowongan(
    val id: Int,
    val judul: String?,
    val perusahaan: String?,
    val lokasi: String?,
    val tipe_pekerjaan: String?,
    val gaji: String?,
    val deskripsi: String?,
    val kualifikasi: String?,
    val logo: String?,
    val email_kontak: String?,
    val tanggal_tutup: String?
)

data class LowonganResponse(
    val response_code: Int,
    val content: List<Lowongan>
)
