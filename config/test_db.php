<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
// $db['dsn'] = 'mysql:host=127.0.0.1:3306;dbname=todo_test';
$db['class'] = 'yii\db\Connection';
$db['dsn'] = 'pgsql:host=localhost;dbname=todo_test';
$db['username'] = 'postgres';
$db['password'] = '';
$db['charset'] = 'utf8'

 // for travis-ci use: 'root' or 'travis' for less privileges.

return $db;
