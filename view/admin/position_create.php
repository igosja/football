<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование позиции</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="position_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Позиция</td>
                        <td>
                            <input 
                                name="position_name" 
                                type="text" 
                                value="{if (isset($position_name))}{$position_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td>
                            <input 
                                name="position_description" 
                                type="text" 
                                value="{if (isset($position_description))}{$position_description}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Координата "x" по сетке 5x7</td>
                        <td>
                            <input
                                name="position_coordinate_x"
                                type="text"
                                value="{if (isset($position_coordinate_x))}{$position_coordinate_x}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Координата "y" по сетке 5x7</td>
                        <td>
                            <input
                                name="position_coordinate_y"
                                type="text"
                                value="{if (isset($position_coordinate_y))}{$position_coordinate_y}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td>
                            <input
                                name="position_description"
                                type="text"
                                value="{if (isset($position_description))}{$position_description}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Статус</td>
                        <td>
                            <select name="position_available">
                                <option value="1"
                                    {if (isset($position_available) && 1 == $position_available)}selected{/if}
                                >
                                    Открытая
                                </option>
                                <option value="0"
                                    {if (isset($position_available) && 0 == $position_available)}selected{/if}
                                >
                                    Служебная
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Роли</td>
                        <td>
                            <table>
                                {section name=i loop=$role_array}
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="role[]" value="{$role_array[i].role_id}"
                                                {if (isset($positionrole_array))}
                                                    {section name=j loop=$positionrole_array}
                                                        {if ($role_array[i].role_id == $positionrole_array[j].positionrole_role_id)}
                                                            checked
                                                        {/if}
                                                    {/section}
                                                {/if}
                                            >
                                        </td>
                                        <td>{$role_array[i].role_name}</td>
                                    </tr>
                                {/section}
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Сохранить"/>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>