<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `historytext_id`, `historytext_name`
        FROM `historytext`
        ORDER BY `historytext_id` ASC";
$historytext_sql = $mysqli->query($sql);

$historytext_array = $historytext_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('historytext_array', $historytext_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');