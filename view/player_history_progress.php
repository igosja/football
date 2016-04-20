<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Достижения</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Сезон</th>
                    <th colspan="2">Команда</th>
                    <th colspan="2">Турнир</th>
                    <th class="w10">Место</th>
                </tr>
                <?php foreach ($trophy_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['season_id']; ?></td>
                        <?php if (isset($item['team_id'])) { ?>
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
                        <?php } else { ?>
                            <td class="w1">
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    class="img-12"
                                    src="/img/flag/12/<?= $item['country_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                    <?= $item['country_name']; ?>
                                </a>
                            </td>
                        <?php } ?>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="/img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w35">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['standing_place']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>