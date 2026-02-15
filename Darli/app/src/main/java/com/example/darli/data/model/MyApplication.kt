package com.example.darli.data.model

import java.io.Serializable

data class MyApplication(
    val id: Int,
    val lowongan_id: Int,
    val judul_lowongan: String,
    val perusahaan: String,
    val logo: String?,
    val status: String,
    val status_admin: String,
    val status_pimpinan: String,
    val final_status: String,
    val applied_at: String
) : Serializable
