<table class="block-table w100">
    <tr>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Создание профиля</p>
                <table class="center">
                    <tr>
                        <td>
                            <input name="data[registration_login]" placeholder="Логин" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="data[registration_email]" placeholder="Email" type="email" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="data[registration_password]"  placeholder="Пароль" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td class="center">
                            <input type="submit" value="Зарегестрироваться" />
                        </td>
                    </tr>
                    <tr>
                        <td class="center">или войти через</td>
                    </tr>
                    <tr>
                        <td class="center">
                            <img
                                alt="Facebook"
                                class="img-30"
                                src="img/social/facebook.png"
                            />
                            <img
                                alt="Google"
                                class="img-30"
                                src="img/social/google.png"
                            />
                            <img
                                alt="Одноклассники"
                                class="img-30"
                                src="img/social/odnoklassniki.png"
                            />
                            <img
                                alt="Вконтакте"
                                class="img-30"
                                src="img/social/vkontakte.png"
                            />
                        </td>
                    </tr>
                </table>
            </form>
            <p><?= SPACE; ?></p>
            <table class="center striped grey">
                <tr>
                    <td>
                        <a href="login.php">
                            Вход
                        </a>
                    </td>
                    <td>|</td>
                    <td>
                        <a href="forget_password.php">
                            Забыли пароль?
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>