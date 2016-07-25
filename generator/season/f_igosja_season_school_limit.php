<?php

function f_igosja_season_school_limit()
//Сбрасываем счетчик спортшколы
{
    $sql = "UPDATE `team`
            SET `team_school_use`='4'
            WHERE `team_school_use`<'4'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}