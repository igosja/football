<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `rule_name`,
               `rule_text`
        FROM `rule`
        WHERE `rule_id`='$get_num'
        LIMIT 1";
$rule_sql = $mysqli->query($sql);

$count_rule = $rule_sql->num_rows;

if (0 == $count_rule)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['rule_name']))
{
    $rule_name    = $_POST['rule_name'];
    $rule_text      = $_POST['rule_text'];

    $sql = "UPDATE `rule` 
            SET `rule_name`=?,
                `rule_text`=?
            WHERE `rule_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $rule_name, $rule_text);
    $prepare->execute();
    $prepare->close();

    redirect('rule_list.php');

    exit;
}

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

$rule_name    = $rule_array[0]['rule_name'];
$rule_text      = $rule_array[0]['rule_text'];

$smarty->assign('rule_name', $rule_name);
$smarty->assign('rule_text', $rule_text);
$smarty->assign('tpl', 'rule_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');