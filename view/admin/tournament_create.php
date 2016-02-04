<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование турнира</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="tournament_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Тип</td>
                        <td>
                            <select name="tournamenttype_id" id="tournament-type">
                                {section name=i loop=$tournamenttype_array}
                                    <option value="{$tournamenttype_array[i].tournamenttype_id}"
                                        {if (isset($tournamenttype_id) && $tournamenttype_id == $tournamenttype_array[i].tournamenttype_id)}
                                            selected
                                        {/if}
                                    >
                                        {$tournamenttype_array[i].tournamenttype_name}
                                    </option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Название</td>
                        <td>
                            <input name="tournament_name" type="text" value="{if (isset($tournament_name))}{$tournament_name}{/if}"/>
                        </td>
                    </tr>
                    <tr id="tournament-level">
                        <td>Уровень</td>
                        <td>
                            <input name="tournament_level" type="text" value="{if (isset($tournament_level))}{$tournament_level}{else}1{/if}"/>
                        </td>
                    </tr>
                    <tr id="tournament-name">
                        <td>Страна</td>
                        <td>
                            <select name="country_id">
                                {section name=i loop=$country_array}
                                    <option value="{$country_array[i].country_id}"
                                        {if (isset($country_id) && $country_id == $country_array[i].country_id)}
                                             selected
                                        {/if}
                                    >{$country_array[i].country_name}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Эмблема (90x90, png)</td>
                        <td>
                            <input name="tournament_logo_90" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Эмблема (50x50, png)</td>
                        <td>
                            <input name="tournament_logo_50" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Эмблема (12x12, png)</td>
                        <td>
                            <input name="tournament_logo_12" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Сохранить"/>
                        </td>
                    </tr>
                    {if (isset($smarty.get.num))}
                        <tr>
                            <td colspan="2">
                                <img src="/img/tournament/90/{$smarty.get.num}.png" />
                                <img src="/img/tournament/50/{$smarty.get.num}.png" />
                                <img src="/img/tournament/12/{$smarty.get.num}.png" />
                            </td>
                        </tr>
                    {/if}
                </table>
            </form>
        </td>
    </tr>
</table>