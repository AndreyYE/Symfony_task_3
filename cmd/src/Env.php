<?php

class Env{
    public static function get_env(){
        return array(
            'dbname' => 'symfony',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );
    }
}