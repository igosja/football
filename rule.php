<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 0;
}

if (0 == $num_get)
{
    $sql = "SELECT `rule_id`,
                   `rule_name`
            FROM `rule`
            ORDER BY `rule_order` ASC";
}
else
{
    $sql = "SELECT `rule_name`,
                   `rule_text`
            FROM `rule`
            WHERE `rule_id`='$num_get'";
}

$rule_sql = $mysqli->query($sql);

$count_rule = $rule_sql->num_rows;

if (0 == $count_rule)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$rule_array = $rule_sql->fetch_all(1);

$header_title       = 'Правила';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');