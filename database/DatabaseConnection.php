<?php

class DatabaseConnection
{
    private const HOST_NAME = 'localhost';
    private const DATABASE_NAME = 'websocket';
    private const ADMIN = 'root';
    private const DATABASE_PASSWORD = '';

    function connect()
    {
        $connect = new PDO('mysql:host='. self::HOST_NAME . 
                            '; dbname=' . self::DATABASE_NAME,
                            self::ADMIN, 
                            self::DATABASE_PASSWORD);

        return $connect;
    }


}