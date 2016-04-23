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

    if (30 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'30',
                    `user_money_training`=`user_money_training`+'1'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=SYSDATE(),
                    `historyfinanceuser_sum`='-30',
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

    if (200 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'200',
                    `user_money_position`=`user_money_position`+'1'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=SYSDATE(),
                    `historyfinanceuser_sum`='-200',
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

    if (500 > $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'На вашем счету недостаточно денег для покупки этого товара';

        redirect('shop.php');
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `user`
                SET `user_money`=`user_money`-'500'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceuser`
                SET `historyfinanceuser_date`=SYSDATE(),
                    `historyfinanceuser_sum`='-500',
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
                SET `historyfinanceteam_date`=CURDATE(),
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

    $sql = "INSERT INTO `interkassa`
            SET `interkassa_date`=SYSDATE(),
                `interkassa_sum`='$sum',
                `interkassa_user_id`='$num_get'";
    $mysqli->query($sql);

    $secret_key = 'KFDEdXkx598iVRCe';
    $ik_pm_no   = $mysqli->insert_id;
    $ik_co_id   = '571b23043d1eaf784c8b456b';
    $ik_desc    = 'Пополнение счета на сайте Виртуальной футбольной лиги';
    $ik_am      = $sum;
    $ik_cur     = "RUB";

    $params = array(
        'ik_co_id'  => $ik_co_id,
        'ik_pm_no'  => $ik_pm_no,
        'ik_am'     => $ik_am,
        'ik_cur'    => $ik_cur,
        'ik_desc'   => $ik_desc,
    );

    ksort($params, SORT_STRING);
    array_push($params, $secret_key);
    $str_sign   = implode(':', $params);
    $ik_sign    = base64_encode(md5($str_sign, true));

    $params['ik_sign'] = $ik_sign;

    $url = 'https://sci.interkassa.com/?' . http_build_query($params);

    redirect($url);
}

$sql = "SELECT `user_money`
        FROM `user`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = 'Магазин';

include (__DIR__ . '/view/main.php');