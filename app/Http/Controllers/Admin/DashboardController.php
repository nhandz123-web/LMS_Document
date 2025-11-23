<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // luôn là ADMIN do middleware đã chặn
        return view('admin.dashboard', compact('user'));
    }
}
