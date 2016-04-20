<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Персональные данные</p>
            <table class="striped w100">
                <tr>
                    <td>Национальность</td>
                    <td>
                        <img alt="" class="img-12" src="img/flag/12/<?= $referee_array[0]['country_id']; ?>.png" />
                        <a href="national_team_review_profile.php?num=<?= $referee_array[0]['country_id']; ?>">
                            <?= $referee_array[0]['country_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Возраст</td>
                    <td><?= $referee_array[0]['referee_age']; ?></td>
                </tr>
                <tr>
                    <td>Репутация</td>
                    <td><?= f_igosja_five_star($referee_array[0]['referee_reputation'], 12); ?></td>
                </tr>
                <tr>
                    <td>Должность</td>
                    <td>Судья</td>
                </tr>
            </table>
        </td>
        <td class="block-page w50">
            <p class="header">Статистика</p>
            <table class="striped w100">
                <tr>
                    <td>Матчей</td>
                    <td><?= $referee_array[0]['count_game']; ?></td>
                </tr>
                <tr>
                    <td>Красные карточки</td>
                    <td><?= $referee_array[0]['count_red']; ?></td>
                </tr>
                <tr>
                    <td>Желтые карточки</td>
                    <td><?= $referee_array[0]['count_yellow']; ?></td>
                </tr>
                <tr>
                    <td>Пенальти</td>
                    <td><?= $referee_array[0]['count_penalty']; ?></td>
                </tr>
                <tr>
                    <td>Средняя оценка</td>
                    <td><?= $referee_array[0]['average_mark']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Недавние матчи</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">Дата</th>
                    <th colspan="3">Матч</th>
                    <th colspan="2">Турнир</th>
                    <th class="w5">Пен</th>
                    <th class="w5">ЖК</th>
                    <th class="w5">КК</th>
                    <th class="w5">Оценка</th>
                </tr>
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="right">
                            <?php if (0 != $item['game_home_team_id']) { ?>
                                <a href="team_team_review_profile.php?num=<?= $item['game_home_team_id']; ?>">
                                    <?= $item['home_team_name']; ?>
                                </a>
                                <img
                                    alt="<?= $item['home_team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?= $item['game_home_team_id']; ?>.png"
                                />
                            <?php } else { ?>
                                <a href="national_team_review_profile.php?num=<?= $item['game_home_country_id']; ?>">
                                    <?= $item['home_country_name']; ?>
                                </a>
                                <img
                                    alt="<?= $item['home_country_name']; ?>"
                                    class="img-12"
                                    src="img/flag/12/<?= $item['game_home_country_id']; ?>.png"
                                />
                            <?php } ?>
                        </td>
                        <td class="center">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?= $item['game_home_score']; ?>-<?= $item['game_guest_score']; ?>
                            </a>
                        </td>
                        <td>
                            <?php if (0 != $item['game_home_team_id']) { ?>
                                <img
                                    alt="<?= $item['guest_team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?= $item['game_guest_team_id']; ?>.png"
                                />
                                <a href="team_team_review_profile.php?num=<?= $item['game_guest_team_id']; ?>">
                                    <?= $item['guest_team_name']; ?>
                                </a>
                            <?php } else { ?>
                                <img
                                    alt="<?= $item['guest_country_name']; ?>"
                                    class="img-12"
                                    src="img/flag/12/<?= $item['game_guest_country_id']; ?>.png"
                                />
                                <a href="national_team_review_profile.php?num=<?= $item['game_guest_country_id']; ?>">
                                    <?= $item['guest_country_name']; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['game_penalty']; ?></td>
                        <td class="center"><?= $item['game_yellow']; ?></td>
                        <td class="center"><?= $item['game_red']; ?></td>
                        <td class="center"><?= $item['game_referee_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>