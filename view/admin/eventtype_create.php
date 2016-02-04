<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование события</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="eventtype_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Действие</td>
                        <td>
                            <input 
                                name="eventtype_name" 
                                type="text" 
                                value="{if (isset($eventtype_name))}{$eventtype_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Картинка (15x15, png)</td>
                        <td>
                            <input name="eventtype_logo" type="file"/>
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