<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    /**
     * Display the entire network tree structure for the admin.
     */
    public function index()
    {
        // Fetch all root users (users without a parent)
        // Eager load all descendants and their ranks for maximum efficiency
        $rootUsers = User::whereNull('parent_id')
            ->with(['rank', 'allChildren.rank'])
            ->get();

        return view('admin.network.index', compact('rootUsers'));
    }
}
