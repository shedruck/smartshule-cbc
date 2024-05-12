<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Self Appraisal</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a class="btn btn-success" href="<?php echo base_url('appraisal_targets/trs/appraisalResults'); ?>"><i class=""></i> Reports</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="card">
                    <div class="card-header bg-default">
                        Targets
                    </div>
                    <div class="card-body">
                        <!-- Targets Start Here -->
                        <div class="row">
                        <?php
                        if ($targets)
                            foreach ($targets as $target) {
                                $date_started = date_create($target->start_date);
                                $start_date = date_format($date_started, "d/M/Y");

                                $ending_date = date_create($target->end_date);
                                $end_date = date_format($ending_date, "d/M/Y");

                        ?>
                            <div class="col-lg-4 col-md-6">
                                <a href="<?php echo base_url('appraisal_targets/trs/selfAppraisal/'.$target->id); ?>">
                                <div class="card">
                                    <div class="card-header pb-0 border-bottom-0">
                                        <h3 class="card-title"><?php echo $target->target?></h3>
                                        <div class="card-options">
                                            <a class="btn btn-sm btn-success" href="<?php echo base_url('appraisal_targets/trs/selfAppraisal/'.$target->id); ?>"><i class="fa fa-send-o mb-0"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-body pt-0">
                                        <h6 class="d-inline-block mb-2">From : <span class="text-success"><?php echo $start_date?></span> </h6><br>
                                        <h6 class="d-inline-block mb-2">To : <span class="text-danger"><?php echo $end_date?></span></h6>
                                        <div class="progress h-2 mt-2 mb-2">
                                            <div class="progress-bar bg-default" style="width: 100%;" role="progressbar">
                                            </div>
                                        </div>
                                        <!-- <div class="float-start">
                                            <div class="mt-2">
                                                <i class="fa fa-caret-down text-success"></i>
                                                <span>5% decrease</span>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php } ?>
                        </div>
                        <!-- Targets End Here -->
                    </div>
                </div>
                <!-- </div> -->
            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
                </div>
                <div class="float-end d-inline-block btn-list">

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>