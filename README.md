**Using The Class**
--


**Test MySQL**

Start by creating a test table in your database -

```mysql
CREATE TABLE IF NOT EXISTS CRUDClass (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO CRUDClass VALUES('','Name 1','name1@email.com');
INSERT INTO CRUDClass VALUES('','Name 2','name2@email.com');
INSERT INTO CRUDClass VALUES('','Name 3','name3@email.com');
```

**Select Example**

Use the following code to select * rows from the databse using the class

```php
<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->select('CRUDClass'); // Enter the table name
$res = $db->getResult();
print_r($res);
```