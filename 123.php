<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "INSERT INTO `test`
        SET `test_date`=UNIX_TIMESTAMP()";
$mysqli->query($sql);