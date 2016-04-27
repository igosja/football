<?php

include (__DIR__ . '/include/include.php');

$_SESSION['message_class']  = 'error';
$_SESSION['message_text']   = 'Счет пополнить не удалось';

redirect('shop.php');