<?php

namespace Vgplay\Acl\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vgplay\Acl\Actions\CreateRole;
use Vgplay\Acl\Actions\UpdateRole;
use Vgplay\Acl\Exceptions\DeleteAdminRoleException;
use Vgplay\Acl\Models\Permission;
use Vgplay\Acl\Models\Role;

class RoleController
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $roles = Role::fromCache()->all();

        return view('vgplay::roles.index', compact('roles'));
    }

    public function create(Request $request)
    {
        $this->authorize(config('vgplay.acl.roles.permissions.create'));

        $permissions = Permission::fromCache()->all();

        return view('vgplay::roles.create', compact('permissions'));
    }

    public function store(Request $request, CreateRole $roleCreater)
    {
        $this->authorize(config('vgplay.acl.roles.permissions.create'));

        try {
            $roleCreater->create($request->all());
            session()->flash('status', 'Thêm thành công');
            return redirect(route('roles.index'));
        } catch (ValidationException $e) {
            session()->flash('status', $e->getMessage());
            return back()->withInput()->withErrors($e->validator);
        } catch (\Exception $e) {
            session()->flash('status', $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Request $request, Role $role)
    {
        $this->authorize(config('vgplay.acl.roles.permissions.create'));

        $role->load('permissions');

        $permissions = Permission::fromCache()->all();

        return view('vgplay::roles.edit', compact('role', 'permissions'));
    }


    public function update(Request $request, UpdateRole $roleUpdater, Role $role)
    {
        $this->authorize(config('vgplay.acl.roles.permissions.create'));

        try {
            $roleUpdater->update($role, $request->all());
            session()->flash('status', 'Thêm thành công');
            return redirect(route('roles.index'));
        } catch (ValidationException $e) {
            session()->flash('status', $e->getMessage());
            return back()->withInput()->withErrors($e->validator);
        } catch (\Exception $e) {
            session()->flash('status', $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        $this->authorize(config('vgplay.acl.roles.permissions.delete'));

        $role = Role::fromCache()->find($id);

        if (is_null($role)) abort(404);

        try {
            if ($role->isAdminRole()) {
                throw new DeleteAdminRoleException();
            }
            $role->delete();
            session()->flash('status', 'Xoá thành công!');
            return redirect(route('roles.index'));
        } catch (DeleteAdminRoleException $e) {
            session()->flash('status', $e->getMessage());
            return back();
        } catch (\Exception $e) {
            session()->flash('danger', 'Có lỗi bất ngờ xảy ra!');
            return back();
        }
    }
}
