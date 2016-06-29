<table class="block-table w100">
    <tr>
        <td class="block-page" id="application-block">
            <p class="header">Подача заявки на пост тренера национальной сборной</p>
            <form method="POST">
                <table class="striped w100">
                    <tr>
                        <td class="right w25">Страна:</td>
                        <td>
                            <select name="country_id" id="application-country-id">
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?=$item['country_id']?>">
                                        <?=$item['country_name']?> (<?=$item['count']?> канд.)
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">Ваша программа:</td>
                        <td>
                            <textarea class="w98" rows="5" name="text" id="application-text"><?php

                            if (isset($application_array[0]['coachapplication_text']))
                            {
                                print $application_array[0]['coachapplication_text'];
                            }

                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="center" colspan="2">
                            <input type="submit" value="Подать заявку" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>