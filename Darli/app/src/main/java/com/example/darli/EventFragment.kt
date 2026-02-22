package com.example.darli

import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.EditText
import android.widget.ImageView
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.DateAdapter
import com.example.darli.adapters.EventAdapter
import com.example.darli.data.model.Event
import com.example.darli.data.model.EventResponse
import com.example.darli.data.network.ApiClient
import com.example.darli.data.network.ApiService
import com.google.android.material.tabs.TabLayout
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.text.SimpleDateFormat
import java.util.*

class EventFragment : Fragment() {

    private lateinit var rvEvent: RecyclerView
    private lateinit var rvCalendarStrip: RecyclerView
    private lateinit var eventAdapter: EventAdapter
    private lateinit var dateAdapter: DateAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var btnBack: ImageView
    private lateinit var tvMonthYear: TextView
    private lateinit var btnPrevMonth: ImageView
    private lateinit var btnNextMonth: ImageView
    private lateinit var tabLayout: TabLayout
    private lateinit var fabAddEvent: View
    private lateinit var etSearchEvent: EditText

    private var allEvents: List<Event> = emptyList()
    private var selectedDate: Date? = null
    private var currentMonthCalendar: Calendar = Calendar.getInstance()
    private var currentTabPosition = 0 // 0: Upcoming, 1: Past, 2: All

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_event, container, false)

        initViews(view)
        setupCalendar()
        setupTabs()
        setupSearch()
        setupEventList()
        
        fetchEvents()

        return view
    }

    private fun initViews(view: View) {
        rvEvent = view.findViewById(R.id.rvEvent)
        rvCalendarStrip = view.findViewById(R.id.rvCalendarStrip)
        progressBar = view.findViewById(R.id.progressBar)
        tvEmpty = view.findViewById(R.id.tvEmpty)
        btnBack = view.findViewById(R.id.btnBack)
        tvMonthYear = view.findViewById(R.id.tvMonthYear)
        btnPrevMonth = view.findViewById(R.id.btnPrevMonth)
        btnNextMonth = view.findViewById(R.id.btnNextMonth)
        tabLayout = view.findViewById(R.id.tabLayout)
        fabAddEvent = view.findViewById(R.id.fabAddEvent)
        etSearchEvent = view.findViewById(R.id.etSearchEvent)

        btnBack.setOnClickListener { findNavController().popBackStack() }
        
        btnPrevMonth.setOnClickListener {
            currentMonthCalendar.add(Calendar.MONTH, -1)
            updateCalendarStrip()
        }
        
        btnNextMonth.setOnClickListener {
            currentMonthCalendar.add(Calendar.MONTH, 1)
            updateCalendarStrip()
        }
        
        fabAddEvent.setOnClickListener {
             findNavController().navigate(R.id.action_eventFragment_to_addEventFragment)
        }
    }

    private fun setupCalendar() {
        updateCalendarStrip()
    }

    private fun updateCalendarStrip() {
        // Update Month Text
        val monthFormat = SimpleDateFormat("MMMM yyyy", Locale("id", "ID"))
        tvMonthYear.text = monthFormat.format(currentMonthCalendar.time)

        // Generate days for the month
        val days = getDaysInMonth(currentMonthCalendar)
        
        dateAdapter = DateAdapter(days) { date ->
            selectedDate = date
            filterEvents()
        }
        rvCalendarStrip.layoutManager = LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false)
        rvCalendarStrip.adapter = dateAdapter

        // Scroll to selected date or today
        val today = Calendar.getInstance()
        if (currentMonthCalendar.get(Calendar.MONTH) == today.get(Calendar.MONTH) &&
            currentMonthCalendar.get(Calendar.YEAR) == today.get(Calendar.YEAR)) {
            val dayOfMonth = today.get(Calendar.DAY_OF_MONTH)
            rvCalendarStrip.scrollToPosition(dayOfMonth - 1)
        }
    }

    private fun setupSearch() {
        etSearchEvent.addTextChangedListener(object : android.text.TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {
                filterEvents()
            }
            override fun afterTextChanged(s: android.text.Editable?) {}
        })
    }

    private fun getDaysInMonth(calendar: Calendar): List<Date> {
        val days = mutableListOf<Date>()
        val cal = calendar.clone() as Calendar
        cal.set(Calendar.DAY_OF_MONTH, 1)
        val maxDay = cal.getActualMaximum(Calendar.DAY_OF_MONTH)
        
        for (i in 1..maxDay) {
            cal.set(Calendar.DAY_OF_MONTH, i)
            days.add(cal.time)
        }
        return days
    }

    private fun setupTabs() {
        tabLayout.addTab(tabLayout.newTab().setText("Akan Datang"))
        tabLayout.addTab(tabLayout.newTab().setText("Selesai"))
        tabLayout.addTab(tabLayout.newTab().setText("Semua"))

        tabLayout.addOnTabSelectedListener(object : TabLayout.OnTabSelectedListener {
            override fun onTabSelected(tab: TabLayout.Tab?) {
                currentTabPosition = tab?.position ?: 0
                filterEvents()
                
                // Update Badge Counts if possible (requires custom tab view or reflection)
                // For now just filtering
            }
            override fun onTabUnselected(tab: TabLayout.Tab?) {}
            override fun onTabReselected(tab: TabLayout.Tab?) {}
        })
    }

    private fun setupEventList() {
        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()

        eventAdapter = EventAdapter(
            emptyList(),
            userId,
            onDetailClick = { event ->
                // Serialize event to JSON
                val eventJson = com.google.gson.Gson().toJson(event)
                val bundle = Bundle().apply {
                    putString("event_json", eventJson)
                }
                findNavController().navigate(R.id.action_eventFragment_to_eventDetailFragment, bundle)
            },
            onRegisterClick = { event ->
                // Check if already joined
                if (event.is_joined == true) return@EventAdapter

                val request = ApiService.JoinEventRequest(event.id, userId)
                ApiClient.instance.joinEvent(request).enqueue(object : Callback<ApiService.JoinEventResponse> {
                    override fun onResponse(call: Call<ApiService.JoinEventResponse>, response: Response<ApiService.JoinEventResponse>) {
                        if (response.isSuccessful && response.body()?.response_code == 200) {
                            Toast.makeText(context, response.body()?.message, Toast.LENGTH_SHORT).show()
                            fetchEvents() // Refresh list
                        } else {
                            Toast.makeText(context, response.body()?.message ?: "Gagal mendaftar", Toast.LENGTH_SHORT).show()
                        }
                    }
                    override fun onFailure(call: Call<ApiService.JoinEventResponse>, t: Throwable) {
                        Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
                    }
                })
            },
            onEditClick = { event ->
                Toast.makeText(context, "Ubah: ${event.title}", Toast.LENGTH_SHORT).show()
            },
            onDeleteClick = { event ->
                Toast.makeText(context, "Hapus: ${event.title}", Toast.LENGTH_SHORT).show()
            }
        )
        rvEvent.layoutManager = LinearLayoutManager(context)
        rvEvent.adapter = eventAdapter
    }

    private fun fetchEvents() {
        progressBar.visibility = View.VISIBLE
        val sessionManager = SessionManager(requireContext())
        val userId = sessionManager.getUserId()

        ApiClient.instance.getEvents(userId).enqueue(object : Callback<EventResponse> {
            override fun onResponse(call: Call<EventResponse>, response: Response<EventResponse>) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    allEvents = response.body()?.content ?: emptyList()
                    // Update tab counts
                    updateTabTitles()
                    filterEvents()
                } else {
                    Toast.makeText(context, "Gagal memuat acara", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<EventResponse>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
    
    private fun updateTabTitles() {
        // Count events
        val upcomingCount = allEvents.count { isUpcoming(it) }
        val pastCount = allEvents.count { !isUpcoming(it) }
        val allCount = allEvents.size
        
        tabLayout.getTabAt(0)?.text = "Akan Datang ($upcomingCount)"
        tabLayout.getTabAt(1)?.text = "Selesai ($pastCount)"
        tabLayout.getTabAt(2)?.text = "Semua ($allCount)"
    }

    private fun filterEvents() {
        var filteredList = when (currentTabPosition) {
            0 -> allEvents.filter { isUpcoming(it) }
            1 -> allEvents.filter { !isUpcoming(it) }
            else -> allEvents
        }

        // Apply Search Filter
        val query = etSearchEvent.text.toString().trim().lowercase()
        if (query.isNotEmpty()) {
            filteredList = filteredList.filter { 
                it.title?.lowercase()?.contains(query) == true ||
                it.location?.lowercase()?.contains(query) == true ||
                it.description?.lowercase()?.contains(query) == true ||
                it.category?.lowercase()?.contains(query) == true
            }
        }

        // Apply Date Filter if selected
        selectedDate?.let { date ->
             val sdf = SimpleDateFormat("yyyy-MM-dd", Locale.getDefault())
             val selectedDateStr = sdf.format(date)
             filteredList = filteredList.filter { 
                 it.raw_date == selectedDateStr
             }
        }

        if (filteredList.isEmpty()) {
            tvEmpty.visibility = View.VISIBLE
            rvEvent.visibility = View.GONE
            tvEmpty.text = "Tidak ada acara ditemukan"
        } else {
            tvEmpty.visibility = View.GONE
            rvEvent.visibility = View.VISIBLE
            eventAdapter.updateData(filteredList)
        }
    }
    
    private fun isUpcoming(event: Event): Boolean {
        // Use raw_date for comparison
        val rawDate = event.raw_date ?: return false
        val sdf = SimpleDateFormat("yyyy-MM-dd", Locale.getDefault())
        return try {
            val eventDate = sdf.parse(rawDate)
            val today = Calendar.getInstance().apply {
                set(Calendar.HOUR_OF_DAY, 0)
                set(Calendar.MINUTE, 0)
                set(Calendar.SECOND, 0)
                set(Calendar.MILLISECOND, 0)
            }.time
            !eventDate.before(today)
        } catch (e: Exception) {
            false
        }
    }
}
