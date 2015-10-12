<?php

include ('../include/include.php');

if (isset($_POST['city_id']))
{
    $city_id        = (int) $_POST['city_id'];
    $team_name      = $_POST['team_name'];
    $stadium_name   = $_POST['stadium_name'];

    $sql = "SELECT `count_team_id`, `t1`.`country_id` AS `country_id`
            FROM `country` AS `t1`
            LEFT JOIN `city` AS `t2`
            ON `city_country_id`=`country_id`
            LEFT JOIN 
            (
                SELECT COUNT(`team_id`) AS `count_team_id`, `country_id`
                FROM `team`
                LEFT JOIN `city`
                ON `city_id`=`team_city_id`
                LEFT JOIN `country`
                ON `country_id`=`city_country_id`
                GROUP BY `country_id`
            ) AS `t3`
            ON `t1`.`country_id`=`t3`.`country_id`
            WHERE `city_id`='$city_id'";
    $country_sql = $mysqli->query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    $count_team = $country_array[0]['count_team_id'];

    if (0 == $count_team)
    {
        $country_id = $country_array[0]['country_id'];

        $sql = "UPDATE `country`
                SET `country_season_id`='$igosja_season_id'
                WHERE `county_id`='$country_id'
                LIMIT 1";

        f_igosja_history(1, $country_id);
    }

    $sql = "INSERT INTO `team`
            SET `team_name`=?,
                `team_city_id`=?,
                `team_season_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sii', $team_name, $city_id, $igosja_season_id);
    $prepare->execute();
    $prepare->close();

    $team_id = $mysqli->insert_id;

    $sql = "INSERT INTO `stadium`
            SET `stadium_name`=?,
                `stadium_team_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $stadium_name, $team_id);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['team_logo']['type'])
    {
        copy($_FILES['team_logo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/' . $team_id . '.png');
    }

    if ('image/png' == $_FILES['team_logo_120']['type'])
    {
        copy($_FILES['team_logo_120']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/120/' . $team_id . '.png');
    }

    if ('image/png' == $_FILES['team_logo_90']['type'])
    {
        copy($_FILES['team_logo_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/90/' . $team_id . '.png');
    }

    if ('image/png' == $_FILES['team_logo_50']['type'])
    {
        copy($_FILES['team_logo_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/50/' . $team_id . '.png');
    }

    if ('image/png' == $_FILES['team_logo_12']['type'])
    {
        copy($_FILES['team_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/12/' . $team_id . '.png');
    }

    for ($i=0; $i<NUMBER_PLAYER_IN_NEW_TEAM; $i++)
    {
        f_igosja_player_create($team_id, $i);
    }

    f_igosja_staff_create($team_id);
    f_igosja_history(2, 0, $team_id);

    $sql = "INSERT INTO `standing`
            SET `standing_country_id`=(SELECT `city_country_id`
                                       FROM `city` 
                                       WHERE `city_id`='$city_id'
                                       LIMIT 1),
                `standing_season_id`='$igosja_season_id',
                `standing_team_id`='$team_id',
                `standing_tournament_id`=(SELECT `tournament_id`
                                          FROM `tournament`
                                          LEFT JOIN `city`
                                          ON `city_country_id`=`tournament_country_id`
                                          WHERE `tournament_tournamenttype_id`='2'
                                          AND `city_id`='$city_id'
                                          ORDER BY `tournament_level` DESC
                                          LIMIT 1)";
    $mysqli->query($sql);

    redirect('team_list.php');

    exit;
}

$sql = "SELECT `city_id`, `city_name`
        FROM `city`
        ORDER BY `city_name` ASC";
$city_sql = $mysqli->query($sql);

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('city_array', $city_array);

$smarty->display('admin_main.html');