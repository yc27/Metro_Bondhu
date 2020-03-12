<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Invitation;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\StoreInvitationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'invitation_token' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $request = Invitation::where([
                        ['invitation_token', md5($value)],
                        ['email', $data['email']]
                    ])->first();
                    if ($request === null) {
                        $fail('Invitation Code is invalid.');
                    } elseif ($request->is_active === false) {
                        $fail('This Invitation Code has been expired.');
                    } elseif ($request->is_used === false) {
                        $fail('Invitation Code is invalid.');
                    }
                }
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = Invitation::where('email', $data['email'])->first();
        $request->is_active = false;
        $request->is_used = true;
        $request->registered_at = Date('Y-m-d H:i:s');
        $request->save();
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function requestInvitation() {
        return view('auth.request');
    }
    
    public function storeRequest(StoreInvitationRequest $request)
    {
        $invitation = new Invitation($request->all());
        $email = $invitation['email'];
        Invitation::where('email', $email)->delete();
        $invitation->save();

        return redirect()->route('requestInvitation')
            ->with('success', 'Invitation to register successfully requested. Please wait and check your mail unitil an admin sent you an invitaion code.');
    }
}