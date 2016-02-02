<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Менеджеры</p>
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
                    <th>Имя</th>
                    <th colspan="2">Команда</th>
                    <th colspan="2">Страна менеджера</th>
                    <th class="w10">Рейтинг</th>
                </tr>
                <?php for ($i=0; $i<$count_user; $i++) { ?>
                    <tr>
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
                        <td>
                            <a href="player_home_profile.php?num=<?php print $user_array[$i]['user_id']; ?>">
                                <?php print $user_array[$i]['user_login']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <?php if ($user_array[$i]['team_id']) { ?>
                                <img
                                    alt="<?php print $user_array[$i]['team_name']; ?>"
                                    class="img-12"
                                    src="img/team/12/<?php print $user_array[$i]['team_id']; ?>.png"
                                />
                            <?php } ?>
                        </td>
                        <td class="w25">
                            <a href="team_team_review_profile.php?num=<?php print $user_array[$i]['team_id']; ?>">
                                <?php print $user_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img src="img/flag/12/<?php print $user_array[$i]['country_id']; ?>.png" class="img-12" />
                        </td>
                        <td class="w20">
                            <a href="national_team_review_profile.php?num=<?php print $user_array[$i]['country_id']; ?>">
                                <?php print $user_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <?php print f_igosja_five_star($user_array[$i]['user_reputation'], 12); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>