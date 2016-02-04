<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Состояние газона</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="stadiumquality_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$stadiumquality_array}
                    <tr>
                        <td>
                            <a href="stadiumquality.php?num={$stadiumquality_array[i].stadiumquality_id}">
                                {$stadiumquality_array[i].stadiumquality_name}
                            </a>
                        </td>
                        <td>
                            <a href="stadiumquality_edit.php?num={$stadiumquality_array[i].stadiumquality_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>