<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Оценочная стоимость</p>
            <table class="w100">
                <tr>
                    <td class="right">
                        <form method="GET" id="page-form">
                            Старница:
                            <select name="page" id="page-select">
                                <?php for ($i=0; $i<$count_page; $i++) { ?>
                                    <option value="<?php print $i + 1; ?>"
                                        <?php if (isset($_GET['page']) && $_GET['page'] == $i + 1) { ?>
                                            selected
                                        <?php } ?>
                                    ><?php print $i + 1; ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th class="w1">Ранг</th>
                    <th colspan="2">Название</th>
                    <th colspan="2">Страна</th>
                    <th class="w10">Всего</th>
                    <th class="w50"></th>
                </tr>
                <?php for ($i=0; $i<$count_team; $i++) { ?>
                    <tr
                        <?php if (isset($authorization_team_id) && $authorization_team_id == $team_array[$i]['team_id']) { ?>
                            class="current"
                        <?php } ?>
                    >
                        <td class="center">
                            <?php

                            if (isset($_GET['page']))
                            {
                                print $i + 1 + ($_GET['page'] - 1) * 30;
                            }
                            else
                            {
                                print $i + 1;
                            }

                            ?>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $team_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $team_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $team_array[$i]['team_id']; ?>">
                                <?php print $team_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $team_array[$i]['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?php print $team_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="national_team_review_profile.php?num=<?php print $team_array[$i]['country_id']; ?>">
                                <?php print $team_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td class="right"><?php print f_igosja_money($team_array[$i]['team_price']); ?></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php print $team_array[$i]['team_price'] / $best_team_array[0]['team_price'] * 100; ?>%">
                                    <?php print SPACE; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>