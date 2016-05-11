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

$sql = "SELECT `tournament_country_id`,
               `tournament_id`,
               `tournament_level`,
               `tournament_name`,
               `tournament_tournamenttype_id`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['tournamenttype_id']))
{
    $tournamenttype_id  = (int) $_POST['tournamenttype_id'];
    $tournament_name    = $_POST['tournament_name'];
    $tournament_level   = (int) $_POST['tournament_level'];
    $country_id         = (int) $_POST['country_id'];

    $sql = "UPDATE `tournament`
            SET `tournament_name`=?,
                `tournament_tournamenttype_id`=?,
                `tournament_level`=?,
                `tournament_country_id`=?
            WHERE `tournament_id`='$num_get'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('siii', $tournament_name, $tournamenttype_id, $tournament_level, $country_id);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['tournament_logo_90']['type'])
    {
        copy($_FILES['tournament_logo_90']['tmp_name'], __DIR__ . '/../img/tournament/90/' . $num_get . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_50']['type'])
    {
        copy($_FILES['tournament_logo_50']['tmp_name'], __DIR__ . '/../img/tournament/50/' . $num_get . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_12']['type'])
    {
        copy($_FILES['tournament_logo_12']['tmp_name'], __DIR__ . '/../img/tournament/12/' . $num_get . '.png');
    }

    redirect('tournament_list.php');
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = $mysqli->query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'tournament_create';

include (__DIR__ . '/../view/admin_main.php');