<?php

namespace Vgplay\Acl;

use Illuminate\Auth\EloquentUserProvider as ServiceProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Vgplay\LaravelRedisModel\Contracts\Cacheable;

/**
 * Class CacheUserProvider
 * @package App\Auth
 */
class EloquentUserProvider extends ServiceProvider
{
    /**
     * CacheUserProvider constructor.
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, config('vgplay.roles.guard_model'));
    }

    /**
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        if (in_array(Cacheable::class, class_implements(config('vgplay.roles.guard_model')))) {
            return config('vgplay.roles.guard_model')::fromCache()->find($identifier);
        }

        return config('vgplay.roles.guard_model')::find($identifier);
    }
}
