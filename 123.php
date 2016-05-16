<?php

include (__DIR__ . '/include/include.php');

$a = 'I1AR';
$b = 'I1AR';

print $a == $b;

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';