<?php

namespace App\Providers;

use Protosofia\Ben10ant\Contracts\TenantModelInterface;
use Protosofia\Ben10ant\Contracts\TenantServiceAbstract;

class MyDefaultTenantService extends TenantServiceAbstract {

    public function setTenant(TenantModelInterface $tenant)
    {
        $dbConn = env('TENANT_DB_CONNECTION', 'mysql');
        $storageConn = env('TENANT_STORAGE_CONNECTION', 'mysql');

        $dbConfig = json_decode($tenant->database, true);
        $storageConfig = json_decode($tenant->storage, true);

        $this->setDatabaseConnection($dbConn, $dbConfig);
        $this->setStorageConnection($storageConn, $storageConfig);

        return $tenant;
    }
}
