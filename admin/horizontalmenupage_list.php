<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `horizontalmenuchapter_name`, `horizontalmenupage_id`, `horizontalmenupage_name`
        FROM `horizontalmenupage`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenupage_horizontalmenuchapter_id`=`horizontalmenuchapter_id`
        ORDER BY `horizontalmenupage_name` ASC";
$horizontalmenupage_sql = $mysqli->query($sql);

$horizontalmenupage_array = $horizontalmenupage_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('horizontalmenupage_array', $horizontalmenupage_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');