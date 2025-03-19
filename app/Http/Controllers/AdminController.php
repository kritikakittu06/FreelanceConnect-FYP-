<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;

class AdminController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->count();
        $freelancers = User::where('role', 'freelancer')->count();
        $payments = Payment::sum('amount'); // Adjust based on your database structure

        return view('admin.dashboard', compact('clients', 'freelancers', 'payments'));
    }
}
