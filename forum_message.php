<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

if (isset($_POST['text']))
{
    $name = $_POST['name'];
    $text = $_POST['text'];

    $sql = "INSERT INTO `forummessage`
            SET `forummessage_name`=?,
                `forummessage_text`=?,
                `forummessage_user_id_from`='$authorization_id',
                `forummessage_user_id_to`='$get_num',
                `forummessage_date`=SYSDATE()";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $name, $text);
    $prepare->execute();
    $prepare->close();

    redirect('forum_outbox.php');
}

$sql = "SELECT `user_login`
        FROM `user`
        WHERE `user_id`='$get_num'
        LIMIT 1";
$forum_sql = $mysqli->query($sql);

$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('forum_array', $forum_array);

$smarty->display('main.html');