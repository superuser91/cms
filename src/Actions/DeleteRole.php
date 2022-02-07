<?php

namespace Vgplay\Acl\Actions;

use App\Exceptions\DeleteAdminRoleException;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class DeleteRole
{
    /**
     * public api
     *
     * @param Role $role
     * @return bool|null
     */
    public function execute(Role $role)
    {
        $this->validate($role);

        $deleted = $role->forceDelete();

        $this->clean($role);

        return $deleted;
    }

    protected function validate(Role $role)
    {
        if ($role->isAdminRole()) {
            throw new DeleteAdminRoleException();
        }
    }

    /**
     * cleanup
     *
     * @param Role $role
     * @return void
     */
    protected function clean(Role $role)
    {
        Cache::forget(Role::getCacheKey($role->id));
        Cache::forget('all_role_ids');
    }
}
