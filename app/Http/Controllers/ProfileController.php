<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Image;
use Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function updatePhoto(Request $request)
    {
        request()->validate(
            [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
            [
                'photo.required' => 'Image Required',
                'photo.image' => 'File must an Image',
                'photo.mimes' => 'Allowed formats are *.jpeg, *.png, *.jpg, *.gif',
                'photo.max' => 'Maximum file size 2MB'
            ]
        );

        $userId = Auth::user()->id;       

        $image = $request->file('photo');
        $imageName = date('YmdHis') . '-user-' . $userId . '.' . $image->extension();
     
        $destinationPath = public_path('img/admins/');        
        $img = Image::make($image->path());
        $img->resize(400, 400)->save($destinationPath . $imageName);

        $user = User::find($userId);
        $user->photo = $imageName;
        $user->save();

        $response = ['image' => $imageName, 'status' => true, 'msg' => 'Profile photo updated successfully.'];
        return Response::json($response);
    }

    public function updateProfile(Request $request)
    {
        request()->validate(
            [
                'name' => 'required|string|max:30',
                'mobile' => 'required|regex:/(1)[0-9]{9}/|max:10'
            ],
            [
                'name.required' => 'Name is required field',
                'name.image' => 'Name must be a string',
                'name.max' => 'Name can have maximum 30 character',
                'mobile.required' => 'Mobile Number is required field',
                'mobile.regex' => 'Mobile number is not valid',
                'mobile.max' => 'Mobile number is not valid',
            ]
        );

        $userId = Auth::User()->id;
        $user = User::find($userId);
        $user->name = $request['name'];
        $user->mobile_no = $request['mobile'];
        
        if($request->has('new-pass') && $request['new-pass'] !== null)
        {
            $validator = Validator::make($request->all(), [
                'old-pass' => [
                    'required', function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('Old Password didn\'t match');
                        }
                    },
                ],
                'new-pass' => 'required|min:8',
                'confirm-pass' => 'required|same:new-pass'
            ],
            [
                'new-pass.min' => 'Password should be minimum 8 charcater',
                'confirm-pass.required' => 'Confirm Password is required',
                'confirm-pass.same' => 'Confirm password doesn\'t match'
            ]);

            if($validator->fails()) {
                return Response::json(['errors' => $validator->errors()], 422);
            }
            
            $user->password = Hash::make($request['new-pass']);
        }

        $user->save();

        $response = ['msg' => 'Profile updated successfully', 'name' => $user->name, 'mobile' => $user->mobile_no, 'status' => true];
        return Response::json($response);
    }
}