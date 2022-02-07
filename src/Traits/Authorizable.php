<?php

namespace Vgplay\Acl\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Vgplay\Acl\Models\Permission;
use Vgplay\Acl\Models\Role;

trait Authorizable
{
    /**
     * return role relationship
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * assign role to the user
     *
     * @param string $name
     * @return array
     */
    public function assignRole($name): array
    {
        $name = is_array($name) ? $name : [$name];

        $roleIds = Role::fromCache()->all()->whereIn('name', $name)->pluck('id');

        return $this->roles()->syncWithoutDetaching($roleIds);
    }

    /**
     * Check if User has a Role(s) associated.
     *
     * @param string|array $name The role(s) to check.
     *
     * @return bool
     */
    public function hasRole($name): bool
    {
        if (in_array($name, $this->roles->pluck('name')->toArray())) {
            return true;
        }

        return false;
    }

    /**
     * check if user has the permission
     *
     * @param string
     * @return bool
     */
    public function hasPermission($name): bool
    {
        $roles = Role::fromCache()->get($this->roles->pluck('name')->toArray());

        $permissionIds = $roles->pluck('permissions')
            ->flatten()->pluck('name')
            ->toArray();

        $permissions = Permission::fromCache()->get($permissionIds);

        return in_array($name, $permissions->pluck('name')->toArray());
    }
}
