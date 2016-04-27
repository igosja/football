<?php

include (__DIR__ . '/include/include.php');

if (!isset($_POST['xml']) ||
    !isset($_POST['sign']))
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$secret_key = 'hRCuJWDxBpG5eNj';
$hidden_key = '9cCCtEqwPcgzZKf';
$api_key    = '2rC7Xb3lbg2OAwr';
$xml        = $_POST['data'];
$sign       = $_POST['signature'];
$xml        = str_replace(' ', '+', $xml);
$sign       = str_replace(' ', '+', $sign);
$xml        = base64_decode($xml);
$sign_check = base64_encode(md5($hidden_key . $xml . $hidden_key));

if ($sign_check != $sign)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$xml = simplexml_load_string($xml);

$status = $xml->status;

if ('success' != $status)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$payment_id = $xml->order_id;

$sql = "SELECT `payment_status`,
               `payment_sum`,
               `payment_user_id`
        FROM `payment`
        WHERE `payment_id`='$payment_id'
        LIMIT 1";
$payment_sql = $mysqli->query($sql);

$count_payment = $payment_sql->num_rows;

if (0 == $count_payment)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$payment_array = $payment_sql->fetch_all(MYSQLI_ASSOC);

$status = $payment_array[0]['payment_status'];

if (1 == $status)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$user_id    = $payment_array[0]['payment_user_id'];
$sum        = $payment_array[0]['payment_sum'];

$sql = "UPDATE `payment`
        SET `payment_status`='1'
        WHERE `payment_id`='$payment_id'";
$mysqli->query($sql);

$sql = "UPDATE `user`
        SET `user_money`=`user_money`+'$sum'
        WHERE `user_id`='$user_id'";
$mysqli->query($sql);

$sql = "INSERT INTO `historyfinanceuser`
        SET `historyfinanceuser_date`=SYSDATE(),
            `historyfinanceuser_sum`='$sum',
            `historyfinanceuser_user_id`='$user_id'";
$mysqli->query($sql);

$_SESSION['message_class']  = 'success';
$_SESSION['message_text']   = 'Счет успешно пополнен';

redirect('shop.php');