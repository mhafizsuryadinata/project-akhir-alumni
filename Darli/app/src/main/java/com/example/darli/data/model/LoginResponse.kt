package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class LoginResponse(
    @SerializedName("response_code")
    val responseCode: Int,
    
    @SerializedName("message")
    val message: String,
    
    @SerializedName("content")
    val user: Alumni? = null,
    
    @SerializedName("redirect")
    val redirect: String? = null
)
