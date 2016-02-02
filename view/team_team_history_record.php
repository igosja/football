<table class="block-table w100">
    <tr>
        <td class="w50">
            <table class="w100">
                <tr>
                    <td class="block-page w100">
                        <p class="header">Место в лиге</p>
                        <table class="striped w100">
                            <?php for ($i=0; $i<2; $i++) { ?>
                                <tr>
                                    <td class="w50"><?php print $record_array[$i]['recordteamtype_name']; ?></td>
                                    <td>
                                        <?php print $record_array[$i]['recordteam_value']; ?> в
                                        <a href="tournament_review_profile.php?num=<?php print $record_array[$i]['tournament_id']; ?>">
                                            <?php print $record_array[$i]['tournament_name']; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="block-page w100">
                        <p class="header">Посещаемость</p>
                        <table class="striped w100">
                            <?php for ($i=2; $i<4; $i++) { ?>
                                <tr>
                                    <td class="w50"><?php print $record_array[$i]['recordteamtype_name']; ?></td>
                                    <td>
                                        <a href="game_review_main.php?num=<?php print $record_array[$i]['game_id']; ?>">
                                            <?php print $record_array[$i]['recordteam_value']; ?>
                                        </a>
                                    (<?php print f_igosja_ufu_date($record_array[$i]['shedule_date']); ?>)
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="block-page w100">
                        <p class="header">Результаты</p>
                        <table class="striped w100">
                            <?php for ($i=4; $i<7; $i++) { ?>
                                <tr>
                                    <td class="w50"><?php print $record_array[$i]['recordteamtype_name']; ?></td>
                                    <td>
                                        <a href="game_review_main.php?num=<?php print $record_array[$i]['game_id']; ?>">
                                            <?php print $record_array[$i]['game_home_score']; ?>:<?php print $record_array[$i]['game_guest_score']; ?>
                                        </a>
                                        (<?php print f_igosja_ufu_date($record_array[$i]['shedule_date']); ?>)
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="block-page w100">
                        <p class="header">Трансферы</p>
                        <table class="striped w100">
                            <?php for ($i=7; $i<9; $i++) { ?>
                                <tr>
                                    <td class="w50"><?php print $record_array[$i]['recordteamtype_name']; ?></td>
                                    <td>
                                        <a href="player_home_profile.php?num=<?php print $record_array[$i]['player_id']; ?>">
                                            <?php print $record_array[$i]['name_name']; ?> <?php print $record_array[$i]['surname_name']; ?>
                                        </a>
                                        (<?php print f_igosja_money($record_array[$i]['recordteam_value']); ?>,
                                        <?php print f_igosja_ufu_date($record_array[$i]['recordteam_date_start']); ?>)
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table class="w100">
                <tr>
                    <td class="block-page w100">
                        <p class="header">Игроки</p>
                        <table class="striped w100">
                            <?php for ($i=9; $i<13; $i++) { ?>
                                <tr>
                                    <td class="w50"><?php print $record_array[$i]['recordteamtype_name']; ?></td>
                                    <td>
                                        <?php print $record_array[$i]['recordteam_value']; ?> -
                                        <a href="player_home_profile.php?num=<?php print $record_array[$i]['player_id']; ?>">
                                            <?php print $record_array[$i]['name_name']; ?> <?php print $record_array[$i]['surname_name']; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="block-page w100">
                        <p class="header">Серии</p>
                        <table class="striped w100">
                            <?php for ($i=13; $i<$count_record; $i++) { ?>
                                <tr>
                                    <td class="w50"><?php print $record_array[$i]['recordteamtype_name']; ?></td>
                                    <td>
                                        <?php print $record_array[$i]['recordteam_value']; ?>
                                        (<?php print f_igosja_ufu_date($record_array[$i]['recordteam_date_start']); ?> -
                                        <?php print f_igosja_ufu_date($record_array[$i]['recordteam_date_end']); ?>)
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>