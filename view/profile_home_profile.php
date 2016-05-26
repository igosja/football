<table class="block-table w100">
    <tr>
        <td class="block-page w35">
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
                    <td>Сыграно матчей</td>
                    <td class="right"><?= $user_array[0]['statisticuser_game']; ?></td>
                </tr>
                <tr>
                    <td>Выиграно матчей</td>
                    <td class="right"><?= $user_array[0]['statisticuser_win']; ?></td>
                </tr>
            </table>
        </td>
        <td class="block-page w35" rowspan="2">
            <p class="header">Статистика карьеры</p>
            <table class="striped w100">
                <tr>
                    <td class="w25"></td>
                    <td class="w25"></td>
                    <td class="w25"></td>
                    <td class="w25"></td>
                </tr>
                <tr>
                    <td class="w25">Матчей</td>
                    <td class="right w25"><?= $user_array[0]['statisticuser_game']; ?></td>
                    <td class="w25">Забито</td>
                    <td class="right"><?= $user_array[0]['statisticuser_score']; ?></td>
                </tr>
                <tr>
                    <td>Выигрыши</td>
                    <td class="right"><?= $user_array[0]['statisticuser_win']; ?></td>
                    <td>Пропущено</td>
                    <td class="right"><?= $user_array[0]['statisticuser_pass']; ?></td>
                </tr>
                <tr>
                    <td>Ничьи</td>
                    <td class="right"><?= $user_array[0]['statisticuser_draw']; ?></td>
                    <td>Разница</td>
                    <td class="right"><?= $user_array[0]['statisticuser_score'] - $user_array[0]['statisticuser_pass']; ?></td>
                </tr>
                <tr>
                    <td>Поражения</td>
                    <td class="right"><?= $user_array[0]['statisticuser_loose']; ?></td>
                    <td>Побед</td>
                    <td class="right">
                        <?php if (0 == $user_array[0]['statisticuser_game']) { ?>
                        0
                        <?php } else { ?>
                        <?= round($user_array[0]['statisticuser_win'] / $user_array[0]['statisticuser_game'] * 100); ?>
                        <?php } ?> %
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page" rowspan="3">
            <p class="header">Краткое изложение карьеры</p>
            <div class="overflow overflow-profile">
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
        <td class="block-page w25" rowspan="2">
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
</table>