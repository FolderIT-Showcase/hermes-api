<?php

namespace App\Providers;

use Protosofia\Ben10ant\Providers\TenantServiceProvider;

class MyTenantServiceProvider extends TenantServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Protosofia\Ben10ant\TenantServiceInterface',
            'App\Providers\MyDefaultTenantService');

        $this->app->bind('Protosofia\Ben10ant\Contracts\TenantModelInterface',
            'Protosofia\Ben10ant\Models\TenantModel');

        $this->mergeConfigFrom(__DIR__.'\..\..\vendor\protosofia\ben10ant\src\Config\database.php',
            'database.connections');

        $this->mergeConfigFrom(__DIR__.'\..\..\vendor\protosofia\ben10ant\src\Config\filesystems.php',
            'filesystems.disks');
    }
}
