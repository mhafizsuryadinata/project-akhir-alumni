<?php

use App\Models\Event;
use App\Models\User;

echo "Checking Events in Database...\n";
$events = Event::with('user')->get();

echo "Total Events Found: " . $events->count() . "\n";

foreach ($events as $event) {
    echo "ID: " . $event->id . " | Title: " . $event->title . " | Status Admin: " . $event->status_admin . " | Status Pimpinan: " . $event->status_pimpinan . "\n";
    if ($event->user) {
        echo " - Created By: " . $event->user->nama . " (ID: " . $event->user->id_user . ")\n";
    } else {
        echo " - Created By: [ORPHANED USER] (User ID: " . $event->user_id . ")\n";
    }
}
