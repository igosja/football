<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `historytext_id`,
               `historytext_name`
        FROM `historytext`
        ORDER BY `historytext_id` ASC";
$historytext_sql = $mysqli->query($sql);

$historytext_array = $historytext_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');