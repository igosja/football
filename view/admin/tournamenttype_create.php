<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование типа турнира</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="tournamenttype_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Название</td>
                        <td>
                            <input name="tournamenttype_name" type="text" value="{if (isset($tournamenttype_name))}{$tournamenttype_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Посещаемость</td>
                        <td>
                            <input name="tournamenttype_visitor" type="text" value="{if (isset($tournamenttype_visitor))}{$tournamenttype_visitor}{else}0{/if}"/>
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