<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return $this->show(auth()->user()->uuid);
    }

    public function show($uuid)
    {
        $user = \App\User::withUuid($uuid)->firstOrFail();
        
        return view('profile.show')->with([
            'item' => $user
        ]);
    }
}
