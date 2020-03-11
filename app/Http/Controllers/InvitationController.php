<?php

namespace App\Http\Controllers;
use App\Invitation;
use App\Mail\SendInvitationToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Response;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function show()
    {
        $pendingRequests = Invitation::whereNull('invitation_token')->count();
        
        return Datatables::of(Invitation::whereNull('invitation_token')->get(['id', 'email', 'created_at']))
            ->with([
                "pendingRequests" => $pendingRequests
            ])
            ->make(true);
    }

    public function generateToken($id)
    {
        $request = Invitation::find($id);
        
        $token = random_int(10000000, 99999999);

        $request->invitation_token = md5($token);
        $request->inviter_id = Auth::user()->id;
        $request->is_active = true;
        $request->is_used = false;
        $request->save();
        
        // This Token will be active for next 48 hours
        $qry = "CREATE EVENT updateRequest_".$id."
            ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 48 HOUR
            ON COMPLETION NOT PRESERVE
            DO
            update invitations set is_active = false where id = ".$id.";";
        DB::unprepared($qry);

        // Send Invitation Token tom mailing address
        Mail::to($request->email)->send(new SendInvitationToken($token));
        
        return Response::json($request);
    }

    public function destroy($id)
    {
        $invitations = Invitation::where('id', $id)->delete();

        return Response::json($invitations);
    }
}