<table class="block-table w100">
    <tr>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Персональные данные</p>
                <table class="center striped">
                    <tr>
                        <td class="right">Логин</td>
                        <td class="left">
                            <input name="data[login]" type="text" value="<?= $user_array[0]['user_login']; ?>" id="questionary-login-input" />
                            <span class="center red" id="questionary-login-span" style="display: none;">Этот логин занят</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Имя</td>
                        <td class="left">
                            <input name="data[firstname]" type="text" value="<?= $user_array[0]['user_firstname']; ?>" />
                            <input name="data[lastname]" type="text" value="<?= $user_array[0]['user_lastname']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Email</td>
                        <td class="left">
                            <input name="data[email]" type="text" value="<?= $user_array[0]['user_email']; ?>" id="questionary-email-input" />
                            <span class="center red" id="questionary-email-span" style="display: none;">Этот Email занят</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Пол</td>
                        <td class="left">
                            <?php foreach ($gender_array as $item) { ?>
                                <input
                                    name="data[gender]"
                                    type="radio"
                                    value="<?= $item['gender_id']; ?>"
                                    <?php if ($item['gender_id'] == $user_array[0]['user_gender']) { ?>
                                        checked
                                    <?php } ?>
                                />
                                <?= $item['gender_name']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Дата рождения</td>
                        <td class="left">
                            <select name="data[birth][day]">
                                <?php for ($i=1; $i<=31; $i++) { ?>
                                    <option value="<?= $i; ?>"
                                        <?php if ($i == $user_array[0]['user_birth_day']) { ?>selected<?php } ?>
                                    ><?= $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="data[birth][month]">
                                <?php for ($i=1; $i<=12; $i++) { ?>
                                    <option value="<?= $i; ?>"
                                        <?php if ($i == $user_array[0]['user_birth_month']) { ?>selected<?php } ?>
                                    ><?= $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="data[birth][year]">
                                <?php for ($i=date('Y'); $i>=date('Y')-100; $i--) { ?>
                                    <option value="<?= $i; ?>"
                                        <?php if ($i == $user_array[0]['user_birth_year']) { ?>selected<?php } ?>
                                    ><?= $i; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Страна</td>
                        <td class="left">
                            <select name="data[country]">
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?= $item['country_id']; ?>"
                                        <?php if ($item['country_id'] == $user_array[0]['user_country_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['country_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Новый пароль</td>
                        <td class="left">
                            <input name="data[password]" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Сохранить" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Соцсети</p>
                <table class="center striped">
                    <?php foreach ($social_array as $item) { ?>
                        <tr>
                            <td class="right">
                                <img
                                    alt="<?= $item['alt']; ?>"
                                    class="img-30"
                                    src="/img/social/<?= $item['img']; ?>.png"
                                />
                            </td>
                            <td class="left">
                                <a href="<?= $item['url']; ?>">
                                    <?= $item['text']; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
        </td>
    </tr>
</table>