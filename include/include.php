<?php

$start_time = microtime(true);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/smarty.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/constants.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/database.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/function.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/session.php');

$file_name      = $_SERVER['PHP_SELF'];

$file_name      = explode('/', $file_name);
$chapter        = $file_name[1];
$file_name      = end($file_name);
$file_name      = explode('.', $file_name);
$file_name      = $file_name[0];
$header_2       = explode('_', $file_name);
$header_2_block = $header_2[0];

if (in_array($header_2_block, $HEADER_2_ARRAY))
{
    $header_2_block = $header_2_block . '-' . $header_2[1];
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = $mysqli->query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$igosja_season_id = $season_array[0]['season_id'];

$sql = "SELECT `continent_id`, `continent_name`
        FROM `continent`
        ORDER BY `continent_id` ASC";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `horizontalsubmenu_name`, `horizontalmenu_name`, `horizontalsubmenu_href`
        FROM `horizontalmenu`
        LEFT JOIN `horizontalsubmenu`
        ON `horizontalmenu_id`=`horizontalsubmenu_horizontalmenu_id`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenu_horizontalmenuchapter_id`=`horizontalmenuchapter_id`
        LEFT JOIN `horizontalmenupage`
        ON `horizontalmenuchapter_id`=`horizontalmenupage_horizontalmenuchapter_id`
        WHERE `horizontalmenupage_name`='$file_name'
        ORDER BY `horizontalmenu_id` ASC, `horizontalsubmenu_id` ASC";
$horizontalmenu_sql = $mysqli->query($sql);

$horizontalmenu_array = $horizontalmenu_sql->fetch_all(MYSQLI_ASSOC);

if ('admin' == $chapter)
{
    f_igosja_admin_permission($authorization_permission);
}

if (isset($_SESSION['message_class']))
{
    $smarty->assign($_SESSION['message_class'] . '_message', $_SESSION['message_text']);

    unset($_SESSION['message_class']);
    unset($_SESSION['message_text']);
}

$smarty->assign('main_menu_continent_array', $continent_array);
$smarty->assign('horizontalmenu_array', $horizontalmenu_array);
$smarty->assign('start_time', $start_time);
$smarty->assign('chapter', $chapter);
$smarty->assign('header_2_block', $header_2_block);
$smarty->assign('tpl', $file_name);