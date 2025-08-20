<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markRead(Request $request)
    {
        $userId = Auth::id();
        Notification::where('user_id', $userId)->whereNull('read_at')->update(['read_at' => now()]);
        $unreadCount = Notification::where('user_id', $userId)->whereNull('read_at')->count();
        return response()->json(['success' => true, 'unread' => $unreadCount]);
    }

    public function clear(Request $request)
    {
        $userId = Auth::id();
        Notification::where('user_id', $userId)->delete();
        return response()->json(['success' => true, 'unread' => 0]);
    }
} 