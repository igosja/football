<table class="block-table w100">
    <tr>
        <td rowspan="2" class="block-page">
            <p class="header">Турнирная таблица</p>
            <table class="striped w100">
                <tr>
                    <th class="w8">№</th>
                    <th colspan="2">Команда</th>
                    <th class="w8">И</th>
                    <th class="w8">В</th>
                    <th class="w8">Н</th>
                    <th class="w8">П</th>
                    <th class="w8">О</th>
                </tr>
                <?php foreach ($standing_array as $item) { ?>
                    <tr <?php if (isset($authorization_team_id) && $authorization_team_id == $item['team_id']) { ?>class="current"<?php } ?>>
                        <td class="center"><?= $item['standing_place']; ?></td>
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
                        <td class="center"><?= $item['standing_game']; ?></td>
                        <td class="center"><?= $item['standing_win']; ?></td>
                        <td class="center"><?= $item['standing_draw']; ?></td>
                        <td class="center"><?= $item['standing_loose']; ?></td>
                        <td class="center"><?= $item['standing_point']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w35" id="game-block">
            <p class="header">Матчи</p>
            <table class="center striped vcenter">
                <tr>
                    <td>
                        <img
                            alt="Предыдущие"
                            class="img-12"
                            data-tournament="<?= $num; ?>"
                            data-shedule="<?= $game_array[0]['shedule_id']; ?>"
                            id="tournament-game-prev"
                            src="/img/arrow/left.png"
                        />
                    </td>
                    <td id="shedule-date">
                        <?= $game_array[0]['shedule_day']; ?>,
                        <?= date('d.m.Y', strtotime($game_array[0]['shedule_date'])); ?>
                    </td>
                    <td>
                        <img
                            alt="Следующие"
                            class="img-12"
                            data-tournament="<?= $num; ?>"
                            data-shedule="<?= $game_array[0]['shedule_id']; ?>"
                            id="tournament-game-next"
                            src="/img/arrow/right.png"
                        />
                    </td>
                </tr>
            </table>
            <table class="striped w100" id="tournament-game">
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td class="right w45">
                            <a href="team_team_review_profile.php?num=<?= $item['game_home_team_id']; ?>">
                                <?= $item['home_team_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                <?php if (1 == $item['game_played']) { ?>
                                    <?= $item['game_home_score']; ?>:<?= $item['game_guest_score']; ?>
                                <?php } ?>
                            </a>
                        </td>
                        <td class="w45">
                            <a href="team_team_review_profile.php?num=<?= $item['game_guest_team_id']; ?>">
                                <?= $item['guest_team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w30">
            <p class="header">Предыдущие победители</p>
            <table class="striped w100">
                <?php foreach ($winner_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-50"
                                src="/img/team/50/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <h6>
                                <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                    <?= $item['team_name']; ?>
                                </a>
                            </h6>
                        </td>
                        <td>
                            <h6>
                                <?= $item['standing_season_id']; ?>
                            </h6>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page" colspan="3">
            <p class="header">Статистика</p>
            <table class="w100">
                <tr>
                    <td class="w33">
                        <table class="striped w100">
                            <tr>
                                <th colspan="2">Лучшие бомбардиры</th>
                            </tr>
                            <?php foreach ($player_goal_array as $item) { ?>
                                <tr>
                                    <td>
                                        <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                        </a>
                                    </td>
                                    <td class="center"><?= $item['statisticplayer_goal']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td class="w33">
                        <table class="striped w100">
                            <tr>
                                <th colspan="2">Лучшие асистенты</th>
                            </tr>
                            <?php foreach ($player_pass_array as $item) { ?>
                                <tr>
                                    <td>
                                        <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                        </a>
                                    </td>
                                    <td class="center"><?= $item['statisticplayer_pass_scoring']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td class="w33">
                        <table class="striped w100">
                            <tr>
                                <th colspan="2">Средняя оценка</th>
                            </tr>
                            <?php foreach ($player_mark_array as $item) { ?>
                                <tr>
                                    <td>
                                        <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                        </a>
                                    </td>
                                    <td class="center"><?= $item['statisticplayer_mark']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>