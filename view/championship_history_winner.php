<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Прошлые победители</p>
            <table class="striped w100">
                <tr>
                    <th>Сезон</th>
                    <th colspan="2">Победитель</th>
                    <th colspan="2">Второй призер</th>
                    <th colspan="2">Третий призер</th>
                </tr>
                <?php for ($i=0; $i<$count_first; $i++) { ?>
                    <tr>
                        <td class="center"><?= $first_array[$i]['standing_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $first_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $first_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="team_team_review_profile.php?num=<?= $first_array[$i]['team_id']; ?>">
                                <?= $first_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $second_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $second_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="team_team_review_profile.php?num=<?= $second_array[$i]['team_id']; ?>">
                                <?= $second_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $third_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $third_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="team_team_review_profile.php?num=<?= $third_array[$i]['team_id']; ?>">
                                <?= $third_array[$i]['team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>