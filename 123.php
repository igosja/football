<?php

include (__DIR__ . '/include/include.php');

$NewY = array(49100, 21, 600, 12.5);
$NewM = array(53200, 21, 640, 13.5);
$NewC = array(50100, 21, 640, 16.1);
$NevF = array(57100, 54.5, 740, 14.9);

$array = array('NewY' => $NewY, 'NewM' => $NewM, 'NewC' => $NewC, 'NevF' => $NevF);

usort($array, 'f_array_sort');

function f_array_sort($a, $b)
{
    return strcmp($a[3], $b[3]);
}

print '<pre>';
print_r($array);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';