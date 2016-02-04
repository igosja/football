<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование континента</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="continent_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Континент</td>
                        <td>
                            <input name="continent_name" type="text" value="{if (isset($continent_name))}{$continent_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Эмблема (160x110, png)</td>
                        <td>
                            <input name="continent_logo" type="file"/>
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