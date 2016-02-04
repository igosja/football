<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование типа травмы</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="injurytype_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Травма</td>
                        <td>
                            <input 
                                name="injurytype_name" 
                                type="text" 
                                value="{if (isset($injurytype_name))}{$injurytype_name}{/if}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Длительность, дней</td>
                        <td>
                            <input 
                                name="injurytype_day" 
                                type="text" 
                                value="{if (isset($injurytype_day))}{$injurytype_day}{/if}"
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