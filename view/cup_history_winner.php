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
                <?php for ($i=0; $i<$count_winner; $i++) { ?>
                    <tr>
                        <td class="center"><?= $winner_array[$i]['cupparticipant_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $winner_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $winner_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w40">
                            <a href="team_team_review_profile.php?num=<?= $winner_array[$i]['team_id']; ?>">
                                <?= $winner_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $looser_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $looser_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w40">
                            <a href="team_team_review_profile.php?num=<?= $looser_array[$i]['team_id']; ?>">
                                <?= $looser_array[$i]['team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>