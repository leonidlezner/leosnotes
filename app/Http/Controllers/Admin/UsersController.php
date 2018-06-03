<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ResourceCrud;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use ResourceCrud;

    public function __construct()
    {
        $this->model = '\App\User';
        $this->indexRoute = 'admin.users.index';
        $this->trashRoute = 'admin.users.trash';
        $this->viewFolder = 'admin.users';

        $this->validationRules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
        ];

        $this->setupCrud();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

        if(strlen($request->password) > 0)
        {
            $request->merge(['password' => Hash::make($request->password)]);
        }
        else
        {
            $request->merge(['password' => Hash::make(str_random(15))]);
        }

        $item = $this->model::create($request->all());
        
        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('New %s was created!', $item)
        ]);
    }

    public function update(Request $request, $id)
    {
        # Ignore the user id during the email validation
        $this->validationRules['email'] .= ','.$id;

        $this->validate($request, $this->validationRules);

        $item = $this->findOrAbort($id, true);

        if(strlen($request->password) > 0)
        {
            $request->merge(['password' => Hash::make($request->password)]);
        }
        else
        {
            $request->merge(['password' => $item->password]);
        }

        $item->update($request->all());

        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('The %s was updated!', $item)
        ]);
    }
}
