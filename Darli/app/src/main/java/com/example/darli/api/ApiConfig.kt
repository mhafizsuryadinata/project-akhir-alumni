package com.example.darli.api

import com.example.darli.models.LoginModel
import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.Field
import retrofit2.http.FormUrlEncoded
import retrofit2.http.POST

interface ApiConfig {
    @FormUrlEncoded
    @POST("login")
    fun login(
        @Field("username") username: String,
        @Field("nomor_nia") nomor_nia: String
    ): Call<LoginModel>

    @retrofit2.http.Multipart
    @POST("update_profile")
    fun updateProfile(
        @retrofit2.http.Part("id_user") idUser: okhttp3.RequestBody,
        @retrofit2.http.Part("nama") nama: okhttp3.RequestBody,
        @retrofit2.http.Part("alamat") alamat: okhttp3.RequestBody,
        @retrofit2.http.Part("no_hp") noHp: okhttp3.RequestBody,
        @retrofit2.http.Part("pekerjaan") pekerjaan: okhttp3.RequestBody,
        @retrofit2.http.Part("lokasi") lokasi: okhttp3.RequestBody,
        @retrofit2.http.Part("email") email: okhttp3.RequestBody,
        @retrofit2.http.Part("bio") bio: okhttp3.RequestBody,
        @retrofit2.http.Part("instagram") instagram: okhttp3.RequestBody,
        @retrofit2.http.Part("linkedin") linkedin: okhttp3.RequestBody,
        @retrofit2.http.Part("pendidikan_lanjutan") pendidikanLanjutan: okhttp3.RequestBody,
        @retrofit2.http.Part("tahun_masuk") tahunMasuk: okhttp3.RequestBody,
        @retrofit2.http.Part("tahun_tamat") tahunTamat: okhttp3.RequestBody,
        @retrofit2.http.Part file: okhttp3.MultipartBody.Part?
    ): Call<LoginModel>

    companion object {
        fun getApiService(): ApiConfig {
            val loggingInterceptor = HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY)
            val client = OkHttpClient.Builder()
                .addInterceptor(loggingInterceptor)
                .build()
            val retrofit = Retrofit.Builder()
                .baseUrl("http://10.0.2.2:8000/api/")
                .addConverterFactory(GsonConverterFactory.create())
                .client(client)
                .build()
            return retrofit.create(ApiConfig::class.java)
        }
    }
}