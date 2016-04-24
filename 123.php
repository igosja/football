<?php

include (__DIR__ . '/include/include.php');

$email   = 'igosja@ukr.net';
$subject = 'Запуск сайта ' . $_SERVER['HTTP_HOST'];
$message = 'Здравствуйте, Игося.<br/><br/>Рады сообщить вам, что сайт <a href="http://' . $_SERVER['HTTP_HOST'] . '">' . $_SERVER['HTTP_HOST'] . '</a> начинает свою работу, вы можете войти на сайт используя свой логин и пароль и взять под свое управление поднравившуюся команду.<br/><br/>С уважением,<br/>администрация <a href="http://' . $_SERVER['HTTP_HOST'] . '">' . $_SERVER['HTTP_HOST'] . '</a>';
$header  = "From: <noreply@" . $_SERVER['HTTP_HOST'] . ">\r\n";
$header .= "Content-type:text/html; charset=utf-8\r\n";

mail($email, $subject, $message, $header);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';