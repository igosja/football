<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT COUNT(`shedule_id`) AS `count`
        FROM `shedule`
        WHERE `shedule_date`>CURRENT_DATE()
        AND `shedule_season_id`='$igosja_season_id'";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$count_shedule = $shedule_array[0]['count'];

if (0 == $count_shedule)
{
    //стартуем новый сезон
    //состариваем игроков на 1 год
    //раздаем призовые
    //раздаем трофеи менеджерам, командам, игрокам
    //обновляем достижения
    //обновляем статистику турниров - количество титулов и все такое
    //календарь на сезон
    //жребий турниров
    //очистить вспомогательные таблицы
    //новый сезон в базу

    $sql = "UPDATE `player`
            SET `player_age`=`player_age`+'1'
            WHERE `player_id`!='0'";
    $mysqli->query($sql);

    $sql = "UPDATE `user`
            LEFT JOIN `team`
            ON `team_user_id`=`user_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`team_id`
            SET `user_trophy`=`user_trophy`+'1'
            WHERE `standing_season_id`='$igosja_season_id'
            AND `standing_place`='1'
            AND `user_id`!='0'";
    $mysqli->query($sql);

    $sql = "SELECT `standing_point`,
                   `standing_score`,
                   `standing_team_id`,
                   `standing_tournament_id`
            FROM `standing`
            WHERE `standing_place`='1'
            ORDER BY `standing_id` ASC";
    $standing_sql = $mysqli->query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_standing; $i++)
    {
        $point          = $standing_array[$i]['standing_point'];
        $score          = $standing_array[$i]['standing_score'];
        $team_id        = $standing_array[$i]['standing_team_id'];
        $tournament_id  = $standing_array[$i]['standing_tournament_id'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "',
                        `recordtournament_season_id`='$igosja_season_id',
                        `recordtournament_team_id`='$team_id',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$point'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_point = $record_array[$i]['recordtournament_value_1'];

            if ($point > $record_point)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_value_1`='$point',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_season_id`='$igosja_season_id'
                        WHERE `recordtournament_tournament_id`='$tournament_id'
                        AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                LIMIT 1";
        $record_sql = $mysqli->query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "',
                        `recordtournament_season_id`='$igosja_season_id',
                        `recordtournament_team_id`='$team_id',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$score'";
            $mysqli->query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_score = $record_array[$i]['recordtournament_value_1'];

            if ($score > $record_score)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_value_1`='$score',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_season_id`='$igosja_season_id'
                        WHERE `recordtournament_tournament_id`='$tournament_id'
                        AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
    }
}

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';