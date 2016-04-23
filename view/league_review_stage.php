<table class="block-table w100">
    <tr>
        <td class="block-page w30">
            <p class="header">Стадии</p>
            <form id="tournament-stage-form" method="GET" class="center">
                <input type="hidden" name="num" value="<?= $num; ?>">
                Стадия:
                <select id="tournament-stage-select" name="stage">
                    <?php foreach ($stage_array as $item) { ?>
                        <option value="<?= $item['stage_id']; ?>"
                            <?php if ($item['stage_id'] == $stage_id) { ?>
                                selected
                            <?php } ?>
                        >
                            <?= $item['stage_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
            <?php if (39 <= $stage_id) { ?>
                <table class="striped w100" id="tournament-game">
                    <?php foreach ($game_array as $item) { ?>
                        <tr>
                            <td class="w45 right">
                                <a href="team_team_review_profile.php?num=<?= $item['home_team_id']; ?>">
                                    <?= $item['home_team_name']; ?>
                                </a>
                            </td>
                            <td class="w1">
                                <img
                                    alt="<?= $item['home_team_name']; ?>"
                                    class="img-12"
                                    src="/img/team/12/<?= $item['home_team_id']; ?>.png"
                                />
                            </td>
                            <td class="center">
                                <a href="game_review_main.php?num=<?= $item['game_id_2']; ?>">
                                    <?php if (1 == $item['game_played_2']) { ?>
                                        <?= $item['home_score_2']; ?>:<?= $item['guest_score_2']; ?>
                                    <?php } ?>
                                </a>
                                <a href="game_review_main.php?num=<?= $item['game_id_1']; ?>">
                                    <?php if (1 == $item['game_played_1']) { ?>
                                        <?php if (isset($item['game_played_2'])) { ?>(<?php } ?><?= $item['home_score_1']; ?>:<?= $item['guest_score_1']; ?><?php if (isset($item['game_played_2'])) { ?>)<?php } ?>
                                    <?php } ?>
                                </a>
                            </td>
                            <td class="w1">
                                <img
                                    alt="<?= $item['guest_team_name']; ?>"
                                    class="img-12"
                                    src="/img/team/12/<?= $item['guest_team_id']; ?>.png"
                                />
                            </td>
                            <td class="w45">
                                <a href="team_team_review_profile.php?num=<?= $item['guest_team_id']; ?>">
                                    <?= $item['guest_team_name']; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <?php $group = 'A'; ?>
                <p class="center">Группа <?= $group; ?></p>
                <table class="w100 striped">
                    <tr>
                        <th class="w5">№</th>
                        <th colspan="2">Команда</th>
                        <th class="w5">И</th>
                        <th class="w5">В</th>
                        <th class="w5">Н</th>
                        <th class="w5">П</th>
                        <th class="w5">ГЗ</th>
                        <th class="w5">ГП</th>
                        <th class="w5">+/-</th>
                        <th class="w5">О</th>
                    </tr>
                <?php foreach ($league_array as $item) { ?>
                    <?php if ($group != $item['league_group']) { ?>
                        </table>
                        <p class="center">Группа <?= $item['league_group']; ?></p>
                        <table class="w100 striped">
                            <tr>
                                <th class="w5">№</th>
                                <th colspan="2">Команда</th>
                                <th class="w5">И</th>
                                <th class="w5">В</th>
                                <th class="w5">Н</th>
                                <th class="w5">П</th>
                                <th class="w5">ГЗ</th>
                                <th class="w5">ГП</th>
                                <th class="w5">+/-</th>
                                <th class="w5">О</th>
                            </tr>
                    <?php } ?>
                    <tr>
                        <td class="center"><?= $item['league_place']; ?></td>
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
                                (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                            </a>
                        </td>
                        <td class="center"><?= $item['league_game']; ?></td>
                        <td class="center"><?= $item['league_win']; ?></td>
                        <td class="center"><?= $item['league_draw']; ?></td>
                        <td class="center"><?= $item['league_loose']; ?></td>
                        <td class="center"><?= $item['league_score']; ?></td>
                        <td class="center"><?= $item['league_pass']; ?></td>
                        <td class="center"><?= $item['league_difference']; ?></td>
                        <td class="center"><strong><?= $item['league_point']; ?></strong></td>
                    </tr>
                    <?php $group = $item['league_group']; ?>
                <?php } ?>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>