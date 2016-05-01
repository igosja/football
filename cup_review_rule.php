<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Правила. ' . $seo_title;
$seo_description    = $tournament_name . '. Правила. ' . $seo_description;
$seo_keywords       = $tournament_name . ', правила, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');