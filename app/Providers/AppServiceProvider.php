<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Morph map for polymorphic relations.
        Relation::morphMap([
            'users'       => 'App\Models\System\User',
            'permissions' => 'App\Models\System\Permission',
            'roles'       => 'App\Models\System\Role',

            'addresses' => 'App\Models\Polymorphics\Address',
        ]);
    }
}
