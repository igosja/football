<?php

function f_igosja_season_player_age()
{
    $sql = "UPDATE `player`
            SET `player_age`=`player_age`+'1'
            WHERE `player_id`!='0'";
    f_igosja_mysqli_query($sql);
}