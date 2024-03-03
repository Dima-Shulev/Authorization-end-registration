<?php

class ConnectionDb{

    const DB_HOST = "localhost";
    /*const DB_PORT = "3306";*/
    const DB_NAME = "intern";
    const DB_USER = "intern";
    const DB_PASS = "intern";
    const DB_CHARSET = "utf8";

    public $DNS;
    public $OPT;
    public $PDO;

    public function  __construct()
    {
        $this->DNS = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET . "";
        $this->OPT = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            $this->PDO = new PDO($this->DNS, self::DB_USER, self::DB_PASS, $this->OPT);
        } catch(PDOException $e) {
            echo "Ошибка: ".$e->getMessage();
        }
    }
}
