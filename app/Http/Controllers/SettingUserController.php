<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingUserController extends Controller
{
    public function index()
    {
        // Logic to show user settings
        $user = Auth::user();

        return view('user.settings.index', compact('user'));
    }
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'longname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'name' => 'required|string|max:255|unique:users,name,' . Auth::id(),
            'bank_name' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user settings
        $user = Auth::user();

        // Jika password tidak kosong maka update password
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->update($request->except('password'));

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
