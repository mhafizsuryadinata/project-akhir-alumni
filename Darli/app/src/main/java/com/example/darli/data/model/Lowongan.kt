package com.example.darli.data.model

import java.io.Serializable

data class Lowongan(
    val id: Int,
    val user_id: Int?, // Creator ID
    val judul: String?,
    val perusahaan: String?,
    val lokasi: String?,
    val tipe_pekerjaan: String?,
    val gaji: String?,
    val deskripsi: String?,
    val kualifikasi: String?,
    val logo: String?,
    val email_kontak: String?,
    val tanggal_tutup: String?,
    val status: String?,
    val created_at: String?
) : Serializable

data class LowonganResponse(
    val response_code: Int,
    val content: List<Lowongan>
)
