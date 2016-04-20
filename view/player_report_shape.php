<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Оценки матча</p>
            <table class="striped w100">
                <tr>
                    <td>Игр</td>
                    <td class="center w25"><?= $total_statistic_array[0]['count_game']; ?></td>
                </tr>
                <tr>
                    <td>Максимальная оценка</td>
                    <td class="center"><?= $mark_array[0]['max_mark']; ?></td>
                </tr>
                <tr>
                    <td>Минимальная оценка</td>
                    <td class="center"><?= $mark_array[0]['min_mark']; ?></td>
                </tr>
                <tr>
                    <td>Средняя оценка</td>
                    <td class="center"><?= $total_statistic_array[0]['count_mark']; ?></td>
                </tr>
                <tr>
                    <td>Голов забито</td>
                    <td class="center"><?= $total_statistic_array[0]['count_goal']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Матчи</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">Дата</th>
                    <th colspan="2">Соперник</th>
                    <th class="w5">Счет</th>
                    <th class="w5">Гол</th>
                    <th class="w5">Гпас</th>
                    <th class="w5">Пен</th>
                    <th class="w5">Жк</th>
                    <th class="w5">Кк</th>
                    <th class="w5">УдСтв</th>
                    <th class="w5">Пас %</th>
                    <th class="w5">Фолы</th>
                    <th class="w5">Оцн</th>
                </tr>
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['lineup_goal']; ?></td>
                        <td class="center"><?= $item['lineup_pass_scoring']; ?></td>
                        <td class="center"><?= $item['lineup_penalty_goal']; ?></td>
                        <td class="center"><?= $item['lineup_yellow']; ?></td>
                        <td class="center"><?= $item['lineup_red']; ?></td>
                        <td class="center"><?= $item['lineup_ontarget']; ?></td>
                        <td class="center"><?= $item['lineup_pass_accurate']; ?></td>
                        <td class="center"><?= $item['lineup_foul_made']; ?></td>
                        <td class="center"><?= $item['lineup_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Статистика</p>
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
</table>