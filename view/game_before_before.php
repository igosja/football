<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Погодные условия</p>
            <table class="striped w100">
                <tr>
                    <td class="center" rowspan="3">
                        <img alt="" class="img-20" src="img/weather/1.png" />
                        <br />
                        14<?= CELSIUS; ?>
                    </td>
                    <td>
                        <?= f_igosja_ufu_date($game_array[0]['shedule_date']); ?>,
                        <?= $game_array[0]['stadium_name']; ?>
                        (<?= $game_array[0]['city_name']; ?>)
                    </td>
                </tr>
                <tr>
                    <td><?= $game_array[0]['stadiumquality_name']; ?></td>
                </tr>
                <tr>
                    <td>Вместимость стадиона - <?= $game_array[0]['stadium_capacity']; ?></td>
                </tr>
            </table>
        </td>
        <td class="block-page w33" rowspan="2">
            <p class="header">Предыдущие матчи</p>
            <table class="striped w100">
                <tr>
                    <th>Дата</th>
                    <th colspan="5">Матч</th>
                </tr>
                <?php foreach ($last_array as $item) { ?>
                    <tr>
                        <td class="center w10"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="right w35">
                            <?= $item['home_name']; ?>
                        </td>
                        <td class="w1">
                            <img
                                alt=""
                                class="img-12"
                                src="img/team/12/<?= $item['game_home_team_id']; ?>.png"
                            />
                        </td>
                        <td class="center">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?= $item['game_home_score']; ?>:<?= $item['game_guest_score']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt=""
                                class="img-12"
                                src="img/team/12/<?= $item['game_guest_team_id']; ?>.png"
                            />
                        </td>
                        <td class="w35">
                            <?= $item['guest_name']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page" rowspan="3">
            <p class="header">Турнирная таблица</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">М</th>
                    <th colspan="2">Команда</th>
                    <th class="w10">О</th>
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
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['standing_point']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page w33">
            <p class="header">Судья</p>
            <h6>
                <p class="center">
                    <a href="referee_home_profile.php?num=<?= $game_array[0]['referee_id']; ?>">
                        <?= $game_array[0]['name_name']; ?>
                        <?= $game_array[0]['surname_name']; ?>
                    </a>
                </p>
            </h6>
            <table class="striped w100">
                <tr>
                    <td>Отработал матчей в этом сезоне</td>
                    <td class="right">
                        <?php if (isset($referee_array[0]['statisticreferee_game'])) { ?>
                            <?= $referee_array[0]['statisticreferee_game']; ?>
                        <?php } else { ?>
                            0
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Показал желтых карточек</td>
                    <td class="right">
                        <?php if (isset($referee_array[0]['statisticreferee_yellow'])) { ?>
                            <?= $referee_array[0]['statisticreferee_yellow']; ?>
                            ({($referee_array[0]['statisticreferee_yellow/$game_array[0]['statisticreferee_game)|round:1']; ?>/матч)
                        <?php } else { ?>
                            0
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Показал красных карточек</td>
                    <td class="right">
                        <?php if (isset($referee_array[0]['statisticreferee_red'])) { ?>
                            <?= $referee_array[0]['statisticreferee_red']; ?>
                            ({($referee_array[0]['statisticreferee_red/$game_array[0]['statisticreferee_game)|round:1']; ?>/матч)
                        <?php } else { ?>
                            0
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header"><?= $game_array[0]['game_home_team_name']; ?> (матчи)</p>
            <table class="striped w100">
                <tr>
                    <th class="w20">Дата</th>
                    <th>Соперник</th>
                    <th class="w15">Счет</th>
                </tr>
                <?php foreach ($home_latest_game_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td>
                            <img alt="" class="img-12" src="img/team/12/<?= $item['team_id']; ?>.png" />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header"><?= $game_array[0]['game_guest_team_name']; ?> (матчи)</p>
            <table class="striped w100">
                <tr>
                    <th class="w15">Дата</th>
                    <th>Соперник</th>
                    <th class="w15">Счет</th>
                </tr>
                <?php foreach ($guest_latest_game_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td>
                            <img alt="" class="img-12" src="img/team/12/<?= $item['team_id']; ?>.png" />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>