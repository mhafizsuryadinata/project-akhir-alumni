package com.example.darli.data.model

data class Event(
    val id: Int,
    val title: String?,
    val category: String?,
    val date: String?,
    val time: String?,
    val location: String?,
    val description: String?,
    val image: String?,
    val status: String?
)

data class EventResponse(
    val response_code: Int,
    val content: List<Event>
)
