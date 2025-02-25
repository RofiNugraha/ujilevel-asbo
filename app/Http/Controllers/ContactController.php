<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        Contact::create([
            'user_id' => $user ? $user->id : null,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}