<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function createRegister()
    {
        return view('register');
    }

    public function storeRegister(Request $request)
    {
        $genderCode = $request->gender == "male" ? "01" : "02";
        $id = "SKY" . $request->dating_code . $genderCode;
        $request->merge(['id' => $id]);

        $validated = $request->validate([
            'id' => 'unique:users',
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|unique:users',
            'dating_code' => 'required|regex:/^[0-9]{3}$/',
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|regex:/^[0-9]{10,14}$/',
            'image' => 'required|image',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string',
        ], [
            'id' => "ID DT sudah terpakai"
        ]);

        $uploaded_image = $request->file('image');
        $image_path = Storage::putFileAs('public/profiles', $uploaded_image, $id . "." . $uploaded_image->getClientOriginalExtension());

        $user = User::create([
            'id' => $id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dating_code' => "DT" . $validated['dating_code'],
            'birthday' => $validated['birthday'],
            'gender' => $validated['gender'],
            'phone_number' => "+65" . $validated['phone_number'],
            'image_path' => $image_path,
            'password' => Hash::make($validated['password']),
            'status' => 'offline'
        ]);

        return redirect()->back()->with('success', 'Selamat akun anda berhasil dibuat, anda dapat login menggunakan ' . $validated['email'] . ' atau ' . $id);
    }

    public function createLogin()
    {
        return view('login');
    }
    public function storeLogin(Request $request)
    {
        // dd($request->all());
        $isEmail = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'id';
        $request->merge([$isEmail => $request->login]);
        $validated = $request->validate([
            'email' => 'required_without:id|email|exists:users',
            'id' => 'required_without:email|string|exists:users',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->status == "banned") {
                return redirect()->back()->with('status', "You are banned from this server");
            } else {
                return redirect()->route('home');
            }
        }

        return redirect()->back()->with('status', "Email atau password salah");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
