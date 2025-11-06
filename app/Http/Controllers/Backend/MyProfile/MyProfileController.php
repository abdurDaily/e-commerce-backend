<?php

namespace App\Http\Controllers\Backend\MyProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyProfileController extends Controller
{
    //* VIEW MY PROFILE 
    public function view(){
       return view('backend.myProfile.profileView');
    }
}
