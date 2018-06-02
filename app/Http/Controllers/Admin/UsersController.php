<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ResourceCrud;


class UsersController extends Controller
{
    use ResourceCrud;

    public function __construct()
    {
        $this->model = '\App\User';
        $this->indexRoute = 'admin.users.index';
        $this->viewFolder = 'admin.users';

        $this->validationRules = [
            'name' => 'required',
            'email' => 'required',
        ];

        $this->setupCrud();
    }
}
