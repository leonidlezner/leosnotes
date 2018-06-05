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

    public function edit()
    {
        $user = auth()->user();
        
        return view('profile.edit')->with([
            'item' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id
        ]);

        $user->update($request->all());

        return redirect()->route('profile.index')->with([
            'success' => 'Your profile was updated!'
        ]);
    }
}
