package com.example.darli.data.model

import java.io.Serializable

data class InfoPondok(
    val id: Int,
    val judul: String,
    val konten: String,
    val jenis: String,
    val gambar: String?,
    val created_at: String
) : Serializable

data class InfoPondokResponse(
    val response_code: Int,
    val content: List<InfoPondok>
)
