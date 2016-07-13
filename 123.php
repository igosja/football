<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `standing_id`,
               `standing_team_id`
        FROM `standing`
        WHERE `standing_season_id`='1'
        AND `standing_user_id`='0'
        ORDER BY `standing_id` ASC";
$standing_sql = $mysqli->query($sql);

$count_standing = $standing_sql->num_rows;
$standing_array = $standing_sql->fetch_all(1);

for ($i=0; $i<$count_standing; $i++)
{
    $standing_id    = $standing_array[$i]['standing_id'];
    $team_id        = $standing_array[$i]['standing_team_id'];

    $sql = "SELECT `history_user_id`
            FROM `history`
            WHERE `history_historytext_id`='1'
            AND `history_team_id`='$team_id'
            AND `history_date`<'1467658800'
            ORDER BY `history_id` DESC
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $count_user = $user_sql->num_rows;

    if (0 != $count_user)
    {
        $user_array = $user_sql->fetch_all(1);

        $user_id = $user_array[0]['history_user_id'];

        $sql = "UPDATE `standing`
                SET `standing_user_id`='$user_id'
                WHERE `standing_id`='$standing_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
}

print $count_standing;

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';