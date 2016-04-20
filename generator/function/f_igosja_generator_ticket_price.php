<?php

function f_igosja_generator_ticket_price()
//Обновление средней цены билета
{
    $sql = "UPDATE `team`
            LEFT JOIN `stadium`
            ON `stadium_team_id`=`team_id`
            SET `team_price_subscribe`=IF(ROUND(`stadium_capacity`/'1000')>'10',ROUND(`stadium_capacity`/'1000'),'10')*'38',
                `team_price_ticket`=IF(ROUND(`stadium_capacity`/'1000')>'10',ROUND(`stadium_capacity`/'1000'),'10'),
                `team_subscriber`=ROUND(`stadium_capacity`/'10')
            WHERE `team_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}