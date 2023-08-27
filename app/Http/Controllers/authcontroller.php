<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class authcontroller extends Controller
{
    public function registerView()
    {

        return view('user-register');
    }
    public function register(request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect()->route('loginview');
    }

    public function loginView()
    {
        return view('login');
    }

    public function login(request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        // dd($email);
        $user = DB::table('users')->where('email', $email)->first();


        if ($user && Hash::check($password, $user->password)) {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return redirect()->route('user-data');
            }
        } else {
            return redirect()->route('loginview')->withErrors(['msg' => 'User Not Found']);
        }
    }
}