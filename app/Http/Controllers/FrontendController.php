<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // For admin application
    public function admin()
    {
        
        return view('admin', ['scriptVariables' => $this->scriptVariables(auth()->user())]);
    }
    
    // For public application
    public function app()
    {
       
        return view('app', ['scriptVariables' => $this->scriptVariables()]);
    }

    public function scriptVariables($user = null)
    {
        return [
            'user' => $user,
            '_token' => csrf_token(),
            '_session' => session()->getId(),
        ];
    }
}
