package com.example.darli.models

data class Alumni(
    val id: String = "",
    val nisn: String = "",
    val username: String = "",
    val fullName: String = "",
    val angkatan: String = "",
    val pekerjaan: String = "",
    val whatsapp: String = "",
    val email: String = "",
    val instagram: String = "",
    val alamat: String = "",
    val photoUrl: String = "",
    val isComplete: Boolean = false,
    // Additional fields for local demo
    val bio: String = "",
    val imageResId: Int = 0
)
