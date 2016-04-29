<?php

function f_igosja_season_championship_visitor()
{
    global $igosja_season_id;

    $sql = "SELECT `standing_place`,
                   `standing_team_id`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'
            ORDER BY `standing_id` ASC";
    $standing_sql = f_igosja_mysqli_query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_standing; $i++)
    {
        $place      = $standing_array[$i]['standing_place'];
        $team_id    = $standing_array[$i]['standing_team_id'];
        $visitor    = 50000 - ($place - 1) * 1000;

        $sql = "UPDATE `team`
                SET `team_visitor`=IF(`team_visitor`+'1000'>'$visitor', '$visitor', `team_visitor`+'1000')
                WHERE `team_id`='$team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}