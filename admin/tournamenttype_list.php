<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = $mysqli->query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');