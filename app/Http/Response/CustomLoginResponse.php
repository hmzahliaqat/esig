<?php

namespace App\Http\Response;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;


class CustomLoginResponse implements LoginResponseContract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {

        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->intended(config('fortify.home'));
    }

}