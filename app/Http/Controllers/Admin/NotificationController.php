<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function readAll()
    {
        Notification::where('is_read', false)->update([
            'is_read' => true,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifications marked as read.',
        ]);
    }
}