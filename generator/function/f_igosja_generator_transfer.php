<?php

function f_igosja_generator_transfer()
//Проведение трансферов
{
    global $igosja_season_id;

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_OFF_SEASON . "'
            AND `shedule_date`=CURDATE()
            ORDER BY `shedule_id` ASC
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $count_shedule = $shedule_sql->num_rows;

    if (0 != $count_shedule)
    {
        $sql = "SELECT `buyer`.`team_user_id` AS `buyer_user_id`,
                       `player_team_id`,
                       `seller`.`team_user_id` AS `seller_user_id`,
                       `transfer_id`,
                       `transfer_buyer_id`,
                       `transfer_offertype_id`,
                       `transfer_player_id`,
                       `transfer_price`,
                       `transfer_seller_id`
                FROM `transfer`
                LEFT JOIN `player`
                ON `transfer_player_id`=`player_id`
                LEFT JOIN `team` AS `buyer`
                ON `buyer`.`team_id`=`transfer_buyer_id`
                LEFT JOIN `team` AS `seller`
                ON `seller`.`team_id`=`transfer_buyer_id`
                ORDER BY `transfer_id` ASC";
        $transfer_sql = f_igosja_mysqli_query($sql);

        $count_transfer = $transfer_sql->num_rows;
        $transfer_array = $transfer_sql->fetch_all(1);

        for ($i=0; $i<$count_transfer; $i++)
        {
            $delete_sql     = 0;
            $transfer_id    = $transfer_array[$i]['transfer_id'];
            $player_id      = $transfer_array[$i]['transfer_player_id'];
            $player_team_id = $transfer_array[$i]['player_team_id'];
            $buyer_id       = $transfer_array[$i]['transfer_buyer_id'];
            $buyer_user_id  = $transfer_array[$i]['buyer_user_id'];
            $seller_id      = $transfer_array[$i]['transfer_seller_id'];
            $seller_user_id = $transfer_array[$i]['seller_user_id'];
            $price          = $transfer_array[$i]['transfer_price'];
            $tax            = round($price / 10);
            $offertype_id   = $transfer_array[$i]['transfer_offertype_id'];

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`='$buyer_id'
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(1);

            $team_finance = $team_array[0]['team_finance'];

            if ($player_team_id == $seller_id &&
                $team_finance >= $price)
            {
                $sql = "UPDATE `player`
                        SET `player_team_id`='$buyer_id'
                        WHERE `player_id`='$player_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+'$price'-'$tax'
                        WHERE `team_id`='$seller_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`-'$price'
                        WHERE `team_id`='$buyer_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "INSERT INTO `historyfinanceteam`
                        (
                            `historyfinanceteam_date`,
                            `historyfinanceteam_historytext_id`,
                            `historyfinanceteam_season_id`,
                            `historyfinanceteam_team_id`,
                            `historyfinanceteam_value`
                        )
                        VALUES (UNIX_TIMESTAMP(), '" . HISTORY_TEXT_EXPENCE_TRANSFER. "', '$igosja_season_id', '$buyer_id', '$price'),
                               (UNIX_TIMESTAMP(), '" . HISTORY_TEXT_EXPENCE_TAX. "', '$igosja_season_id', '$seller_id', '$tax'),
                               (UNIX_TIMESTAMP(), '" . HISTORY_TEXT_INCOME_TRANSFER. "', '$igosja_season_id', '$seller_id', '$price');";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `finance`
                        SET `finance_expense_transfer`=`finance_expense_transfer`+'$price'
                        WHERE `finance_season_id`='$igosja_season_id'
                        AND `finance_team_id`='$buyer_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `finance`
                        SET `finance_income_transfer`=`finance_income_transfer`+'$price',
                            `finance_expense_tax`=`finance_expense_tax`+'$tax'
                        WHERE `finance_season_id`='$igosja_season_id'
                        AND `finance_team_id`='$seller_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $sql = "INSERT INTO `transferhistory`
                        SET `transferhistory_buyer_id`='$buyer_id',
                            `transferhistory_date`=UNIX_TIMESTAMP(),
                            `transferhistory_offertype_id`='$offertype_id',
                            `transferhistory_player_id`='$player_id',
                            `transferhistory_price`='$price',
                            `transferhistory_season_id`='$igosja_season_id',
                            `transferhistory_seller_id`='$seller_id'";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `recordteam_value`
                        FROM `recordteam`
                        WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_TRANSFER_FROM . "'
                        AND `recordteam_team_id`='$seller_id'
                        LIMIT 1";
                $record_sql = f_igosja_mysqli_query($sql);

                $count_record = $record_sql->num_rows;

                if (0 == $count_record)
                {
                    $sql = "INSERT INTO `recordteam`
                            SET `recordteam_date_start`=CURDATE(),
                                `recordteam_player_id`='$player_id',
                                `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_TRANSFER_FROM . "',
                                `recordteam_team_id`='$seller_id',
                                `recordteam_value`='$price'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $record_array = $record_sql->fetch_all(1);

                    $record_value = $record_array[0]['recordteam_value'];

                    if ($price > $record_value)
                    {
                        $sql = "UPDATE `recordteam`
                                SET `recordteam_date_start`=CURDATE(),
                                    `recordteam_player_id`='$player_id',
                                    `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_TRANSFER_FROM . "',
                                    `recordteam_value`='$price'
                                WHERE `recordteam_team_id`='$seller_id'
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                }

                $sql = "SELECT `recordteam_value`
                        FROM `recordteam`
                        WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_TRANSFER_TO . "'
                        AND `recordteam_team_id`='$buyer_id'
                        LIMIT 1";
                $record_sql = f_igosja_mysqli_query($sql);

                $count_record = $record_sql->num_rows;

                if (0 == $count_record)
                {
                    $sql = "INSERT INTO `recordteam`
                            SET `recordteam_date_start`=CURDATE(),
                                `recordteam_player_id`='$player_id',
                                `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_TRANSFER_TO . "',
                                `recordteam_team_id`='$buyer_id',
                                `recordteam_value`='$price'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $record_array = $record_sql->fetch_all(1);

                    $record_value = $record_array[0]['recordteam_value'];

                    if ($price > $record_value)
                    {
                        $sql = "UPDATE `recordteam`
                                SET `recordteam_date_start`=CURDATE(),
                                    `recordteam_player_id`='$player_id',
                                    `recordteam_recordteamtype_id`='" . RECORD_TEAM_BIGGEST_TRANSFER_TO . "',
                                    `recordteam_value`='$price'
                                WHERE `recordteam_team_id`='$buyer_id'
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                }

                if (0 != $seller_user_id)
                {
                    $sql = "UPDATE `user`
                            SET `user_sell_player`=`user_sell_player`+'1',
                                `user_sell_price`=`user_sell_price`+'$price',
                                `user_sell_max`=IF(`user_sell_max`>'$price', `user_sell_max`, '$price')
                            WHERE `user_id`='$seller_user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                if (0 != $buyer_user_id)
                {
                    $sql = "UPDATE `user`
                            SET `user_buy_player`=`user_buy_player`+'1',
                                `user_buy_price`=`user_buy_price`+'$price',
                                `user_buy_max`=IF(`user_buy_max`>'$price', `user_buy_max`, '$price')
                            WHERE `user_id`='$buyer_user_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }

                $delete_sql = 1;
            }
            elseif ($player_team_id != $seller_id)
            {
                $delete_sql = 1;
            }

            if (1 == $delete_sql)
            {
                $sql = "DELETE FROM `transfer`
                        WHERE `transfer_id`='$transfer_id'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}