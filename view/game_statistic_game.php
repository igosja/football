<table class="block-table w100">
    <tr>
        <td class="block-page w100">
            <p class="header">Статистика матча</p>
            <table class="striped w100">
                <tr>
                    <th>Статистика</th>
                    <th class="w1"></th>
                    <th class="w35"><?php print $game_array[0]['game_home_team_name']; ?></th>
                    <th class="w35"><?php print $game_array[0]['game_guest_team_name']; ?></th>
                    <th class="w1"></th>
                </tr>
                <tr>
                    <td>Удары</td>
                    <td class="center"><?php print $game_array[0]['game_home_shot']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_shot'] + $game_array[0]['game_guest_shot'])
                            {
                                print round($game_array[0]['game_home_shot'] / ($game_array[0]['game_home_shot'] + $game_array[0]['game_guest_shot']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_shot'] + $game_array[0]['game_guest_shot'])
                            {
                                print round($game_array[0]['game_guest_shot'] / ($game_array[0]['game_home_shot'] + $game_array[0]['game_guest_shot']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_shot']; ?></td>
                </tr>
                <tr>
                    <td>В створ</td>
                    <td class="center"><?php print $game_array[0]['game_home_ontarget']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_ontarget'] + $game_array[0]['game_guest_ontarget'])
                            {
                                print round($game_array[0]['game_home_ontarget'] / ($game_array[0]['game_home_ontarget'] + $game_array[0]['game_guest_ontarget']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_ontarget'] + $game_array[0]['game_guest_ontarget'])
                            {
                                print round($game_array[0]['game_guest_ontarget'] / ($game_array[0]['game_home_ontarget'] + $game_array[0]['game_guest_ontarget']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_ontarget']; ?></td>
                </tr>
                <tr>
                    <td>Голевые моменты</td>
                    <td class="center"><?php print $game_array[0]['game_home_moment']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_moment'] + $game_array[0]['game_guest_moment'])
                            {
                                print round($game_array[0]['game_home_moment'] / ($game_array[0]['game_home_moment'] + $game_array[0]['game_guest_moment']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_moment'] + $game_array[0]['game_guest_moment'])
                            {
                                print round($game_array[0]['game_guest_moment'] / ($game_array[0]['game_home_moment'] + $game_array[0]['game_guest_moment']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_moment']; ?></td>
                </tr>
                <tr>
                    <td>Владение</td>
                    <td class="center"><?php print $game_array[0]['game_home_possession']; ?>%</td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_possession'] + $game_array[0]['game_guest_possession'])
                            {
                                print round($game_array[0]['game_home_possession'] / ($game_array[0]['game_home_possession'] + $game_array[0]['game_guest_possession']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_possession'] + $game_array[0]['game_guest_possession'])
                            {
                                print round($game_array[0]['game_guest_possession'] / ($game_array[0]['game_home_possession'] + $game_array[0]['game_guest_possession']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_possession']; ?>%</td>
                </tr>
                <tr>
                    <td>Угловые</td>
                    <td class="center"><?php print $game_array[0]['game_home_corner']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_corner'] + $game_array[0]['game_guest_corner'])
                            {
                                print round($game_array[0]['game_home_corner'] / ($game_array[0]['game_home_corner'] + $game_array[0]['game_guest_corner']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_corner'] + $game_array[0]['game_guest_corner'])
                            {
                                print round($game_array[0]['game_guest_corner'] / ($game_array[0]['game_home_corner'] + $game_array[0]['game_guest_corner']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_corner']; ?></td>
                </tr>
                <tr>
                    <td>Фолы</td>
                    <td class="center"><?php print $game_array[0]['game_home_foul']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_foul'] + $game_array[0]['game_guest_foul'])
                            {
                                print round($game_array[0]['game_home_foul'] / ($game_array[0]['game_home_foul'] + $game_array[0]['game_guest_foul']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_foul'] + $game_array[0]['game_guest_foul'])
                            {
                                print round($game_array[0]['game_guest_foul'] / ($game_array[0]['game_home_foul'] + $game_array[0]['game_guest_foul']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_foul']; ?></td>
                </tr>
                <tr>
                    <td>Пенальти</td>
                    <td class="center"><?php print $game_array[0]['game_home_penalty']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_penalty'] + $game_array[0]['game_guest_penalty'])
                            {
                                print round($game_array[0]['game_home_penalty'] / ($game_array[0]['game_home_penalty'] + $game_array[0]['game_guest_penalty']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_penalty'] + $game_array[0]['game_guest_penalty'])
                            {
                                print round($game_array[0]['game_guest_penalty'] / ($game_array[0]['game_home_penalty'] + $game_array[0]['game_guest_penalty']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_penalty']; ?></td>
                </tr>
                <tr>
                    <td>Офсайды</td>
                    <td class="center"><?php print $game_array[0]['game_home_offside']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_offside'] + $game_array[0]['game_guest_offside'])
                            {
                                print round($game_array[0]['game_home_offside'] / ($game_array[0]['game_home_offside'] + $game_array[0]['game_guest_offside']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_offside'] + $game_array[0]['game_guest_offside'])
                            {
                                print round($game_array[0]['game_guest_offside'] / ($game_array[0]['game_home_offside'] + $game_array[0]['game_guest_offside']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_offside']; ?></td>
                </tr>
                <tr>
                    <td>Точные передачи</td>
                    <td class="center"><?php print $game_array[0]['game_home_pass']; ?>%</td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_pass'] + $game_array[0]['game_guest_pass'])
                            {
                                print round($game_array[0]['game_home_pass'] / ($game_array[0]['game_home_pass'] + $game_array[0]['game_guest_pass']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_pass'] + $game_array[0]['game_guest_pass'])
                            {
                                print round($game_array[0]['game_guest_pass'] / ($game_array[0]['game_home_pass'] + $game_array[0]['game_guest_pass']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_pass']; ?>%</td>
                </tr>
                <tr>
                    <td>Желтые карточки</td>
                    <td class="center"><?php print $game_array[0]['game_home_yellow']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_yellow'] + $game_array[0]['game_guest_yellow'])
                            {
                                print round($game_array[0]['game_home_yellow'] / ($game_array[0]['game_home_yellow'] + $game_array[0]['game_guest_yellow']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_yellow'] + $game_array[0]['game_guest_yellow'])
                            {
                                print round($game_array[0]['game_guest_yellow'] / ($game_array[0]['game_home_yellow'] + $game_array[0]['game_guest_yellow']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_yellow']; ?></td>
                </tr>
                <tr>
                    <td>Красные карточки</td>
                    <td class="center"><?php print $game_array[0]['game_home_red']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_red'] + $game_array[0]['game_guest_red'])
                            {
                                print round($game_array[0]['game_home_red'] / ($game_array[0]['game_home_red'] + $game_array[0]['game_guest_red']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['game_home_red'] + $game_array[0]['game_guest_red'])
                            {
                                print round($game_array[0]['game_guest_red'] / ($game_array[0]['game_home_red'] + $game_array[0]['game_guest_red']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['game_guest_red']; ?></td>
                </tr>
                <tr>
                    <td>Средняя оценка</td>
                    <td class="center"><?php print $game_array[0]['home_average']; ?></td>
                    <td colspan="2">
                        <div class="progress">
                            <div class="progress-bar-red" style="width: 
                            <?php

                            if (0 < $game_array[0]['home_average'] + $game_array[0]['guest_average'])
                            {
                                print round($game_array[0]['home_average'] / ($game_array[0]['home_average'] + $game_array[0]['guest_average']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                            <div class="progress-bar-green" style="width: 
                            <?php

                            if (0 < $game_array[0]['home_average'] + $game_array[0]['guest_average'])
                            {
                                print round($game_array[0]['guest_average'] / ($game_array[0]['home_average'] + $game_array[0]['guest_average']) * 100, 0);
                            }
                            else
                            {
                                print 50;
                            }

                            ?>%"></div>
                        </div>
                    </td>
                    <td class="center"><?php print $game_array[0]['guest_average']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>