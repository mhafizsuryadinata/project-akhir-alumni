package com.example.darli.data.model

data class Event(
    val id: Int,
    val title: String?,
    val category: String?,
    val date: String?,
    val raw_date: String?,
    val time: String?,
    val location: String?,
    val description: String?,
    val image: String?,
    val status: String?,
    val user_id: Int?,
    val creator_name: String?,
    val is_joined: Boolean?,
    val status_admin: String?,
    val status_pimpinan: String?
)

data class EventResponse(
    val response_code: Int,
    val content: List<Event>
)
