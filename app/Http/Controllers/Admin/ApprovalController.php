<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        return view('admin.approvals.index');
    }
    public function withdrawals()
    {
        return view('admin.approvals.withdrawals');
    }
    public function rankClaims()
    {
        return view('admin.approvals.rank-claims');
    }
}
