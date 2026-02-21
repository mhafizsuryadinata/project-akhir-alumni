package com.example.darli.data.model

data class Faq(
    val id: Int,
    val question: String,
    val answer: String,
    val category: String?
)

data class FaqResponse(
    val response_code: Int,
    val content: List<Faq>
)
