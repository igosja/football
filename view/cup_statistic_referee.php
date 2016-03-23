<table class="block-table w100">
    <tr>
        <td rowspan="2" class="block-page w30">
            <p class="header">Статистика судей</p>
            <table class="striped w100">
                <tr>
                    <th>Имя</th>
                    <th class="w10">Матчей</th>
                    <th class="w10">Желтые карточки</th>
                    <th class="w10">Красные карточки</th>
                    <th class="w10">Пенальти</th>
                    <th class="w10">Средняя оценка</th>
                </tr>
                <?php foreach ($referee_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="referee_home_profile.php?num=<?php print $item['referee_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?php print $item['statisticreferee_game']; ?></td>
                        <td class="center"><?php print $item['statisticreferee_yellow']; ?></td>
                        <td class="center"><?php print $item['statisticreferee_red']; ?></td>
                        <td class="center"><?php print $item['statisticreferee_penalty']; ?></td>
                        <td class="center"><?php print $item['statisticreferee_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>