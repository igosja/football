<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Вид</p>
            <table class="w100">
                <tr>
                    <td class="w1" rowspan="4">
                        <img
                            alt="<?= $game_array[0]['tournament_name']; ?>"
                            class="img-50"
                            src="img/tournament/50/<?= $game_array[0]['tournament_id']; ?>.png"
                        />
                    </td>
                    <td>
                        <h6>
                            <a href="tournament_review_profile.php?num=<?= $game_array[0]['tournament_id']; ?>">
                                <?= $game_array[0]['tournament_name']; ?>
                            </a>
                        </h6>
                    </td>
                    <td class="right"><?= f_igosja_ufu_date($game_array[0]['shedule_date']); ?></td>
                </tr>
                <tr>
                    <td>Судья: 
                        <a href="referee_home_profile.php?num=<?= $game_array[0]['referee_id']; ?>">
                            <?= $game_array[0]['name_name']; ?> <?= $game_array[0]['surname_name']; ?>
                        </a>
                        (оценка - <?= $game_array[0]['game_referee_mark']; ?>)
                    </td>
                    <td class="right">
                        <img
                            alt="<?= $game_array[0]['weather_name']; ?>"
                            class="img-12"
                            title="<?= $game_array[0]['weather_name']; ?>"
                            src="img/weather/12/<?= $game_array[0]['weather_id']; ?>.png"
                        />
                        <?= $game_array[0]['game_temperature'] . CELSIUS; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Зрителей: <?= number_format($game_array[0]['game_visitor'], 0, ',', ' '); ?></td>
                </tr>
                <tr>
                    <td class="center" colspan="2"><?= $game_array[0]['stadium_name']; ?>, <?= $game_array[0]['city_name']; ?></td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="center w50">
                        <h5>
                            <?php if (isset($game_array[0]['game_home_team_id'])) { ?>
                                <a href="team_team_review_profile.php?num=<?= $game_array[0]['game_home_team_id']; ?>">
                                    <?= $game_array[0]['game_home_team_name']; ?>
                                </a>
                            <?php } else { ?>
                                <a href="national_team_review_profile.php?num=<?= $game_array[0]['game_home_country_id']; ?>">
                                    <?= $game_array[0]['game_home_country_name']; ?>
                                </a>
                            <?php } ?>
                        </h5>
                    </td>
                    <td class="center">
                        <h5>
                            <?php if (isset($game_array[0]['game_guest_team_id'])) { ?>
                                <a href="team_team_review_profile.php?num=<?= $game_array[0]['game_guest_team_id']; ?>">
                                    <?= $game_array[0]['game_guest_team_name']; ?>
                                </a>
                            <?php } else { ?>
                                <a href="national_team_review_profile.php?num=<?= $game_array[0]['game_guest_country_id']; ?>">
                                    <?= $game_array[0]['game_guest_country_name']; ?>
                                </a>
                            <?php } ?>
                        </h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="striped w100">
                            <?php foreach ($home_event_array as $item) { ?>
                                <tr>
                                    <td>
                                        <img
                                            alt="<?= $item['eventtype_name']; ?>"
                                            class="img-12"
                                            src="img/eventtype/<?= $item['eventtype_id']; ?>.png"
                                        />
                                        <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                        </a>
                                        (<?= $item['event_minute']; ?>)
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td>
                        <table class="striped w100">
                            <?php foreach ($guest_event_array as $item) { ?>
                                <tr>
                                    <td>
                                        <img
                                            alt="<?= $item['eventtype_name']; ?>"
                                            class="img-12"
                                            src="img/eventtype/<?= $item['eventtype_id']; ?>.png"
                                        />
                                        <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                        </a>
                                        (<?= $item['event_minute']; ?>)
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Статистика матча</p>
            <table class="striped w100">
                <tr>
                    <th class="center w33">
                        <?php if (isset($game_array[0]['game_home_team_name'])) { ?>
                            <?= $game_array[0]['game_home_team_name']; ?>
                        <?php } else { ?>
                            <?= $game_array[0]['game_home_country_name']; ?>
                        <?php } ?>
                    </th>
                    <th class="center w33"></th>
                    <th class="center">
                        <?php if (isset($game_array[0]['game_guest_team_name'])) { ?>
                            <?= $game_array[0]['game_guest_team_name']; ?>
                        <?php } else { ?>
                            <?= $game_array[0]['game_guest_country_name']; ?>
                        <?php } ?>
                    </th>
                </tr>
                <tr>
                    <td class="center"><?= $game_array[0]['game_home_shot']; ?></td>
                    <td class="center">Удары</td>
                    <td class="center"><?= $game_array[0]['game_guest_shot']; ?></td>
                </tr>
                <tr>
                    <td class="center"><?= $game_array[0]['game_home_ontarget']; ?></td>
                    <td class="center">В створ</td>
                    <td class="center"><?= $game_array[0]['game_guest_ontarget']; ?></td>
                </tr>
                <tr>
                    <td class="center"><?= $game_array[0]['game_home_foul']; ?></td>
                    <td class="center">Фолы</td>
                    <td class="center"><?= $game_array[0]['game_guest_foul']; ?></td>
                </tr>
                <tr>
                    <td class="center"><?= $game_array[0]['game_home_yellow']; ?> (<?= $game_array[0]['game_home_red']; ?>)</td>
                    <td class="center">Желтые (красные) карточки</td>
                    <td class="center"><?= $game_array[0]['game_guest_yellow']; ?> (<?= $game_array[0]['game_guest_red']; ?>)</td>
                </tr>
                <tr>
                    <td class="center"><?= $game_array[0]['game_home_possession']; ?>%</td>
                    <td class="center">Владение</td>
                    <td class="center"><?= $game_array[0]['game_guest_possession']; ?>%</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">
                Статистика
                <?php if (isset($game_array[0]['game_home_team_name'])) { ?>
                    (<?= $game_array[0]['game_home_team_name']; ?>)
                <?php } else { ?>
                    (<?= $game_array[0]['game_home_country_name']; ?>)
                <?php } ?>
            </p>
            <table class="striped w100">
                <tr>
                    <th class="w5">№</th>
                    <th>Имя</th>
                    <th class="w10">Поз</th>
                    <th class="w10">Конд</th>
                    <th class="w10">Оцн</th>
                </tr>
                <?php foreach ($home_player_array as $item) { ?>
                    <tr>
                        <td class="center">
                            <?php if (isset($item['player_number'])) { ?>
                                <?= $item['player_number']; ?>
                            <?php } else { ?>
                                <?= $item['player_number_national']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['lineup_condition']; ?>%</td>
                        <td class="center"><?= $item['lineup_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">
                Статистика
                <?php if (isset($game_array[0]['game_guest_team_name'])) { ?>
                    (<?= $game_array[0]['game_guest_team_name']; ?>)
                <?php } else { ?>
                    (<?= $game_array[0]['game_guest_country_name']; ?>)
                <?php } ?>
            </p>
            <table class="striped w100">
                <tr>
                    <th class="w5">№</th>
                    <th>Имя</th>
                    <th class="w10">Поз</th>
                    <th class="w10">Конд</th>
                    <th class="w10">Оцн</th>
                </tr>
                <?php foreach ($guest_player_array as $item) { ?>
                    <tr>
                        <td class="center">
                            <?php if (isset($item['player_number'])) { ?>
                                <?= $item['player_number']; ?>
                            <?php } else { ?>
                                <?= $item['player_number_national']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['lineup_condition']; ?>%</td>
                        <td class="center"><?= $item['lineup_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>