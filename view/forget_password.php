<table class="block-table w100">
    <tr>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Восстановление пароля</p>
                <table class="center">
                    <tr>
                        <td>
                            <input name="data[email]" placeholder="Email" type="email" />
                        </td>
                    </tr>
                    <tr>
                        <td class="center">
                            <input type="submit" value="Востановить" />
                        </td>
                    </tr>
                </table>
            </form>
            <p><?= SPACE; ?></p>
            <table class="center striped grey">
                <tr>
                    <td>
                        <a href="registration.php">
                            Регистрация
                        </a>
                    </td>
                    <td>|</td>
                    <td>
                        <a href="login.php">
                            Вход
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>