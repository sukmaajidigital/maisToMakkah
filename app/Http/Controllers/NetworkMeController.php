<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NetworkMeController extends Controller
{
    /**
     * Menampilkan halaman struktur jaringan dari user yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        // eager load
        $user->load('allChildren.rank', 'rank');
        return view('network.index', compact('user'));
    }
}
