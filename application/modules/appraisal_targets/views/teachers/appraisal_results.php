<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Appraisal Results</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a class="btn btn-danger" onclick="goBack()"><i class=""></i> Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo   form_open_multipart(current_url(), $attributes);

                ?>
                <!-- <div class="row justify-content-center"> -->
                <div class="row justify-content-center">
                    <div class="col-md-3 col-lg-3 col-xl-3 m-2">
                        <?php
                        $range = range(date('Y') - 5, date('Y') + 1);
                        $yrs = array_combine($range, $range);
                        krsort($yrs);

                        echo form_dropdown('year', ['' => 'Please Year'] + $yrs, $this->input->post('year'), 'class="form-control js-example-placeholder-exam"')
                        ?>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3 m-2">
                        <?php
                        $terms = array(
                            'term1' => 'Term 1',
                            'term2' => 'Term 2',
                            'term3' => 'Term 3'
                        );
                        echo form_dropdown('term', ['' => 'Please select Term'] + $terms, $this->input->post('term'), 'class="form-control js-example-placeholder-exam"')
                        ?>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3 m-2">
                        <button type="submit" class="btn btn-sm btn-primary">submit</button>
                    </div>
                </div>
                <?php echo form_close() ?>
                <hr>
                <div class="row">
                    <?php
                    if (isset($results)) {
                    ?>
                        <?php if ($results) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable-basic">
                                    <thead class="bg-default">
                                        <th>#</th>
                                        <th>Period</th>
                                        <th>Target</th>
                                        <th>Appraiser</th>
                                        <th>Appraisee</th>
                                        <th>Score(Appraiser)</th>
                                        <th>Score(Appraisee)</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
                                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                        }

                                        foreach ($results as $p) :
                                            $rate = $p->rate;
                                            if ($rate == 5) {
                                                $score = "<span class='text-success'>Strongly Agree</span>";
                                            } elseif ($rate == 4) {
                                                $score = "<span class='text-primary'>Agree</span>";
                                            } elseif ($rate == 3) {
                                                $score = "<span class='text-secondary'>Uncertain</span>";
                                            } elseif ($rate == 2) {
                                                $score = "<span class='text-warning'>Disagree</span>";
                                            } elseif ($rate == 1) {
                                                $score = "<Span class='text-danger'>Strongly Disagree</span>";
                                            } else {
                                                $score = "<span class='text-muted'>INVALID DATA!</span>";
                                            }

                                            if ($p->created_by == 1) {
                                                $appraiser = 'Admin User';
                                            } else {
                                                $appraiser = 'Self';
                                            }

                                            if ($p->appraisee_rate == "") {
                                                $appraisee_ratee = 'Null';
                                            } else {
                                                if ($p->appraisee_rate == 5) {
                                                    $appraisee_ratee = "<span class='text-success'>Strongly Agree</span>";
                                                } elseif ($p->appraisee_rate == 4) {
                                                    $appraisee_ratee = "<span class='text-primary'>Agree</span>";
                                                } elseif ($p->appraisee_rate == 3) {
                                                    $appraisee_ratee = "<span class='text-secondary'>Uncertain</span>";
                                                } elseif ($p->appraisee_rate == 2) {
                                                    $appraisee_ratee = "<span class='text-warning'>Disagree</span>";
                                                } elseif ($p->appraisee_rate == 1) {
                                                    $appraisee_ratee = "<Span class='text-danger'>Strongly Disagree</span>";
                                                } else {
                                                    $appraisee_ratee = "<span class='text-muted'>INVALID DATA!</span>";
                                                }
                                            }

                                            $i++;
                                        ?>

                                            <tr>
                                                <td><?php echo $i . '.'; ?></td>
                                                <td><?php echo ucfirst($p->term . ', ' . $p->year) ?></td>
                                                <td><?php echo $p->target; ?></td>
                                                <td><?php echo $appraiser; ?></td>
                                                <td><?php echo ucfirst($p->first_name . ' ' . $p->last_name) ?></td>
                                                <td><?php echo $p->rate . ' <small>(' . $score . ')</small>' ?></td>
                                                <td><?php echo $p->appraisee_rate . ' <small>(' . $appraisee_ratee . ')</small>' ?></td>


                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php else : ?>
                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                        <?php endif ?>
                    <?php } ?>
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