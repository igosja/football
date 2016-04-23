<table class="block-table w100">
    <tr>
        <td class="block-page w30">
            <p class="header">Встречи и результаты</p>
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
        </td>
    </tr>
</table>