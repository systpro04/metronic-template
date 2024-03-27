
<div class="page-container">
	<div class="page-content">
        <div class="container">		
           <div class="row margin-top-10">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">dashboard</span>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="" class="fullscreen" data-original-title="" title="">
								</a>
                                <a href="javascript:;" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
                                    <a class="dashboard-stat dashboard-stat-light blue-madison" href="<?= base_url('data_view') ?>">
                                    <div class="visual">
                                        <i class="fa fa-briefcase fa-icon-medium"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                        <?php echo $all_history_adjust; ?>

                                        </div>
                                        <div class="desc">
                                        Uniform History Adjustment
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-light red-intense" href="<?= base_url('data_view') ?>">
                                    <div class="visual">
                                        <i class="fa fa-ticket fa-icon-medium"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                        <?php echo $mop_count; ?>
                                        </div>
                                        <div class="desc">
                                            Mode of Payments( All Department)
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-light green-haze" href="<?= base_url('data_view') ?>">
                                    <div class="visual">
                                        <i class="fa fa-thumbs-up fa-icon-medium"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                        <?php echo $iad_count; ?>
                                        </div>
                                        <div class="desc">
                                           Iad Access
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
