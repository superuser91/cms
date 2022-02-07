<?php

namespace Vgplay\Acl\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vgplay\Acl\Models\Role;

class CreateRole
{
    /**
     * @var SyncPermission
     */
    protected $permissionSynchronizer;

    /**
     * @param SyncPermission $permissionSynchronizer
     * @return void
     */
    public function __construct(SyncPermission $permissionSynchronizer)
    {
        $this->permissionSynchronizer = $permissionSynchronizer;
    }

    /**
     * @param array $data
     * @return Role
     * @throws ValidationException
     */
    public function create(array $data): Role
    {
        $this->validate($data);

        $role = Role::create($data);

        $this->syncFeature($role, $data['permissions'] ?? []);

        return $role;
    }

    /**
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    protected function validate(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:191|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'permissions' => 'nullable|array'
        ], [], [
            'display_name' => 'tên hiển thị'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * handle sync feature
     *
     * @param Role $role
     * @param array|null $features
     * @return void
     */
    protected function syncFeature(Role $role, $permissions)
    {
        $this->permissionSynchronizer->sync($role, $permissions);
    }
}
