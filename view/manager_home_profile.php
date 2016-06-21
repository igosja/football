<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Учетная запись</p>
            <table class="striped w100">
                <tr>
                    <td class="w50">Страна</td>
                    <td class="right">
                        <a href="national_team_review_profile.php?num=<?= $user_array[0]['country_id']; ?>">
                            <?= $user_array[0]['country_name']; ?>
                        </a>
                        <img
                            alt="<?= $user_array[0]['country_name']; ?>"
                            class="img-12"
                            src="/img/flag/12/<?= $user_array[0]['country_id']; ?>.png"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Репутация</td>
                    <td class="right"><?= f_igosja_five_star($user_array[0]['user_reputation'], 12); ?></td>
                </tr>
                <tr>
                    <td>Последний визит</td>
                    <td class="right"><?= f_igosja_ufu_last_visit($user_array[0]['user_last_visit']); ?></td>
                </tr>
                <tr>
                    <td>Дата регистрации</td>
                    <td class="right"><?= f_igosja_ufu_date($user_array[0]['user_registration_date']); ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php if (isset($authorization_id) && $authorization_id != $num_get) { ?>
                            <a href="profile_news_outbox.php?answer=<?= $num_get; ?>" class="button-link">
                                <button>
                                    Сообщение
                                </button>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page" rowspan="2">
            <p class="header">Краткое изложение карьеры</p>
            <div class="overflow overflow-manager">
                <table class="striped w100">
                    <?php for ($i=0; $i<$count_career; $i++) { ?>
                        <tr>
                            <td class="w1" rowspan="3">
                                <img
                                    alt="<?= $career_array[$i]['team_name']; ?>"
                                    class="img-50"
                                    src="/img/team/50/<?= $career_array[$i]['team_id']; ?>.png"
                                />
                            </td>
                            <td><?= $career_array[$i]['team_name']; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <img
                                    alt="<?= $career_array[$i]['country_name']; ?>"
                                    class="img-12"
                                    src="/img/flag/12/<?= $career_array[$i]['country_id']; ?>.png"
                                />
                                <?= $career_array[$i]['country_name']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Сезоны: <?= $career_array[$i]['history_season_id']; ?>
                                -
                                <?php if (isset($career_array[$i+1]['history_season_id'])) { ?>
                                    <?= $career_array[$i+1]['history_season_id']; ?>
                                <?php } else { ?>
                                    н.в.
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td class="block-page w25">
            <p class="header">Тактика</p>
            <table class="striped w100">
                <tr>
                    <td class="w50">Любимая схема</td>
                    <td><?= $user_array[0]['formation_name']; ?></td>
                </tr>
                <tr>
                    <td>Стиль игры</td>
                    <td><?= $user_array[0]['gamestyle_name']; ?></td>
                </tr>
                <tr>
                    <td>Настрой на игру</td>
                    <td><?= $user_array[0]['gamemood_name']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Статистика</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Статистика менеджера</th>
                    <th colspan="2">Статистика игрока</th>
                </tr>
                <tr>
                    <td class="w35">Количество клубных постов в карьере</td>
                    <td class="center w15"><?= $summary_array[0]['user_team']; ?></td>
                    <td class="w35">Число купленных игроков</td>
                    <td class="center w15"><?= $summary_array[0]['user_buy_player']; ?></td>
                </tr>
                <tr>
                    <td>Количество сборных постов в карьере</td>
                    <td class="center"><?= $summary_array[0]['user_national']; ?></td>
                    <td>Общая стоимость купленных игроков</td>
                    <td class="center"><?= f_igosja_money($summary_array[0]['user_buy_price']); ?></td>
                </tr>
                <tr>
                    <td>Наибольшее время в клубе</td>
                    <td class="center"><?= $summary_array[0]['user_team_time_max']; ?> дн.</td>
                    <td>Количество проданных игроков</td>
                    <td class="center"><?= $summary_array[0]['user_sell_player']; ?></td>
                </tr>
                <tr>
                    <td>Число трофеев</td>
                    <td class="center"><?= $summary_array[0]['user_trophy']; ?></td>
                    <td>Общая стоимость проданных игроков</td>
                    <td class="center"><?= f_igosja_money($summary_array[0]['user_sell_price']); ?></td>
                </tr>
                <tr>
                    <td>Общее игровое время</td>
                    <td class="center"><?= $career_statistic_array[0]['day']; ?> дн.</td>
                    <td>Наибольшая потраченная сумма</td>
                    <td class="center"><?= f_igosja_money($summary_array[0]['user_sell_max']); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Наибольшая полученная сумма</td>
                    <td class="center"><?= f_igosja_money($summary_array[0]['user_buy_max']); ?></td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="4">Статистика карьеры</th>
                </tr>
                <tr>
                    <td class="w35">Сыграно матчей</td>
                    <td class="center w15"><?= $career_statistic_array[0]['game']; ?></td>
                    <td class="w35">Мячей забито</td>
                    <td class="center w15"><?= $career_statistic_array[0]['score']; ?></td>
                </tr>
                <tr>
                    <td>Побед</td>
                    <td class="center"><?= $career_statistic_array[0]['win']; ?></td>
                    <td>Мячей пропущено</td>
                    <td class="center"><?= $career_statistic_array[0]['pass']; ?></td>
                </tr>
                <tr>
                    <td>Ничьих</td>
                    <td class="center"><?= $career_statistic_array[0]['draw']; ?></td>
                    <td>Разница мячей</td>
                    <td class="center"><?= $career_statistic_array[0]['score'] - $career_statistic_array[0]['pass']; ?></td>
                </tr>
                <tr>
                    <td>Поражений</td>
                    <td class="center"><?= $career_statistic_array[0]['loose']; ?></td>
                    <td>Процент побед</td>
                    <td class="center">
                        <?php

                        if (0 == $career_statistic_array[0]['game'])
                        {
                            print 0;
                        }
                        else
                        {
                            print round($career_statistic_array[0]['win'] / $career_statistic_array[0]['game'] * 100);
                        }

                        ?> %
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Достижения</p>
            <table class="w100">
                <tr>
                    <td>
                        <table class="striped w100">
                            <tr>
                                <th class="w10">Сезон</th>
                                <th class="w10">Место</th>
                                <th colspan="2">Команда</th>
                                <th colspan="2">Турнир</th>
                            </tr>
                            <?php foreach ($progress_array as $item) { ?>
                                <tr>
                                    <td class="center"><?= $item['season_id']; ?></td>
                                    <td class="center"><?= $item['standing_place']; ?></td>
                                    <?php if (isset($item['team_id'])) { ?>
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
                                    <?php } else { ?>
                                        <td class="w1">
                                            <img
                                                alt="<?= $item['country_name']; ?>"
                                                class="img-12"
                                                src="/img/flag/12/<?= $item['country_id']; ?>.png"
                                            />
                                        </td>
                                        <td>
                                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                                <?= $item['country_name']; ?>
                                            </a>
                                        </td>
                                    <?php } ?>
                                    <td class="w1">
                                        <img
                                            alt="<?= $item['tournament_name']; ?>"
                                            class="img-12"
                                            src="/img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                        />
                                    </td>
                                    <td class="w35">
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
        </td>
    </tr>
</table>