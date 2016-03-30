<?php

include (__DIR__ . '/include/include.php');

$sql = "INSERT INTO `test`
        SET `test_date`=UNIX_TIMESTAMP()";
$mysqli->query($sql);