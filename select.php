<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->select('CRUDClass');
$res = $db->getResult();
print_r($res);
