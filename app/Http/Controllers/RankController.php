<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankController extends Controller
{
    public function qualification()
    {
        return view('rank.qualification');
    }
}
