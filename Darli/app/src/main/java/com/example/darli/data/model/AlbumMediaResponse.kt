package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class AlbumMediaResponse(
    @SerializedName("response_code")
    val responseCode: Int,
    @SerializedName("content")
    val content: List<AlbumMediaItem>
)

data class AlbumMediaItem(
    @SerializedName("id")
    val id: Int,
    @SerializedName("album_id")
    val albumId: Int,
    @SerializedName("file_path")
    val filePath: String?,
    @SerializedName("tipe")
    val tipe: String?,
    @SerializedName("deskripsi")
    val deskripsi: String?,
    @SerializedName("status_admin")
    val statusAdmin: String?,
    @SerializedName("status_pimpinan")
    val statusPimpinan: String?,
    @SerializedName("created_at")
    val createdAt: String?
)
