<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function history()
    {
        return view('bonus.history');
    }
    public function withdraw()
    {
        return view('bonus.withdraw');
    }
}
