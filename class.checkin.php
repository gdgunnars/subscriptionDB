<?php

/**
 * Created by PhpStorm.
 * User: gd
 * Date: 8.6.2016
 * Time: 20:00
 */
class CheckIn
{
    private $connection;

    public function __construct() {
        //$this->connection = mysqli_connect("SERVER","USERNAME","PASSWORD","DATABASE");
        $config = parse_ini_file('hfhDbConfig.ini');
        $this->connection = mysqli_connect($config['server'],$config['username'],$config['password'],$config['dbname']);
    }

    public function __desctruct() {
        print "Destroying";
        mysqli_close($$this->connection);
    }


}