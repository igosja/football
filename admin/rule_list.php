<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['data']))
{
    $post_data = $_POST['data'];

    foreach ($post_data as $rule_id => $order)
    {
        $rule_id    = (int) $rule_id;
        $order      = (int) $order;

        $sql = "UPDATE `rule`
                SET `rule_order`='$order'
                WHERE `rule_id`='$rule_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    redirect('rule_list.php');
}

$sql = "SELECT `rule_id`,
               `rule_name`,
               `rule_order`
        FROM `rule`
        ORDER BY `rule_order` ASC";
$rule_sql = $mysqli->query($sql);

$rule_array = $rule_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');