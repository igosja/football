<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Личное сообщение</p>
            <p>Кому: {$forum_array.0.user_login}</p>
            <form method="POST" class="center">
                <input type="text" class="w100" placeholder="Заголовок" name="name"/>
                <textarea class="w100" rows="10" placeholder="Сообщение" name="text"></textarea>
                <input type="submit" />
            </form>
        </td>
    </tr>
</table>