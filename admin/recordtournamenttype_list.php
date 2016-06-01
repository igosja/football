<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `recordtournamenttype_id`, `recordtournamenttype_name`
        FROM `recordtournamenttype`
        ORDER BY `recordtournamenttype_id` ASC";
$recordtournamenttype_sql = $mysqli->query($sql);

$recordtournamenttype_array = $recordtournamenttype_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');