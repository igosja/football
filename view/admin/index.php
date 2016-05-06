<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Административный раздел</h1>
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
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Подробнее</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
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
<script>
    var registration_date = [<?= $registration_date; ?>];
    var registration_user = [<?= $registration_user; ?>];
</script>