<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_GET['from_del']))
{
    $delete = (int) $_GET['from_del'];

    $sql = "DELETE FROM `playeroffer`
            WHERE `playeroffer_id`='$delete'
            AND `playeroffer_team_id`='$get_num'";
    $mysqli->query($sql);

    $sql = "DELETE FROM `inbox`
            WHERE `inbox_playeroffer_id`='$delete'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Предложение успешно удалено.';

    redirect('team_team_transfer_center.php?num=' . $get_num);
    exit;
}
elseif (isset($_GET['to_del']))
{
    $delete = (int) $_GET['to_del'];

    $sql = "DELETE `playeroffer`
            FROM `playeroffer`
            LEFT JOIN `player`
            ON `playeroffer_player_id`=`player_id`
            WHERE `playeroffer_id`='$delete'
            AND `player_team_id`='$get_num'";
    $mysqli->query($sql);

    $sql = "DELETE FROM `inbox`
            WHERE `inbox_playeroffer_id`='$delete'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Предложение успешно удалено.';

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Предложение успешно удалено.';

    redirect('team_team_transfer_center.php');
    exit;
}
elseif (isset($_GET['to_ok']))
{
    $ok = (int) $_GET['to_ok'];

    $sql = "SELECT COUNT(`playeroffer_id`) AS `count`
            FROM `playeroffer`
            WHERE `playeroffer_id`='$ok'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

    $count = $count_array[0]['count'];

    if (0 == $count)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Такая заявка не найдена.';

        redirect('team_team_transfer_center.php?num=' . $get_num);
        exit;
    }

    $sql = "SELECT COUNT(`transfer_id`) AS `count`
            FROM `transfer`
            WHERE `transfer_player_id`=
            (
                SELECT `playeroffer_player_id`
                FROM `playeroffer`
                WHERE `playeroffer_id`='$ok'
            )";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

    $count = $count_array[0]['count'];

    if (0 != $count)
    {
        $sql = "SELECT `playeroffer_player_id`
                FROM `playeroffer`
                WHERE `playeroffer_id`='$ok'
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $player_id = $player_array[0]['playeroffer_player_id'];

        $sql = "SELECT `playeroffer_id`
                FROM `playeroffer`
                WHERE `playeroffer_player_id`='$player_id'
                ORDER BY `playeroffer_id` ASC";
        $playeroffer_sql = $mysqli->query($sql);

        $count_playeroffer = $playeroffer_sql->num_rows;
        $playeroffer_array = $playeroffer_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_playeroffer; $i++)
        {
            $playeroffer_id = $playeroffer_array[$i]['playeroffer_id'];

            $sql = "DELETE FROM `playeroffer`
                    WHERE `playeroffer_id`='$playeroffer_id'";
            $mysqli->query($sql);

            $sql = "DELETE FROM `inbox`
                    WHERE `inbox_playeroffer_id`='$playeroffer_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Трансфер этого игрока уже согласован.';

        redirect('team_team_transfer_center.php?num=' . $get_num);
        exit;
    }

    $sql = "INSERT INTO `transfer`
            (
                `transfer_buyer_id`,
                `transfer_offertype_id`,
                `transfer_period`,
                `transfer_player_id`,
                `transfer_price`,
                `transfer_season_id`,
                `transfer_seller_id`
            )
            SELECT `playeroffer_team_id`,
                   `playeroffer_offertype_id`,
                   `playeroffer_period`,
                   `playeroffer_player_id`,
                   `playeroffer_price`,
                   '$igosja_season_id',
                   `player_team_id`
            FROM `playeroffer`
            LEFT JOIN `player`
            ON `playeroffer_player_id`=`player_id`
            WHERE `playeroffer_id`='$ok'
            AND `player_team_id`='$get_num'";
    $mysqli->query($sql);

    $sql = "DELETE `playeroffer`
            FROM `playeroffer`
            LEFT JOIN `player`
            ON `playeroffer_player_id`=`player_id`
            WHERE `playeroffer_id`='$ok'
            AND `player_team_id`='$get_num'";
    $mysqli->query($sql);

    $sql = "DELETE FROM `inbox`
            WHERE `inbox_playeroffer_id`='$ok'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Предложение успешно принято.';

    redirect('team_team_transfer_center.php?num=' . $get_num);
    exit;
}

$sql = "SELECT `name_name`,
               `offertype_id`,
               `offertype_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `transfer_buyer_id`,
               `transfer_price`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `offertype`
        ON `transfer_offertype_id`=`offertype_id`
        LEFT JOIN `team`
        ON IF (`transfer_seller_id`='$get_num', `transfer_buyer_id`, `transfer_seller_id`)=`team_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE (`transfer_buyer_id`='$get_num'
        OR `transfer_seller_id`='$get_num')
        AND `standing_season_id`='$igosja_season_id'
        AND `tournament_tournamenttype_id`='2'
        ORDER BY `transfer_date` DESC";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `offertype_id`,
               `offertype_name`,
               `player_id`,
               `playeroffer_id`,
               `playeroffer_price`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `playeroffer`
        LEFT JOIN `player`
        ON `playeroffer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `offertype`
        ON `playeroffer_offertype_id`=`offertype_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE `playeroffer_team_id`='$get_num'
        AND `standing_season_id`='$igosja_season_id'
        AND `tournament_tournamenttype_id`='2'
        ORDER BY `playeroffer_id` ASC";
$offer_from_me_sql = $mysqli->query($sql);

$offer_from_me_array = $offer_from_me_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `offertype_id`,
               `offertype_name`,
               `player_id`,
               `playeroffer_id`,
               `playeroffer_price`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `playeroffer`
        LEFT JOIN `player`
        ON `playeroffer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `offertype`
        ON `playeroffer_offertype_id`=`offertype_id`
        LEFT JOIN `team`
        ON `playeroffer_team_id`=`team_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE `player_team_id`='$get_num'
        AND `standing_season_id`='$igosja_season_id'
        AND `tournament_tournamenttype_id`='2'
        ORDER BY `playeroffer_id` ASC";
$offer_to_me_sql = $mysqli->query($sql);

$offer_to_me_array = $offer_to_me_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');