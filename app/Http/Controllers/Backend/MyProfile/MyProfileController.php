<?php

namespace App\Http\Controllers\Backend\MyProfile;

use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    //* VIEW MY PROFILE 
    public function view()
    {
        return view('backend.myProfile.profileView');
    }

    //* UPDATE MY PROFILE INFO
    public function updateInfo(Request $request)
    {
        dd($request->all());
    }

    //* UPDATE MY PROFILE PASSWORD
    public function updatePassword(Request $request)
    {
        $user = Auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current Password is incorrect!');
        }
        if ($request->new_password !== $request->confirm_password) {
            return back()->with('confirm_error', 'New Password and Confirm Password do not match!');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        Swal::success([
            'title' => 'Password updated successfully!',
        ]);
        return back();
    }
    //* UPDATE MY PROFILE IMAGE
    public function updateProfileImage(Request $request)
    {
        $profileImage = Auth::user();
        if ($request->hasFile('profile_image')) {

            $image = $request->file('profile_image');
            $imageName = 'profile' . time() . '.' . $image->getClientOriginalName();

            $image->storeAs('profile_images/', $imageName, 'public');
            $profileImage->profile_image = $imageName;
            $profileImage->save();

            Swal::success([
                'title' => 'Profile Image Uploded!',
            ]);
            return back();
        }
    }
}
