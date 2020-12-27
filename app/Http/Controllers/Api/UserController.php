<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Compound;
use Illuminate\Http\Request;
use App\Traits\UpdateProfileImage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use UpdateProfileImage;

    public function profile(){
        $user_id = Auth::user()->id;
        $user_profile = User::select('fname','lname','email')
                        ->where('id' , '=', $user_id)
                        ->get();

        return response(['profile' => $user_profile]);
    }

    public function getCompounds(){
        $compound = Compound::all();

        return response(['compound' => $compound]);
    }

    public function updateProfile(Request $request , $user_id)
    {
        $request->validate([
            'firstname' => 'max:20',
            'lastname' => 'max:20',
            'compound' => 'numeric',
        ]);

        if(Auth::user()->isAdmin){
            $user = User::find($user_id);
            $user->fname = $request->firstname? $request->firstname : $user->fname;
            $user->lname = $request->lastname? $request->lastname : $user->lname;
            $user->compound = $request->compound? $request->compound : $user->compound;
            $user->isBanned = $request->isBanned? $request->isBanned : $user->isBanned;

            $user->save();
            return response(['message' => 'profile picture updated successfully']);
        }else{
            return response(['message' => 'Unauthorized']);
        }


    }

    public function updateProfileImages(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|mimes:png,jpg,jpeg'
        ]);

        $user = Auth::user();
        $profile_picture = $request->file('profile_picture');
        $profile_link = $this->UpdateProfileImage($profile_picture ,$user->profile_picture);
        $user->profile_picture = $profile_link;
        $user->save();

        return response(['message' => 'profile picture updated successfully']);
    }
}
