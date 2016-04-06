<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "UPDATE `country`
        SET `country_user_id`='0'
        WHERE `country_user_id`!='0'";
$mysqli->query($sql);

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';