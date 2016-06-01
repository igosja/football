<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `formation_id`,
               `formation_name`
        FROM `formation`
        ORDER BY `formation_id` ASC";
$formation_sql = $mysqli->query($sql);

$formation_array = $formation_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');