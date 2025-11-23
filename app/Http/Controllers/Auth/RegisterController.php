<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show() {
        return view('auth.register');
    }

    public function store(Request $request) {
        $request->validate([
            'fullname' => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => [
                'required','confirmed','min:8',
                'regex:/[A-Z]/',     // ≥1 ký tự hoa
                'regex:/[\W_]/'      // ≥1 ký tự đặc biệt
            ],
        ],[
            'password.regex' => 'Mật khẩu phải có ít nhất 1 ký tự viết hoa và 1 ký tự đặc biệt.',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'SV',
        ]);

        auth()->login($user);
        return redirect()->route('dashboard');
    }
}
