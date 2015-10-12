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

$sql = "SELECT `news_id`,
               `news_date`,
               `news_title`
        FROM `news`
        WHERE `news_user_id`='$authorization_id'
        ORDER BY `news_date` DESC";
$news_sql = $mysqli->query($sql);

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $authorization_id);
$smarty->assign('header_2_title', $authorization_login);
$smarty->assign('news_array', $news_array);

$smarty->display('main.html');