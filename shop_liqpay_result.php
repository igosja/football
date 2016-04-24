<?php

include (__DIR__ . '/include/include.php');

$fp = fopen('liqpay.txt', 'w');

foreach ($_POST as $key => $value)
{
    fwrite($fp, $key . '-' . $value . '/r/n');
}

fclose($fp);

exit;
if (!isset($_POST['data']) ||
    !isset($_POST['signature']) ||
    !isset($_POST['ik_inv_st']) ||
    !isset($_POST['ik_inv_id']) ||
    $interkassa_id != $_POST['ik_co_id'])
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$form_id        = $_POST['ik_co_id'];
$payment_id     = $_POST['ik_pm_no'];
$form_status    = $_POST['ik_inv_st'];

$sql = "SELECT `interkassa_status`,
               `interkassa_sum`,
               `interkassa_user_id`
        FROM `interkassa`
        WHERE `interkassa_id`='$payment_id'
        LIMIT 1";
$interkassa_sql = $mysqli->query($sql);

$count_interkassa = $interkassa_sql->num_rows;

if (0 == $count_interkassa)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$interkassa_array = $interkassa_sql->fetch_all(MYSQLI_ASSOC);

$status = $interkassa_array[0]['interkassa_status'];

if (1 == $status || 'success' != $form_status)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
}

$user_id    = $interkassa_array[0]['interkassa_user_id'];
$sum        = $interkassa_array[0]['interkassa_sum'];

$sql = "UPDATE `interkassa`
        SET `interkassa_status`='1'
        WHERE `interkassa_id`='$payment_id'";
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