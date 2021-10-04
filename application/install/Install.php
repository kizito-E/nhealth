<?php

namespace Install;

use Install\Database\DatabaseInstaller;

class Install
{
    public $databaseInstaller;

    public function __construct($host, $db, $user, $password)
    {
        Eloquent::init($host, $db, $user, $password);

        $this->databaseInstaller = new DatabaseInstaller();
    }

    public function run(array $data)
    {
        $this->databaseInstaller->createTables();
        $this->databaseInstaller->createAdminAccount($data);
    }


}