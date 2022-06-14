<?php

namespace Vgplay\Acl\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PermissionController
{
    use AuthorizesRequests;

    public function create(Request $request)
    {
        $this->authorize(config('vgplay.roles.permissions.permissions.create'));

        return view('vgplay::permissions.create');
    }

    public function store(Request $request)
    {
        $this->authorize(config('vgplay.roles.permissions.permissions.create'));

        #
    }
}
