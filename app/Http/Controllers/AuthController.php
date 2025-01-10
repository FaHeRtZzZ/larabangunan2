<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Method untuk menampilkan halaman registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Method untuk melakukan registrasi
    public function register(Request $request)
{
    $request->validate([
        'email' => 'required|string|email|max:255|unique:login',
        'username' => 'required|string|max:255|unique:login',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Membuat pengguna baru
    $user = User::create([
        'email' => $request->email,
        'username' => $request->username,
        'password' => bcrypt(   $request->password),
        'role' => 'member',
        'otp' => rand(100000, 999999), // Menghasilkan OTP acak
        'is_verified' => false,
    ]);

    // Kirim email verifikasi dengan OTP
    Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($user));

    return redirect()->route('verify.otp')->with('message', 'Registration successful! Please check your email for OTP verification.');
}


    // Method untuk verifikasi OTP
public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|string',
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && $user->otp === $request->otp) {
        $user->is_verified = true;
        $user->otp = null; // Reset OTP setelah verifikasi berhasil
        $user->save();

        // Login pengguna setelah verifikasi OTP berhasil
        Auth::login($user);

        // Redirect ke dashboard berdasarkan role
        if ($user->role == 'admin') {
            return redirect()->route('dashboard')->with('message', 'Email verified successfully! Welcome to your dashboard.');
        } elseif ($user->role == 'member') {
            return redirect()->route('member.dashboard')->with('message', 'Email verified successfully! Welcome to your dashboard.');
        }

        // Redirect ke dashboard umum jika role lain
        return redirect()->route('dashboard')->with('message', 'Email verified successfully! Welcome to your dashboard.');
    }

    return back()->withErrors(['otp' => 'The provided OTP is incorrect.']);
}


    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Generate and send OTP
            $user = Auth::user();
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();

            // Send OTP to user's email
            Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($user));

            return redirect()->route('verify.otp')->with('message', 'An OTP has been sent to your email. Please verify it.');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    
}
