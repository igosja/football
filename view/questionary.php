<table class="block-table w100">
    <tr>
        <td class="block-page">
            <form method="POST">
                <p class="center header">Персональные данные</p>
                <table class="center striped">
                    <tr>
                        <td class="right">Имя</td>
                        <td>
                            <input name="data[firstname]" type="text" value="<?php print $user_array[0]['user_firstname']; ?>" />
                            <input name="data[lastname]" type="text" value="<?php print $user_array[0]['user_lastname']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Пол</td>
                        <td>
                            <?php foreach ($gender_array as $item) { ?>
                                <input
                                    name="data[gender]"
                                    type="radio"
                                    value="<?php print $item['gender_id']; ?>"
                                    <?php if ($item['gender_id'] == $user_array[0]['user_gender']) { ?>
                                        checked
                                    <?php } ?>
                                />
                                <?php print $item['gender_name']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Дата рождения</td>
                        <td>
                            <select name="data[birth][day]">
                                <?php for ($i=1; $i<=31; $i++) { ?>
                                    <option value="<?php print $i; ?>"
                                        <?php if ($i == $user_array[0]['user_birth_day']) { ?>selected<?php } ?>
                                    ><?php print $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="data[birth][month]">
                                <?php for ($i=1; $i<=12; $i++) { ?>
                                    <option value="<?php print $i; ?>"
                                        <?php if ($i == $user_array[0]['user_birth_month']) { ?>selected<?php } ?>
                                    ><?php print $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="data[birth][year]">
                                <?php for ($i=date('Y'); $i>=date('Y')-100; $i--) { ?>
                                    <option value="<?php print $i; ?>"
                                        <?php if ($i == $user_array[0]['user_birth_year']) { ?>selected<?php } ?>
                                    ><?php print $i; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Страна</td>
                        <td>
                            <select name="data[country]">
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?php print $item['country_id']; ?>"
                                        <?php if ($item['country_id'] == $user_array[0]['user_country_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['country_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Новый пароль</td>
                        <td>
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
    </tr>
</table>