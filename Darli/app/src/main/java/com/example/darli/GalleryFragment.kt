package com.example.darli

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.LinearLayout
import android.widget.ProgressBar
import android.widget.Toast
import androidx.recyclerview.widget.RecyclerView
import com.example.darli.adapters.AlbumAdapter
import com.example.darli.data.network.ApiClient
import com.example.darli.data.model.AlbumResponse
import com.example.darli.data.model.AlbumItem
import com.google.android.material.chip.Chip
import com.google.android.material.chip.ChipGroup
import com.google.android.material.floatingactionbutton.ExtendedFloatingActionButton
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import androidx.navigation.fragment.findNavController

class GalleryFragment : Fragment() {

    private var allAlbums: List<AlbumItem> = emptyList()
    private lateinit var adapter: AlbumAdapter
    private var selectedCategory: String? = null

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_gallery, container, false)

        view.findViewById<ImageButton>(R.id.btnBack).setOnClickListener {
            parentFragmentManager.popBackStack()
        }

        adapter = AlbumAdapter(emptyList()) { album ->
            val bundle = Bundle().apply {
                putInt("album_id", album.id)
                putString("album_name", album.namaAlbum)
            }
            findNavController().navigate(R.id.albumDetailFragment, bundle)
        }

        val recyclerView = view.findViewById<RecyclerView>(R.id.rvGallery)
        recyclerView.adapter = adapter

        val fabNewAlbum = view.findViewById<ExtendedFloatingActionButton>(R.id.fabNewAlbum)
        fabNewAlbum.setOnClickListener {
            findNavController().navigate(R.id.addAlbumFragment)
        }

        setupChips(view)
        fetchAlbums(view)

        return view
    }

    private fun setupChips(view: View) {
        val chipGroup = view.findViewById<ChipGroup>(R.id.chipGroupCategory)
        val chipAll = view.findViewById<Chip>(R.id.chipAll)
        val chipReuni = view.findViewById<Chip>(R.id.chipReuni)
        val chipKegiatan = view.findViewById<Chip>(R.id.chipKegiatan)
        val chipFoto = view.findViewById<Chip>(R.id.chipFoto)
        val chipEvent = view.findViewById<Chip>(R.id.chipEvent)

        val chipMap = mapOf(
            chipAll to null,
            chipReuni to "Reuni",
            chipKegiatan to "Kegiatan Pesantren",
            chipFoto to "Foto Angkatan",
            chipEvent to "Event"
        )

        chipGroup.setOnCheckedStateChangeListener { _, checkedIds ->
            if (checkedIds.isEmpty()) return@setOnCheckedStateChangeListener

            val selectedChip = view.findViewById<Chip>(checkedIds.first())
            selectedCategory = chipMap[selectedChip]

            // Update chip styles
            for ((chip, _) in chipMap) {
                if (chip.id == checkedIds.first()) {
                    chip.chipBackgroundColor = android.content.res.ColorStateList.valueOf(0xFF4285F4.toInt())
                    chip.setTextColor(0xFFFFFFFF.toInt())
                } else {
                    chip.chipBackgroundColor = android.content.res.ColorStateList.valueOf(0xFFFFFFFF.toInt())
                    chip.setTextColor(0xFF000000.toInt())
                }
            }

            filterAlbums(view)
        }
    }

    private fun filterAlbums(view: View) {
        val filtered = if (selectedCategory == null) {
            allAlbums
        } else {
            allAlbums.filter { it.kategori == selectedCategory }
        }

        adapter.updateData(filtered)

        val emptyState = view.findViewById<LinearLayout>(R.id.emptyState)
        val recyclerView = view.findViewById<RecyclerView>(R.id.rvGallery)

        if (filtered.isEmpty()) {
            emptyState.visibility = View.VISIBLE
            recyclerView.visibility = View.GONE
        } else {
            emptyState.visibility = View.GONE
            recyclerView.visibility = View.VISIBLE
        }
    }

    private fun fetchAlbums(view: View) {
        val progressBar = view.findViewById<ProgressBar>(R.id.progressBar)
        val recyclerView = view.findViewById<RecyclerView>(R.id.rvGallery)
        val emptyState = view.findViewById<LinearLayout>(R.id.emptyState)

        progressBar.visibility = View.VISIBLE
        recyclerView.visibility = View.GONE

        ApiClient.instance.getAlbums().enqueue(object : Callback<AlbumResponse> {
            override fun onResponse(call: Call<AlbumResponse>, response: Response<AlbumResponse>) {
                if (!isAdded) return
                progressBar.visibility = View.GONE

                if (response.isSuccessful && response.body()?.responseCode == 200) {
                    allAlbums = response.body()?.content ?: emptyList()
                    filterAlbums(view)
                } else {
                    emptyState.visibility = View.VISIBLE
                    Toast.makeText(context, "Gagal memuat album", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<AlbumResponse>, t: Throwable) {
                if (!isAdded) return
                progressBar.visibility = View.GONE
                emptyState.visibility = View.VISIBLE
                Toast.makeText(context, "Kesalahan jaringan: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
