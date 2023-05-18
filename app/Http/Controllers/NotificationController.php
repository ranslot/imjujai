<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function update(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->find($id);
        $notification->markAsRead();
    }
}
