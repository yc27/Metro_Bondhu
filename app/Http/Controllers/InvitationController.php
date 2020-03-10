<?php

namespace App\Http\Controllers;
use App\Invitation;
use Yajra\DataTables\DataTables;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function show()
    {
        $pendingRequests = Invitation::whereNull('invitation_token')->count();
        return Datatables::of(Invitation::query()->whereNull('invitation_token'))
            ->with([
                "pendingRequests" => $pendingRequests
            ])
            ->make(true);
    }
}