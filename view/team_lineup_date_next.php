<table class="block-table w100">
    <tr>
        <td class="block-page w100">
            <p class="header">Сравнительная таблица</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Команда</th>
                    <th class="w10">И</th>
                    <th class="w10">В</th>
                    <th class="w10">Н</th>
                    <th class="w10">П</th>
                    <th class="w10">ГЗ</th>
                    <th class="w10">ГП</th>
                </tr>
                <tr>
                    <td class="w1">
                        <img
                            alt="<?= $team_name; ?>"
                            class="img-12"
                            src="img/team/12/<?= $num; ?>.png"
                        />
                    </td>
                    <td>
                        <a href="team_team_review_profile.php?num=<?= $num; ?>">
                            <?= $team_name; ?>
                        </a>
                    </td>
                    <td class="center"><?= $game; ?></td>
                    <td class="center"><?= $win; ?></td>
                    <td class="center"><?= $draw; ?></td>
                    <td class="center"><?= $loose; ?></td>
                    <td class="center"><?= $score; ?></td>
                    <td class="center"><?= $pass; ?></td>
                </tr>
                <tr>
                    <td class="w1">
                        <img
                            alt="<?= $nearest_game_array[0]['team_name']; ?>"
                            class="img-12"
                            src="img/team/12/<?= $nearest_game_array[0]['team_id']; ?>.png"
                        />
                    </td>
                    <td>
                        <a href="team_team_review_profile.php?num=<?= $nearest_game_array[0]['team_id']; ?>">
                            <?= $nearest_game_array[0]['team_name']; ?>
                        </a>
                    </td>
                    <td class="center"><?= $game; ?></td>
                    <td class="center"><?= $loose; ?></td>
                    <td class="center"><?= $draw; ?></td>
                    <td class="center"><?= $win; ?></td>
                    <td class="center"><?= $pass; ?></td>
                    <td class="center"><?= $score; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Предыдущие результаты</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Дата</th>
                    <th colspan="2">Турнир</th>
                    <th colspan="2">Хозяева</th>
                    <th colspan="2">Гости</th>
                    <th class="w5">Счет</th>
                </tr>
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['game_home_team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['game_home_team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="team_team_review_profile.php?num=<?= $item['game_home_team_id']; ?>">
                                <?= $item['game_home_team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['game_guest_team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['game_guest_team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="team_team_review_profile.php?num=<?= $item['game_guest_team_id']; ?>">
                                <?= $item['game_guest_team_name']; ?>
                            </a>
                        </td>
                        <td class="center w5">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?= $item['game_home_score']; ?>:<?= $item['game_guest_score']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>