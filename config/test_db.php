<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'pgsql:host=127.0.0.1;dbname=yii2_basic_tests';

return $db;
