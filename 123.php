<?php

include (__DIR__ . '/include/database.php');

$sql = "INSERT INTO `test`
        SET `test_date`=UNIX_TIMESTAMP()";
$mysqli->query($sql);