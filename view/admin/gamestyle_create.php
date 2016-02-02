<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование настроя</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="gamestyle_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Настрой</td>
                        <td class="left">
                            <input 
                                name="gamestyle_name" 
                                type="text" 
                                value="{if (isset($gamestyle_name))}{$gamestyle_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td class="left">
                            <textarea name="gamestyle_description" rows="10">
                                {if (isset($gamestyle_description))}{$gamestyle_description}{/if}
                            </textarea>
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