<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Итоги сезона</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2"><?php print $championship_array[0]['tournament_name']; ?></th>
                </tr>
                <tr>
                    <td class="w50">Победитель</td>
                    <td>
                        <img
                            alt="<?php print $championship_array[0]['team_name']; ?>"
                            class="img-12"
                            src="img/team/12/<?php print $championship_array[0]['team_id']; ?>.png"
                        />
                        <a href="team_team_review_profile.php?num=<?php print $championship_array[0]['team_id']; ?>">
                            <?php print $championship_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Лучший бомбардир</td>
                    <td>
                        <?php foreach ($championship_goal_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                            (<?php print $item['statisticplayer_goal']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший асистент</td>
                    <td>
                        <?php foreach ($championship_pass_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                            (<?php print $item['statisticplayer_pass_scoring']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучшая средняя оценка</td>
                    <td>
                        <?php foreach ($championship_mark_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                            (<?php print $item['mark']; ?>)
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2"><?php print $cup_array[0]['tournament_name']; ?></th>
                </tr>
                <tr>
                    <td class="w50">Победитель</td>
                    <td>
                        <?php foreach ($cup_array as $item) { ?>
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший бомбардир</td>
                    <td>
                        <?php foreach ($cup_goal_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                            (<?php print $item['statisticplayer_goal']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучший асистент</td>
                    <td>
                        <?php foreach ($cup_pass_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                            (<?php print $item['statisticplayer_pass_scoring']; ?>)
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Лучшая средняя оценка</td>
                    <td>
                        <?php foreach ($cup_mark_array as $item) { ?>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                            из команды
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                            (<?php print $item['mark']; ?>)
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Лига чемпионов - квалификация</th>
                </tr>
                <?php foreach ($champions_qualify_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td><?php print $item['stage_name']; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Лига чемпионов - достижения</th>
                </tr>
                <?php foreach ($champions_out_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td><?php print $item['stage_name']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>