<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Админ</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-info-circle fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $count_freeteam; ?></div>
                        <div>Свободные команды</div>
                    </div>
                </div>
            </div>
            <a href="team_free_list.php">
                <div class="panel-footer">
                    <span class="pull-left">Подробнее</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $count_userteam; ?></div>
                        <div>Менеджеры с командами</div>
                    </div>
                </div>
            </div>
            <a href="team_user_list.php">
                <div class="panel-footer">
                    <span class="pull-left">Подробнее</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php if ($count_event) { ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-times fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $count_event; ?></div>
                            <div>События матча</div>
                        </div>
                    </div>
                </div>
                <a href="eventerror_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Подробнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> График регистраций
            </div>
            <div class="panel-body">
                <div id="index-registration-chart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> График платежей
            </div>
            <div class="panel-body">
                <div id="index-payment-chart"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var registration_date   = [<?= $registration_date; ?>];
    var registration_user   = [<?= $registration_user; ?>];
    var payment_date        = [<?= $payment_date; ?>];
    var payment_sum         = [<?= $payment_sum; ?>];
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Последние пользователи (<a href="history.php">Подробнее</a>)
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Событие</th>
                                <th>Пользователь</th>
                                <th>Страна</th>
                                <th>Команда</th>
                                <th>Игрок</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history_array as $item) { ?>
                                <tr>
                                    <td><?= f_igosja_ufu_date_time($item['history_date']); ?></td>
                                    <td><?= $item['historytext_name']; ?></td>
                                    <td><?= $item['user_login']; ?></td>
                                    <td><?= $item['country_name']; ?></td>
                                    <td><?= $item['team_name']; ?></td>
                                    <td><?= $item['name_name']; ?> <?= $item['surname_name']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>