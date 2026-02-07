package com.example.darli.data.model

data class Comment(
    val id: Int,
    val user_id: Int,
    val user_name: String,
    val user_photo: String?,
    val content: String,
    val rating: Int,
    val status: String,
    val admin_reply: String?,
    val admin_reply_date: String?,
    val mudir_reply: String?,
    val mudir_reply_date: String?,
    val created_at: String,
    val replies: List<CommentReply> = emptyList()
)

data class CommentReply(
    val user_name: String,
    val content: String,
    val created_at: String
)

data class CommentListResponse(
    val response_code: Int,
    val content: List<Comment>
)

data class StoreCommentResponse(
    val response_code: Int,
    val message: String
)
