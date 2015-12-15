<?php

include ('../include/include.php');

$sql = "SELECT `country_name`,
               `tournament_id`,
               `tournament_level`,
               `tournament_name`,
               `tournamenttype_name`
        FROM `tournament`
        LEFT JOIN `tournamenttype`
        ON `tournament_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `country`
        ON `country_id`=`tournament_country_id`
        ORDER BY `tournamenttype_id` ASC, `tournament_name` ASC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('tournament_array', $tournament_array);

$smarty->display('admin_main.html');