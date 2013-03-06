<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->select('CRUDClass','id,name','name="Name 1"','id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
$res = $db->getResult();
print_r($res);
