<table class="block-table w100">
    <tr>
        <td class="block-page w30">
            <p class="header">Рекорды</p>
            <table class="striped w100">
                <?php for ($i=0; $i<1; $i++) { ?>
                    <tr>
                        <td class="w25"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> -
                            <a href="team_team_review_profile.php?num=<?= $record_array[$i]['team_id']; ?>">
                                <?= $record_array[$i]['team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=1; $i<2; $i++) { ?>
                    <tr>
                        <td class="w50"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> -
                            <a href="game_review_main.php?num=<?= $record_array[$i]['game_id']; ?>">
                                <?= $record_array[$i]['game_home_score']; ?>:<?= $record_array[$i]['game_guest_score']; ?>
                            </a>,
                            <?= date('d.m.Y', strtotime($record_array[$i]['shedule_date'])); ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=2; $i<3; $i++) { ?>
                    <tr>
                        <td class="w50"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> -
                            <a href="team_team_review_profile.php?num=<?= $record_array[$i]['team_id']; ?>">
                                <?= $record_array[$i]['team_name']; ?></a>,
                            <?= $record_array[$i]['recordtournament_season_id']; ?> сезон
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=3; $i<5; $i++) { ?>
                    <tr>
                        <td class="w50"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <a href="game_review_main.php?num=<?= $record_array[$i]['game_id']; ?>">
                                <?= $record_array[$i]['game_home_score']; ?>:<?= $record_array[$i]['game_guest_score']; ?>
                            </a> -
                            <?= date('d.m.Y', strtotime($record_array[$i]['shedule_date'])); ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=5; $i<11; $i++) { ?>
                    <tr>
                        <td class="w50"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> -
                            <a href="team_team_review_profile.php?num=<?= $record_array[$i]['team_id']; ?>">
                                <?= $record_array[$i]['team_name']; ?>
                            </a>
                            (<?= date('d.m.Y', strtotime($record_array[$i]['recordtournament_date_start'])); ?> -
                            <?= date('d.m.Y', strtotime($record_array[$i]['recordtournament_date_end'])); ?>)
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=11; $i<13; $i++) { ?>
                    <tr>
                        <td class="w25"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> -
                            <a href="team_team_review_profile.php?num=<?= $record_array[$i]['team_id']; ?>">
                                <?= $record_array[$i]['team_name']; ?>
                            </a>,
                            <?= $record_array[$i]['recordtournament_season_id']; ?> сезон
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=13; $i<14; $i++) { ?>
                    <tr>
                        <td class="w25"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> КК,
                            <?= $record_array[$i]['recordtournament_value_2']; ?> ЖК,
                            <a href="team_team_review_profile.php?num=<?= $record_array[$i]['team_id']; ?>">
                                <?= $record_array[$i]['team_name']; ?>
                            </a>,
                            <?= $record_array[$i]['recordtournament_season_id']; ?> сезон
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=14; $i<18; $i++) { ?>
                    <tr>
                        <td class="w25"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> -
                            <a href="player_home_profile.php?num=<?= $record_array[$i]['player_id']; ?>">
                                <?= $record_array[$i]['name_name']; ?> <?= $record_array[$i]['surname_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=18; $i<19; $i++) { ?>
                    <tr>
                        <td class="w25"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1'] / 10; ?> -
                            <a href="player_home_profile.php?num=<?= $record_array[$i]['player_id']; ?>">
                                <?= $record_array[$i]['name_name']; ?> <?= $record_array[$i]['surname_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php for ($i=19; $i<$count_record; $i++) { ?>
                    <tr>
                        <td class="w25"><?= $record_array[$i]['recordtournamenttype_name']; ?></td>
                        <td>
                            <?= $record_array[$i]['recordtournament_value_1']; ?> КК,
                            <?= $record_array[$i]['recordtournament_value_2']; ?> ЖК,
                            <a href="player_home_profile.php?num=<?= $record_array[$i]['player_id']; ?>">
                                <?= $record_array[$i]['name_name']; ?> <?= $record_array[$i]['surname_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>