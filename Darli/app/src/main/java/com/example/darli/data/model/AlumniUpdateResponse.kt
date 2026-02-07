package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class AlumniUpdateResponse(
    @SerializedName("response_code")
    val responseCode: Int,
    
    @SerializedName("message")
    val message: String,
    
    @SerializedName("content")
    val content: Alumni?
)
