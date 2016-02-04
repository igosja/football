<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Ситуация на рынке труда</p>
            <table class="w100">
                <tr>
                    <td>
                        <form method="GET">
                            <select name="country">
                                <option value="0">Страна</option>
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?php print $item['country_id']; ?>"
                                        <?php if (isset($_GET['country']) && $_GET['country'] == $item['country_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['country_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="submit" value="Поиск">
                        </form>
                    </td>
                    <td class="right">
                        <form method="GET" id="page-form">
                            Старница:
                            <select name="page" id="page-select">
                                <?php for ($i=1; $i<=$count_page; $i++) { ?>
                                    <option value="<?php print $i; ?>"
                                        <?php if (isset($_GET['page']) && $_GET['page'] == $i) { ?>
                                            selected
                                        <?php } ?>
                                    ><?php print $i; ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th>Менеджер</th>
                    <th colspan="2">Команда</th>
                    <th colspan="2">Страна</th>
                    <th colspan="2">Турнир</th>
                    <th class="w10">Финансы</th>
                </tr>
                <?php foreach ($team_array as $item) { ?>
                    <tr>
                        <td><?php print $item['user_login']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?php print $item['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                <?php print $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w25">
                            <a href="tournament_review_profile.php?num=<?php print $item['tournament_id']; ?>">
                                <?php print $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="right"><?php print f_igosja_money($item['team_finance']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>