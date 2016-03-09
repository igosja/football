<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_logged.php');
    exit;
}

if (isset($_GET['success']))
{
    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Счет успешно пополнен';

    redirect('shop.php');
    exit;
}
elseif (isset($_GET['error']))
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
    exit;
}
elseif (isset($_GET['point']))
{
    $sql = "SELECT `user_money`
            FROM `user`
            WHERE `user_id`='$get_num'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money'];

    if (1 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
        exit;
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'1',
                    `user_money_training`=`user_money_training`+'1'
                WHERE `user_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=SYSDATE(),
                    `historyfinanceuser_sum`='-1',
                    `historyfinanceuser_user_id`='$get_num'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Балл для тренировки приобретен успешно';

        redirect('shop.php');
        exit;
    }

    $tpl            = 'submit_shop_point';
    $header_title   = 'Магазин';

    include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');
    exit;
}
elseif (isset($_GET['position']))
{
    $sql = "SELECT `user_money`
            FROM `user`
            WHERE `user_id`='$get_num'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money'];

    if (5 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
        exit;
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'5',
                    `user_money_position`=`user_money_position`+'1'
                WHERE `user_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=SYSDATE(),
                    `historyfinanceuser_sum`='-5',
                    `historyfinanceuser_user_id`='$get_num'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Позиция для тренировки приобретена успешно';

        redirect('shop.php');
        exit;
    }

    $tpl            = 'submit_shop_position';
    $header_title   = 'Магазин';

    include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');
    exit;
}
elseif (isset($_GET['money']))
{
    if (!isset($authorization_team_id))
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'В вашем распоряжении не найдено ни одной команды.';

        redirect('shop.php');
        exit;
    }

    $sql = "SELECT `user_money`
            FROM `user`
            WHERE `user_id`='$get_num'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money'];

    if (10 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
        exit;
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'10'
                WHERE `user_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=SYSDATE(),
                    `historyfinanceuser_sum`='-10',
                    `historyfinanceuser_user_id`='$get_num'";
        $mysqli->query($sql);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+'1000000'
                WHERE `team_id`='$authorization_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "SELECT COUNT(`finance_team_id`) AS `count`
                FROM `finance`
                WHERE `finance_season_id`='$igosja_season_id'
                AND `finance_team_id`='$authorization_team_id'
                LIMIT 1";
        $finance_sql = $mysqli->query($sql);

        $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);
        $count_finance = $finance_array[0]['count'];

        if (0 == $count_finance)
        {
            $sql = "INSERT INTO `finance`
                    SET `finance_team_id`='$authorization_team_id',
                        `finance_season_id`='$igosja_season_id'";
            $mysqli->query($sql);
        }

        $sql = "UPDATE `finance`
                SET `finance_income_donat`=`finance_income_donat`+'1000000'
                WHERE `finance_team_id`='$authorization_team_id'
                AND `finance_season_id`='$igosja_season_id'
                LIMIT 1";
        $mysqli->query($sql);
        
        $sql = "INSERT INTO `historyfinanceteam`
                SET `historyfinanceteam_date`=CURDATE(),
                    `historyfinanceteam_historytext_id`='" . HISTORY_TEXT_INCOME_INVESTOR . "',
                    `historyfinanceteam_season_id`='$igosja_season_id',
                    `historyfinanceteam_team_id`='$authorization_team_id',
                    `historyfinanceteam_value`='1000000'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = '1 миллион $ успешно переведен на счет вашей команды';

        redirect('shop.php');
        exit;
    }

    $tpl            = 'submit_shop_money';
    $header_title   = 'Магазин';

    include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');
    exit;
}
elseif (isset($_POST['data']))
{
    $sum = (int) $_POST['data']['sum'];

    if (0 == $sum)
    {
        $sum = 1;
    }

    $sql = "INSERT INTO `robokassa`
            SET `robokassa_date`=SYSDATE(),
                `robokassa_sum`='$sum',
                `robokassa_user_id`='$get_num'";
    $mysqli->query($sql);

    $IsTest         = 1;
    $inv_id         = $mysqli->insert_id;
    $mrh_login      = 'virtual-football-league';
    $mrh_pass1      = 'v4Sz7y0D0JOe0JjDjWQU';
    $inv_desc       = 'Пополнение счета на сайте Виртуальной футбольной лиги';
    $out_summ       = $sum;
    $out_currency   = "USD";
    $culture        = "ru";
    $encoding       = "utf-8";
    $shp_item       = 1;

    $crc    = md5("$mrh_login:$out_summ:$inv_id:$out_currency:$mrh_pass1:Shp_item=$shp_item");
    $params = array(
        'IsTest'            => $IsTest,
        'InvId'             => $inv_id,
        'MrchLogin'         => $mrh_login,
        'OutSum'            => $out_summ,
        'Desc'              => $inv_desc,
        'Shp_item'          => $shp_item,
        'Culture'           => $culture,
        'OutSumCurrency'    => $out_currency,
        'SignatureValue'    => $crc
    );

    $url = 'https://auth.robokassa.ru/Merchant/Index.aspx?' . http_build_query($params);;

    redirect($url);
    exit;
}

$sql = "SELECT `user_money`
        FROM `user`
        WHERE `user_id`='$get_num'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = 'Магазин';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');