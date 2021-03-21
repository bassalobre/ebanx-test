<?php

namespace Source\Infra\Database;

class DatabaseConnection
{
    private static ?IDatabase $connection = null;

    private function __construct() {}

    public static function getConnection(): IDatabase
    {
        if (is_null(self::$connection)) {
            self::$connection = new DatabaseAdapter();
        }

        return self::$connection;
    }
}
