<?php

    class DB
    {
        private $host = 'localhost', $name = 'kanverhayatver', $user = 'root', $pass = '';

        public function connect()
        {
            $connection = new PDO("mysql:host=$this->host;dbname=$this->name;charset=utf8", $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        }
    }

?>