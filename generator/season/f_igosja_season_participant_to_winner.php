<?php

function f_igosja_season_participant_to_winner()
{
    $sql = "UPDATE `cupparticipant`
            SET `cupparticipant_out`='-1'
            WHERE `cupparticipant_out`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `leagueparticipant`
            SET `leagueparticipant_out`='-1'
            WHERE `leagueparticipant_out`='0'";
    f_igosja_mysqli_query($sql);
}