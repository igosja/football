<?php

include ('include/include.php');

$mrh_pass2  = "RNVK948h0sUWiOcvkSq8";
$shp_item   = 1;
$out_summ   = $_POST["OutSum"];
$inv_id     = $_POST["InvId"];
$crc        = $_POST["SignatureValue"];
$crc        = strtoupper($crc);
$my_crc     = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item"));

if (strtoupper($my_crc) != strtoupper($crc))
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
    exit;
}

$sql = "SELECT `robokassa_status`,
               `robokassa_sum`,
               `robokassa_user_id`
        FROM `robokassa`
        WHERE `robokassa_id`='$inv_id'
        LIMIT 1";
$robokassa_sql = $mysqli->query($sql);

$count_robokassa = $robokassa_sql->num_rows;

if (0 == $count_robokassa)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
    exit;
}

$robokassa_array = $robokassa_sql->fetch_all(MYSQLI_ASSOC);

$status     = $robokassa_array[0]['robokassa_status'];

if (1 == $status)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Счет пополнить не удалось';

    redirect('shop.php');
    exit;
}

$user_id    = $robokassa_array[0]['robokassa_user_id'];
$sum        = $robokassa_array[0]['robokassa_sum'];

$sql = "UPDATE `robokassa`
        SET `robokassa_status`='1'
        WHERE `robokassa_id`='$inv_id'";
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