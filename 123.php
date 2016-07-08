<?php

include (__DIR__ . '/include/include.php');

$country_1 = 132;
$country_2 = 6;
$country_3 = 133;
$country_4 = 119;
$country_5 = 65;
$country_6 = 168;
$country_7 = 107;
$country_8 = 64;
$country_9 = 10;
$country_10 = 171;
$country_11 = 25;
$country_12 = 43;
$country_13 = 79;
$country_14 = 177;

$game = "'$country_1',  '$country_2',  '1',  '1',  '1',  '1'<br>
        '$country_13', '$country_3',  '2',  '13', '1',  '1'<br>
        '$country_12', '$country_4',  '3',  '12', '1',  '1'<br>
        '$country_11', '$country_5',  '4',  '11', '1',  '1'<br>
        '$country_10', '$country_6',  '5',  '10', '1',  '1'<br>
        '$country_9',  '$country_7',  '6',  '9',  '1',  '1'<br>
        '$country_14', '$country_8',  '7',  '14', '1',  '1'<br>
        '$country_3',  '$country_1',  '8',  '3',  '2',  '2'<br>
        '$country_4',  '$country_13', '9',  '4',  '2',  '2'<br>
        '$country_5',  '$country_12', '10', '5',  '2',  '2'<br>
        '$country_6',  '$country_11', '11', '6',  '2',  '2'<br>
        '$country_7',  '$country_10', '12', '7',  '2',  '2'<br>
        '$country_8',  '$country_9',  '13', '8',  '2',  '2'<br>
        '$country_2',  '$country_14', '14', '2',  '2',  '2'<br>
        '$country_1',  '$country_4',  '15', '1',  '3',  '3'<br>
        '$country_2',  '$country_3',  '16', '2',  '3',  '3'<br>
        '$country_10', '$country_8',  '17', '10', '3',  '3'<br>
        '$country_11', '$country_7',  '18', '11', '3',  '3'<br>
        '$country_12', '$country_6',  '19', '12', '3',  '3'<br>
        '$country_13', '$country_5',  '20', '13', '3',  '3'<br>
        '$country_14', '$country_9',  '21', '14', '3',  '3'<br>
        '$country_4',  '$country_2',  '22', '4',  '4',  '4'<br>
        '$country_5',  '$country_1',  '23', '5',  '4',  '4'<br>
        '$country_6',  '$country_13', '24', '6',  '4',  '4'<br>
        '$country_7',  '$country_12', '25', '7',  '4',  '4'<br>
        '$country_8',  '$country_11', '26', '8',  '4',  '4'<br>
        '$country_9',  '$country_10', '27', '9',  '4',  '4'<br>
        '$country_3',  '$country_14', '28', '3',  '4',  '4'<br>
        '$country_1',  '$country_6',  '29', '1',  '5',  '5'<br>
        '$country_2',  '$country_5',  '30', '2',  '5',  '5'<br>
        '$country_3',  '$country_4',  '31', '3',  '5',  '5'<br>
        '$country_11', '$country_9',  '32', '11', '5',  '5'<br>
        '$country_12', '$country_8',  '33', '12', '5',  '5'<br>
        '$country_13', '$country_7',  '34', '13', '5',  '5'<br>
        '$country_14', '$country_10', '35', '14', '5',  '5'<br>
        '$country_7',  '$country_1',  '36', '7',  '6',  '6'<br>
        '$country_6',  '$country_2',  '37', '6',  '6',  '6'<br>
        '$country_5',  '$country_3',  '38', '5',  '6',  '6'<br>
        '$country_10', '$country_11', '39', '10', '6',  '6'<br>
        '$country_9',  '$country_12', '40', '9',  '6',  '6'<br>
        '$country_8',  '$country_13', '41', '8',  '6',  '6'<br>
        '$country_4',  '$country_14', '42', '14', '6',  '6'<br>
        '$country_1',  '$country_8',  '43', '1',  '7',  '7'<br>
        '$country_2',  '$country_7',  '44', '2',  '7',  '7'<br>
        '$country_3',  '$country_6',  '45', '3',  '7',  '7'<br>
        '$country_4',  '$country_5',  '46', '4',  '7',  '7'<br>
        '$country_12', '$country_10', '47', '12', '7',  '7'<br>
        '$country_13', '$country_9',  '48', '13', '7',  '7'<br>
        '$country_14', '$country_11', '49', '14', '7',  '7'<br>
        '$country_9',  '$country_1',  '50', '9',  '8',  '8'<br>
        '$country_8',  '$country_2',  '51', '8',  '8',  '8'<br>
        '$country_7',  '$country_3',  '52', '7',  '8',  '8'<br>
        '$country_6',  '$country_4',  '53', '6',  '8',  '8'<br>
        '$country_11', '$country_12', '54', '11', '8',  '8'<br>
        '$country_10', '$country_13', '55', '10', '8',  '8'<br>
        '$country_5',  '$country_14', '56', '5',  '8',  '8'<br>
        '$country_1',  '$country_10', '57', '1',  '9',  '9'<br>
        '$country_2',  '$country_9',  '58', '2',  '9',  '9'<br>
        '$country_3',  '$country_8',  '59', '3',  '9',  '9'<br>
        '$country_4',  '$country_7',  '60', '4',  '9',  '9'<br>
        '$country_5',  '$country_6',  '61', '5',  '9',  '9'<br>
        '$country_13', '$country_11', '62', '13', '9',  '9'<br>
        '$country_14', '$country_12', '63', '14', '9',  '9'<br>
        '$country_11', '$country_1',  '64', '11', '10', '10'<br>
        '$country_10', '$country_2',  '65', '10', '10', '10'<br>
        '$country_9',  '$country_3',  '66', '9',  '10', '10'<br>
        '$country_8',  '$country_4',  '67', '8',  '10', '10'<br>
        '$country_7',  '$country_5',  '68', '7',  '10', '10'<br>
        '$country_12', '$country_13', '69', '12', '10', '10'<br>
        '$country_6',  '$country_14', '70', '6',  '10', '10'<br>
        '$country_1',  '$country_12', '71', '1',  '11', '11'<br>
        '$country_2',  '$country_11', '72', '2',  '11', '11'<br>
        '$country_3',  '$country_10', '73', '3',  '11', '11'<br>
        '$country_4',  '$country_9',  '74', '4',  '11', '11'<br>
        '$country_5',  '$country_8',  '75', '5',  '11', '11'<br>
        '$country_6',  '$country_7',  '76', '6',  '11', '11'<br>
        '$country_14', '$country_13', '77', '14', '11', '11'<br>
        '$country_13', '$country_1',  '78', '13', '12', '12'<br>
        '$country_12', '$country_2',  '79', '12', '12', '12'<br>
        '$country_11', '$country_3',  '80', '11', '12', '12'<br>
        '$country_10', '$country_4',  '81', '10', '12', '12'<br>
        '$country_9',  '$country_5',  '82', '9',  '12', '12'<br>
        '$country_8',  '$country_6',  '83', '8',  '12', '12'<br>
        '$country_7',  '$country_14', '84', '7',  '12', '12'<br>
        '$country_1',  '$country_14', '85', '1',  '13', '13'<br>
        '$country_2',  '$country_13', '86', '2',  '13', '13'<br>
        '$country_3',  '$country_12', '87', '3',  '13', '13'<br>
        '$country_4',  '$country_11', '88', '4',  '13', '13'<br>
        '$country_5',  '$country_10', '89', '5',  '13', '13'<br>
        '$country_6',  '$country_9',  '90', '6',  '13', '13'<br>
        '$country_7',  '$country_8',  '91', '7',  '13', '13'<br>";

print $game;
print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';