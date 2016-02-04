<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование турнирного рекорда</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="recordtournamenttype_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Название</td>
                        <td>
                            <input name="recordtournamenttype_name" type="text" value="{if (isset($recordtournamenttype_name))}{$recordtournamenttype_name}{/if}"/>
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