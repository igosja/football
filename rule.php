<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `rule_id`,
               `rule_name`,
               `rule_text`
        FROM `rule`
        ORDER BY `rule_id` ASC";
$rule_sql = $mysqli->query($sql);

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

$header_title = 'Правила';

include (__DIR__ . '/view/main.php');