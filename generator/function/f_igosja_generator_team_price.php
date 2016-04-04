<?php

function f_igosja_generator_team_price()
//Обновление стоимости команд
{
    $sql = "UPDATE `team`
            LEFT JOIN `stadium`
            ON `stadium_team_id`=`team_id`
            SET `team_price`=`team_finance`+POW(`team_school_level`, '1.5')*'1000000'+POW(`team_training_level`, '1.5')*'1000000'+`stadium_capacity`*'999'
            WHERE `team_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}