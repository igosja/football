<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Игры</p>
            <table class="striped w100">
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_game']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w33">
            <p class="header">Победы</p>
            <table class="striped w100">
                <?php foreach ($win_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_win']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Лучший игрок матча</p>
            <table class="striped w100">
                <?php foreach ($best_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_best']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Голы</p>
            <table class="striped w100">
                <?php foreach ($goal_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_goal']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Голевые передачи</p>
            <table class="striped w100">
                <?php foreach ($pass_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_pass_scoring']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Процент ударов в створ</p>
            <table class="striped w100">
                <?php foreach ($shot_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_shot']; ?>%</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Красные карточки</p>
            <table class="striped w100">
                <?php foreach ($red_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_red']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Желтые карточки</p>
            <table class="striped w100">
                <?php foreach ($yellow_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_yellow']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Перодоленное расстояние (км)</p>
            <table class="striped w100">
                <?php foreach ($distance_array as $item) { ?>
                    <tr>
                        <td class="w50">
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center w10"><?= $item['statisticplayer_distance']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>