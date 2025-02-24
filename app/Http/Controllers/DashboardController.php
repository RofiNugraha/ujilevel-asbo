<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $contacts = Contact::with('user:id,name,image,email')->get();
        
        return view('admin.dashboard', compact('contacts'));
    }

}