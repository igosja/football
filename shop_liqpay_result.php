<?php

include (__DIR__ . '/include/include.php');

if (!isset($_POST['data']) ||
    !isset($_POST['signature']))
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$private_key    = 'xjaJgqw2L2zCMT1Bs7lVcM7xRXzAwayVO1h1nZbz';
$public_key     = 'i33620494410';
$data           = $_POST['data'];
$signature      = $_POST['signature'];
$sign_check     = base64_encode(sha1($private_key . $data . $private_key, 1));

if ($sign_check != $signature)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$json = base64_decode($data);
$json = json_decode($json, true);

$public_check = $json['public_key'];

if ($public_key != $public_check)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$status = $json['status'];

if ('sandbox' != $status)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$payment_id = $json['order_id'];

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