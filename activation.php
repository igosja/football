<?php

include('include/include.php');

if (isset($_GET['id']))
{
    $id     = (int) $_GET['id'];
    $code   = $_GET['code'];
    $check  = f_igosja_chiper_password($id);

    if ($code == $check)
    {
        $sql = "UPDATE `user`
                SET `user_activation`='1'
                WHERE `user_id`='$id'
                LIMIT 1";
        $mysqli->query($sql);

        $success_message = 'Профиль активирован успешно.';

        $smarty->assign('success_message', $success_message);
    }
    else
    {
        $sql = "DELETE FROM `user`
                WHERE `user_id`='$id'";
        $mysqli->query($sql);

        $error_message = 'Активировать профиль не удалось.<br/>
                          Зарегистрируйтесь повторно.';

        $smarty->assign('error_message', $error_message);
    }
}

$sql = "DELETE FROM `user`
        WHERE UNIX_TIMESTAMP(SYSDATE())-UNIX_TIMESTAMP(`user_registration_date`)>'3600'
        AND `user_activation`='0'";
$mysqli->query($sql);

$smarty->assign('header_title', 'Активация профиля');

$smarty->display('main.html');