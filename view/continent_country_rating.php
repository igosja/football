<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Рейтинг</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">Ранг</th>
                    <th colspan="2">Страна</th>
                    <th class="w10">Очки</th>
                </tr>
                <?php foreach ($country_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['ratingcountry_position']; ?></td>
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
                        <td class="center"><?= $item['ratingcountry_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>