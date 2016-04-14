<table class="block-table w100">
    <tr>
        <td class="block-page w20" rowspan="3">
            <p class="header">Данные по клубу</p>
            <table class="center">
                <tr>
                    <td>
                        <img
                            alt="<?= $team_array[0]['team_name']; ?>"
                            class="img-120"
                            src="img/team/120/<?= $num; ?>.png"
                        />
                    </td>
                </tr>
                <tr>
                    <td><h6><?= SPACE; ?></h6></td>
                </tr>
                <tr>
                    <td>
                        <img
                            alt="<?= $team_array[0]['tournament_name']; ?>"
                            class="img-50"
                            src="img/tournament/50/<?= $team_array[0]['tournament_id']; ?>.png"
                        />
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="tournament_review_profile.php?num=<?= $team_array[0]['tournament_id']; ?>">
                            <h6><?= $team_array[0]['tournament_name']; ?></h6>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img
                            alt="<?= $team_array[0]['country_name']; ?>"
                            class="img-12"
                            src="img/flag/12/<?= $team_array[0]['country_id']; ?>.png"
                        />
                        <a href="national_team_review_profile.php?num=<?= $team_array[0]['country_id']; ?>">
                            <?= $team_array[0]['country_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><h6><?= SPACE; ?></h6></td>
                </tr>
                <tr>
                    <td><h1><?= $team_array[0]['team_season_id']; ?></h1></td>
                </tr>
                <tr>
                    <td>Сезон основания</td>
                </tr>
            </table>
        </td>
        <td class="block-page w40">
            <p class="header">Команда</p>
            <table class="striped w100">
                <tr>
                    <td><?= $team_array[0]['team_name']; ?></td>
                    <td class="right">
                        <?= $team_array[0]['standing_place']; ?> в
                        <a href="tournament_review_profile.php?num=<?= $team_array[0]['tournament_id']; ?>">
                            <?= $team_array[0]['tournament_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Сыграно матчей</td>
                    <td class="right"><?= $count_game_array[0]['count_game']; ?></td>
                </tr>
                <tr>
                    <td>Лучший бомбардир</td>
                    <td class="right">
                        <?php if (isset($player_goal_array[0]['player_id'])) { ?>
                            <a href="player_home_profile.php?num=<?= $player_goal_array[0]['player_id']; ?>">
                                <?= $player_goal_array[0]['name_name']; ?> <?= $player_goal_array[0]['surname_name']; ?>
                            </a>
                            (<?= $player_goal_array[0]['goal']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший асистент</td>
                    <td class="right">
                        <?php if (isset($player_pass_array[0]['player_id'])) { ?>
                            <a href="player_home_profile.php?num=<?= $player_pass_array[0]['player_id']; ?>">
                                <?= $player_pass_array[0]['name_name']; ?> <?= $player_pass_array[0]['surname_name']; ?>
                            </a>
                            (<?= $player_pass_array[0]['pass']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Наибольшее число раз ИМ</td>
                    <td class="right">
                        <?php if (isset($player_best_array[0]['player_id'])) { ?>
                            <a href="player_home_profile.php?num=<?= $player_best_array[0]['player_id']; ?>">
                                <?= $player_best_array[0]['name_name']; ?> <?= $player_best_array[0]['surname_name']; ?>
                            </a>
                            (<?= $player_best_array[0]['best']; ?>)
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Следующий матч</p>
            <?php foreach ($nearest_game_array as $item) { ?>
                <table class="w100">
                    <tr>
                        <td class="center w50">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-90"
                                src="img/team/90/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <table class="striped w100">
                                <tr>
                                    <td>
                                        <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                            <?= $item['team_name']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= $item['tournament_name']; ?></td>
                                </tr>
                                <tr>
                                    <td><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                                </tr>
                                <tr>
                                    <td><a href="game_before_before.php?num=<?= $item['game_id']; ?>">Просмотр</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Ключевые должности</p>
            <table class="striped w100">
                <tr>
                    <td>Менеджер</td>
                    <td>
                        <a href="profile_home_home.php?num=<?= $team_array[0]['user_id']; ?>">
                            <?= $team_array[0]['user_login']; ?>
                        </a>
                    </td>
                    <td class="w1">
                        <img
                            alt="<?= $team_array[0]['user_country_name']; ?>"
                            class="img-12"
                            src="img/flag/12/<?= $team_array[0]['user_country_id']; ?>.png"
                        />
                    </td>
                    <td>
                        <a href="national_team_review_profile.php?num=<?= $team_array[0]['user_country_id']; ?>">
                            <?= $team_array[0]['user_country_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Капитан</td>
                    <td>
                        <a href="player_home_profile.php?num=<?= $team_array[0]['captain_id']; ?>">
                            <?= $team_array[0]['captain_name']; ?> <?= $team_array[0]['captain_surname']; ?>
                        </a>
                    </td>
                    <td>
                        <img
                            alt="<?= $team_array[0]['captain_country_name']; ?>"
                            class="img-12"
                            src="img/flag/12/<?= $team_array[0]['captain_country_id']; ?>.png"
                        />
                    </td>
                    <td>
                        <a href="national_team_review_profile.php?num=<?= $team_array[0]['captain_country_id']; ?>">
                            <?= $team_array[0]['captain_country_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Вице-капитан</td>
                    <td>
                        <a href="player_home_profile.php?num=<?= $team_array[0]['vicecaptain_id']; ?>">
                            <?= $team_array[0]['vicecaptain_name']; ?> <?= $team_array[0]['vicecaptain_surname']; ?>
                        </a>
                    </td>
                    <td>
                        <img
                            alt="<?= $team_array[0]['vicecaptain_country_name']; ?>"
                            class="img-12"
                            src="img/flag/12/<?= $team_array[0]['vicecaptain_country_id']; ?>.png"
                        />
                    </td>
                    <td>
                        <a href="national_team_review_profile.php?num=<?= $team_array[0]['vicecaptain_country_id']; ?>">
                            <?= $team_array[0]['vicecaptain_country_name']; ?>
                        </a>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page" rowspan="2">
            <table class="center w100">
                <p class="header">Результаты</p>
                <tr>
                    <?php foreach ($latest_game_array as $item) { ?>
                        <td class="w20">
                            <table class="w100">
                                <tr>
                                    <td><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if ($item['home_score'] > $item['guest_score']) { ?>
                                            (В)
                                        <?php } elseif ($item['home_score'] == $item['guest_score']) { ?>
                                            (Н)
                                        <?php } else { ?>
                                            (П)
                                        <?php } ?>
                                        <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                            <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?= SPACE; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img
                                            alt="<?= $item['team_name']; ?>"
                                            class="img-50"
                                            src="img/team/50/<?= $item['team_id']; ?>.png"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                            <?= $item['team_name']; ?>
                                        </a>
                                        <br />
                                        <?php if ($item['game_home_team_id'] == $num) { ?>
                                            (Д)
                                        <?php } else { ?>
                                            (Г)
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    <?php } ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Стадион</p>
            <table class="center w100">
                <tr>
                    <td class="w50"><h5><?= $team_array[0]['stadium_name']; ?></h5></td>
                    <td><h5><?= $team_array[0]['stadium_capacity']; ?></h5></td>
                </tr>
                <tr>
                    <td><?= $team_array[0]['city_name']; ?></td>
                    <td>Вместимость стадиона</td>
                </tr>
            </table>
        </td>
    </tr>
</table>