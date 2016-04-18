<?php

function f_igosja_season_worldcup_game()
{
    global $igosja_season_id;

    $tournament_id = TOURNAMENT_WORLD_CUP;

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_WORLD_CUP . "'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` ASC";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $count_shedule = $shedule_sql->num_rows;
    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_shedule; $i++)
    {
        $shedule  = 'shedule_' . ($i + 1);
        $$shedule = $shedule_array[$i]['shedule_id'];
    }

    $sql = "SELECT `country_id`,
                   `country_stadium_id`
            FROM `worldcup`
            LEFT JOIN `country`
            ON `country_id`=`worldcup_country_id`
            WHERE `worldcup_season_id`='$igosja_season_id'
            ORDER BY RAND()";
    $standing_sql = f_igosja_mysqli_query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for($j=0; $j<$count_standing; $j++)
    {
        $team_num   = $j + 1;
        $country    = 'country_' . $team_num;
        $$country   = $standing_array[$j]['country_id'];
        $stadium    = 'stadium_' . $team_num;
        $$stadium   = $standing_array[$j]['country_stadium_id'];
    }

    $sql = "SELECT `referee_id`
            FROM `referee`
            ORDER BY RAND()
            LIMIT 91";
    $referee_sql = f_igosja_mysqli_query($sql);

    $count_referee = $referee_sql->num_rows;
    $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_referee; $j++)
    {
        $referee  = 'referee_' . ($j + 1);
        $$referee = $referee_array[$j]['referee_id'];
    }

    $sql = "INSERT INTO `game`
            (
                `game_field_bonus`,
                `game_home_country_id`,
                `game_guest_country_id`,
                `game_referee_id`,
                `game_stadium_id`,
                `game_stage_id`,
                `game_shedule_id`,
                `game_temperature`,
                `game_tournament_id`,
                `game_weather_id`
            )
            VALUES  ('0', '$country_1',  '$country_2',  '$referee_1',  '$stadium_1',  '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_13', '$country_3',  '$referee_2',  '$stadium_13', '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_12', '$country_4',  '$referee_3',  '$stadium_12', '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_11', '$country_5',  '$referee_4',  '$stadium_11', '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_10', '$country_6',  '$referee_5',  '$stadium_10', '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_9',  '$country_7',  '$referee_6',  '$stadium_9',  '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_14', '$country_8',  '$referee_7',  '$stadium_14', '1',  '$shedule_1',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_1',  '$referee_8',  '$stadium_3',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_13', '$referee_9',  '$stadium_4',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_12', '$referee_10', '$stadium_5',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_11', '$referee_11', '$stadium_6',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_10', '$referee_12', '$stadium_7',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_8',  '$country_9',  '$referee_13', '$stadium_8',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_14', '$referee_14', '$stadium_2',  '2',  '$shedule_2',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_1',  '$country_4',  '$referee_15', '$stadium_1',  '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_3',  '$referee_16', '$stadium_2',  '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_10', '$country_8',  '$referee_17', '$stadium_10', '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_11', '$country_7',  '$referee_18', '$stadium_11', '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_12', '$country_6',  '$referee_19', '$stadium_12', '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_13', '$country_5',  '$referee_20', '$stadium_13', '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_14', '$country_9',  '$referee_21', '$stadium_14', '3',  '$shedule_3',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_2',  '$referee_22', '$stadium_4',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_1',  '$referee_23', '$stadium_5',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_13', '$referee_24', '$stadium_6',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_12', '$referee_25', '$stadium_7',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_8',  '$country_11', '$referee_26', '$stadium_8',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_9',  '$country_10', '$referee_27', '$stadium_9',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_14', '$referee_28', '$stadium_3',  '4',  '$shedule_4',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_1',  '$country_6',  '$referee_29', '$stadium_1',  '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_5',  '$referee_30', '$stadium_2',  '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_4',  '$referee_31', '$stadium_3',  '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_11', '$country_9',  '$referee_32', '$stadium_11', '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_12', '$country_8',  '$referee_33', '$stadium_12', '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_13', '$country_7',  '$referee_34', '$stadium_13', '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_14', '$country_10', '$referee_35', '$stadium_14', '5',  '$shedule_5',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_1',  '$referee_36', '$stadium_7',  '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_2',  '$referee_37', '$stadium_6',  '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_3',  '$referee_38', '$stadium_5',  '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_10', '$country_11', '$referee_39', '$stadium_10', '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_9',  '$country_12', '$referee_40', '$stadium_9',  '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_8',  '$country_13', '$referee_41', '$stadium_8',  '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_14', '$referee_42', '$stadium_14', '6',  '$shedule_6',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_1',  '$country_8',  '$referee_43', '$stadium_1',  '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_7',  '$referee_44', '$stadium_2',  '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_6',  '$referee_45', '$stadium_3',  '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_5',  '$referee_46', '$stadium_4',  '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_12', '$country_10', '$referee_47', '$stadium_12', '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_13', '$country_9',  '$referee_48', '$stadium_13', '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_14', '$country_11', '$referee_49', '$stadium_14', '7',  '$shedule_7',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_9',  '$country_1',  '$referee_50', '$stadium_9',  '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_8',  '$country_2',  '$referee_51', '$stadium_8',  '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_3',  '$referee_52', '$stadium_7',  '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_4',  '$referee_53', '$stadium_6',  '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_11', '$country_12', '$referee_54', '$stadium_11', '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_10', '$country_13', '$referee_55', '$stadium_10', '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_14', '$referee_56', '$stadium_5',  '8',  '$shedule_8',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_1',  '$country_10', '$referee_57', '$stadium_1',  '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_9',  '$referee_58', '$stadium_2',  '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_8',  '$referee_59', '$stadium_3',  '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_7',  '$referee_60', '$stadium_4',  '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_6',  '$referee_61', '$stadium_5',  '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_13', '$country_11', '$referee_62', '$stadium_13', '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_14', '$country_12', '$referee_63', '$stadium_14', '9',  '$shedule_9',  '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_11', '$country_1',  '$referee_64', '$stadium_11', '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_10', '$country_2',  '$referee_65', '$stadium_10', '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_9',  '$country_3',  '$referee_66', '$stadium_9',  '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_8',  '$country_4',  '$referee_67', '$stadium_8',  '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_5',  '$referee_68', '$stadium_7',  '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_12', '$country_13', '$referee_69', '$stadium_12', '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_14', '$referee_70', '$stadium_6',  '10', '$shedule_10', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_1',  '$country_12', '$referee_71', '$stadium_1',  '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_11', '$referee_72', '$stadium_2',  '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_10', '$referee_73', '$stadium_3',  '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_9',  '$referee_74', '$stadium_4',  '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_8',  '$referee_75', '$stadium_5',  '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_7',  '$referee_76', '$stadium_6',  '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_14', '$country_13', '$referee_77', '$stadium_14', '11', '$shedule_11', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_13', '$country_1',  '$referee_78', '$stadium_13', '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_12', '$country_2',  '$referee_79', '$stadium_12', '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_11', '$country_3',  '$referee_80', '$stadium_11', '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_10', '$country_4',  '$referee_81', '$stadium_10', '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_9',  '$country_5',  '$referee_82', '$stadium_9',  '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_8',  '$country_6',  '$referee_83', '$stadium_8',  '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_14', '$referee_84', '$stadium_7',  '12', '$shedule_12', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_1',  '$country_14', '$referee_85', '$stadium_1',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_2',  '$country_13', '$referee_86', '$stadium_2',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_3',  '$country_12', '$referee_87', '$stadium_3',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_4',  '$country_11', '$referee_88', '$stadium_4',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_5',  '$country_10', '$referee_89', '$stadium_5',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_6',  '$country_9',  '$referee_90', '$stadium_6',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3'),
                    ('0', '$country_7',  '$country_8',  '$referee_91', '$stadium_7',  '13', '$shedule_13', '15'+RAND()*'15', '$tournament_id', '1'+RAND()*'3');";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}