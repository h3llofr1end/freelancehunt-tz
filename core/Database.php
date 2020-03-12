<?php

namespace app\core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    private static $instance;

    public static function getInstance()
    {
        if(empty(self::$instance)) {
            self::$instance = new Capsule;

            self::$instance->addConnection([
                'driver'    => 'mysql',
                'host'      => $_ENV['DB_HOST'],
                'database'  => $_ENV['DB_NAME'],
                'username'  => $_ENV['DB_USER'],
                'password'  => $_ENV['DB_PASS'],
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]);

            self::$instance->setAsGlobal();

            self::$instance->bootEloquent();
        }
        return self::$instance;
    }
}
