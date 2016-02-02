<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование серии матчей</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="seriestype_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Название</td>
                        <td class="left">
                            <input name="seriestype_name" type="text" value="{if (isset($seriestype_name))}{$seriestype_name}{/if}"/>
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