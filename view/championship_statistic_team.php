<table class="block-table w100">
    <tr>
        <td class="block-page w25">
            <p class="header">Голы</p>
            <table class="striped w100">
                <?php foreach ($goal_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['statisticteam_goal']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Пропущено</p>
            <table class="striped w100">
                <?php foreach ($pass_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['statisticteam_pass']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Красные карточки</p>
            <table class="striped w100">
                <?php foreach ($red_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['statisticteam_red']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Желтые карточки</p>
            <table class="striped w100">
                <?php foreach ($yellow_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['statisticteam_yellow']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page w25">
            <p class="header">Побед подряд</p>
            <table class="striped w100">
                <?php foreach ($win_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Игр без поражений подряд</p>
            <table class="striped w100">
                <?php foreach ($no_loose_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Поражений подряд</p>
            <table class="striped w100">
                <?php foreach ($loose_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Игры без пропущенных мячей</p>
            <table class="striped w100">
                <?php foreach ($nopass_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w15"><?php print $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>