<?php

namespace Vgplay\Acl\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vgplay\Acl\Models\Role;

class UpdateRole
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
     * Handle update role
     *
     * @param Role $role
     * @param array $data
     * @return Role
     * @throws ValidationException
     */
    public function update(Role $role, array $data): Role
    {
        $data = $this->validate($role, $data);

        $this->updateRole($role, $data);

        $this->syncPermissions($role, $data['permissions'] ?? []);

        return $role->refresh();
    }

    /**
     * validate data
     *
     * @param Role $role
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    protected function validate(Role $role, array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'exclude',
            'display_name' => 'required|string|max:255',
            'permissions' => 'nullable|array'
        ], [], [
            'display_name' => 'tên hiển thị'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $data;
    }

    /**
     * handle update role
     *
     * @param Role $role
     * @param array $data
     * @return bool
     */
    protected function updateRole(Role $role, array $data): bool
    {
        return $role->update([
            'display_name' => $data['display_name']
        ]);
    }

    /**
     * handle sync
     *
     * @param Role $role
     * @param array $features
     * @return void
     */
    protected function syncPermissions(Role $role, array $permissions)
    {
        $this->permissionSynchronizer->sync($role, $permissions);
    }
}
