<?php

include (__DIR__ . '/include/include.php');

$num_get = 17;
$last = $num_get % 10;

$sql = "SELECT `name_name`,
               `player_ability`,
               `player_power` / '3600' AS `player_power`,
               `position_description`,
               `role_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN `positionrole`
        ON `positionrole_position_id`=`position_id`
        LEFT JOIN `role`
        ON `positionrole_role_id`=`role_id`
        WHERE `player_id`='$num_get'
        ORDER BY `positionrole_position_id` ASC";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;
$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$best_place = $last % $count_player;

for ($i=0; $i<$count_player; $i++) {
    if ($best_place == $i)
    {
        $plus = 10;
    }
    else
    {
        $plus = 0;
    }
    print $player_array[$i]['role_name'];
    print f_igosja_five_star($player_array[$i]['player_power'] + $plus, 12);
    print '<br/>';
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';