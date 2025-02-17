<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        // Validate Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:6|max:200',
        ]);

        // Store Message
        Message::create($request->all());

        // Redirect with Success Message
        return redirect()->back()->with('success', __('lang.message_sent_success'));
    }
}
