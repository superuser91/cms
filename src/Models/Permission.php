<?php

namespace Vgplay\Acl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vgplay\LaravelRedisModel\Contracts\Cacheable;
use Vgplay\LaravelRedisModel\HasCache;

class Permission extends Model implements Cacheable
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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
