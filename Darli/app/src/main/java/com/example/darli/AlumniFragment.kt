package com.example.darli

import android.graphics.Typeface
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.view.Gravity
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.EditText
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.AlumniAdapter
import com.example.darli.data.model.Alumni
import com.example.darli.data.network.ApiClient
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class AlumniFragment : Fragment() {

    private lateinit var rvAlumni: RecyclerView
    private lateinit var alumniAdapter: AlumniAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var etSearch: EditText
    private lateinit var chipContainer: LinearLayout
    private lateinit var tvMemberCount: TextView
    private lateinit var layoutLoadMore: LinearLayout
    private lateinit var btnLoadMore: Button
    private lateinit var layoutEmpty: LinearLayout

    private var allAlumniData: List<Alumni> = emptyList()
    private var filteredList: List<Alumni> = emptyList()
    private var displayedCount = 10
    private val pageSize = 10
    private var selectedChipYear: String? = null // null = semua

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_alumni, container, false)

        rvAlumni = view.findViewById(R.id.rvAlumni)
        progressBar = view.findViewById(R.id.progressBar)
        etSearch = view.findViewById(R.id.etSearch)
        chipContainer = view.findViewById(R.id.chipContainer)
        tvMemberCount = view.findViewById(R.id.tvMemberCount)
        layoutLoadMore = view.findViewById(R.id.layoutLoadMore)
        btnLoadMore = view.findViewById(R.id.btnLoadMore)
        layoutEmpty = view.findViewById(R.id.layoutEmpty)

        val btnBack = view.findViewById<ImageView>(R.id.btnBack)
        btnBack.setOnClickListener {
            findNavController().navigateUp()
        }

        setupRecyclerView()
        setupSearch()
        setupLoadMore()
        fetchAlumniData()

        return view
    }

    private fun setupRecyclerView() {
        alumniAdapter = AlumniAdapter(emptyList()) { alumni ->
            val bundle = Bundle().apply {
                putString("name", alumni.name ?: "Alumni")
                putString("job", alumni.profession ?: "-")
                putString("angkatan", alumni.batch ?: "-")
                putString("bio", alumni.bio ?: "")
                putString("loc", alumni.location ?: "-")
                putString("email", alumni.email ?: "-")
                putString("phone", alumni.contact ?: "-")
                putString("photo", alumni.imageUrl ?: "")
                putString("address", alumni.address ?: "-")
                putString("instagram", alumni.instagram ?: "")
                putString("linkedin", alumni.linkedin ?: "")
                putString("education", alumni.education ?: "-")
                putString("year_in", alumni.yearIn ?: "?")
                putString("year_out", alumni.yearOut ?: "?")
            }
            findNavController().navigate(R.id.alumniDetailFragment, bundle)
        }

        rvAlumni.apply {
            layoutManager = LinearLayoutManager(context)
            adapter = alumniAdapter
            isNestedScrollingEnabled = false
        }
    }

    private fun setupSearch() {
        etSearch.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable?) {
                displayedCount = pageSize
                applyFilters()
            }
        })
    }

    private fun setupLoadMore() {
        btnLoadMore.setOnClickListener {
            displayedCount += pageSize
            applyFilters()
        }
    }

    private fun fetchAlumniData() {
        progressBar.visibility = View.VISIBLE
        layoutEmpty.visibility = View.GONE
        ApiClient.instance.getAlumniList().enqueue(object : Callback<List<Alumni>> {
            override fun onResponse(
                call: Call<List<Alumni>>,
                response: Response<List<Alumni>>
            ) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    allAlumniData = response.body() ?: emptyList()
                    tvMemberCount.text = "${allAlumniData.size} Anggota"
                    buildFilterChips()
                    applyFilters()
                } else {
                    Toast.makeText(context, "Gagal mengambil data alumni", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<List<Alumni>>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(context, "Error: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun buildFilterChips() {
        chipContainer.removeAllViews()

        // Collect unique years from yearOut
        val years = allAlumniData
            .mapNotNull { it.yearOut }
            .filter { it.isNotBlank() }
            .distinct()
            .sortedDescending()

        // "Semua Angkatan" chip
        val allChip = createChipView("Semua Angkatan", null)
        chipContainer.addView(allChip)

        // Per-year chips
        for (year in years) {
            val chip = createChipView("Angkatan $year", year)
            chipContainer.addView(chip)
        }

        updateChipStyles()
    }

    private fun createChipView(label: String, year: String?): TextView {
        val chip = TextView(requireContext())
        chip.text = label
        chip.textSize = 13f
        chip.setPadding(dpToPx(16), dpToPx(8), dpToPx(16), dpToPx(8))
        chip.gravity = Gravity.CENTER
        chip.tag = year // null for "All"

        val params = LinearLayout.LayoutParams(
            LinearLayout.LayoutParams.WRAP_CONTENT,
            LinearLayout.LayoutParams.WRAP_CONTENT
        )
        params.marginEnd = dpToPx(8)
        chip.layoutParams = params

        chip.setOnClickListener {
            selectedChipYear = year
            displayedCount = pageSize
            updateChipStyles()
            applyFilters()
        }

        return chip
    }

    private fun updateChipStyles() {
        for (i in 0 until chipContainer.childCount) {
            val chip = chipContainer.getChildAt(i) as? TextView ?: continue
            val chipYear = chip.tag as? String

            if (chipYear == selectedChipYear) {
                chip.setBackgroundResource(R.drawable.bg_chip_selected)
                chip.setTextColor(0xFFFFFFFF.toInt())
                chip.setTypeface(chip.typeface, Typeface.BOLD)
            } else {
                chip.setBackgroundResource(R.drawable.bg_chip_unselected)
                chip.setTextColor(0xFF475569.toInt())
                chip.setTypeface(chip.typeface, Typeface.NORMAL)
            }
        }
    }

    private fun applyFilters() {
        val query = etSearch.text.toString().trim().lowercase()

        filteredList = allAlumniData.filter { alumni ->
            // Year filter
            val matchesYear = selectedChipYear == null ||
                    alumni.yearOut == selectedChipYear

            // Search filter
            val matchesSearch = query.isEmpty() ||
                    (alumni.name?.lowercase()?.contains(query) == true) ||
                    (alumni.profession?.lowercase()?.contains(query) == true) ||
                    (alumni.location?.lowercase()?.contains(query) == true)

            matchesYear && matchesSearch
        }

        // Pagination
        val displayList = filteredList.take(displayedCount)

        alumniAdapter.updateData(displayList)

        // Show/hide load more
        if (displayedCount < filteredList.size) {
            layoutLoadMore.visibility = View.VISIBLE
        } else {
            layoutLoadMore.visibility = View.GONE
        }

        // Show/hide empty state
        layoutEmpty.visibility = if (filteredList.isEmpty() && allAlumniData.isNotEmpty()) {
            View.VISIBLE
        } else {
            View.GONE
        }
    }

    private fun dpToPx(dp: Int): Int {
        return (dp * resources.displayMetrics.density).toInt()
    }
}
