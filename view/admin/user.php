<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Просмотр пользователя</h1>
        <button type="button" class="btn btn-default">
            <a href="user_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
    </div>
</div>
<form method="POST">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="col-lg-6 text-right">Логин</td>
                    <td><?= $user_array[0]['user_login']; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Email</td>
                    <td><?= $user_array[0]['user_email']; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Дата регистрации</td>
                    <td><?= f_igosja_ufu_date_time($user_array[0]['user_registration_date']); ?></td>
                </tr>
                <tr>
                    <td class="text-right">Дата последнего посещения</td>
                    <td><?= f_igosja_ufu_last_visit($user_array[0]['user_last_visit']); ?></td>
                </tr>
                <tr>
                    <td class="text-right">Имя</td>
                    <td><?= $user_array[0]['user_firstname']; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Фамилия</td>
                    <td><?= $user_array[0]['user_lastname']; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Дата рождения</td>
                    <td><?= $user_array[0]['user_birth_day']; ?>.<?= $user_array[0]['user_birth_month']; ?>.<?= $user_array[0]['user_birth_year']; ?></td>
                </tr>
                <?php if (!empty($user_array[0]['user_social_vk'])) { ?>
                    <tr>
                        <td class="text-right">Вконтакте</td>
                        <td>
                            <a href="http://vk.com/id<?php print $user_array[0]['user_social_vk']; ?>" target="_blank">
                                Профиль
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (!empty($user_array[0]['user_social_fb'])) { ?>
                    <tr>
                        <td class="text-right">Facebook</td>
                        <td>
                            <a href="https://www.facebook.com/app_scoped_user_id/<?= $user_array[0]['user_social_fb']; ?>" target="_blank">
                                Профиль
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (!empty($user_array[0]['user_social_gl'])) { ?>
                    <tr>
                        <td class="text-right">Google+</td>
                        <td>
                            <a href="https://plus.google.com/<?= $user_array[0]['user_social_gl']; ?>" target="_blank">
                                Профиль
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="text-right">Денежный счет</td>
                    <td><?= $user_array[0]['user_money']; ?> ед.</td>
                </tr>
                <tr>
                    <td class="text-right">Количество клубных постов</td>
                    <td><?= $user_array[0]['user_team']; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Количество сборных постов</td>
                    <td><?= $user_array[0]['user_national']; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Количество трофеев</td>
                    <td><?= $user_array[0]['user_trophy']; ?></td>
                </tr>
                <?php if ($user_array[0]['team_id']) { ?>
                    <tr>
                        <td class="text-right">Клуб</td>
                        <td>
                            <img src="/img/team/12/<?= $user_array[0]['team_id']; ?>.png" />
                            <a href="team.php?num=<?= $user_array[0]['team_id']; ?>">
                                <?= $user_array[0]['team_name']; ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right">Баланс клуба</td>
                        <td><?= f_igosja_money($user_array[0]['team_finance']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Время входа</th>
                    <th>IP адрес</th>
                </tr>
                <?php foreach ($ip_array as $item) { ?>
                    <tr>
                        <td><?= f_igosja_ufu_date_time($item['ip_date']); ?></td>
                        <td><?= $item['ip_ip']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>