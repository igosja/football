<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $num_get = $authorization_id;
}
else
{
    include (__DIR__ . '/view/only_logged.php');
    exit;
}

if (isset($_GET['success']))
{
    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Счет успешно пополнен';

    redirect('shop.php');
}
elseif (isset($_GET['error']))
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}
elseif (isset($_GET['point']))
{
    $sql = "SELECT `user_money`
            FROM `user`
            WHERE `user_id`='$num_get'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money'];

    if (1 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'1',
                    `user_money_training`=`user_money_training`+'1'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=UNIX_TIMESTAMP(),
                    `historyfinanceuser_sum`='-1',
                    `historyfinanceuser_user_id`='$num_get'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Балл для тренировки приобретен успешно';

        redirect('shop.php');
    }

    $tpl            = 'submit_shop_point';
    $header_title   = 'Магазин';

    include (__DIR__ . '/view/main.php');
    exit;
}
elseif (isset($_GET['position']))
{
    $sql = "SELECT `user_money`
            FROM `user`
            WHERE `user_id`='$num_get'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money'];

    if (5 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'5',
                    `user_money_position`=`user_money_position`+'1'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=UNIX_TIMESTAMP(),
                    `historyfinanceuser_sum`='-5',
                    `historyfinanceuser_user_id`='$num_get'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Позиция для тренировки приобретена успешно';

        redirect('shop.php');
    }

    $tpl            = 'submit_shop_position';
    $header_title   = 'Магазин';

    include (__DIR__ . '/view/main.php');
    exit;
}
elseif (isset($_GET['money']))
{
    if (!isset($authorization_team_id))
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'В вашем распоряжении не найдено ни одной команды.';

        redirect('shop.php');
    }

    $sql = "SELECT `user_money`
            FROM `user`
            WHERE `user_id`='$num_get'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money'];

    if (10 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'10'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=UNIX_TIMESTAMP(),
                    `historyfinanceuser_sum`='-10',
                    `historyfinanceuser_user_id`='$num_get'";
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
                SET `historyfinanceteam_date`=UNIX_TIMESTAMP(),
                    `historyfinanceteam_historytext_id`='" . HISTORY_TEXT_INCOME_INVESTOR . "',
                    `historyfinanceteam_season_id`='$igosja_season_id',
                    `historyfinanceteam_team_id`='$authorization_team_id',
                    `historyfinanceteam_value`='1000000'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = '1 миллион $ успешно переведен на счет вашей команды';

        redirect('shop.php');
    }

    $tpl            = 'submit_shop_money';
    $header_title   = 'Магазин';

    include (__DIR__ . '/view/main.php');
    exit;
}
elseif (isset($_POST['data']))
{
    $sum = (int) $_POST['data']['sum'];

    if (0 == $sum)
    {
        $sum = 1;
    }

    $sql = "INSERT INTO `payment`
            SET `payment_date`=UNIX_TIMESTAMP(),
                `payment_sum`='$sum',
                `payment_user_id`='$num_get'";
    $mysqli->query($sql);

    $secret_key     = 'hRCuJWDxBpG5eNj';
    $hidden_key     = '9cCCtEqwPcgzZKf';
    $api_key        = '2rC7Xb3lbg2OAwr';

    $merchant_id    = 57065;
    $order_id       = $mysqli->insert_id;
    $amount         = $sum;
    $currency       = 'USD';
    $desc           = 'Пополнение счета на сайте Виртуальной футбольной лиги';
    $test_mode      = 0;

    $xml =  '<?xml version="1.0" encoding="UTF-8"?>
             <request>
                 <version>1.3</version>
                 <merchant_id>' . $merchant_id . '</merchant_id>
                 <language>ru</language>
                 <order_id>' . $order_id . '</order_id>
                 <amount>' . $amount . '</amount>
                 <currency>' . $currency . '</currency>
                 <description>' . $desc . '</description>
                 <test_mode>' . $test_mode . '</test_mode>
             </request>';

    $sign   = base64_encode(md5($secret_key . $xml . $secret_key));
    $xml    = base64_encode($xml);

    $params = array
    (
        'xml'   => $xml,
        'sign'  => $sign,
    );

    $url = 'https://merchant.pay2pay.com/?page=init&' . http_build_query($params);

    redirect($url);
}

$sql = "SELECT `user_money`
        FROM `user`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$num                = $authorization_id;
$header_title       = 'Магазин';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');