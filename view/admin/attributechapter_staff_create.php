<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование группы характеристик</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="attributechapter_staff_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Группа</td>
                        <td>
                            <input name="chapter_name" type="text" value="{if (isset($chapter_name))}{$chapter_name}{/if}"/>
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