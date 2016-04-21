<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_id`>='252'
        ORDER BY `shedule_id` ASC";
$shedule_sql = $mysqli->query($sql);

$count_shedule = $shedule_sql->num_rows;
$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_shedule; $i++)
{
    $shedule_id     = $shedule_array[$i]['shedule_id'];
    $shedule_date   = date('Y-m-d', time()+24*60*60*$i);

    $sql = "UPDATE `shedule`
            SET `shedule_date`='$shedule_date'
            WHERE `shedule_id`='$shedule_id'
            LIMIT 1";
    $mysqli->query($sql);
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';