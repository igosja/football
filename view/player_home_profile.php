<table class="block-table w100">
    <tr>
        <td class="block-page w25" rowspan="2">
            <p class="header">Персональные данные</p>
            <table class="w100">
                <tr>
                    <td>
                        <table class="w100">
                            <tr>
                                <td class="w20">
                                    <table class="w100">
                                        <tr>
                                            <td>Номер</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>
                                                    <?php if (0 < $player_array[0]['player_number']) { ?>
                                                        <?= $player_array[0]['player_number']; ?>
                                                    <?php } else { ?>
                                                        -
                                                    <?php } ?>
                                                </h6>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="center vcenter">
                                    <h5>
                                        <?= $position_array[0]['position_description']; ?>
                                    </h5>
                                </td>
                                <td class="w20">
                                    <table class="right w100">
                                        <tr>
                                            <td>Возраст</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>
                                                    <?= $player_array[0]['player_age']; ?>
                                                </h6>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><?= SPACE; ?></td>
                </tr>
                <tr>
                    <td class="center">
                        Имеет контракт с клубом 
                        <a href="team_team_review_profile.php?num=<?= $player_array[0]['team_id']; ?>">
                            <?= $player_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><?= SPACE; ?></td>
                </tr>
                <tr>
                    <td>
                        <table class="center w100">
                            <tr>
                                <td class="vcenter w50">
                                    <table class="w100">
                                        <tr>
                                            <td>Игры: <?= $player_array[0]['count_game']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Голы: <?= $player_array[0]['count_goal']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Передачи: <?= $player_array[0]['count_pass']; ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="center">
                                    <a href="national_team_review_profile.php?num=<?= $player_array[0]['country_id']; ?>">
                                        <img
                                            alt="<?= $player_array[0]['country_name']; ?>"
                                            class="img-50"
                                            src="/img/flag/50/<?= $player_array[0]['country_id']; ?>.png"
                                        />
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><?= SPACE; ?></td>
                </tr>
                <tr>
                    <td>
                        <table class="center w100">
                            <tr>
                                <td class="w50"><h6><?= f_igosja_money($player_array[0]['player_salary']); ?></h6></td>
                                <td><h6><?= f_igosja_money($player_array[0]['player_price']); ?></h6></td>
                            </tr>
                            <tr>
                                <td>Зарплата в день</td>
                                <td>Стоимость</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><?= SPACE; ?></td>
                </tr>
                <tr>
                    <td>
                        <table class="center w100">
                            <tr>
                                <td class="w33"><h6><?= $player_array[0]['player_height']; ?> см</h6></td>
                                <td><h6><?= $player_array[0]['player_weight']; ?> кг</h6></td>
                                <td class="w33">
                                    <h6>
                                        <?= f_igosja_leg_name($player_array[0]['player_leg_left'], $player_array[0]['player_leg_right']); ?>
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td>Рост</td>
                                <td>Вес</td>
                                <td>Нога</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page" rowspan="2">
            <p class="header">Характеристики</p>
            <table class="w100">
                <tr>
                    <?php for ($i=0; $i<$count_attribute; $i++) { ?>
                        <?php

                        if (!isset($attribute_array[$i-1]['attributechapter_name']) ||
                            $attribute_array[$i-1]['attributechapter_name'] != $attribute_array[$i]['attributechapter_name']) {

                        ?>
                            <td>
                                <table class="striped w100">
                                    <tr>
                                        <th colspan="2"><?= $attribute_array[$i]['attributechapter_name']; ?></th>
                                    </tr>
                            <?php } ?>
                                <tr>
                                    <td><?= $attribute_array[$i]['attribute_name']; ?></td>
                                    <td class="center w25">
                                        <?php if (1 == $count_scout ||
                                                 (isset($authorization_team_id) &&
                                                  $player_array[0]['team_id'] == $authorization_team_id))  { ?>
                                            <?= $attribute_array[$i]['playerattribute_value']; ?>
                                        <?php } else { ?>
                                            ?
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php

                        if (!isset($attribute_array[$i+1]['attributechapter_name']) ||
                            $attribute_array[$i+1]['attributechapter_name'] != $attribute_array[$i]['attributechapter_name']) {

                        ?>
                                </table>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Позиции</p>
            <table class="w100">
                <tr>
                    <td class="relative w1">
                        <img alt="Позиции" src="/img/field/field-108.png" />
                        <?php foreach ($position_array as $item) { ?>
                            <img
                                alt="<?= $item['position_description']; ?>"
                                src="/img/position/<?= f_igosja_position_icon($item['playerposition_value']); ?>.png"
                                style="position: absolute; top: <?= 150 -   $item['position_coordinate_x'] * 15 - 10; ?>px; left: <?= 1 + $item['position_coordinate_y'] * 15; ?>px;"
                                title="<?= $item['position_description']; ?>"
                            />
                        <?php } ?>
                    </td>
                    <td>
                        <table class="striped w100">
                            <tr>
                                <th class="w50">Позиция</th>
                                <th>Способность</th>
                            </tr>
                            <?php foreach ($position_array as $item) { ?>
                                <tr>
                                    <td><?= $item['position_name']; ?></td>
                                    <td class="right"><?= $item['playerposition_value']; ?> %</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Физические</p>
            <table class="w100">
                <tr>
                    <td>Кондиции</td>
                    <td class="right"><?php if (isset($authorization_team_id) && $authorization_team_id == $player_array[0]['team_id']) { print $player_array[0]['player_condition'] . '%'; } else { print '?'; } ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="progress">
                            <div class="<?= f_igosja_progress_class($player_array[0]['player_condition']); ?>" style="width: <?php if (isset($authorization_team_id) && $authorization_team_id == $player_array[0]['team_id']) { print $player_array[0]['player_condition']; } else { print '0'; } ?>%"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><?= SPACE; ?></td>
                </tr>
                <tr>
                    <td>Игровая практика</td>
                    <td class="right"><?php if (isset($authorization_team_id) && $authorization_team_id == $player_array[0]['team_id']) { print $player_array[0]['player_practice'] . '%'; } else { print '?'; } ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="progress">
                            <div class="<?= f_igosja_progress_class($player_array[0]['player_practice']); ?>" style="width: <?php if (isset($authorization_team_id) && $authorization_team_id == $player_array[0]['team_id']) { print $player_array[0]['player_practice'];  } else { print '0'; } ?>%"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Информация о статусе игрока</p>
            <table class="w100">
                <tr>
                    <td>Настроение: <img alt="" class="img-12" src="/img/mood/<?= $player_array[0]['mood_id']; ?>.png" /> <?= $player_array[0]['mood_name']; ?></td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Оценки за последние 5 матчей</p>
            <table class="w100">
                <?php foreach ($last_five_array as $item) { ?>
                    <tr>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?= $item['lineup_mark'] * 10; ?>%">
                                    <?= SPACE; ?>
                                </div>
                            </div>
                        </td>
                        <td class="center w10"><?= $item['lineup_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Запреты</p>
            <table class="w100">
                <?php foreach ($disqualification_array as $item) { ?>
                    <tr>
                        <td class="w1" rowspan="2">
                            <?php if (2 <= $item['disqualification_yellow'] || 1 <= $item['disqualification_red']) { ?>
                                <img alt="Красная карточка" class="img-30" src="/img/card/red.png" />
                            <?php } else { ?>
                                <img alt="Желтая карточка" class="img-30" src="/img/card/yellow.png" />
                            <?php } ?>
                        </td>
                        <td class="w1">
                            <?= SPACE; ?>
                        </td>
                        <td>
                            <?php if (2 <= $item['disqualification_yellow'] || 1 <= $item['disqualification_red']) { ?>
                                Дисквалифицирован на 1 игру
                            <?php } else { ?>
                                <?= 2 - $item['disqualification_yellow']; ?> ЖК до дисквалификации на 1 игру
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="w1">
                            <?= SPACE; ?>
                        </td>
                        <td>
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>
