<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index() {
        $user = auth()->user();
        return view('dashboard', ['user' => $user, 'role' => $user->role]);
    }
}
