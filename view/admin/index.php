<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Администртивный раздел</h1>
    </div>
</div>
<div class="row">
    <?php if (0 != $count_support) { ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $count_support ?></div>
                            <div>Новые вопросы в ТП!</div>
                        </div>
                    </div>
                </div>
                <a href="support_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Детальнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>