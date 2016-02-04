<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Должности персонала</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="post_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Должность</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$post_array}
                    <tr>
                        <td>
                            <a href="post.php?num={$post_array[i].staffpost_id}">
                                {$post_array[i].staffpost_name}
                            </a>
                        </td>
                        <td>
                            <a href="post_edit.php?num={$post_array[i].staffpost_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>