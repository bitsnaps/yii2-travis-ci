<?php
$db = require __DIR__ . '/db.php';

// test database! Important not to run tests on production or development databases

// for travis-ci use: 'root' or 'travis' for less privileges.

$DB_NAME = 'todo_test';

// if ( getenv("TRAVIS") == 'true' ){ // this check doesn't work for me

  // PostgreSQL (working correctly on travis)
  // $db['class'] = 'yii\db\Connection';
  // $db['dsn'] = 'pgsql:host=localhost:5432;dbname='.$DB_NAME;
  // $db['username'] = 'postgres';
  // $db['password'] = '';
  // $db['charset'] = 'utf8';

// } else {
  // MySQL
  $db['dsn'] = 'mysql:host=127.0.0.1:3306;dbname='.$DB_NAME;

// }

return $db;
