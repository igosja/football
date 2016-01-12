<?php

include ('../include/include.php');

$sql = "SELECT `rule_id`,
               `rule_name`
        FROM `rule`
        ORDER BY `rule_id` ASC";
$rule_sql = $mysqli->query($sql);

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('rule_array', $rule_array);

$smarty->display('admin_main.html');