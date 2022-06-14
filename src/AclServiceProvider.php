<?php

namespace Vgplay\Acl;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Vgplay\Acl\Models\Permission;
use Vgplay\Contracts\Admin;
use Illuminate\Support\Facades\Auth;

class AclServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'vgplay.roles');
    }

    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'vgplay');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Auth::provider('cache-user', function () {
            return resolve(EloquentUserProvider::class);
        });

        $this->bootGuard();

        $this->publishes([
            __DIR__ . '/../resources/assets/vendor' => public_path('vendor')
        ], 'assets');
    }

    protected function bootGuard()
    {
        Gate::before(function (Admin $admin) {
            if ($admin->hasRole('administrator')) {
                return true;
            }
        });

        try {
            $permissions = Permission::fromCache()->all();

            foreach ($permissions as $permission) {
                Gate::define($permission->name, function (Admin $admin) use ($permission) {
                    return $admin->hasPermission($permission->name);
                });
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
        }
    }
}
