<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Все игроки</p>
            <table class="striped w100">
                <tr>
                    <th>Имя</th>
                    <th class="w1">Нац</th>
                    <th class="w5">Поз</th>
                    <th class="w5">Воз</th>
                    <th class="w5">Рост</th>
                    <th class="w5">Вес</th>
                    <th class="w10">Цена</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                <img
                                    alt="<?php print $item['country_name']; ?>"
                                    class="img-12"
                                    src="img/flag/12/<?php print $item['country_id']; ?>.png"
                                    title="<?php print $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="center"><?php print $item['position_name']; ?></td>
                        <td class="center"><?php print $item['player_age']; ?></td>
                        <td class="center"><?php print $item['player_height']; ?> см</td>
                        <td class="center"><?php print $item['player_weight']; ?> кг</td>
                        <td class="right"><?php print f_igosja_money($item['player_price']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>