<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `team_id`,
               `team_name`
        FROM `transfer`
        LEFT JOIN `team`
        ON `transfer_buyer_id`=`team_id`
        WHERE `transfer_player_id`='$num_get'
        LIMIT 1";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_statustransfer_id`,
               `player_transfer_price`,
               `statusrent_name`,
               `statusteam_name`,
               `statustransfer_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `statusrent`
        ON `statusrent_id`=`player_statusrent_id`
        LEFT JOIN `statusteam`
        ON `statusteam_id`=`player_statusteam_id`
        LEFT JOIN `statustransfer`
        ON `statustransfer_id`=`player_statustransfer_id`
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['data']))
{
    $offer_price    = (int) $_POST['data']['offer_price'];
    $offer_type     = (int) $_POST['data']['offer_type'];

    $sql = "SELECT `team_finance`
            FROM `team`
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $finance_sql = $mysqli->query($sql);

    $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

    $team_finance = $finance_array[0]['team_finance'];

    if ($offer_price > $team_finance)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'У вашего клуба недостаточно денег для проведения этой сделки.';

        redirect('player_transfer_offer.php?num=' . $num_get);
    }

    $team_id = $player_array[0]['team_id'];

    if ($team_id == $authorization_team_id)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Нельзя купить своего игрока.';

        redirect('player_transfer_offer.php?num=' . $num_get);
    }

    $statustransfer_id = $player_array[0]['player_statustransfer_id'];

    if (3 == $statustransfer_id)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Этот игрок не продается.';

        redirect('player_transfer_offer.php?num=' . $num_get);
    }

    $sql = "SELECT `playeroffer_id`
            FROM `playeroffer`
            WHERE `playeroffer_player_id`='$num_get'
            AND `playeroffer_team_id`='$authorization_team_id'
            AND `playeroffer_offertype_id`='$offer_type'
            LIMIT 1";
    $check_sql = $mysqli->query($sql);

    $count_check = $check_sql->num_rows;

    if (0 == $count_check)
    {
        $sql = "INSERT INTO `playeroffer`
                SET `playeroffer_player_id`='$num_get',
                    `playeroffer_offertype_id`='$offer_type',
                    `playeroffer_price`='$offer_price',
                    `playeroffer_team_id`='$authorization_team_id',
                    `playeroffer_date`=SYSDATE()";
        $mysqli->query($sql);

        $playeroffer_id = $mysqli->insert_id;

        $sql = "SELECT `name_name`,
                       `surname_name`,
                       `team_user_id`
                FROM `player`
                LEFT JOIN `name`
                ON `name_id`=`player_name_id`
                LEFT JOIN `surname`
                ON `surname_id`=`player_surname_id`
                LEFT JOIN `team`
                ON `team_id`=`player_team_id`
                WHERE `player_id`='$num_get'
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        $name           = $player_array[0]['name_name'];
        $surname        = $player_array[0]['surname_name'];
        $player_name    = $name . ' ' . $surname;
        $user_id        = $player_array[0]['team_user_id'];

        $sql = "SELECT `inboxtheme_name`,
                       `inboxtheme_text`
                FROM `inboxtheme`
                WHERE `inboxtheme_id`='" . INBOXTHEME_TRANSFER . "'
                LIMIT 1";
        $inboxtheme_sql = $mysqli->query($sql);

        $inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

        $inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
        $inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];
        $inboxtheme_text = sprintf($inboxtheme_text, $authorization_team_name, $player_name);

        $sql = "INSERT INTO `inbox`
                SET `inbox_date`=CURDATE(),
                    `inbox_inboxtheme_id`='" . INBOXTHEME_TRANSFER . "',
                    `inbox_playeroffer_id`='$playeroffer_id',
                    `inbox_title`='$inboxtheme_name',
                    `inbox_text`='$inboxtheme_text',
                    `inbox_user_id`='$user_id'";
        $mysqli->query($sql);
    }
    else
    {
        $sql = "UPDATE `playeroffer`
                SET `playeroffer_offertype_id`='$offer_type',
                    `playeroffer_price`='$offer_price',
                    `playeroffer_date`=SYSDATE()
                WHERE `playeroffer_player_id`='$num_get'
                AND `playeroffer_team_id`='$authorization_team_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Ваше предложение успешно сохранено.';

    redirect('player_transfer_offer.php?num=' . $num_get);
}

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `offertype_id`,
               `offertype_name`
        FROM `offertype`
        WHERE `offertype_status`='1'
        ORDER BY `offertype_id` ASC";
$offertype_sql = $mysqli->query($sql);

$offertype_array = $offertype_sql->fetch_all(MYSQLI_ASSOC);


$num            = $num_get;
$header_title   = $player_name . ' ' . $player_surname;

include (__DIR__ . '/view/main.php');