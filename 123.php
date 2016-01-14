<?php

include($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "TRUNCATE `ratingcountry`";
$mysqli->query($sql);

$sql = "INSERT INTO `ratingcountry` (`ratingcountry_country_id`)
        SELECT `city_country_id`
        FROM `city`
        WHERE `city_id`!='0'
        GROUP BY `city_country_id`
        ORDER BY `city_country_id` ASC";
$mysqli->query($sql);