package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class AlbumResponse(
    @SerializedName("response_code")
    val responseCode: Int,
    @SerializedName("content")
    val content: List<AlbumItem>
)

data class AlbumItem(
    @SerializedName("id")
    val id: Int,
    @SerializedName("nama_album")
    val namaAlbum: String?,
    @SerializedName("deskripsi")
    val deskripsi: String?,
    @SerializedName("tahun")
    val tahun: String?,
    @SerializedName("kategori")
    val kategori: String?,
    @SerializedName("cover_url")
    val coverUrl: String?,
    @SerializedName("photo_count")
    val photoCount: Int,
    @SerializedName("video_count")
    val videoCount: Int
)
