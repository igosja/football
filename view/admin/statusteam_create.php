<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование командного статуса</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="statusteam_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Название</td>
                        <td class="left">
                            <input name="statusteam_name" type="text" value="{if (isset($statusteam_name))}{$statusteam_name}{/if}"/>
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