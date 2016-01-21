<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    $smarty->display('wrong_page.html');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `name_name`,
               `referee_id`,
               `statisticreferee_game`,
               ROUND(`statisticreferee_mark`/`statisticreferee_game`, 2) AS `statisticreferee_mark`,
               `statisticreferee_penalty`,
               `statisticreferee_red`,
               `statisticreferee_yellow`,
               `surname_name`
        FROM `statisticreferee`
        LEFT JOIN `referee`
        ON `referee_id`=`statisticreferee_referee_id`
        LEFT JOIN `name`
        ON `referee_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `referee_surname_id`=`surname_id`
        WHERE `statisticreferee_tournament_id`='$get_num'
        AND `statisticreferee_season_id`='$igosja_season_id'
        ORDER BY `statisticreferee_game` DESC, `statisticreferee_mark` DESC";
$referee_sql = $mysqli->query($sql);

$referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $tournament_name);
$smarty->assign('referee_array', $referee_array);

$smarty->display('main.html');