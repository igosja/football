<?php

include (__DIR__ . '/include/include.php');

$array = array(1, 'asdf' => 'qwer', 'zxcv' => array('klnk' => 'nhgn', 'klnkqwer' => 1234));
$array = serialize($array);
print '<pre>';
print_r($array);
$array = unserialize($array);
print '<pre>';
print_r($array);
exit;

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';