<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `gender_id`,
               `gender_name`
        FROM `gender`
        ORDER BY `gender_id` ASC";
$gender_sql = $mysqli->query($sql);

$gender_array = $gender_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');