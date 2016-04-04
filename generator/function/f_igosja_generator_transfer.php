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
        $sql = "SELECT `player_team_id`,
                       `transfer_id`,
                       `transfer_buyer_id`,
                       `transfer_offertype_id`,
                       `transfer_player_id`,
                       `transfer_price`,
                       `transfer_seller_id`
                FROM `transfer`
                LEFT JOIN `player`
                ON `transfer_player_id`=`player_id`
                ORDER BY `transfer_id` ASC";
        $transfer_sql = f_igosja_mysqli_query($sql);

        $count_transfer = $transfer_sql->num_rows;
        $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_transfer; $i++)
        {
            $delete_sql     = 0;
            $transfer_id    = $transfer_array[$i]['transfer_id'];
            $player_id      = $transfer_array[$i]['transfer_price'];
            $player_team_id = $transfer_array[$i]['player_team_id'];
            $buyer_id       = $transfer_array[$i]['transfer_buyer_id'];
            $seller_id      = $transfer_array[$i]['transfer_seller_id'];
            $price          = $transfer_array[$i]['transfer_price'];
            $offertype_id   = $transfer_array[$i]['transfer_offertype_id'];

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`='$buyer_id'
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

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
                        SET `team_finance`=`team_finance`+'$price'
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
                        VALUES (SYSDATE(), '" . HISTORY_TEXT_EXPENCE_TRANSFER. "', '$igosja_season_id', '$buyer_id', '$price'),
                               (SYSDATE(), '" . HISTORY_TEXT_INCOME_TRANSFER. "', '$igosja_season_id', '$seller_id', '$price');";
                f_igosja_mysqli_query($sql);

                $sql = "INSERT INTO `transferhistory`
                        SET `transferhistory_buyer_id`='$buyer_id',
                            `transferhistory_date`=SYSDATE(),
                            `transferhistory_offertype_id`='$offertype_id',
                            `transferhistory_player_id`='$player_id',
                            `transferhistory_price`='$price',
                            `transferhistory_season_id`='$igosja_season_id',
                            `transferhistory_seller_id`='$seller_id'";
                f_igosja_mysqli_query($sql);

                $sql = "INSERT INTO `transferhistory`
                        SET `transferhistory_buyer_id`='$buyer_id',
                            `transferhistory_date`=SYSDATE(),
                            `transferhistory_offertype_id`='$offertype_id',
                            `transferhistory_player_id`='$player_id',
                            `transferhistory_price`='$price',
                            `transferhistory_season_id`='$igosja_season_id',
                            `transferhistory_seller_id`='$seller_id'";
                f_igosja_mysqli_query($sql);

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