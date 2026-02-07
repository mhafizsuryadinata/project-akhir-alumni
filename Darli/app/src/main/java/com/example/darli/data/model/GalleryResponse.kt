package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class GalleryResponse(
    @SerializedName("response_code")
    val responseCode: Int,
    @SerializedName("content")
    val content: List<GalleryItem>
)

data class GalleryItem(
    @SerializedName("id")
    val id: Int,
    @SerializedName("title")
    val title: String?,
    @SerializedName("image")
    val image: String?,
    @SerializedName("created_at")
    val createdAt: String
)
