<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Прошлые победители</p>
            <table class="striped w100">
                <tr>
                    <th>Сезон</th>
                    <th colspan="2">Победитель</th>
                    <th colspan="2">Второй призер</th>
                </tr>
                <?php foreach ($winner_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['shedule_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['winner_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['winner_id']; ?>.png"
                            />
                        </td>
                        <td class="w40">
                            <a href="team_team_review_profile.php?num=<?= $item['winner_id']; ?>">
                                <?= $item['winner_name']; ?>
                                (<?= $item['winner_city']; ?>,
                                <?= $item['winner_country']; ?>)
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['looser_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['looser_id']; ?>.png"
                            />
                        </td>
                        <td class="w40">
                            <a href="team_team_review_profile.php?num=<?= $item['looser_id']; ?>">
                                <?= $item['looser_name']; ?>
                                (<?= $item['looser_city']; ?>,
                                <?= $item['looser_country']; ?>)
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>