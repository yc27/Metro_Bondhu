<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $invitations = DB::table('invitations')
            ->whereNull('invitation_token')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $pendingRequests = DB::table('invitations')
            ->whereNull('invitation_token')
            ->count();
            
        // $invitations = DB::table('invitations')
        //     ->select('email', DB::raw('MIN(created_at) as created_at'))
        //     ->whereNull('registered_at')
        //     ->groupBy('email')
        //     ->orderBy('created_at', 'desc')
        //     ->get(['email', 'created_at'])
        //     ->paginate(10);
        return view('admin.dashboard', ['invitations' => $invitations, 'pendingRequests' => $pendingRequests]);
    }
}