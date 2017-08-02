<?php

namespace App\Providers;

use Protosofia\Ben10ant\Contracts\TenantModelInterface;
use Protosofia\Ben10ant\Contracts\TenantServiceAbstract;

class MyDefaultTenantService extends TenantServiceAbstract {

    public function setTenant(TenantModelInterface $tenant)
    {
        $dbConn = config('tenant_db_connection', 'mysql');
        $storageConn = config('tenant_storage_connection', 'mysql');

        $dbConfig = json_decode($tenant->database, true);
        $storageConfig = json_decode($tenant->storage, true);

        $this->setDatabaseConnection($dbConn, $dbConfig);
        $this->setStorageConnection($storageConn, $storageConfig);

        return $tenant;
    }
}
