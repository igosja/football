<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/only_logged.html');
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

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');