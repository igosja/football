<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование роли</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="role_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Роль</td>
                        <td>
                            <input 
                                name="role_name" 
                                type="text" 
                                value="{if (isset($role_name))}{$role_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Сокращение</td>
                        <td>
                            <input
                                name="role_short" 
                                type="text" 
                                value="{if (isset($role_short))}{$role_short}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td>
                            <textarea name="role_description" rows="5" cols="100">{if (isset($role_description))}{$role_description}{/if}</textarea>
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