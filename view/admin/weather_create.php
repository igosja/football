<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование погоды</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="weather_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Погода</td>
                        <td class="left">
                            <input 
                                name="weather_name" 
                                type="text" 
                                value="{if (isset($weather_name))}{$weather_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Картинка (25x25, png)</td>
                        <td class="left">
                            <input name="weather_logo" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Картинка (12x12, png)</td>
                        <td class="left">
                            <input name="weather_logo_12" type="file"/>
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