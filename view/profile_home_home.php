<?php if ($authorization_team_id) { ?>
    <table class="block-table w100">
        <tr>
            <td class="block-page w50" colspan="2">
                <p class="header">Следующий матч</p>
                <table class="center w100">
                    <tr>
                        <?php foreach ($next_array as $item) { ?>
                            <td class="w30">
                                <img
                                    alt="<?= $item['home_name']; ?>"
                                    class="img-120"
                                    src="img/team/120/<?= $item['home_id']; ?>.png"
                                />
                            </td>
                            <td class="w30">
                                <img
                                    alt="<?= $item['guest_name']; ?>"
                                    class="img-120"
                                    src="img/team/120/<?= $item['guest_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <table class="left vcenter w100">
                                    <tr>
                                        <td class="h20">
                                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                                <?= $item['tournament_name']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h20">
                                            <a href="team_team_review_profile.php?num=<?= $item['home_id']; ?>">
                                                <?= $item['home_name']; ?>
                                            </a>
                                            против
                                            <a href="team_team_review_profile.php?num=<?= $item['guest_id']; ?>">
                                                <?= $item['guest_name']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h20"><?= $item['stadium_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="h20">
                                            <img
                                                alt="<?= $item['weather_name']; ?>"
                                                class="img-12"
                                                title="<?= $item['weather_name']; ?>"
                                                src="/img/weather/12/<?= $item['weather_id']; ?>.png" 
                                            />
                                            <?= $item['game_temperature']; ?> <?= CELSIUS; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        <?php } ?>
                    </tr>
                </table>
                <table class="striped w100">
                    <?php foreach ($latest_array as $item) { ?>
                        <tr>
                            <td class="center w10"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                            <td class="w1">
                                <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                    Д
                                <?php } else { ?>
                                    Г
                                <?php } ?>
                            </td>
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
                            <td class="right">
                                <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                    <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($nearest_array as $item) { ?>
                        <tr>
                            <td class="center w10"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                            <td class="w1">
                                <?php if (isset($item['game_home_team_id'])) { ?>
                                    <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                        Д
                                    <?php } else { ?>
                                        Г
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if ($item['game_home_country_id'] == $authorization_team_id) { ?>
                                        Д
                                    <?php } else { ?>
                                        Г
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td class="w1">
                                <?php if (isset($item['game_home_team_id'])) { ?>
                                    <img
                                        alt="<?= $item['team_name']; ?>"
                                        class="img-12"
                                        src="img/team/12/<?= $item['team_id']; ?>.png"
                                    />
                                <?php } else { ?>
                                    <img
                                        alt="<?= $item['country_name']; ?>"
                                        class="img-12"
                                        src="img/flag/12/<?= $item['country_id']; ?>.png"
                                    />
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (isset($item['game_home_team_id'])) { ?>
                                    <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                        <?= $item['team_name']; ?>
                                    </a>
                                <?php } else { ?>
                                    <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                        <?= $item['country_name']; ?>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="right">
                                <?php if (isset($item['game_home_team_id'])) { ?>
                                    <a href="team_lineup_tactic_review.php?num=<?= $authorization_team_id; ?>&game=<?= $item['game_id']; ?>">
                                <?php } else { ?>
                                    <a href="national_lineup_tactic_review.php?num=<?= $authorization_country_id; ?>&game=<?= $item['game_id']; ?>">
                                <?php } ?>
                                    <?php if ($item['lineupmain_id']) { ?>
                                        Редактировать
                                    <?php } else { ?>
                                        Отправить
                                    <?php } ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td class="block-page w25">
                <p class="header">Таблица лиги</p>
                <table class="striped w100">
                    <tr>
                        <th>№</th>
                        <th colspan="2">Команда</th>
                        <th>О</th>
                    </tr>
                    <?php foreach ($standing_array as $item) { ?>
                        <tr>
                            <td class="center"><?= $item['standing_place']; ?></td>
                            <td class="w1">
                                <img
                                    alt="<?= $item['team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?= $item['team_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>"
                                    <?php if ($authorization_team_id == $item['team_id']) { ?>
                                        class="blue"
                                    <?php } ?>
                                >
                                    <?= $item['team_name']; ?>
                                </a>
                            </td>
                            <td class="center"><?= $item['standing_point']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td class="block-page w25">
                <p class="header">Финансы</p>
                <?php foreach ($finance_array as $item) { ?>
                    <table class="striped w100">
                        <tr>
                            <td>Баланс</td>
                            <td class="right"><?= f_igosja_money($item['team_finance']); ?></td>
                        </tr>
                        <tr>
                            <td>Прибыль текущего сезона</td>
                            <td class="right"><?= f_igosja_money($item['profit']); ?></td>
                        </tr>
                        <tr>
                            <td>Зарплата игроков</td>
                            <td class="right"><?= f_igosja_money($item['total_player_salary']); ?></td>
                        </tr>
                        <tr>
                            <td>Средняя зарплата</td>
                            <td class="right"><?= f_igosja_money($item['average_player_salary']); ?></td>
                        </tr>
                        <tr>
                            <td>Зарплата персонала</td>
                            <td class="right"><?= f_igosja_money($item['total_staff_salary']); ?></td>
                        </tr>
                        <tr>
                            <td>Средняя зарплата</td>
                            <td class="right"><?= f_igosja_money($item['average_staff_salary']); ?></td>
                        </tr>
                    </table>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="block-page w25">
                <p class="header">Статистика команды</p>
                <?php foreach ($statistic_team_array as $item) { ?>
                    <table class="striped w100">
                        <tr>
                            <td class="center" colspan="2">
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="img-12"
                                    src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                                <a href="tournament_review_profile?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Сыграно матчей</td>
                            <td class="right"><?= $item['statisticteam_game']; ?></td>
                        </tr>
                        <tr>
                            <td>Забито голов</td>
                            <td class="right"><?= $item['statisticteam_goal']; ?></td>
                        </tr>
                        <tr>
                            <td>Пропушено голов</td>
                            <td class="right"><?= $item['statisticteam_pass']; ?></td>
                        </tr>
                        <tr>
                            <td>Желтые карточки</td>
                            <td class="right"><?= $item['statisticteam_yellow']; ?></td>
                        </tr>
                        <tr>
                            <td>Красные карточки</td>
                            <td class="right"><?= $item['statisticteam_red']; ?></td>
                        </tr>
                        <tr>
                            <td>Средняя посещаемость</td>
                            <td class="right">
                                <?= $item['statisticteam_visitor']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Аншлаги</td>
                            <td class="right"><?= $item['statisticteam_full_house']; ?></td>
                        </tr>
                    </table>
                <?php } ?>
            </td>
            <td class="block-page">
                <p class="header">Статистика игрока</p>
                <?php foreach ($statistic_player_array as $item) { ?>
                    <table class="striped w100">
                        <tr>
                            <td class="center" colspan="2">
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="img-12"
                                    src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                                <a href="tournament_review_profile?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Лучший бомбардир</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?= $item['goal_player_id']; ?>">
                                    <?= $item['goal_name']; ?> <?= $item['goal_surname']; ?>
                                </a>
                                (<?= $item['statisticplayer_goal']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Лучший ассистент</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?= $item['pass_player_id']; ?>">
                                    <?= $item['pass_name']; ?> <?= $item['pass_surname']; ?>
                                </a>
                                (<?= $item['statisticplayer_pass_scoring']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Игрок матча</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?= $item['best_player_id']; ?>">
                                    <?= $item['best_name']; ?> <?= $item['best_surname']; ?>
                                </a>
                                (<?= $item['statisticplayer_best']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Сыграно матчей</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?= $item['game_player_id']; ?>">
                                    <?= $item['game_name']; ?> <?= $item['game_surname']; ?>
                                </a>
                                (<?= $item['statisticplayer_game']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Желтых карточек</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?= $item['yellow_player_id']; ?>">
                                    <?= $item['yellow_name']; ?> <?= $item['yellow_surname']; ?>
                                </a>
                                (<?= $item['statisticplayer_yellow']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Красных карточек</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?= $item['red_player_id']; ?>">
                                    <?= $item['red_name']; ?> <?= $item['red_surname']; ?>
                                </a>
                                (<?= $item['statisticplayer_red']; ?>)
                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </td>
            <td class="block-page w25">
                <p class="header">Травмы</p>
                <table class="striped w100">
                    <?php foreach ($injury_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td><?= $item['injurytype_name']; ?></td>
                            <td class="right"><?= $item['day']; ?> дн</td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td class="block-page">
                <p class="header">Турниры команды</p>
                <table class="striped w100">
                    <?php foreach ($tournament_championship_array as $item) { ?>
                        <tr>
                            <td class="w1">
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="w12"
                                    src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="tournament_review_profile?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            </td>
                            <td class="right w25"><?= $item['standing_place']; ?></td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($tournament_cup_array as $item) { ?>
                        <tr>
                            <td class="w1">
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="w12"
                                    src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="tournament_review_profile?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            </td>
                            <td class="right w25"><?= $item['stage_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($tournament_league_array as $item) { ?>
                        <tr>
                            <td class="w1">
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="w12"
                                    src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="tournament_review_profile?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            </td>
                            <td class="right w25"><?= $item['stage_name']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
<?php } else { ?>
    <table class="block-table w100">
        <tr>
            <td class="block-page">
                <p class="header">Доступные вакансии</p>
                <form method="POST">
                    <table class="striped w100">
                        <tr>
                            <th class="w1"></th>
                            <th colspan="2">Команда</th>
                            <th class="w1">Страна</th>
                            <th colspan="2">Дивизион</th>
                            <th class="w10">Финансы</th>
                        </tr>
                        <?php foreach ($team_array as $item) { ?>
                            <tr>
                                <td>
                                    <input name="data[team]" value="<?= $item['team_id']; ?>" type="radio" />
                                </td>
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
                                <td class="center">
                                    <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                        <img
                                            alt="<?= $item['country_name']; ?>"
                                            class="img-12"
                                            src="img/flag/12/<?= $item['country_id']; ?>.png"
                                        />
                                    </a>
                                </td>
                                <td class="w1">
                                    <img
                                        alt="<?= $item['tournament_name']; ?>"
                                        class="img-12"
                                        src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                    />
                                </td>
                                <td class="w25">
                                    <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                        <?= $item['tournament_name']; ?>
                                    </a>
                                </td>
                                <td class="right"><?= f_igosja_money($item['team_finance']); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <p class="center">
                        <input type="submit" value="Взять команду под управление" />
                    </p>
                </form>
            </td>
        </tr>
    </table>
<?php } ?>