<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `team_id`,
               `user_id`
        FROM `team`
        LEFT JOIN `user`
        ON `user_id`=`team_user_id`
        WHERE `user_last_visit`<UNIX_TIMESTAMP() - 14 * 24 * 24 * 60
        ORDER BY `team_id` ASC";
$user_sql = $mysqli->query($sql);

$count_user = $user_sql->num_rows;
$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_user; $i++)
{
    $user_id = $user_array[$i]['user_id'];
    $team_id = $user_array[$i]['team_id'];

    $sql = "UPDATE `team`
                SET `team_user_id`='0'
                WHERE `team_id`='$team_id'
                LIMIT 1";
    $mysqli->query($sql);

    f_igosja_history(2, $user_id, 0, $team_id);
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';