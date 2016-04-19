<table class="block-table w100">
    <tr>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Вход</p>
                <table class="center">
                    <tr>
                        <td>
                            <input name="data[login]" placeholder="Логин" type="text" autofocus />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="data[password]" placeholder="Пароль" type="password" />
                        </td>
                    </tr>
                    <tr>
                        <td class="center">
                            <input type="submit" value="Войти" />
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
                                            src="img/social/<?= $item['img']; ?>.png"
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
                        <a href="registration.php">
                            Регистрация
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