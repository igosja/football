<?php

function f_igosja_mysqli_query($sql)
//Логируем запросы (На деве нужно расскомментировать все строки)
{
    global $count_sql;
    global $mysqli;

//    $start_time = microtime(true);
    $result_sql = $mysqli->query($sql);
//    $query_time = round((microtime(true) - $start_time) * 1000, 2);
    $count_sql++;
//    $text = addslashes($sql);

//    $sql = "INSERT INTO `debug`
//            SET `debug_sql`='$text',
//                `debug_time`='$query_time'";
//    $mysqli->query($sql);

    return $result_sql;
}