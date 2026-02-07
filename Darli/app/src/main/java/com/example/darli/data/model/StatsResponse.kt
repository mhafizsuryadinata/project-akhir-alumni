package com.example.darli.data.model

import com.google.gson.annotations.SerializedName

data class StatsResponse(
    @SerializedName("total_alumni")
    val totalAlumni: Int,
    @SerializedName("total_events")
    val totalEvents: Int,
    @SerializedName("total_announcements")
    val totalAnnouncements: Int,
    @SerializedName("total_teachers")
    val totalTeachers: Int,
    @SerializedName("total_jobs")
    val totalJobs: Int
)
