<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `user_email`,
               `user_login`
        FROM `user`
        WHERE `user_id`>'0'";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

foreach ($user_array as $user)
{
    $email      = $user['user_email'];
    $login      = $user['user_login'];
    $subject    = 'Запуск сайта ' . $_SERVER['HTTP_HOST'];
    $message    = 'Здравствуйте, ' . $login . '.<br/><br/>Рады сообщить вам, что сайт <a href="http://' . $_SERVER['HTTP_HOST'] . '">' . $_SERVER['HTTP_HOST'] . '</a> начинает свою работу, вы можете войти на сайт используя свой логин и пароль и взять под свое управление понравившуюся команду.<br/><br/>С уважением,<br/>администрация <a href="http://' . $_SERVER['HTTP_HOST'] . '">' . $_SERVER['HTTP_HOST'] . '</a>';
    $header     = "From: <admin@" . $_SERVER['HTTP_HOST'] . ">\r\n";
    $header     = $header . "Content-type:text/html; charset=utf-8\r\n";

    print $message;
    //mail($email, $subject, $message, $header);
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';