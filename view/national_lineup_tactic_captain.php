<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Игроки</p>
            <table class="striped w100">
                <tr>
                    <th>Игрок</th>
                    <th class="w10">Поз</th>
                    <th class="w15">Возраст</th>
                    <th class="w15">Лидерство</th>
                </tr>
                {section name=i loop=$player_array}
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num={$player_array[i].player_id}">
                                {$player_array[i].name_name} {$player_array[i].surname_name}
                            </a>
                        </td>
                        <td class="center">{$player_array[i].position_name}</td>
                        <td class="center">{$player_array[i].player_age}</td>
                        <td class="center">{$player_array[i].leader}</td>
                    </tr>
                {/section}
            </table>
        </td>
        <td class="block-page" id="player-block">
            <p class="header">Капитаны</p>
            <table class="w100">
                <tr>
                    <td class="w50">Капитан</td>
                    <td>
                        <select data-id="1" id="select-captain-1-national" class="select-captain-national">
                            <option value="0">-</option>
                            {section name=i loop=$leader_array}
                                <option value="{$leader_array[i].player_id}"
                                    {if $captain_array.0.country_captain_player_id_1 == $leader_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$leader_array[i].name_name} {$leader_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Вице-капитан</td>
                    <td>
                        <select data-id="2" id="select-captain-2-national" class="select-captain-national">
                            <option value="0">-</option>
                            {section name=i loop=$leader_array}
                                <option value="{$leader_array[i].player_id}"
                                    {if $captain_array.0.country_captain_player_id_2 == $leader_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$leader_array[i].name_name} {$leader_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Первый заместитель</td>
                    <td>
                        <select data-id="3" id="select-captain-3-national" class="select-captain-national">
                            <option value="0">-</option>
                            {section name=i loop=$leader_array}
                                <option value="{$leader_array[i].player_id}"
                                    {if $captain_array.0.country_captain_player_id_3 == $leader_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$leader_array[i].name_name} {$leader_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Второй заместитель</td>
                    <td>
                        <select data-id="4" id="select-captain-4-national" class="select-captain-national">
                            <option value="0">-</option>
                            {section name=i loop=$leader_array}
                                <option value="{$leader_array[i].player_id}"
                                    {if $captain_array.0.country_captain_player_id_4 == $leader_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$leader_array[i].name_name} {$leader_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Третий заместитель</td>
                    <td>
                        <select data-id="5" id="select-captain-5-national" class="select-captain-national">
                            <option value="0">-</option>
                            {section name=i loop=$leader_array}
                                <option value="{$leader_array[i].player_id}"
                                    {if $captain_array.0.country_captain_player_id_5 == $leader_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$leader_array[i].name_name} {$leader_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>