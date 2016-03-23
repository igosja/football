<table class="block-table w100">
    <tr>
        <td class="block-page w30">
            <p class="header">Встречи и результаты</p>
            <form id="tournament-stage-form" method="GET" class="center">
                <input type="hidden" name="num" value="<?php print $num; ?>">
                Стадия:
                <select id="tournament-stage-select" name="shedule">
                    <?php foreach ($shedule_array as $item) { ?>
                        <option value="<?php print $item['shedule_id']; ?>"
                            <?php if ($item['shedule_id'] == $game_array[0]['game_shedule_id']) { ?>
                                selected
                            <?php } ?>
                        >
                            <?php print $item['stage_name']; ?>, <?php print date('d.m.Y', strtotime($item['shedule_date'])); ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
            <table class="striped w100" id="tournament-game">
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td class="w45 right">
                            <a href="team_team_review_profile.php?num=<?php print $item['game_home_team_id']; ?>">
                                <?php print $item['home_team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['home_team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['game_home_team_id']; ?>.png"
                            />
                        </td>
                        <td class="center">
                            <?php if (1 == $item['game_played']) { ?>
                                <a href="game_review_main.php?num=<?php print $item['game_id']; ?>">
                                    <?php print $item['game_home_score']; ?>:<?php print $item['game_guest_score']; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['guest_team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['game_guest_team_id']; ?>.png"
                            />
                        </td>
                        <td class="w45">
                            <a href="team_team_review_profile.php?num=<?php print $item['game_guest_team_id']; ?>">
                                <?php print $item['guest_team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>