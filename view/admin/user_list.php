<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Пользователи</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Пользователь</th>
                    <th>Последний визит</th>
                </tr>
                {section name=i loop=$user_array}
                    <tr>
                        <td>
                            <a href="user.php?num={$user_array[i].user_id}">
                                {$user_array[i].user_login}
                            </a>
                        </td>
                        <td>{f_igosja_ufu_last_visit($user_array[i].user_last_visit)}</td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>