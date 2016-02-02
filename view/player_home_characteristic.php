<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Персональные данные</p>
            <table class="center w100">
                <tr>
                    <td>
                        <table class="striped w100">
                            <tr>
                                <td colspan="2">
                                    <h5><?php print $player_array[0]['position_description']; ?></h5>
                                </td>
                            </tr>
                            <tr>
                                <td class="w50">
                                    <a href="national_team_review_profile.php?num=<?php print $player_array[0]['country_id']; ?>">
                                        <img
                                            alt="<?php print $player_array[0]['country_name']; ?>"
                                            class="img-12"
                                            src="img/flag/12/<?php print $player_array[0]['country_id']; ?>.png"
                                        />
                                        <?php print $player_array[0]['country_name']; ?>
                                    </a>
                                    <br />
                                    Не вызывался
                                </td>
                                <td>
                                    <?php print $player_array[0]['player_age']; ?>
                                    <br />
                                    Возраст
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php print $player_array[0]['player_height']; ?> см
                                    <br />
                                    <?php print $player_array[0]['player_weight']; ?> кг
                                </td>
                                <td>
                                    <?php print f_igosja_leg_name($player_array[0]['player_leg_left'], $player_array[0]['player_leg_right']); ?>
                                    <br />
                                    Рабочая нога
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php print f_igosja_money($player_array[0]['player_salary']); ?> в день
                                    <br />
                                    Зарплата
                                </td>
                                <td>
                                    <?php print f_igosja_money($player_array[0]['player_price']); ?>
                                    <br />
                                    Стоимость
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Имеет сонтракт с клубом 
                                    <a href="team_team_review_profile.php?num=<?php print $player_array[0]['team_id']; ?>">
                                        <?php print $player_array[0]['team_name']; ?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Характеристики</p>
            <table class="w100">
                <tr>
                    <?php for ($i=0; $i<$count_attribute; $i++) { ?>
                        <?php

                        if (!isset($attribute_array[$i-1]['attributechapter_name']) ||
                            $attribute_array[$i-1]['attributechapter_name'] != $attribute_array[$i]['attributechapter_name'])
                        {

                        ?>
                            <td>
                                <table class="striped w100">
                                    <tr>
                                        <th colspan="2"><?php print $attribute_array[$i]['attributechapter_name']; ?></th>
                                    </tr>
                        <?php } ?>
                            <tr>
                                <td><?php print $attribute_array[$i]['attribute_name']; ?></td>
                                <td class="w33">
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?php print $attribute_array[$i]['playerattribute_value']; ?>%">
                                            <?php print SPACE; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php if (!isset($attribute_array[$i+1]['attributechapter_name'])) { ?>
                            <tr>
                                <td>Кондиции</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?php print $player_array[0]['player_condition']; ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Игровая практика</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?php print $player_array[0]['player_practice']; ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Последние 5 игр</td>
                                <td><?php print $player_array[0]['player_mark']; ?></td>
                            </tr>
                            <tr>
                                <td>Настроение</td>
                                <td>
                                    <img
                                        alt="<?php print $player_array[0]['mood_name']; ?>"
                                        class="img-12"
                                        src="img/mood/<?php print $player_array[0]['mood_id']; ?>.png"
                                    />
                                    <?php print $player_array[0]['mood_name']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Рабочая нога</td>
                                <td><?php print f_igosja_leg_name($player_array[0]['player_leg_left'], $player_array[0]['player_leg_right']); ?></td>
                            </tr>
                        <?php } ?>
                        <?php

                        if (!isset($attribute_array[$i+1]['attributechapter_name']) ||
                            $attribute_array[$i+1]['attributechapter_name'] != $attribute_array[$i]['attributechapter_name'])
                        {

                        ?>
                                </table>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page" colspan="2">
            <table class="striped w100">
                <tr>
                    <th>Статистика</th>
                    <th class="w5">Игры</th>
                    <th class="w5">Гол</th>
                    <th class="w5">Пен</th>
                    <th class="w5">ГПас</th>
                    <th class="w5">ИМ</th>
                    <th class="w5">Жк</th>
                    <th class="w5">Кк</th>
                    <th class="w5">Пас %</th>
                    <th class="w5">Удары</th>
                    <th class="w5">УдСтв</th>
                    <th class="w5">Фолы</th>
                    <th class="w5">СрОц</th>
                </tr>
                <?php foreach ($statistic_array as $item) { ?>
                    <tr>
                        <td><?php print $item['tournamenttype_name']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_game']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_goal']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_penalty']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_pass_scoring']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_best']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_yellow']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_red']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_pass_accurate']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_shot']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_ontarget']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_foul']; ?></td>
                        <td class="center"><?php print $item['statisticplayer_mark']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Всего</td>
                    <td class="center"><?php print $total_statistic_array[0]['count_game']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_goal']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_penalty']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_pass_scoring']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_best']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_yellow']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_red']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_pass_accurate']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_shot']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_ontarget']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_foul']; ?></td>
                    <td class="center"><?php print $total_statistic_array[0]['count_mark']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>