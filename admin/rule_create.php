<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['rule_name']))
{
    $rule_name    = $_POST['rule_name'];
    $rule_text      = $_POST['rule_text'];

    $sql = "INSERT INTO `rule`
            SET `rule_name`=?,
                `rule_text`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $rule_name, $rule_text);
    $prepare->execute();
    $prepare->close();

    redirect('rule_list.php');

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');