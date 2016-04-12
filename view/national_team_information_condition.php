<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header"><?= $country_array[0]['stadium_name']; ?></p>
            <table class="striped w100">
                <tr>
                    <td>Город</td>
                    <td class="w50"><?= $country_array[0]['city_name']; ?></td>
                </tr>
                <tr>
                    <td>Стадион</td>
                    <td>
                        <a href="team_team_review_profile.php?num=<?= $country_array[0]['team_id']; ?>"><?= $country_array[0]['stadium_name']; ?></a>
                    </td>
                </tr>
                <tr>
                    <td>Вместимость</td>
                    <td><?= number_format($country_array[0]['stadium_capacity'], 0, ',', ' '); ?></td>
                </tr>
                <tr>
                    <td>Состояние газона</td>
                    <td><?= $country_array[0]['stadiumquality_name']; ?></td>
                </tr>
                <tr>
                    <td>Размеры поля</td>
                    <td>Длина: <?= $country_array[0]['stadium_length']; ?> м, ширина: <?= $country_array[0]['stadium_width']; ?> м</td>
                </tr>
            </table>
        </td>
    </tr>
</table>