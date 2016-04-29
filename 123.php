<?php

include (__DIR__ . '/include/include.php');

$json = '{"kniga":"Bulj bulj Karasik","avtor":"Y.Pisun","0":{"otzyv1":"horoho","otzyv2":"ploho"},"1":"idei","2":"zadumki"}';
$json = json_decode($json, true);

print $json[0]['otzyv1'];

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';