<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function read(Request $request)
    {
        $notifications = Auth::user()->unreadNotifications->markAsRead();
    }
}
