<?php
namespace App\Http\Controllers;

use App\Models\User; // Sesuaikan nama model jika berbeda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; 
class ProfileController extends Controller
{
    // Menampilkan halaman profil
    // Controller ProfileController
    public function show()
    {
        $user = auth()->user();
    
        // Tentukan foto profil yang digunakan
        $photoUrl = $user->photo ? asset('storage/' . $user->photo) : asset('assets/img/profile-img.jpg');
        
        // Kirim foto profil ke layout
        return view('profile.show', compact('user'))->with('photoUrl', $photoUrl);
    }
    


    // Menampilkan halaman edit profil
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Mengupdate data profil
    public function update(Request $request)
{
    $user = auth()->user();

    // Validasi data
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'country' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi foto
    ]);

    // Menangani upload foto jika ada
    if ($request->hasFile('photo')) {
        // Menghapus foto lama jika ada
        if ($user->photo && file_exists(storage_path('app/public/profile_photos/' . $user->photo))) {
            unlink(storage_path('app/public/profile_photos/' . $user->photo));
        }

        // Menyimpan foto baru
        $photo = $request->file('photo');
        $photoName = time() . '.' . $photo->getClientOriginalExtension();
        $photo->storeAs('public/profile_photos', $photoName);

        // Menyimpan nama file foto ke dalam database
        $user->photo = $photoName;
    }

    // Mengupdate data lainnya
    $user->update([
        'username' => $request->username,
        'email' => $request->email,
        'country' => $request->country,
        'address' => $request->address,
        'phone' => $request->phone,
    ]);

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}


        public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        // Mengupdate password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password changed successfully.');
    }

}

