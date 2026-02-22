package com.example.darli

import android.app.Application

class DarliApp : Application() {
    override fun onCreate() {
        super.onCreate()
        val themeManager = ThemeManager(this)
        themeManager.applyTheme()
    }
}
