<?php

function f_igosja_season_new_season()
{
    global $igosja_season_id;

    $sql = "INSERT INTO `season`
            SET `season_id`=NULL";
    f_igosja_mysqli_query($sql);

    $igosja_season_id++;
}