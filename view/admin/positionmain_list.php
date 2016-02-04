<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Главные позиции</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <th></th>
                        <th>Позиция</th>
                    </tr>
                    {section name=i loop=$position_array}
                        <tr>
                            <td>
                                <input name="position_id[]" type="checkbox" value="{$position_array[i].position_id}" 
                                    {if (0 < $position_array[i].positionmain_id)}
                                        checked
                                    {/if}
                                />
                            </td>
                            <td>
                                {$position_array[i].position_description}
                            </td>
                        </tr>
                    {/section}
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