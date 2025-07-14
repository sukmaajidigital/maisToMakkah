<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function create()
    {
        return view('user.create');
    }
    public function store(Request $request)
    {
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
    public function edit($ids)
    {
        return view('user.edit', compact('ids'));
    }
    public function update(Request $request, $ids)
    {
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    public function destroy($ids)
    {
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
