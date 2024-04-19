<?php

namespace blog\model;

use blog\classes\dbConnect;

class Manager
{
    private $_dsn = 'mysql:host=localhost:3306;dbname=';
    private $_dbName;
    private $_login;
    private $_password;

    protected $dbManager;

    public function __construct()
    {
        if( strstr( $_SERVER['HTTP_HOST'], '51.178.86.117' ) ) {
            $this->_dbName = 'damien';
            $this->_login = 'damien';
            $this->_password = 'Cei7Thi&';
        } else {
            $this->_dbName = 'blog';
            $this->_login = 'root';
            $this->_password = '';
        }
        $this->_dsn .= $this->_dbName . ';charset=utf8';

        $this->dbManager = dbConnect::getDb(
            $this->_dsn,
            $this->_login,
            $this->_password
        );      

    }
}

