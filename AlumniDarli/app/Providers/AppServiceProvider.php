<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Event;
use App\Models\Lowongan;
use App\Models\InfoPondok;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('alumni*', function ($view) {
            $sevenDaysAgo = now()->subDays(7);
            
            $notifEvents = Event::where('created_at', '>=', $sevenDaysAgo)->get()->map(function($item) {
                return [
                    'title' => 'Event Baru',
                    'description' => $item->title,
                    'icon' => 'fas fa-calendar-alt',
                    'color' => 'primary',
                    'time' => $item->created_at,
                    'url' => url('event')
                ];
            });

            $notifJobs = Lowongan::where('created_at', '>=', $sevenDaysAgo)->get()->map(function($item) {
                return [
                    'title' => 'Lowongan Baru',
                    'description' => $item->judul,
                    'icon' => 'fas fa-briefcase',
                    'color' => 'success',
                    'time' => $item->created_at,
                    'url' => url('lowongan')
                ];
            });

            $notifInfo = InfoPondok::where('created_at', '>=', $sevenDaysAgo)->get()->map(function($item) {
                return [
                    'title' => 'Info Pondok',
                    'description' => $item->judul,
                    'icon' => 'fas fa-info-circle',
                    'color' => 'info',
                    'time' => $item->created_at,
                    'url' => url('alumni')
                ];
            });

            $notifications = $notifEvents->concat($notifJobs)->concat($notifInfo)->sortByDesc('time')->take(5);
            $view->with('notifications', $notifications);
        });
    }
}
