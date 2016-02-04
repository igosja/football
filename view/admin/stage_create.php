<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование стадии</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="stage_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Стадия</td>
                        <td>
                            <input 
                                name="stage_name" 
                                type="text" 
                                value="{if (isset($stage_name))}{$stage_name}{/if}"
                            />
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