<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Календарь</p>
            <table class="striped w100">
                <?php foreach ($shedule_array as $item) { ?>
                    <tr>
                        <td class="center w10"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="w1">
                            <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                Д
                            <?php } else { ?>
                                Г
                            <?php } ?>
                        </td>
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
                        <td class="right">
                            <?php if (1 == $item['game_played']) { ?>
                                <a href="game_review_main.php?num=<?= $item['game_id']; ?>">
                                    <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>