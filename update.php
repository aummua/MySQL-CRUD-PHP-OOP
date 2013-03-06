<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->update('CRUDClass',array('name'=>"Phoebe",'email'=>"phoebestandley@gmail.com"),'id="2" AND name="Rory"');
$res = $db->getResult();
print_r($res);