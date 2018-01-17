<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;

class UserController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    */

    /**
     * Get edit user page.
     *
     * @return view
     */
    public function edit(){
        if(Auth::check()){
            return view('users.edit', ['user' => Auth::user()]);            
        }
        else{
            abort(404);
        }
    }

    /**
     * Get user page with info.
     *
     * @return view
     */
    public function user(User $user){
        return view('users.user', [
            'user' => Auth::check() ? Auth::user() : null,
            'profileUser' => $user
        ]);
    }

    /**
     * Help function for saving changes after editing in profile.
     *
     * @redirect
     */
    public function saveChanges(Request $request){
        if(Auth::check()){
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|max:255',
                'birthday' => 'nullable|date|before:2007-12-31|after:1900-01-01',
                'about' => 'nullable|max:1000',
                'facebook' => 'nullable|max:32',
                'twitter' => 'nullable|max:32',
                'instagram' => 'nullable|max:32'
            ]);
            
            if ($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput(); 
            }

            $user = Auth::user();

            if($user->name != $request->fullname && !(is_null($request->fullname))){
                $user->name = $request->fullname;                
            }
            
            if(date($request->birthday) != $user->birthday && !(is_null($request->birthday))){
                $user->birthday = date($request->birthday);                
            }  
            
            if($user->about != $request->about && !(is_null($request->about))){
                $user->about = $request->about;                
            }

            if($user->facebook != $request->facebook && !(is_null($request->facebook))){
                $user->facebook = $request->facebook;                
            }

            if($user->twitter != $request->twitter && !(is_null($request->twitter))){
                $user->twitter = $request->twitter;                
            }

            if($user->instagram != $request->instagram && !(is_null($request->instagram))){
                $user->instagram = $request->instagram;                
            }
            
            $user->save();
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
}
