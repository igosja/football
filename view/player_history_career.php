<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Карьера</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">Сезон</th>
                    <th colspan="2">Команда</th>
                    <th colspan="2">Дивизион</th>
                    <th class="w5">Игры</th>
                    <th class="w5">Голы</th>
                    <th class="w5">Гпас</th>
                    <th class="w5">ИМ</th>
                    <th class="w5">СрО</th>
                </tr>
                <?php foreach ($season_statistic_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['statisticplayer_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w35">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['statisticplayer_game']; ?></td>
                        <td class="center"><?= $item['statisticplayer_goal']; ?></td>
                        <td class="center"><?= $item['statisticplayer_pass_scoring']; ?></td>
                        <td class="center"><?= $item['statisticplayer_best']; ?></td>
                        <td class="center"><?= $item['statisticplayer_mark']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="center">Всего</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="center"><?= $total_statistic_array[0]['count_game']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_goal']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_pass_scoring']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_best']; ?></td>
                    <td class="center"><?= $total_statistic_array[0]['count_mark']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Статистика</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">Сезон</th>
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
                        <td class="center"><?= $item['statisticplayer_season_id']; ?></td>
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
                    <td></td>
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