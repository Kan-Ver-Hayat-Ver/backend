<?php

$db = new DB();
$host = $_SERVER['HTTP_HOST'];
$key = getallheaders()['API_KEY'];
$db = $db->connect();

$query = $db->query("SELECT * FROM authorize WHERE host = '$host' AND `key` = '$key'")->fetch(PDO::FETCH_OBJ);
if (!$query) { die(); }

?>