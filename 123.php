<?php

$start_time = microtime(true);

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `game_id`,
               `game_guest_team_id`,
               `game_home_team_id`,
               `game_tournament_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        WHERE `shedule_date`=CURDATE()
        AND `game_played`='1'";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_game; $i++)
{
    $game_id        = $game_array[$i]['game_id'];
    $home_team_id   = $game_array[$i]['game_home_team_id'];
    $guest_team_id  = $game_array[$i]['game_guest_team_id'];

    $data['minute']                      = 1;
    $data['season']                      = $igosja_season_id;
    $data['air']                         = '';
    $data['decision']                    = '';
    $data['pass']                        = '';
    $data['take']                        = '';
    $data['team']                        = 'home';
    $data['opponent']                    = 'guest';
    $data['tournament']['tournament_id'] = $game_array[$i]['game_tournament_id'];
    $data['game_id']                     = $game_id;
    $data['home']['team']['team_id']     = $home_team_id;
    $data['guest']['team']['team_id']    = $guest_team_id;

    $sql = "SELECT `lineup_id`,
                   `lineup_position_id`,
                   `player_condition`,
                   `player_id`,
                   `player_practice`
            FROM `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            WHERE `lineup_team_id`='$home_team_id'
            AND `lineup_game_id`='$game_id'
            ORDER BY `lineup_position_id` ASC";
    $lineup_sql = $mysqli->query($sql);

    $count_lineup = $lineup_sql->num_rows;

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_lineup; $j++)
    {
        $player_id = $lineup_array[$j]['player_id'];

        $data['home']['player'][$j]['lineup_id']        = $lineup_array[$j]['lineup_id'];
        $data['home']['player'][$j]['lineup_position']  = $lineup_array[$j]['lineup_position_id'];
        $data['home']['player'][$j]['player_id']        = $player_id;
        $data['home']['player'][$j]['condition']        = $lineup_array[$j]['player_condition'];
        $data['home']['player'][$j]['practice']         = $lineup_array[$j]['player_practice'];

        $sql = "SELECT `playerattribute_attribute_id`,
                       `playerattribute_value`
                FROM `playerattribute`
                WHERE `playerattribute_player_id`='$player_id'
                ORDER BY `playerattribute_attribute_id` ASC";
        $attribute_sql = $mysqli->query($sql);

        $count_attribute = $attribute_sql->num_rows;

        $attaribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

        for ($k=0; $k<$count_attribute; $k++)
        {
            $data['home']['player'][$j]['attribute'][$attaribute_array[$k]['playerattribute_attribute_id']] = $attaribute_array[$k]['playerattribute_value'];
        }

        $sql = "SELECT `playerposition_position_id`,
                       `playerposition_value`
                FROM `playerposition`
                WHERE `playerposition_player_id`='$player_id'
                ORDER BY `playerposition_position_id` ASC";
        $position_sql = $mysqli->query($sql);

        $count_position = $position_sql->num_rows;

        $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

        for ($k=0; $k<$count_position; $k++)
        {
            $data['home']['player'][$j]['posititon'][$position_array[$k]['playerposition_position_id']] = $position_array[$k]['playerposition_value'];
        }
    }

    $sql = "SELECT `lineup_id`,
                   `lineup_position_id`,
                   `player_condition`,
                   `player_id`,
                   `player_practice`
            FROM `lineup`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            WHERE `lineup_team_id`='$guest_team_id'
            AND `lineup_game_id`='$game_id'
            ORDER BY `lineup_position_id` ASC";
    $lineup_sql = $mysqli->query($sql);

    $count_lineup = $lineup_sql->num_rows;

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_lineup; $j++)
    {
        $player_id = $lineup_array[$j]['player_id'];

        $data['guest']['player'][$j]['lineup_id']       = $lineup_array[$j]['lineup_id'];
        $data['guest']['player'][$j]['lineup_position'] = $lineup_array[$j]['lineup_position_id'];
        $data['guest']['player'][$j]['player_id']       = $player_id;
        $data['guest']['player'][$j]['condition']       = $lineup_array[$j]['player_condition'];
        $data['guest']['player'][$j]['practice']        = $lineup_array[$j]['player_practice'];

        $sql = "SELECT `playerattribute_attribute_id`,
                       `playerattribute_value`
                FROM `playerattribute`
                WHERE `playerattribute_player_id`='$player_id'
                ORDER BY `playerattribute_attribute_id` ASC";
        $attribute_sql = $mysqli->query($sql);

        $count_attribute = $attribute_sql->num_rows;

        $attaribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

        for ($k=0; $k<$count_attribute; $k++)
        {
            $data['guest']['player'][$j]['attribute'][$attaribute_array[$k]['playerattribute_attribute_id']] = $attaribute_array[$k]['playerattribute_value'];
        }

        $sql = "SELECT `playerposition_position_id`,
                       `playerposition_value`
                FROM `playerposition`
                WHERE `playerposition_player_id`='$player_id'
                ORDER BY `playerposition_position_id` ASC";
        $position_sql = $mysqli->query($sql);

        $count_position = $position_sql->num_rows;

        $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

        for ($k=0; $k<$count_position; $k++)
        {
            $data['guest']['player'][$j]['posititon'][$position_array[$k]['playerposition_position_id']] = $position_array[$k]['playerposition_value'];
        }
    }

    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
}

print round(microtime(true) - $start_time, 5);