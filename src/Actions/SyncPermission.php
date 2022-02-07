<?php

namespace Vgplay\Acl\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vgplay\Acl\Models\Role;

class SyncPermission
{
    /**
     * public sync api
     *
     * @param Role $role
     * @param array $permissions
     * @return array
     * @throws ValidationException
     */
    public function sync(Role $role, array $permissions): array
    {
        $this->validate($permissions);

        $sync = $role->permissions()->sync($permissions);

        $role->touch();

        return $sync;
    }

    /**
     * validate
     *
     * @param array $permissions
     * @return void
     * @throws ValidationException
     */
    protected function validate(array $permissions)
    {
        $validator = Validator::make($permissions, [
            '*' => 'exists:permissions,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
