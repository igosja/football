<?php

function f_igosja_generator_finance()
//Финансы после матча
{
    global $igosja_season_id;

    $sql = "SELECT `finance_team_id`,
                   `team_id`
            FROM `team`
            LEFT JOIN
            (
                SELECT `finance_team_id`
                FROM `finance`
                WHERE `finance_season_id`='$igosja_season_id'
                GROUP BY `finance_team_id`
            ) AS `t1`
            ON `team_id`=`finance_team_id`
            WHERE `team_id`>'0'
            ORDER BY `team_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i++)
    {
        $finance_team_id = $team_array[$i]['finance_team_id'];

        if (!$finance_team_id)
        {
            $team_id = $team_array[$i]['team_id'];

            $sql = "INSERT INTO `finance`
                    SET `finance_team_id`='$team_id',
                        `finance_season_id`='$igosja_season_id'";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `player_salary`,
                   `team_school_level`,
                   `team_training_level`,
                   `staff_salary`,
                   `standing_place`,
                   `team_id`
            FROM `team`
            LEFT JOIN
            (
                SELECT `standing_place`,
                       `standing_team_id`
                FROM `standing`
                WHERE `standing_season_id`='$igosja_season_id'
            ) AS `t1`
            ON `standing_team_id`=`team_id`
            LEFT JOIN
            (
                SELECT `player_team_id`,
                       SUM(`player_salary`) AS `player_salary`
                FROM `player`
                GROUP BY `player_team_id`
            ) AS `t2`
            ON `player_team_id`=`team_id`
            LEFT JOIN
            (
                SELECT `staff_team_id`,
                       SUM(`staff_salary`) AS `staff_salary`
                FROM `staff`
                GROUP BY `staff_team_id`
            ) AS `t3`
            ON `staff_team_id`=`team_id`
            WHERE `team_id`!='0'
            ORDER BY `team_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i++)
    {
        $team_id            = $team_array[$i]['team_id'];
        $player_salary      = $team_array[$i]['player_salary'];
        $school_level       = $team_array[$i]['team_school_level'];
        $staff_salary       = $team_array[$i]['staff_salary'];
        $standing_place     = $team_array[$i]['standing_place'];
        $training_level     = $team_array[$i]['team_training_level'];
        $finance_tv         = 50000;
        $finance_attributes = (100 - $standing_place) * 10000 / 105;
        $finance_sponsor    = $finance_attributes;
        $finance_agent      = round($player_salary / 100);
        $finance_scout      = pow($training_level, 2) * 100;
        $finance_salary     = $player_salary + $staff_salary;
        $finance_base       = pow($school_level, 2) * 1000000 / 105 + pow($training_level, 2) * 1000000 / 105;
        $finance            = $finance_tv + $finance_attributes + $finance_sponsor - $finance_agent - $finance_scout - $finance_salary - $finance_base;

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+'$finance'
                WHERE `team_id`='$team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `finance`
                SET `finance_income_tv`=`finance_income_tv`+'$finance_tv',
                    `finance_income_attributes`=`finance_income_attributes`+'$finance_attributes',
                    `finance_income_sponsor`=`finance_income_sponsor`+'$finance_sponsor',
                    `finance_expense_agent`=`finance_expense_agent`+'$finance_agent',
                    `finance_expense_scout`=`finance_expense_scout`+'$finance_scout',
                    `finance_expense_salary`=`finance_expense_salary`+'$finance_salary',
                    `finance_expense_base`=`finance_expense_base`+'$finance_base'
                WHERE `finance_team_id`='$team_id'
                AND `finance_season_id`='$igosja_season_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `historyfinanceteam` (`historyfinanceteam_date`, `historyfinanceteam_historytext_id`, `historyfinanceteam_season_id`, `historyfinanceteam_team_id`, `historyfinanceteam_value`)
                VALUES (CURDATE(), '" . HISTORY_TEXT_INCOME_TV . "', '$igosja_season_id', '$team_id', '$finance_tv'),
                       (CURDATE(), '" . HISTORY_TEXT_INCOME_ATTRIBUTE . "', '$igosja_season_id', '$team_id', '$finance_attributes'),
                       (CURDATE(), '" . HISTORY_TEXT_INCOME_SPONSOR . "', '$igosja_season_id', '$team_id', '$finance_sponsor'),
                       (CURDATE(), '" . HISTORY_TEXT_EXPENCE_AGENT . "', '$igosja_season_id', '$team_id', '$finance_agent'),
                       (CURDATE(), '" . HISTORY_TEXT_EXPENCE_SCOUT . "', '$igosja_season_id', '$team_id', '$finance_scout'),
                       (CURDATE(), '" . HISTORY_TEXT_EXPENCE_SALARY . "', '$igosja_season_id', '$team_id', '$finance_salary'),
                       (CURDATE(), '" . HISTORY_TEXT_EXPENCE_BASE . "', '$igosja_season_id', '$team_id', '$finance_base');";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `game_ticket_price`,
                   `game_visitor`,
                   `stadium_capacity`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `stadium`
            ON `stadium_id`=`game_stadium_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id           = $game_array[$i]['game_home_team_id'];
        $guest_team_id          = $game_array[$i]['game_guest_team_id'];
        $ticket_price           = $game_array[$i]['game_ticket_price'];
        $visitor                = $game_array[$i]['game_visitor'];
        $capacity               = $game_array[$i]['stadium_capacity'];
        $finance_ticket_home    = round($ticket_price * $visitor * 0.8);
        $finance_ticket_guest   = round($ticket_price * $visitor * 0.1);
        $finance_subscription   = $finance_ticket_guest;
        $finance_stadium        = $capacity * pow($capacity / 7500, 2);
        $finance_transport      = 500;
        $finance_home           = $finance_ticket_home + $finance_subscription - $finance_stadium;
        $finance_guest          = $finance_ticket_guest - $finance_transport;

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+'$finance_home'
                WHERE `team_id`='$home_team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `finance`
                SET `finance_income_ticket`=`finance_income_ticket`+'$finance_ticket_home',
                    `finance_income_subscription`=`finance_income_subscription`+'$finance_subscription',
                    `finance_expense_stadium`=`finance_expense_stadium`+'$finance_stadium'
                WHERE `finance_team_id`='$home_team_id'
                AND `finance_season_id`='$igosja_season_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `historyfinanceteam` (`historyfinanceteam_date`, `historyfinanceteam_historytext_id`, `historyfinanceteam_season_id`, `historyfinanceteam_team_id`, `historyfinanceteam_value`)
                VALUES (CURDATE(), '" . HISTORY_TEXT_INCOME_TICKET . "', '$igosja_season_id', '$home_team_id', '$finance_ticket_home'),
                       (CURDATE(), '" . HISTORY_TEXT_INCOME_SUBSCRIPTION . "', '$igosja_season_id', '$home_team_id', '$finance_subscription'),
                       (CURDATE(), '" . HISTORY_TEXT_EXPENCE_STADIUM . "', '$igosja_season_id', '$home_team_id', '$finance_stadium');";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+'$finance_guest'
                WHERE `team_id`='$guest_team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `finance`
                SET `finance_income_ticket`=`finance_income_ticket`+'$finance_ticket_guest',
                    `finance_expense_transport`=`finance_expense_transport`+'$finance_transport'
                WHERE `finance_team_id`='$guest_team_id'
                AND `finance_season_id`='$igosja_season_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `historyfinanceteam` (`historyfinanceteam_date`, `historyfinanceteam_historytext_id`, `historyfinanceteam_season_id`, `historyfinanceteam_team_id`, `historyfinanceteam_value`)
                VALUES (CURDATE(), '" . HISTORY_TEXT_INCOME_TICKET . "', '$igosja_season_id', '$guest_team_id', '$finance_ticket_guest'),
                       (CURDATE(), '" . HISTORY_TEXT_EXPENCE_TRANSPORT . "', '$igosja_season_id', '$guest_team_id', '$finance_transport');";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}