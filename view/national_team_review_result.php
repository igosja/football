<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Итоги</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2"><?= $championship_array[0]['tournament_name']; ?> (прошлый сезон)</th>
                </tr>
                <tr>
                    <td class="w50">Победитель</td>
                    <td>
                        <img
                            alt="<?= $championship_array[0]['team_name']; ?>"
                            class="img-12"
                            src="img/team/12/<?= $championship_array[0]['team_id']; ?>.png"
                        />
                        <a href="team_team_review_profile.php?num=<?= $championship_array[0]['team_id']; ?>">
                            <?= $championship_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Лучший бомбардир</td>
                    <td>
                        <?php foreach ($championship_goal_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            (<?= $item['statisticplayer_goal']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший асистент</td>
                    <td>
                        <?php foreach ($championship_pass_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            (<?= $item['statisticplayer_pass_scoring']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучшая средняя оценка</td>
                    <td>
                        <?php foreach ($championship_mark_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            (<?= $item['mark']; ?>)
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2"><?= $cup_array[0]['tournament_name']; ?> (прошлый сезон)</th>
                </tr>
                <tr>
                    <td class="w50">Победитель</td>
                    <td>
                        <?php foreach ($cup_array as $item) { ?>
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший бомбардир</td>
                    <td>
                        <?php foreach ($cup_goal_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            (<?= $item['statisticplayer_goal']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший асистент</td>
                    <td>
                        <?php foreach ($cup_pass_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            (<?= $item['statisticplayer_pass_scoring']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучшая средняя оценка</td>
                    <td>
                        <?php foreach ($cup_mark_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            (<?= $item['mark']; ?>)
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Лига чемпионов - квалификация (этот сезон)</th>
                </tr>
                <?php foreach ($champions_qualify_group_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td>Групповой этап</td>
                    </tr>
                <?php } ?>
                <?php foreach ($champions_qualify_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td><?= $item['stage_name']; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Лига чемпионов - достижения (этот сезон)</th>
                </tr>
                <?php foreach ($champions_out_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td><?= $item['stage_name']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>