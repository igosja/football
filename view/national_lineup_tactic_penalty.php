<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Игроки</p>
            <table class="striped w100">
                <tr>
                    <th>Игрок</th>
                    <th class="w10">Поз</th>
                    <th class="w15">Самообладание</th>
                    <th class="w15">Пенальти</th>
                </tr>
                {section name=i loop=$player_array}
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num={$player_array[i].player_id}">
                                {$player_array[i].name_name} {$player_array[i].surname_name}
                            </a>
                        </td>
                        <td class="center">{$player_array[i].position_name}</td>
                        <td class="center">{$player_array[i].composure}</td>
                        <td class="center">{$player_array[i].penalty}</td>
                    </tr>
                {/section}
            </table>
        </td>
        <td class="block-page w35" id="player-block">
        <p class="header">Пенальти</p>
            <table class="w100">
                <tr>
                    <td class="vcenter w50">Первый игрок</td>
                    <td>
                        <select data-id="1" id="select-penalty-1-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_1 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="vcenter">Второй игрок</td>
                    <td>
                        <select data-id="2" id="select-penalty-2-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_2 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="vcenter">Третий игрок</td>
                    <td>
                        <select data-id="3" id="select-penalty-3-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_3 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="vcenter">Четвертый игрок</td>
                    <td>
                        <select data-id="4" id="select-penalty-4-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_4 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="vcenter">Пятый игрок</td>
                    <td>
                        <select data-id="5" id="select-penalty-5-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_5 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="vcenter">Шестой игрок</td>
                    <td>
                        <select data-id="6" id="select-penalty-6-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_6 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="vcenter">Седьмой игрок</td>
                    <td>
                        <select data-id="7" id="select-penalty-7-national" class="select-penalty-national">
                            <option value="0">-</option>
                            {section name=i loop=$penaltyplayer_array}
                                <option value="{$penaltyplayer_array[i].player_id}"
                                    {if $penalty_array.0.country_penalty_player_id_7 == $penaltyplayer_array[i].player_id}
                                        selected
                                    {/if}
                                >
                                    {$penaltyplayer_array[i].name_name} {$penaltyplayer_array[i].surname_name}
                                </option>
                            {/section}
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>