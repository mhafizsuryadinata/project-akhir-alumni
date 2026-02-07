<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function event(Request $request)
    {
        $events = Event::where(function($query) {
                $query->where(function($q) {
                    $q->where('status_admin', 'approved')
                      ->where('status_pimpinan', 'approved');
                })->orWhere('user_id', auth()->check() ? auth()->user()->id_user : null);
            })
            ->orderBy('date', 'asc')
            ->get();
        
        // Stats for sidebar
        // Stats for sidebar with dynamic date check
        $upcoming_count = Event::where('status_admin', 'approved')
            ->where('status_pimpinan', 'approved')
            ->where(function($query) {
                $query->where('date', '>', now()->toDateString())
                    ->orWhere(function($q) {
                        $q->where('date', '=', now()->toDateString())
                          ->where('time', '>', now()->toTimeString());
                    });
            })->count();
            
        $finished_count = Event::where('status_admin', 'approved')
            ->where('status_pimpinan', 'approved')
            ->where(function($query) {
                $query->where('date', '<', now()->toDateString())
                    ->orWhere(function($q) {
                        $q->where('date', '=', now()->toDateString())
                          ->where('time', '<', now()->toTimeString());
                    });
            })->count();

        $stats = [
            'total_this_month' => Event::where('status_admin', 'approved')
                ->where('status_pimpinan', 'approved')
                ->whereMonth('date', now()->month)
                ->count(),
            'upcoming' => $upcoming_count,
            'finished' => $finished_count,
        ];

        // Category distribution for chart
        $category_counts = Event::where('status_admin', 'approved')
            ->where('status_pimpinan', 'approved')
            ->select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        return view('alumni.event', compact('events', 'stats', 'category_counts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth()->user()->id_user;

        try {
            Event::create($data);
            return redirect()->route('event')->with('success', 'Berhasil, menunggu persetujuan dari admin dan pimpinan baru akan tampil.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan event: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Hanya pemilik atau admin yang bisa edit
        if ($event->user_id !== auth()->user()->id_user && auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk mengubah event ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        try {
            $event->update($data);
            return redirect()->route('event')->with('success', 'Event berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui event: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Hanya pemilik atau admin yang bisa hapus
        if ($event->user_id !== auth()->user()->id_user && auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menghapus event ini.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();

        return redirect()->route('event')->with('success', 'Event berhasil dihapus!');
    }

    /**
     * Menampilkan halaman kalender event
     */
    public function kalender()
    {
        return view('alumni.kalender');
    }

    /**
     * Mengambil data event dalam format JSON untuk FullCalendar
     */
    public function getEventsJson()
    {
        $events = Event::where('status_admin', 'approved')
            ->where('status_pimpinan', 'approved')
            ->get()
            ->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->date . 'T' . $event->time,
                'allDay' => false,
                'backgroundColor' => $this->getCategoryColor($event->category),
                'borderColor' => $this->getCategoryColor($event->category),
                'extendedProps' => [
                    'category' => $event->category,
                    'location' => $event->location,
                    'description' => $event->description,
                    'time' => date('H:i', strtotime($event->time)),
                    'time' => date('H:i', strtotime($event->time)),
                    'status' => ($event->date > now()->toDateString() || ($event->date == now()->toDateString() && $event->time > now()->toTimeString())) ? 'upcoming' : 'finished',
                    'image' => $event->image ? asset('storage/' . $event->image) : null,
                ]
            ];
        });

        return response()->json($events);
    }

    /**
     * Mendapatkan warna berdasarkan kategori event
     */
    private function getCategoryColor($category)
    {
        $colors = [
            'Reuni' => '#1a73e8',
            'Seminar' => '#28a745',
            'Workshop' => '#ffc107',
            'Bakti Sosial' => '#dc3545',
            'Lainnya' => '#6c757d',
        ];

        return $colors[$category] ?? '#1a73e8';
    }

    public function join($id)
    {
        $event = Event::findOrFail($id);
        
        // Cek jika sudah terdaftar
        if ($event->participants()->where('event_user.user_id', auth()->user()->id_user)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di event ini.');
        }

        $event->participants()->attach(auth()->user()->id_user);

        return redirect()->back()->with('success', 'Berhasil mendaftar event! Admin akan segera menghubungi Anda.');
    }
}
