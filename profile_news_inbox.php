<?php

include ('include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    $smarty->display('wrong_page.html');

    exit;
}

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_title`
        FROM `inbox`
        WHERE `inbox_user_id`='$authorization_id'
        ORDER BY `inbox_date` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $authorization_id);
$smarty->assign('header_2_title', $authorization_login);
$smarty->assign('inbox_array', $inbox_array);

$smarty->display('main.html');