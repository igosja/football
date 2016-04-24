<?php

include (__DIR__ . '/include/include.php');

$email   = 'igosja@ukr.net';
$subject = 'Запуск сайта ' . $_SERVER['HTTP_HOST'];
$message = 'Здравствуйте, Игося.<br/>Рады сообщить вам, что сайт ' . $_SERVER['HTTP_HOST'] . ' начинает свою работу, вы можете войти на сайт используя свой логин и пароль и взять под свое управление поднравившуюся команду.<br/>С уважением, администрация ' . $_SERVER['HTTP_HOST'];
$header  = 'From: <admin@' . $_SERVER['HTTP_HOST'] . '>\r\n';
$header .= 'Content-type:text/html; charset=utf-8\r\n';

mail($email, $subject, $message, $header);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';