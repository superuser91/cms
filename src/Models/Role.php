<?php

namespace Vgplay\Acl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vgplay\LaravelRedisModel\Contracts\Cacheable;
use Vgplay\LaravelRedisModel\HasCache;

class Role extends Model implements Cacheable
{
    use HasFactory;
    use HasCache;

    protected $fillable = [
        'name',
        'display_name'
    ];

    public static function primaryCacheKey(): string
    {
        return 'name';
    }

    public function permissionRoles()
    {
        return $this->hasMany(PermissionRole::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function assignPermission($name)
    {
        $name = is_array($name) ? $name : [$name];

        $permissionIds = Permission::whereIn('name', $name)->pluck('id');

        $this->permissions()->syncWithoutDetaching($permissionIds);
    }

    public function scopeCacheWithRelation($query)
    {
        return $query->with('permissions:id,name');
    }

    public function isAdminRole()
    {
        return $this->name == 'administrator';
    }
}
