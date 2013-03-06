<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->insert('CRUDClass',array('name'=>'Name 5','email'=>'name5@email.com'));  // Table name, column names and respective values
$res = $db->getResult();  
print_r($res);