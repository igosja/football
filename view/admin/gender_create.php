<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование пола</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="gender_list.php" class="link-img link-list"></a>
            </p>
            <form method="POST">
                <table class="center striped">
                    <tr>
                        <td>Пол</td>
                        <td>
                            <input name="gender_name" type="text" value="{if (isset($gender_name))}{$gender_name}{/if}"/>
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