<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        // Data akun hardcode lengkap dengan ID
        $accounts = [
            [
                'id' => 1, 
                'email' => 'Pembeli@gmail.com', 
                'password' => '123', 
                'role' => 'pembeli', 
                'name' => 'User Pembeli'
            ],
            [
                'id' => 2, 
                'email' => 'jastiper@gmail.com', 
                'password' => '123', 
                'role' => 'jastiper', 
                'name' => 'User Jastiper'
            ],
        ];

        $inputEmail = trim($request->input('email'));
        $inputPassword = $request->input('password');

        foreach ($accounts as $acc) {
            if (strtolower($acc['email']) === strtolower($inputEmail) && $acc['password'] === $inputPassword) {
                
                // Simpan sesi login
                session([
                    'is_logged_in' => true,
                    'user_id' => $acc['id'],
                    'user_name' => $acc['name'],
                    'user_role' => $acc['role'],
                ]);

                // Arahkan ke dashboard
                if ($acc['role'] === 'pembeli') {
                    return redirect('/dashboard-pembeli');
                } else {
                    return redirect('/dashboard-jastiper');
                }
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah!'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}