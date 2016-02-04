<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование позиции</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="positioncreate_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Позиция</td>
                        <td>
                            <select name="position_id"/>
                                {section name=i loop=$position_array}
                                    <option value="{$position_array[i].position_id}"
                                        {if (isset($position_id) && $position_id == $position_array[i].position_id)}
                                            selected
                                        {/if}
                                    >{$position_array[i].position_description}</option>
                                {/section}
                            </select>
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