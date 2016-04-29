<table class="block-table w100">
    <tr>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Создание профиля</p>
                <table class="center">
                    <tr>
                        <td>
                            <input name="data[registration_login]" placeholder="Логин" type="text" autofocus id="registration-login-input" />
                        </td>
                    </tr>
                    <tr id="registration-login-tr" style="display:none;">
                        <td class="center red">Этот логин занят</td>
                    </tr>
                    <tr>
                        <td>
                            <input name="data[registration_email]" placeholder="Email" type="email" id="registration-email-input" />
                        </td>
                    </tr>
                    <tr id="registration-email-tr" style="display:none;">
                        <td class="center red">Этот Email занят</td>
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
                            <p class="social-block">
                                <?php foreach ($social_array as $item) { ?>
                                    <a href="<?= $item['url']; ?>">
                                        <img
                                            alt="<?= $item['alt']; ?>"
                                            class="img-30"
                                            src="/img/social/<?= $item['img']; ?>.png"
                                        />
                                    </a>
                                <?php } ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </form>
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