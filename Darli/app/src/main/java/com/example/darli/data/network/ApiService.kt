package com.example.darli.data.network

import com.example.darli.data.model.Alumni
import retrofit2.Call
import retrofit2.http.GET
import retrofit2.http.Path

interface ApiService {
    @GET("alumni/dashboard")
    fun getAlumniList(): Call<List<Alumni>>

    @GET("alumni/{id}")
    fun getAlumniDetail(@Path("id") id: String): Call<Alumni>

    @GET("get_comments")
    fun getComments(): Call<com.example.darli.data.model.CommentListResponse>

    @retrofit2.http.FormUrlEncoded
    @retrofit2.http.POST("store_comment")
    fun storeComment(
        @retrofit2.http.Field("id_user") idUser: Int,
        @retrofit2.http.Field("content") content: String,
        @retrofit2.http.Field("rating") rating: Int
    ): Call<com.example.darli.data.model.StoreCommentResponse>

    @retrofit2.http.FormUrlEncoded
    @retrofit2.http.POST("delete_comment")
    fun deleteComment(
        @retrofit2.http.Field("id") commentId: Int,
        @retrofit2.http.Field("id_user") userId: Int
    ): Call<com.example.darli.data.model.StoreCommentResponse>
    @GET("get_stats")
    fun getStats(): Call<com.example.darli.data.model.StatsResponse>

    @GET("info_pondok")
    fun getInfoPondok(): Call<com.example.darli.data.model.InfoPondokResponse>

    @GET("events")
    fun getEvents(): Call<com.example.darli.data.model.EventResponse>

    @GET("kontak_ustadz")
    fun getKontakUstadz(): Call<com.example.darli.data.model.KontakUstadzResponse>

    @GET("lowongan")
    fun getLowongan(): Call<com.example.darli.data.model.LowonganResponse>

    @GET("get_galeri")
    fun getGallery(): Call<com.example.darli.data.model.GalleryResponse>
    @retrofit2.http.POST("update_profile")
    fun updateProfile(
        @retrofit2.http.Field("id_user") idUser: String,
        @retrofit2.http.Field("nama") nama: String,
        @retrofit2.http.Field("alamat") alamat: String,
        @retrofit2.http.Field("no_hp") noHp: String,
        @retrofit2.http.Field("pekerjaan") pekerjaan: String,
        @retrofit2.http.Field("lokasi") lokasi: String,
        @retrofit2.http.Field("email") email: String,
        @retrofit2.http.Field("bio") bio: String,
        @retrofit2.http.Field("instagram") instagram: String,
        @retrofit2.http.Field("linkedin") linkedin: String,
        @retrofit2.http.Field("pendidikan_lanjutan") pendidikanLanjutan: String
    ): Call<com.example.darli.data.model.AlumniUpdateResponse>

    @retrofit2.http.Multipart
    @retrofit2.http.POST("apply_lowongan")
    fun applyLowongan(
        @retrofit2.http.Part("lowongan_id") lowonganId: okhttp3.RequestBody,
        @retrofit2.http.Part("id_user") idUser: okhttp3.RequestBody,
        @retrofit2.http.Part("cover_letter") coverLetter: okhttp3.RequestBody?,
        @retrofit2.http.Part cv: okhttp3.MultipartBody.Part?
    ): Call<com.example.darli.data.model.ApplyResponse>

    @retrofit2.http.GET("my_applications/{id_user}")
    fun getMyApplications(
        @retrofit2.http.Path("id_user") idUser: Int
    ): Call<com.example.darli.data.model.MyApplicationsResponse>
}
