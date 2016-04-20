<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Матчи</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Дата</th>
                    <th colspan="2">Соперник</th>
                    <th class="w5">Счет</th>
                    <th colspan="2">Турнир</th>
                </tr>
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
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
                        <td class="center">
                            <?php if (1 == $item['game_played']) { ?>
                                <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                    <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="/img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
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