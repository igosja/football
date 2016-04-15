<?php

function f_igosja_season_shedule()
{
    global $igosja_season_id;

    $shedule_insert_sql = array();

    $shedule_friendly_array = array(19, 29, 31, 40, 57, 59, 61, 82, 88);
    $shedule_cup_array      = array(5, 12, 26, 33, 47, 54, 68, 75, 89);
    $shedule_league_array   = array(1, 3, 8, 10, 15, 17, 22, 24, 36, 38, 43, 45, 50, 52, 64, 66, 71, 73, 78, 80, 85, 87);
    $shedule_worldcup_array = array(6, 13, 20, 27, 34, 41, 48, 55, 62, 69, 76, 83, 90);

    for ($i=0; $i<98; $i++)
    {
        $day  = $i + 1;
        $date = strtotime(date('Y-m-d') . ' +1days');
        $date = strtotime(strtotime($date) . ' +' . $day . 'days');
        $date = date('Y-m-d', $date);

        if (90 < $i)
        {
            $tournament_type = TOURNAMENT_TYPE_OFF_SEASON;
        }
        elseif (in_array($i, $shedule_friendly_array))
        {
            $tournament_type = TOURNAMENT_TYPE_FRIENDLY;
        }
        elseif (in_array($i, $shedule_cup_array))
        {
            $tournament_type = TOURNAMENT_TYPE_CUP;
        }
        elseif (in_array($i, $shedule_league_array))
        {
            $tournament_type = TOURNAMENT_TYPE_CHAMPIONS_LEAGUE;
        }
        elseif (in_array($i, $shedule_worldcup_array))
        {
            $tournament_type = TOURNAMENT_TYPE_WORLD_CUP;
        }
        else
        {
            $tournament_type = TOURNAMENT_TYPE_CHAMPIONSHIP;
        }

        $shedule_insert_sql[] = "('$date', '$igosja_season_id', '$tournament_type')";
    }

    $shedule_insert_sql = implode(',', $shedule_insert_sql);

    $sql = "INSERT INTO `shedule` (`shedule_date`, `shedule_season_id`, `shedule_tournamenttype_id`)
            VALUES $shedule_insert_sql;";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}