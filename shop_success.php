<?php

include (__DIR__ . '/include/include.php');

$_SESSION['message_class']  = 'success';
$_SESSION['message_text']   = 'Счет успешно пополнен';

redirect('shop.php');