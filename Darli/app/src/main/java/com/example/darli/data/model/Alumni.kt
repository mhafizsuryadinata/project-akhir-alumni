package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class Alumni(
    @SerializedName("id")
    val id: String?,

    @SerializedName("name")
    val name: String?,

    @SerializedName("batch")
    val batch: String?, // Formatted "2020 - 2024"

    @SerializedName("year_in")
    val yearIn: String?,

    @SerializedName("year_out")
    val yearOut: String?,

    @SerializedName("profession")
    val profession: String?,

    @SerializedName("location")
    val location: String?,

    @SerializedName("address")
    val address: String?,

    @SerializedName("bio")
    val bio: String?,

    @SerializedName("email")
    val email: String?,

    @SerializedName("contact")
    val contact: String?,

    @SerializedName("instagram")
    val instagram: String?,

    @SerializedName("linkedin")
    val linkedin: String?,

    @SerializedName("education")
    val education: String?, // Pendidikan Lanjutan

    @SerializedName("experience")
    val experience: String?,

    @SerializedName("imageUrl")
    val imageUrl: String? = null
)
