package com.example.darli.data.model

data class KontakUstadz(
    val id: Int,
    val nama: String,
    val jabatan: String,
    val bidang: String?,
    val no_hp: String,
    val email: String?,
    val foto: String?
)

data class KontakUstadzResponse(
    val response_code: Int,
    val content: List<KontakUstadz>
)
