<?php

include (__DIR__ . '/include/include.php');

$teamwork = 0;

for ($i=0; $i<55; $i++)
{
    if     ($i < 10) { $first = 1; }
    elseif ($i < 19) { $first = 2; }
    elseif ($i < 27) { $first = 3; }
    elseif ($i < 34) { $first = 4; }
    elseif ($i < 40) { $first = 5; }
    elseif ($i < 45) { $first = 6; }
    elseif ($i < 49) { $first = 7; }
    elseif ($i < 52) { $first = 8; }
    elseif ($i < 54) { $first = 9; }
    elseif ($i < 55) { $first = 10; }

    if     (in_array($i, array(0)))                                     { $second = 2; }
    elseif (in_array($i, array(1, 10)))                                 { $second = 3; }
    elseif (in_array($i, array(2, 11, 19)))                             { $second = 4; }
    elseif (in_array($i, array(3, 12, 20, 27)))                         { $second = 5; }
    elseif (in_array($i, array(4, 13, 21, 28, 34)))                     { $second = 6; }
    elseif (in_array($i, array(5, 14, 22, 29, 35, 40)))                 { $second = 7; }
    elseif (in_array($i, array(6, 15, 23, 30, 36, 41, 45)))             { $second = 8; }
    elseif (in_array($i, array(7, 16, 24, 31, 37, 42, 46, 49)))         { $second = 9; }
    elseif (in_array($i, array(8, 17, 25, 32, 38, 43, 47, 50, 52)))     { $second = 10; }
    elseif (in_array($i, array(9, 18, 26, 33, 39, 44, 48, 51, 53, 54))) { $second = 11; }

    $sql = "SELECT `teamwork_id`,
                   `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_first_id`='$first'
            AND `teamwork_second_id`='$second')
            OR (`teamwork_first_id`='$second'
            AND `teamwork_second_id`='$first')
            LIMIT 1";
    $teamwork_sql = $mysqli->query($sql);

    $count_teamwork = $teamwork_sql->num_rows;

    if (0 != $count_teamwork)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_id    = $teamwork_array[0]['teamwork_id'];
        $teamwork_value = $teamwork_array[0]['teamwork_value'];

        $teamwork = $teamwork + $teamwork_value;

        $sql = "UPDATE `teamwork`
                SET `teamwork_value`=`teamwork_value`+'3'
                WHERE `teamwork_id`='$teamwork_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
    else
    {
        $sql = "INSERT INTO `teamwork`
                SET `teamwork_first_id`='$first',
                    `teamwork_second_id`='$second',
                    `teamwork_value`='3'";
        $mysqli->query($sql);
    }
}

$sql = "UPDATE `teamwork`
        SET `teamwork_value`=`teamwork_value`-'1'";
$mysqli->query($sql);

$sql = "UPDATE `teamwork`
        SET `teamwork_value`='100'
        WHERE `teamwork_value`>'100'";
$mysqli->query($sql);

$sql = "UPDATE `teamwork`
        SET `teamwork_value`='0'
        WHERE `teamwork_value`<'0'";
$mysqli->query($sql);

$teamwork = $teamwork / 55;

print '<br/>' . $teamwork;

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';