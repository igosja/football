<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header"><?php print $team_array[0]['stadium_name']; ?></p>
            <table class="striped w100">
                <tr>
                    <td>Город</td>
                    <td class="w50"><?php print $team_array[0]['city_name']; ?></td>
                </tr>
                <tr>
                    <td>Вместимость стадиона</td>
                    <td>
                        <?php print number_format($team_array[0]['stadium_capacity'], 0, ',', ' '); ?>
                        <?php if (isset($authorization_team_id) && $num == $authorization_team_id) { ?>
                            [<a href="stadium.php">Изменить</a>]
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Команда</td>
                    <td>
                        <img
                            alt="<?php print $team_array[0]['team_name']; ?>"
                            class="img-12"
                            src="img/team/12/<?php print $team_array[0]['team_id']; ?>.png"
                        />
                        <a href="team_team_review_profile.php?num=<?php print $team_array[0]['team_id']; ?>">
                            <?php print $team_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Состояние газона</td>
                    <td>
                        <?php print $team_array[0]['stadiumquality_name']; ?>
                        <?php if (isset($authorization_team_id) && $num == $authorization_team_id) { ?>
                            [<a href="fieldgrass.php">Заменить</a>]
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Размеры поля</td>
                    <td>
                        Длина: <?php print $team_array[0]['stadium_length']; ?> м, ширина: <?php print $team_array[0]['stadium_width']; ?> м
                        <?php if (isset($authorization_team_id) && $num == $authorization_team_id) { ?>
                            [<a href="fieldsize.php">Изменить</a>]
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Уровень тренировочной базы</td>
                    <td>
                        <?php print $team_array[0]['team_training_level']; ?>
                        <?php if (isset($authorization_team_id) && $num == $authorization_team_id) { ?>
                            [<a href="base.php">Изменить</a>]
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Уровень молодежной инфраструктуры</td>
                    <td>
                        <?php print $team_array[0]['team_school_level']; ?>
                        <?php if (isset($authorization_team_id) && $num == $authorization_team_id) { ?>
                            [<a href="school.php">Изменить</a>]
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Запланированное работы</td>
                    <td>
                        <?php foreach ($building_array as $item) { ?>
                            <?php print $item['buildingtype_name']; ?> (дата заврешения - <?php print f_igosja_ufu_date($item['building_end_date']); ?>)<br/>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>