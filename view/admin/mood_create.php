<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование настроения</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="mood_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="center striped">
                    <tr>
                        <td>Настроение</td>
                        <td>
                            <input 
                                name="mood_name" 
                                type="text" 
                                value="{if (isset($mood_name))}{$mood_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Эмблема (15x15, png)</td>
                        <td>
                            <input name="mood_logo" type="file"/>
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