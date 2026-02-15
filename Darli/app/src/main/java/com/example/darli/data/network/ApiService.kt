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
    fun getEvents(@retrofit2.http.Query("id_user") idUser: Int? = null): Call<com.example.darli.data.model.EventResponse>

    @androidx.annotation.Keep
    data class JoinEventResponse(
        val response_code: Int,
        val message: String
    )

    @androidx.annotation.Keep
    data class JoinEventRequest(
        val event_id: Int,
        val user_id: Int
    )

    @POST("join_event")
    fun joinEvent(@retrofit2.http.Body request: JoinEventRequest): Call<JoinEventResponse>

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

    @retrofit2.http.Multipart
    @retrofit2.http.POST("store_lowongan")
    fun storeLowongan(
        @retrofit2.http.Part("judul") judul: okhttp3.RequestBody,
        @retrofit2.http.Part("perusahaan") perusahaan: okhttp3.RequestBody,
        @retrofit2.http.Part("tipe_pekerjaan") tipePekerjaan: okhttp3.RequestBody,
        @retrofit2.http.Part("lokasi") lokasi: okhttp3.RequestBody,
        @retrofit2.http.Part("deskripsi") deskripsi: okhttp3.RequestBody,
        @retrofit2.http.Part("kualifikasi") kualifikasi: okhttp3.RequestBody,
        @retrofit2.http.Part("benefit") benefit: okhttp3.RequestBody?,
        @retrofit2.http.Part("gaji_min") gajiMin: okhttp3.RequestBody?,
        @retrofit2.http.Part("gaji_max") gajiMax: okhttp3.RequestBody?,
        @retrofit2.http.Part("email_kontak") emailKontak: okhttp3.RequestBody,
        @retrofit2.http.Part("website") website: okhttp3.RequestBody?,
        @retrofit2.http.Part("tanggal_tutup") tanggalTutup: okhttp3.RequestBody,
        @retrofit2.http.Part("level") level: okhttp3.RequestBody,
        @retrofit2.http.Part("posted_by") postedBy: okhttp3.RequestBody,
        @retrofit2.http.Part logo: okhttp3.MultipartBody.Part?
    ): Call<com.example.darli.data.model.GeneralResponse>
}
