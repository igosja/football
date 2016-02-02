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
                                    alt="<?php print $item['home_name']; ?>"
                                    class="img-120"
                                    src="img/team/120/<?php print $item['home_id']; ?>.png"
                                />
                            </td>
                            <td class="w30">
                                <img
                                    alt="<?php print $item['guest_name']; ?>"
                                    class="img-120"
                                    src="img/team/120/<?php print $item['guest_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <table class="left vcenter w100">
                                    <tr>
                                        <td class="h20">
                                            <a href="tournament_review_profile.php?num=<?php print $item['tournament_id']; ?>">
                                                <?php print $item['tournament_name']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h20">
                                            <a href="team_team_review_profile.php?num=<?php print $item['home_id']; ?>">
                                                <?php print $item['home_name']; ?>
                                            </a>
                                            против
                                            <a href="team_team_review_profile.php?num=<?php print $item['guest_id']; ?>">
                                                <?php print $item['guest_name']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h20"><?php print $item['stadium_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="h20">
                                            <img
                                                alt="<?php print $item['weather_name']; ?>"
                                                class="img-12"
                                                src="/img/weather/12/<?php print $item['weather_id']; ?>.png" 
                                            />
                                            <?php print $item['game_temperature']; ?> <?php print CELSIUS; ?>
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
                            <td class="center w10"><?php print f_igosja_ufu_date($item['shedule_date']); ?></td>
                            <td class="w1">
                                <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                    Д
                                <?php } else { ?>
                                    Г
                                <?php } ?>
                            </td>
                            <td class="w1">
                                <img
                                    alt="<?php print $item['team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?php print $item['team_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                    <?php print $item['team_name']; ?>
                                </a>
                            </td>
                            <td class="right">
                                <a href="game_review_main.php?num=<?php print $item['game_id']; ?>">
                                    <?php print $item['home_score']; ?>:<?php print $item['guest_score']; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($nearest_array as $item) { ?>
                        <tr>
                            <td class="center w10"><?php print f_igosja_ufu_date($item['shedule_date']); ?></td>
                            <td class="w1">
                                <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                    Д
                                <?php } else { ?>
                                    Г
                                <?php } ?>
                            </td>
                            <td class="w1">
                                <img
                                    alt="<?php print $item['team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?php print $item['team_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                    <?php print $item['team_name']; ?>
                                </a>
                            </td>
                            <td class="right">
                                <a href="team_lineup_tactic_review.php?num=<?php print $authorization_team_id; ?>&game=<?php print $item['game_id']; ?>">
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
                            <td class="center"><?php print $item['standing_place']; ?></td>
                            <td class="w1">
                                <img
                                    alt="<?php print $item['team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?php print $item['team_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>"
                                    <?php if ($authorization_team_id == $item['team_id']) { ?>
                                        class="blue"
                                    <?php } ?>
                                >
                                    <?php print $item['team_name']; ?>
                                </a>
                            </td>
                            <td class="center"><?php print $item['standing_point']; ?></td>
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
                            <td class="right"><?php print f_igosja_money($item['team_finance']); ?></td>
                        </tr>
                        <tr>
                            <td>Прибыль текущего сезона</td>
                            <td class="right"><?php print f_igosja_money($item['profit']); ?></td>
                        </tr>
                        <tr>
                            <td>Зарплата игроков</td>
                            <td class="right"><?php print f_igosja_money($item['total_player_salary']); ?></td>
                        </tr>
                        <tr>
                            <td>Средняя зарплата</td>
                            <td class="right"><?php print f_igosja_money($item['average_player_salary']); ?></td>
                        </tr>
                        <tr>
                            <td>Зарплата персонала</td>
                            <td class="right"><?php print f_igosja_money($item['total_staff_salary']); ?></td>
                        </tr>
                        <tr>
                            <td>Средняя зарплата</td>
                            <td class="right"><?php print f_igosja_money($item['average_staff_salary']); ?></td>
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
                                    alt="<?php print $item['tournament_name']; ?>"
                                    class="img-12"
                                    src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                                />
                                <a href="tournament_review_profile?num=<?php print $item['tournament_id']; ?>">
                                    <?php print $item['tournament_name']; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Сыграно матчей</td>
                            <td class="right"><?php print $item['statisticteam_game']; ?></td>
                        </tr>
                        <tr>
                            <td>Забито голов</td>
                            <td class="right"><?php print $item['statisticteam_goal']; ?></td>
                        </tr>
                        <tr>
                            <td>Пропушено голов</td>
                            <td class="right"><?php print $item['statisticteam_pass']; ?></td>
                        </tr>
                        <tr>
                            <td>Желтые карточки</td>
                            <td class="right"><?php print $item['statisticteam_yellow']; ?></td>
                        </tr>
                        <tr>
                            <td>Красные карточки</td>
                            <td class="right"><?php print $item['statisticteam_red']; ?></td>
                        </tr>
                        <tr>
                            <td>Средняя посещаемость</td>
                            <td class="right">
                                <?php print $item['statisticteam_visitor']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Аншлаги</td>
                            <td class="right"><?php print $item['statisticteam_full_house']; ?></td>
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
                                    alt="<?php print $item['tournament_name']; ?>"
                                    class="img-12"
                                    src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                                />
                                <a href="tournament_review_profile?num=<?php print $item['tournament_id']; ?>">
                                    <?php print $item['tournament_name']; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Лучший бомбардир</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?php print $item['goal_player_id']; ?>">
                                    <?php print $item['goal_name']; ?> <?php print $item['goal_surname']; ?>
                                </a>
                                (<?php print $item['statisticplayer_goal']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Лучший ассистент</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?php print $item['pass_player_id']; ?>">
                                    <?php print $item['pass_name']; ?> <?php print $item['pass_surname']; ?>
                                </a>
                                (<?php print $item['statisticplayer_pass_scoring']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Игрок матча</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?php print $item['best_player_id']; ?>">
                                    <?php print $item['best_name']; ?> <?php print $item['best_surname']; ?>
                                </a>
                                (<?php print $item['statisticplayer_best']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Сыграно матчей</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?php print $item['game_player_id']; ?>">
                                    <?php print $item['game_name']; ?> <?php print $item['game_surname']; ?>
                                </a>
                                (<?php print $item['statisticplayer_game']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Желтых карточек</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?php print $item['yellow_player_id']; ?>">
                                    <?php print $item['yellow_name']; ?> <?php print $item['yellow_surname']; ?>
                                </a>
                                (<?php print $item['statisticplayer_yellow']; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td>Красных карточек</td>
                            <td class="right">
                                <a href="player_home_profile.php?num=<?php print $item['red_player_id']; ?>">
                                    <?php print $item['red_name']; ?> <?php print $item['red_surname']; ?>
                                </a>
                                (<?php print $item['statisticplayer_red']; ?>)
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
                                <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                    <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                                </a>
                            </td>
                            <td><?php print $item['injurytype_name']; ?></td>
                            <td class="right"><?php print $item['day']; ?> дн</td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td class="block-page">
                <p class="header">Турниры команды</p>
                <table class="striped w100">
                    <?php foreach ($tournament_array as $item) { ?>
                        <tr>
                            <td class="w1">
                                <img
                                    alt="<?php print $item['tournament_name']; ?>"
                                    class="w12"
                                    src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="tournament_review_profile?num=<?php print $item['tournament_id']; ?>">
                                    <?php print $item['tournament_name']; ?>
                                </a>
                            </td>
                            <td class="right w25"><?php print $item['standing_place']; ?></td>
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
                                    <input name="data[team]" value="<?php print $item['team_id']; ?>" type="radio" />
                                </td>
                                <td class="w1">
                                    <img
                                        alt="<?php print $item['team_name']; ?>"
                                        class="img-12"
                                        src="img/team/12/<?php print $item['team_id']; ?>.png"
                                    />
                                </td>
                                <td>
                                    <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                        <?php print $item['team_name']; ?>
                                    </a>
                                </td>
                                <td class="center">
                                    <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                        <img
                                            alt="<?php print $item['country_name']; ?>"
                                            class="img-12"
                                            src="img/flag/12/<?php print $item['country_id']; ?>.png"
                                        />
                                    </a>
                                </td>
                                <td class="w1">
                                    <img
                                        alt="<?php print $item['tournament_name']; ?>"
                                        class="img-12"
                                        src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                                    />
                                </td>
                                <td class="w25">
                                    <a href="tournament_review_profile.php?num=<?php print $item['tournament_id']; ?>">
                                        <?php print $item['tournament_name']; ?>
                                    </a>
                                </td>
                                <td class="right"><?php print f_igosja_money($item['team_finance']); ?></td>
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