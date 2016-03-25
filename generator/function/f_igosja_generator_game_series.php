<?php

function f_igosja_generator_game_series()
//Увеличение серий матчей (побед, без поражений, без пропущенных...)
{
    $sql = "SELECT `game_guest_country_id`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_country_id`,
                   `game_home_score`,
                   `game_home_team_id`,
                   `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $home_country_id    = $game_array[$i]['game_home_country_id'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];
        $guest_country_id   = $game_array[$i]['game_guest_country_id'];
        $tournament_id      = $game_array[$i]['game_tournament_id'];
        $home_score         = $game_array[$i]['game_home_score'];
        $guest_score        = $game_array[$i]['game_guest_score'];

        if (0 != $home_team_id)
        {
            if ($home_score > $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
            elseif ($home_score < $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
            elseif ($home_score == $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            if (0 == $home_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
            elseif (0 != $home_score)
            {
                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);
            }

            if (0 == $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$guest_team_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$guest_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_team_id`='$home_team_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_team_id`='$home_team_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
            elseif (0 != $guest_score)
            {
                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$guest_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_team_id`='$home_team_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);
            }
        }
        else
        {
            if ($home_score > $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
            elseif ($home_score < $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_NO_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND (`series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
            elseif ($home_score == $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE. "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='0'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_LOOSE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_WIN . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_WIN . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND (`series_seriestype_id`='" . SERIES_LOOSE . "'
                        OR `series_seriestype_id`='" . SERIES_WIN . "')
                        AND `series_tournament_id`='$tournament_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            if (0 == $home_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
            elseif (0 != $home_score)
            {
                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);
            }

            if (0 == $guest_score)
            {
                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='0'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$guest_country_id',
                                `series_seriestype_id`=" . SERIES_NO_SCORE . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$guest_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $sql = "SELECT `series_id`
                        FROM `series`
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $count_check = $check_sql->num_rows;

                if (0 == $count_check)
                {
                    $sql = "INSERT INTO `series`
                            SET `series_country_id`='$home_country_id',
                                `series_seriestype_id`=" . SERIES_NO_PASS . ",
                                `series_value`='1',
                                `series_tournament_id`='$tournament_id',
                                `series_date_start`=CURDATE(),
                                `series_date_end`=CURDATE()";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `series`
                            SET `series_value`=`series_value`+'1',
                                `series_date_end`=CURDATE(),
                                `series_date_start`=IF(`series_value`='0', CURDATE(), `series_date_start`)
                            WHERE `series_country_id`='$home_country_id'
                            AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
                            AND `series_tournament_id`='$tournament_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
            elseif (0 != $guest_score)
            {
                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='0'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$guest_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_SCORE . "'";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `series`
                        SET `series_value`='0'
                        WHERE `series_country_id`='$home_country_id'
                        AND `series_tournament_id`='$tournament_id'
                        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}