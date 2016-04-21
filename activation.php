<?php

include (__DIR__ . 'include/include.php');

$sql = "DELETE FROM `user`
        WHERE UNIX_TIMESTAMP(SYSDATE())-UNIX_TIMESTAMP(`user_registration_date`)>'86400'
        AND `user_activation`='0'";
$mysqli->query($sql);

if (!isset($_GET['id']) ||
    !isset($_GET['code']))
{
    redirect('index.php');
}

$id     = (int) $_GET['id'];
$code   = $_GET['code'];
$check  = f_igosja_chiper_password($id);

if ($code != $check)
{
    $sql = "DELETE FROM `user`
            WHERE `user_id`='$id'
            AND `user_activation`='0'";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Активировать профиль не удалось.<br />Зарегистрируйтесь повторно.';

    redirect('index.php');
}

$sql = "UPDATE `user`
        SET `user_activation`='1'
        WHERE `user_id`='$id'
        LIMIT 1";
$mysqli->query($sql);

$_SESSION['message_class']  = 'success';
$_SESSION['message_text']   = 'Профиль активирован успешно.';

redirect('index.php');