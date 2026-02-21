package com.example.darli.data.model

data class ContactMessage(
    val id: Int,
    val subject: String,
    val message: String,
    val attachment: String?,
    val admin_reply: String?,
    val replied_at: String?,
    val created_at: String?
)

data class ContactMessageResponse(
    val response_code: Int,
    val content: List<ContactMessage>
)
