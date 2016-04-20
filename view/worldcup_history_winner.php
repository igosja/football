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
                        <td class="center"><?= $first_array[$i]['worldcup_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $first_array[$i]['country_name']; ?>"
                                class="img-12"
                                src="/img/flag/12/<?= $first_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="national_team_review_profile.php?num=<?= $first_array[$i]['country_id']; ?>">
                                <?= $first_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $second_array[$i]['country_name']; ?>"
                                class="img-12"
                                src="/img/flag/12/<?= $second_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="national_team_review_profile.php?num=<?= $second_array[$i]['country_id']; ?>">
                                <?= $second_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $third_array[$i]['country_name']; ?>"
                                class="img-12"
                                src="/img/flag/12/<?= $third_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="national_team_review_profile.php?num=<?= $third_array[$i]['country_id']; ?>">
                                <?= $third_array[$i]['country_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>