A simple PHP Class for using with MySQL create, read, update and delete functions. Using OOP this class can easily be added to to enhance existing functions or create more.

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

Use the following code to select * rows from the databse using this class

```php
<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->select('CRUDClass'); // Table name
$res = $db->getResult();
print_r($res);
```

Use the following code to specify what is selected from the database using this class

```php
<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->select('CRUDClass','id,name','name="Name 1"','id DESC'); // Table name, Column Names, WHERE conditions, ORDER BY conditions
$res = $db->getResult();
print_r($res);
```

**Update Example**

Use the following code to update rows in the database using this class

```php
<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->update('CRUDClass',array('name'=>"Name 4",'email'=>"name4@email.com"),'id="1" AND name="Name 1"'); // Table name, column names and values, WHERE conditions
$res = $db->getResult();
print_r($res);
```

**Insert Example**

Use the following code to insert rows into the database using this class

```php
<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->insert('CRUDClass',array('name'=>'Name 5','email'=>'name5@email.com'));  // Table name, column names and respective values
$res = $db->getResult();  
print_r($res);
```

**Delete Example**

Use the following code to delete rows from the database with this class

```php
<?php
include('class/mysql_crud.php');
$db = new Database();
$db->connect();
$db->delete('CRUDClass','id=5');  // Table name, WHERE conditions
$res = $db->getResult();  
print_r($res);
```