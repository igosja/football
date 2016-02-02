<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Новые менеджеры</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Команда</th>
                    <th class="w10">Дата</th>
                    <th>Менеджер</th>
                </tr>
                <?php foreach ($manager_new_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w50">
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?php print $item['history_date|date_format:"%d.%m.%Y"']; ?></td>
                        <td class="w40"><?php print $item['user_login']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w50">
            <p class="header">Ушедшие менедежры</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Команда</th>
                    <th class="w10">Дата</th>
                    <th>Менеджер</th>
                </tr>
                <?php foreach ($manager_old_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w50">
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?php print $item['history_date|date_format:"%d.%m.%Y"']; ?></td>
                        <td class="w40"><?php print $item['user_login']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>