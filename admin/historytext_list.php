<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `historytext_id`, `historytext_name`
        FROM `historytext`
        ORDER BY `historytext_id` ASC";
$historytext_sql = $mysqli->query($sql);

$historytext_array = $historytext_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');