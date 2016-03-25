<?php

function f_igosja_generator_visitor()
//Количество зрителей на трибунах
{
    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            LEFT JOIN `tournamenttype`
            ON `tournamenttype_id`=`tournament_tournamenttype_id`
            LEFT JOIN `team` AS `home`
            ON `game_home_team_id`=`home`.`team_id`
            LEFT JOIN `team` AS `guest`
            ON `game_guest_team_id`=`guest`.`team_id`
            LEFT JOIN `stadium`
            ON `stadium_id`=`game_stadium_id`
            SET `game_visitor`=IF(ROUND((`home`.`team_visitor`+`guest`.`team_visitor`)*`tournamenttype_visitor`)>`stadium_capacity`,`stadium_capacity`,ROUND(`home`.`team_visitor`+`guest`.`team_visitor`)*`tournamenttype_visitor`),
                `game_ticket_price`=IF(ROUND(`stadium_capacity`/'1000')>'10',ROUND(`stadium_capacity`/'1000'),'10')
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            AND `game_home_team_id`!='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            LEFT JOIN `tournamenttype`
            ON `tournamenttype_id`=`tournament_tournamenttype_id`
            LEFT JOIN `stadium`
            ON `stadium_id`=`game_stadium_id`
            SET `game_visitor`=IF(ROUND('50000'*`tournamenttype_visitor`)>`stadium_capacity`, `stadium_capacity`, ROUND('50000')*`tournamenttype_visitor`),
                `game_ticket_price`=IF(ROUND(`stadium_capacity`/'1000')>'10',ROUND(`stadium_capacity`/'1000'),'10')
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            AND `game_home_team_id`='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}