<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `injurytype_id`,
               `injurytype_day`,
               `injurytype_name`
        FROM `injurytype`
        ORDER BY `injurytype_id` ASC";
$injurytype_sql = $mysqli->query($sql);

$injurytype_array = $injurytype_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');