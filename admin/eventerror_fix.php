<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `event_country_id`,
               `event_id`,
               `event_minute`,
               `event_team_id`,
               `eventtype_id`,
               `game_id`,
               `game_tournament_id`,
               `shedule_season_id`
        FROM `event`
        LEFT JOIN `eventtype`
        ON `eventtype_id`=`event_eventtype_id`
        LEFT JOIN `game`
        ON `game_id`=`event_game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `event_player_id`='0'
        ORDER BY `event_id` ASC";
$event_sql = $mysqli->query($sql);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(1);

for ($i=0; $i<$count_event; $i++)
{
    $event_id       = $event_array[$i]['event_id'];
    $event_minute   = $event_array[$i]['event_minute'];
    $game_id        = $event_array[$i]['game_id'];
    $season_id      = $event_array[$i]['shedule_season_id'];
    $tournament_id  = $event_array[$i]['game_tournament_id'];
    $eventtype_id   = $event_array[$i]['eventtype_id'];
    $team_id        = $event_array[$i]['event_team_id'];
    $country_id     = $event_array[$i]['event_country_id'];

    if (1 == $eventtype_id)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$team_id'
                AND `lineup_country_id`='$country_id'
                AND `lineup_red`='0'
                AND `lineup_yellow`<'2'
                AND `lineup_game_id`='$game_id'
                AND ((`lineup_position_id` BETWEEN '2' AND '25'
                AND (`lineup_out`='0'
                OR `lineup_out`>='$event_minute'))
                OR (`lineup_in`<='$event_minute'
                AND `lineup_in`!='0'))
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(1);

        $player_id = $player_array[0]['lineup_player_id'];
        $lineup_id = $player_array[0]['lineup_id'];

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_goal`=`statisticplayer_goal`+'1',
                    `statisticplayer_penalty`=`statisticplayer_penalty`+'1',
                    `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_season_id`='$season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$team_id'
                AND `statisticplayer_country_id`='$country_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `event`
                SET `event_player_id`='$player_id'
                WHERE `event_id`='$event_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
    elseif (5 == $eventtype_id)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$team_id'
                AND `lineup_country_id`='$country_id'
                AND ((`lineup_position_id` BETWEEN '2' AND '25'
                AND (`lineup_out`='0'
                OR `lineup_out`>='$event_minute'))
                OR (`lineup_in`<='$event_minute'
                AND `lineup_in`!='0'))
                AND `lineup_game_id`='$game_id'
                AND `lineup_yellow`='0'
                AND `lineup_red`='0'
                ORDER BY RAND()
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(1);

        $player_id = $player_array[0]['lineup_player_id'];
        $lineup_id = $player_array[0]['lineup_id'];

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_yellow`=`statisticplayer_yellow`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_season_id`='$season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$team_id'
                AND `statisticplayer_country_id`='$country_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_yellow`=`lineup_yellow`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `event`
                SET `event_player_id`='$player_id'
                WHERE `event_id`='$event_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
    elseif (7 == $eventtype_id)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$team_id'
                AND `lineup_country_id`='$country_id'
                AND ((`lineup_position_id` BETWEEN '2' AND '25'
                AND (`lineup_out`='0'
                OR `lineup_out`>='$event_minute'))
                OR (`lineup_in`<='$event_minute'
                AND `lineup_in`!='0'))
                AND `lineup_game_id`='$game_id'
                AND `lineup_red`='0'
                AND `lineup_yellow`<'2'
                ORDER BY RAND()
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(1);

        $player_id = $player_array[0]['lineup_player_id'];
        $lineup_id = $player_array[0]['lineup_id'];

        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_red`=`statisticplayer_red`+'1'
                WHERE `statisticplayer_player_id`='$player_id'
                AND `statisticplayer_season_id`='$season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$team_id'
                AND `statisticplayer_country_id`='$country_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_red`=`lineup_red`+'1'
                WHERE `lineup_id`='$lineup_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `event`
                SET `event_player_id`='$player_id'
                WHERE `event_id`='$event_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
}

redirect('eventerror_list.php');