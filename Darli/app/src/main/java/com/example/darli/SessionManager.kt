package com.example.darli

import android.content.Context
import android.content.SharedPreferences


class SessionManager(context: Context) {
    private val prefs: SharedPreferences = context.getSharedPreferences("user_session", Context.MODE_PRIVATE)
    private val editor: SharedPreferences.Editor = prefs.edit()

    companion object {
        private const val KEY_IS_LOGGED_IN = "is_logged_in"
        private const val KEY_USER_ID = "user_id"
        private const val KEY_NAME = "name"
        private const val KEY_BATCH = "batch"
        private const val KEY_PHOTO = "photo"
        private const val KEY_EMAIL = "email"
        private const val KEY_PHONE = "phone"
        private const val KEY_JOB = "job"
        private const val KEY_LOCATION = "location"
        private const val KEY_ADDRESS = "address"
        private const val KEY_ROLE = "role"
        // New Fields
        private const val KEY_BIO = "bio"
        private const val KEY_INSTAGRAM = "instagram"
        private const val KEY_LINKEDIN = "linkedin"
        private const val KEY_EDUCATION = "pendidikan_lanjutan"
        private const val KEY_YEAR_IN = "tahun_masuk"
        private const val KEY_YEAR_OUT = "tahun_tamat"
    }

    fun createLoginSession(
        id: Int, 
        name: String?, 
        batch: String?, 
        photo: String?, 
        email: String?, 
        phone: String?, 
        job: String?, 
        location: String?, 
        address: String?, 
        role: String?,
        bio: String?,
        instagram: String?,
        linkedin: String?,
        education: String?,
        yearIn: String?,
        yearOut: String?
    ) {
        editor.putBoolean(KEY_IS_LOGGED_IN, true)
        editor.putInt(KEY_USER_ID, id)
        editor.putString(KEY_NAME, name ?: "")
        editor.putString(KEY_BATCH, batch ?: "")
        editor.putString(KEY_PHOTO, photo ?: "")
        editor.putString(KEY_EMAIL, email ?: "")
        editor.putString(KEY_PHONE, phone ?: "")
        editor.putString(KEY_JOB, job ?: "")
        editor.putString(KEY_LOCATION, location ?: "")
        editor.putString(KEY_ADDRESS, address ?: "")
        editor.putString(KEY_ROLE, role ?: "")
        editor.putString(KEY_BIO, bio ?: "")
        editor.putString(KEY_INSTAGRAM, instagram ?: "")
        editor.putString(KEY_LINKEDIN, linkedin ?: "")
        editor.putString(KEY_EDUCATION, education ?: "")
        editor.putString(KEY_YEAR_IN, yearIn ?: "")
        editor.putString(KEY_YEAR_OUT, yearOut ?: "")
        editor.apply()
    }

    fun logout() {
        editor.clear()
        editor.apply()
    }

    fun isLoggedIn(): Boolean {
        return prefs.getBoolean(KEY_IS_LOGGED_IN, false)
    }

    fun getUserDetails(): HashMap<String, String?> {
        val user = HashMap<String, String?>()
        user["name"] = prefs.getString(KEY_NAME, null)
        user["batch"] = prefs.getString(KEY_BATCH, null)
        user["photo"] = prefs.getString(KEY_PHOTO, null)
        user["email"] = prefs.getString(KEY_EMAIL, null)
        user["phone"] = prefs.getString(KEY_PHONE, null)
        user["job"] = prefs.getString(KEY_JOB, null)
        user["location"] = prefs.getString(KEY_LOCATION, null)
        user["address"] = prefs.getString(KEY_ADDRESS, null)
        user["role"] = prefs.getString(KEY_ROLE, null)
        user["bio"] = prefs.getString(KEY_BIO, null)
        user["instagram"] = prefs.getString(KEY_INSTAGRAM, null)
        user["linkedin"] = prefs.getString(KEY_LINKEDIN, null)
        user["education"] = prefs.getString(KEY_EDUCATION, null)
        user["year_in"] = prefs.getString(KEY_YEAR_IN, null)
        user["year_out"] = prefs.getString(KEY_YEAR_OUT, null)
        return user
    }
    
    fun getUserId(): Int {
        return prefs.getInt(KEY_USER_ID, -1)
    }

    fun updateUserDetails(
        name: String?, 
        batch: String?, 
        photo: String?, 
        email: String?, 
        phone: String?, 
        job: String?, 
        location: String?, 
        address: String?,
        bio: String?,
        instagram: String?,
        linkedin: String?,
        education: String?
    ) {
        name?.let { editor.putString(KEY_NAME, it) }
        batch?.let { editor.putString(KEY_BATCH, it) }
        photo?.let { editor.putString(KEY_PHOTO, it) }
        email?.let { editor.putString(KEY_EMAIL, it) }
        phone?.let { editor.putString(KEY_PHONE, it) }
        job?.let { editor.putString(KEY_JOB, it) }
        location?.let { editor.putString(KEY_LOCATION, it) }
        address?.let { editor.putString(KEY_ADDRESS, it) }
        bio?.let { editor.putString(KEY_BIO, it) }
        instagram?.let { editor.putString(KEY_INSTAGRAM, it) }
        linkedin?.let { editor.putString(KEY_LINKEDIN, it) }
        education?.let { editor.putString(KEY_EDUCATION, it) }
        editor.apply()
    }
}
