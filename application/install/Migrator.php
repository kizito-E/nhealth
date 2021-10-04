<?php

namespace Install;


class Migrator
{

    public function __construct($host, $db, $user, $password)
    {
        Eloquent::init($host, $db, $user, $password);
    }

    public function run()
    {

    }

}