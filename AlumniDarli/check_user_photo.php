<?php

use App\Models\User;

$username = 'umarullah'; // Based on the screenshot
$user = User::where('username', 'LIKE', "%$username%")->orWhere('nama', 'LIKE', "%$username%")->first();

if ($user) {
    echo "User Found: " . $user->nama . " (ID: " . $user->id_user . ")\n";
    echo "Photo Path: '" . $user->foto . "'\n";
    echo "Profile Path: '" . $user->profile . "'\n";
} else {
    echo "User not found.\n";
    // List all users to find the right one
    $users = User::all();
    echo "Available users:\n";
    foreach ($users as $u) {
        echo "- " . $u->username . " (" . $u->nama . ")\n";
    }
}
