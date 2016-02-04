<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Настрои на игру</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="gamemood_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Настрой</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$gamemood_array}
                    <tr>
                        <td>
                            <a href="gamemood.php?num={$gamemood_array[i].gamemood_id}">
                                {$gamemood_array[i].gamemood_name}
                            </a>
                        </td>
                        <td>
                            <a href="gamemood_edit.php?num={$gamemood_array[i].gamemood_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>