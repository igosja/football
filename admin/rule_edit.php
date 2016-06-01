<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `rule_name`,
               `rule_text`
        FROM `rule`
        WHERE `rule_id`='$num_get'
        LIMIT 1";
$rule_sql = $mysqli->query($sql);

$count_rule = $rule_sql->num_rows;

if (0 == $count_rule)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['rule_name']))
{
    $rule_name    = $_POST['rule_name'];
    $rule_text      = $_POST['rule_text'];

    $sql = "UPDATE `rule` 
            SET `rule_name`=?,
                `rule_text`=?
            WHERE `rule_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $rule_name, $rule_text);
    $prepare->execute();
    $prepare->close();

    redirect('rule_list.php');
}

$rule_array = $rule_sql->fetch_all(1);

$tpl = 'rule_create';

include (__DIR__ . '/../view/admin_main.php');