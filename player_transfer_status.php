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

$sql = "SELECT `name_name`,
               `player_position_id`,
               `player_price`,
               `player_salary`,
               `player_statusrent_id`,
               `player_statusteam_id`,
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
        LEFT JOIN `statustransfer`
        ON `statustransfer_id`=`player_statustransfer_id`
        LEFT JOIN `statusrent`
        ON `statusrent_id`=`player_statusrent_id`
        LEFT JOIN `statusteam`
        ON `statusteam_id`=`player_statusteam_id`
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(1);

$team_id = $player_array[0]['team_id'];

if (isset($_POST['data']) &&
    $team_id == $authorization_team_id)
{
    $statusteam_id      = (int) $_POST['data']['statusteam'];
    $statusrent_id      = (int) $_POST['data']['statusrent'];
    $statustransfer_id  = (int) $_POST['data']['statustransfer'];
    $transfer_price     = (int) $_POST['data']['transfer_price'];

    if (2 == $statustransfer_id)
    {
        $sql = "SELECT COUNT(`player_id`) AS `count_player`
                FROM `player`
                WHERE `player_team_id`='$team_id'
                AND `player_statustransfer_id`='2'
                AND `player_id`!='$num_get'";
        $count_sql = $mysqli->query($sql);

        $count_array = $count_sql->fetch_all(1);

        $count = $count_array[0]['count_player'];

        if (5 <= $count)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = '???????????? ?????????????????? ???? ???????????????? ?????????? 5 ??????????????.';

            redirect('player_transfer_status.php?num=' . $num_get);
        }

        $position_id = $player_array[0]['player_position_id'];

        if (1 == $position_id)
        {
            $sql = "SELECT COUNT(`player_id`) AS `count_player`
                    FROM `player`
                    WHERE `player_team_id`='$team_id'
                    AND `player_statustransfer_id`!='2'
                    AND `player_position_id`='1'
                    AND `player_id`!='$num_get'";
            $count_sql = $mysqli->query($sql);

            $count_array = $count_sql->fetch_all(1);

            $count = $count_array[0]['count_player'];

            if (2 > $count)
            {
                $_SESSION['message_class']  = 'error';
                $_SESSION['message_text']   = '?? ?????????????? ???????????? ???????????????? ???? ?????????? 2 ????????????????.';

                redirect('player_transfer_status.php?num=' . $num_get);
            }
        }
        else
        {
            $sql = "SELECT COUNT(`player_id`) AS `count_player`
                    FROM `player`
                    WHERE `player_team_id`='$team_id'
                    AND `player_statustransfer_id`!='2'
                    AND `player_position_id`!='1'
                    AND `player_id`!='$num_get'";
            $count_sql = $mysqli->query($sql);

            $count_array = $count_sql->fetch_all(1);

            $count = $count_array[0]['count_player'];

            if (16 > $count)
            {
                $_SESSION['message_class']  = 'error';
                $_SESSION['message_text']   = '?? ?????????????? ???????????? ???????????????? ???? ?????????? 16 ?????????????? ??????????????.';

                redirect('player_transfer_status.php?num=' . $num_get);
            }
        }
    }

    $sql = "UPDATE `player`
            SET `player_statustransfer_id`='$statustransfer_id',
                `player_statusrent_id`='$statusrent_id',
                `player_statusteam_id`='$statusteam_id',
                `player_transfer_price`='$transfer_price'
            WHERE `player_id`='$num_get'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = '?????????????????? ?????????????? ??????????????????.';

    redirect('player_transfer_status.php?num=' . $num_get);
}

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `team_id`,
               `team_name`,
               `playeroffer_date`,
               `playeroffer_price`
        FROM `playeroffer`
        LEFT JOIN `team`
        ON `team_id`=`playeroffer_team_id`
        WHERE `playeroffer_player_id`='$num_get'
        AND `playeroffer_offertype_id`='1'
        ORDER BY `playeroffer_date` DESC
        LIMIT 5";
$playeroffer_sql = $mysqli->query($sql);

$playeroffer_array = $playeroffer_sql->fetch_all(1);

$sql = "SELECT `statusteam_id`,
               `statusteam_name`
        FROM `statusteam`
        ORDER BY `statusteam_id` ASC";
$statusteam_sql = $mysqli->query($sql);

$statusteam_array = $statusteam_sql->fetch_all(1);

$sql = "SELECT `statustransfer_id`,
               `statustransfer_name`
        FROM `statustransfer`
        ORDER BY `statustransfer_id` ASC";
$statustransfer_sql = $mysqli->query($sql);

$statustransfer_array = $statustransfer_sql->fetch_all(1);

$sql = "SELECT `statusrent_id`,
               `statusrent_name`
        FROM `statusrent`
        WHERE `statusrent_status`='1'
        ORDER BY `statusrent_id` ASC";
$statusrent_sql = $mysqli->query($sql);

$statusrent_array = $statusrent_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $player_name . ' ' . $player_surname;
$seo_title          = $header_title . '. ?????????????????????? ????????????. ' . $seo_title;
$seo_description    = $header_title . '. ?????????????????????? ????????????. ' . $seo_description;
$seo_keywords       = $header_title . ', ?????????????????????? ????????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');