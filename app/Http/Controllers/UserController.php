<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->route('users.all');
    }


    function showLogin(){
        return view('login');
    }

    function login(LoginRequest $request){
        $credentials = $request->validated();

        if (Auth::attempt($credentials , $request->input('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'اسم المستخدم او كلمة السر خاطئة',
        ]);
    }

    function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
