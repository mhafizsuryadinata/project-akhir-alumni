package com.example.darli.data.model

data class MyApplicationsResponse(
    val response_code: Int,
    val message: String,
    val content: List<MyApplication>
)
