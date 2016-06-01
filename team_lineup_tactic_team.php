<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($_GET['game']))
{
    $game_id = (int) $_GET['game'];
}
else
{
    $sql = "SELECT `game_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE (`game_home_team_id`='$num_get'
            OR `game_guest_team_id`='$num_get')
            AND `game_played`='0'
            ORDER BY `shedule_date` ASC
            LIMIT 1";
    $game_sql = $mysqli->query($sql);

    $game_array = $game_sql->fetch_all(1);

    if (isset($game_array[0]['game_id']))
    {
        $game_id = $game_array[0]['game_id'];
    }
    else
    {
        include (__DIR__ . '/view/no_game.php');
        exit;
    }
}

$sql = "SELECT COUNT(`game_id`) AS `count`
        FROM `game`
        WHERE `game_id`='$game_id'
        AND (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(1);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include (__DIR__ . '/view/only_my_game.php');
    exit;
}

$team_array = $team_sql->fetch_all(1);

$team_name = $team_array[0]['team_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    $gamemood_id  = (int) $data['gamemood'];
    $gamestyle_id = (int) $data['gamestyle'];

    $sql = "SELECT COUNT(`lineupmain_id`) AS `count`
            FROM `lineupmain`
            WHERE `lineupmain_game_id`='$game_id'
            AND `lineupmain_team_id`='$num_get'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(1);

    $count_lineup = $count_array[0]['count'];

    if (0 == $count_lineup)
    {
        $sql = "INSERT INTO `lineupmain`
                SET `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id',
                    `lineupmain_team_id`='$num_get',
                    `lineupmain_game_id`='$game_id'";
    }
    else
    {
        $sql = "UPDATE `lineupmain`
                SET `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id'
                WHERE `lineupmain_team_id`='$num_get'
                AND `lineupmain_game_id`='$game_id'
                LIMIT 1";
    }

    $mysqli->query($sql);

    $sql = "UPDATE `teaminstruction`
            SET `teaminstruction_status`='0'
            WHERE `teaminstruction_team_id`='$num_get'
            AND `teaminstruction_game_id`='$game_id'";
    $mysqli->query($sql);
    
    if (isset($data['instruction']))
    {
        foreach ($data['instruction'] as $item)
        {
            $instruction_id = (int) $item;

            $sql = "SELECT `teaminstruction_id`
                    FROM `teaminstruction`
                    WHERE `teaminstruction_team_id`='$authorization_team_id'
                    AND `teaminstruction_instruction_id`='$instruction_id'
                    AND `teaminstruction_game_id`='$game_id'
                    LIMIT 1";
            $teaminstruction_sql = $mysqli->query($sql);

            $count_teaminstruction = $teaminstruction_sql->num_rows;

            if (0 == $count_teaminstruction)
            {
                $sql = "INSERT INTO `teaminstruction`
                        SET `teaminstruction_team_id`='$authorization_team_id',
                            `teaminstruction_instruction_id`='$instruction_id',
                            `teaminstruction_game_id`='$game_id'";
                $mysqli->query($sql);
            }
            else
            {
                $teaminstruction_array = $teaminstruction_sql->fetch_all(1);

                $teaminstruction_id = $teaminstruction_array[0]['teaminstruction_id'];

                $sql = "UPDATE `teaminstruction`
                        SET `teaminstruction_status`='1'
                        WHERE `teaminstruction_id`='$teaminstruction_id'
                        LIMIT 1";
                $mysqli->query($sql);
            }
        }
    }

    if (isset($data['substitution']))
    {
        $sql = "DELETE FROM `lineupsubstitution`
                WHERE `lineupsubstitution_game_id`='$game_id'
                AND `lineupsubstitution_team_id`='$num_get'";
        $mysqli->query($sql);

        foreach ($data['substitution'] as $item)
        {
            if (0 != $item['out'] && 0 != $item['in'])
            {
                $minute     = (int) $item['minute'];
                $condition  = (int) $item['condition'];
                $out        = (int) $item['out'];
                $in         = (int) $item['in'];

                $sql = "INSERT INTO `lineupsubstitution`
                        SET `lineupsubstitution_game_id`='$game_id',
                            `lineupsubstitution_team_id`='$num_get',
                            `lineupsubstitution_in`='$in',
                            `lineupsubstitution_out`='$out',
                            `lineupsubstitution_minute`='$minute',
                            `lineupsubstitution_lineupcondition_id`='$condition'";
                $mysqli->query($sql);
            }
        }
    }

    if (isset($data['tactic']))
    {
        $sql = "DELETE FROM `lineuptactic`
                WHERE `lineuptactic_game_id`='$game_id'
                AND `lineuptactic_team_id`='$num_get'";
        $mysqli->query($sql);

        foreach ($data['tactic'] as $item)
        {
            if (0 != $item['tactic'])
            {
                $minute     = (int) $item['minute'];
                $condition  = (int) $item['condition'];
                $tactic     = explode(';', $item['tactic']);

                if (1 == $tactic[0])
                {
                    $gamemood = (int) $tactic[1];
                    $gamesyle = 0;
                }
                else
                {
                    $gamemood = 0;
                    $gamesyle = (int) $tactic[1];
                }

                $sql = "INSERT INTO `lineuptactic`
                        SET `lineuptactic_game_id`='$game_id',
                            `lineuptactic_team_id`='$num_get',
                            `lineuptactic_gamemood_id`='$gamemood',
                            `lineuptactic_gamestyle_id`='$gamesyle',
                            `lineuptactic_minute`='$minute',
                            `lineuptactic_lineupcondition_id`='$condition'";
                $mysqli->query($sql);
            }
        }
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_team.php?num=' . $num_get . '&game=' . $game_id);
}

$sql = "SELECT `game_home_team_id`,
               `game_id`,
               `game_temperature`,
               `lineupmain_id`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `weather_id`,
               `weather_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$num_get', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `weather`
        ON `weather_id`=`game_weather_id`
        LEFT JOIN `lineupmain`
        ON (`lineupmain_game_id`=`game_id`
        AND `lineupmain_team_id`='$num_get')
        WHERE (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(1);

$sql = "SELECT `gamestyle_description`,
               `gamestyle_id`,
               `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(1);

$sql = "SELECT `gamemood_description`,
               `gamemood_id`,
               `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(1);

$sql = "SELECT `lineupmain_gamemood_id`,
               `lineupmain_gamestyle_id`
        FROM `lineupmain`
        WHERE `lineupmain_team_id`='$num_get'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(1);

$sql = "SELECT `instruction_id`,
               `instruction_name`,
               `instructionchapter_id`,
               `instructionchapter_name`
        FROM `instruction`
        LEFT JOIN `instructionchapter`
        ON `instruction_instructionchapter_id`=`instructionchapter_id`
        ORDER BY `instructionchapter_id` ASC, `instruction_id` ASC";
$instruction_sql = $mysqli->query($sql);

$count_instruction = $instruction_sql->num_rows;
$instruction_array = $instruction_sql->fetch_all(1);

$sql = "SELECT `teaminstruction_instruction_id`
        FROM `teaminstruction`
        WHERE `teaminstruction_team_id`='$num_get'
        AND `teaminstruction_status`='1'
        AND `teaminstruction_game_id`='$game_id'
        ORDER BY `teaminstruction_instruction_id` ASC";
$teaminstruction_sql = $mysqli->query($sql);

$teaminstruction_array = $teaminstruction_sql->fetch_all(1);

$sql = "SELECT `lineup_id`,
               `position_name`,
               `surname_name`
        FROM `lineup`
        LEFT JOIN `player`
        ON `lineup_player_id`=`player_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `position`
        ON `position_id`=`lineup_position_id`
        WHERE `lineup_position_id` BETWEEN '1' AND '25'
        AND `lineup_team_id`='$num_get'
        AND `lineup_game_id`='$game_id'
        ORDER BY `lineup_position_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `lineup_id`,
               `position_name`,
               `surname_name`
        FROM `lineup`
        LEFT JOIN `player`
        ON `lineup_player_id`=`player_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `position`
        ON `position_id`=`player_position_id`
        WHERE `lineup_position_id`>'25'
        AND `lineup_team_id`='$num_get'
        AND `lineup_game_id`='$game_id'
        ORDER BY `lineup_position_id` ASC";
$reserve_sql = $mysqli->query($sql);

$reserve_array = $reserve_sql->fetch_all(1);

$sql = "SELECT `lineupsubstitution_in`,
               `lineupsubstitution_lineupcondition_id`,
               `lineupsubstitution_minute`,
               `lineupsubstitution_out`
        FROM `lineupsubstitution`
        WHERE `lineupsubstitution_team_id`='$num_get'
        AND `lineupsubstitution_game_id`='$game_id'";
$lineupsubstitution_sql = $mysqli->query($sql);

$lineupsubstitution_array = $lineupsubstitution_sql->fetch_all(1);

$sql = "SELECT `lineuptactic_gamemood_id`,
               `lineuptactic_gamestyle_id`,
               `lineuptactic_lineupcondition_id`,
               `lineuptactic_minute`
        FROM `lineuptactic`
        WHERE `lineuptactic_team_id`='$num_get'
        AND `lineuptactic_game_id`='$game_id'";
$lineuptactic_sql = $mysqli->query($sql);

$lineuptactic_array = $lineuptactic_sql->fetch_all(1);

$sql = "SELECT `lineupcondition_id`,
               `lineupcondition_name`
        FROM `lineupcondition`
        ORDER BY `lineupcondition_id` ASC";
$lineupcondition_sql = $mysqli->query($sql);

$lineupcondition_array = $lineupcondition_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Выбор командных инструкций. ' . $seo_title;
$seo_description    = $header_title . '. Выбор командных инструкций. ' . $seo_description;
$seo_keywords       = $header_title . ', выбор командных инструкций, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');