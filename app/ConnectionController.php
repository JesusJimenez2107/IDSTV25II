<?php

class ConnectionController
{

    public function connect(): mysqli
    {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'bd_unidadvi_jpjc';
        $port = 3307;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $conn = new mysqli($host, $user, $pass, $db, $port);
        $conn->set_charset('utf8mb4');

        return $conn;
    }
}
?>