<?php

$start_time = microtime(true);

set_time_limit(0);

$array = array(0, 11, 11, 2, 3, 54, 54, 4, 5, 6, 7);
$array = array_count_values($array);

print '<pre>';
print_r($array);
print '</pre>';

print round(microtime(true) - $start_time, 5);