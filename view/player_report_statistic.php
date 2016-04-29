<table class="block-table w100">
    <tr>
        <td class="block-page">
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
                        <td><?= $item['tournamenttype_name']; ?></td>
                        <td class="center"><?= $item['statisticplayer_game']; ?></td>
                        <td class="center"><?= $item['statisticplayer_goal']; ?></td>
                        <td class="center"><?= $item['statisticplayer_penalty']; ?></td>
                        <td class="center"><?= $item['statisticplayer_pass_scoring']; ?></td>
                        <td class="center"><?= $item['statisticplayer_best']; ?></td>
                        <td class="center"><?= $item['statisticplayer_yellow']; ?></td>
                        <td class="center"><?= $item['statisticplayer_red']; ?></td>
                        <td class="center"><?= $item['statisticplayer_pass_accurate']; ?></td>
                        <td class="center"><?= $item['statisticplayer_shot']; ?></td>
                        <td class="center"><?= $item['statisticplayer_ontarget']; ?></td>
                        <td class="center"><?= $item['statisticplayer_foul']; ?></td>
                        <td class="center"><?= $item['statisticplayer_mark']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Всего</td>
                    <td class="center"><?= $total_statistic_array[0]['count_game']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_goal']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_penalty']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_pass_scoring']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_best']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_yellow']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_red']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_pass_accurate']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_shot']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_ontarget']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_foul']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_mark']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Подробная статистика</p>
            <table class="striped w100">
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_best'] / $count_total_game * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center w10"><?= $total_statistic_array[0]['count_best']; ?>/<?= $total_statistic_array[0]['count_game']; ?></td>
                    <td class="w25">Игрок матча / Сыгранных матчей</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_win'] / $count_total_game * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_win']; ?>/<?= $total_statistic_array[0]['count_game']; ?></td>
                    <td>Выигрышей / Сыгранных матчей</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_goal'] / $count_total_shot * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_goal']; ?>/<?= $total_statistic_array[0]['count_shot']; ?></td>
                    <td>Голов / Всего ударов</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_ontarget'] / $count_total_shot * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_ontarget']; ?>/<?= $total_statistic_array[0]['count_shot']; ?></td>
                    <td>Удары в створ / Всего ударов</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_penalty_goal'] / $count_total_penalty * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_penalty_goal']; ?>/<?= $total_statistic_array[0]['count_penalty']; ?></td>
                    <td>Пенальти забито / Всего</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_pass_accurate']; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_pass_accurate']; ?> %</td>
                    <td>Точных пасов</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_yellow'] / $count_total_game * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_yellow']; ?>/<?= $total_statistic_array[0]['count_game']; ?></td>
                    <td>Желтых карточек / Сыграно матчей</td>
                </tr>
                <tr>
                    <td>
                        <div class="progress">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $total_statistic_array[0]['count_red'] / $count_total_game * 100; ?>%"
                            ></div>
                        </div>
                    </td>
                    <td class="center"><?= $total_statistic_array[0]['count_red']; ?>/<?= $total_statistic_array[0]['count_game']; ?></td>
                    <td>Красных карточек / Сыграно матчей</td>
                </tr>
            </table>
        </td>
    </tr>
</table>