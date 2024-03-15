<?php
if ($this->input->get()) {
    $get = (object) $this->input->get();
} else {
    $get = [];
}
?>
<div class="row ">
    <div class="col-md-12">
        <?php if (isset($strands)) { ?>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center align-items-center m-2">
                        <img class="me-2 w-40p" src="../assets/images/icons/1.png" alt="">
                        <div>
                            <h5 class="mb-0"><b><?php echo $class ?></b></h5>
                            <p class="mb-0 text-muted"><?php echo $subject ?></p>
                        </div>


                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="d-lg-flex d-block">
                        <div class="p-4 border-end w-100">
                            <div class="nav flex-column nav-pills ms-3" id="vertical-tab" role="tablist" aria-orientation="vertical">
                                <?php
                                foreach ($strands as $p) {
                                    $sbss =  isset($substrands[$p->id]) ? $substrands[$p->id] : '';
                                    $clas = '';
                                    $col = 'collapsed';

                                    if (isset($get->strand)) {
                                        if ($get->strand == $p->id) {
                                            $clas = 'show';
                                            $col = '';
                                        }
                                    }




                                ?>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button <?php echo $col ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $p->id ?>" aria-expanded="false" aria-controls="collapseTwo">
                                                <i class="bi bi-bookmarks me-2"></i><?php echo $p->name ?>
                                            </button>
                                        </h2>

                                        <div id="collapse_<?php echo $p->id ?>" class="accordion-collapse collapse <?php echo $clas ?>" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php
                                                foreach ($sbss as $s) {

                                                    $cls = '';
                                                    if (isset($get->substrand)) {
                                                        if ($get->substrand == $s->id) {
                                                            $cls = 'text-success fs-24';
                                                        }
                                                    }
                                                ?>
                                                    <a href="<?php echo current_url() . '?strand=' . $p->id . '&substrand=' . $s->id ?>" class="nav-link text-start <?php echo $cls ?> " id="vertical-terms-tab" aria-selected="true"><i class="bi bi-arrow-return-right me-2"></i> <?php echo $s->name ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>


                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="p-6">

                            <?php
                            if (isset($rubric)) {
                            ?>

                                <div>
                                    <h5 class="mb-0"><b><?php echo $strand ?></b></h5>
                                    <p class="mb-0 text-muted"><?php echo $substrand ?></p>
                                </div>

                                <div class="table-responsive push">
                                    <table class="table table-bordered text-nowrap">
                                        <tbody>
                                            <tr class="table-primary bg-primary">
                                                <th class="text-center tx-fixed-white">#</th>
                                                <th class="tx-fixed-white">Rubric</th>
                                            </tr>
                                            <?php
                                            $index = 1;

                                            foreach ($rubric as $r) {

                                                $par = [
                                                    'strand' => $get->strand,
                                                    'substrand' => $get->substrand,
                                                    'task' => $r->id,
                                                    'class' => $attr[0],
                                                    'subject' => $attr[1]
                                                ];

                                                $argss = $this->cbc_tr->encryptParameters($par);
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index ?></td>
                                                    <td>
                                                        <p class="font-w600 mb-1"><?php echo $r->name ?> <br>

                                                        <a style="float:" href="<?php echo base_url('cbc/trs/perform_assessment').'?arg='. $argss?>" onclick="return confirm('Are you sure to do assessment?')" class="btn btn-success mb-1 d-inline-flex"><i class="si si-paper-plane me-1 lh-base"></i> Begin Assessment</a></p>
                                                        <table class="table table-bordered text-nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th>BE</th>
                                                                    <th>AE</th>
                                                                    <th>ME</th>
                                                                    <th>EE</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($r->remarks as $obj) {

                                                                ?>
                                                                    <tr>
                                                                        <td> <?php echo $this->cbc_tr->wrapWords($obj->be_remarks) ?> </td>
                                                                        <td><?php echo $this->cbc_tr->wrapWords($obj->ae_remarks) ?> </td>
                                                                        <td> <?php echo $this->cbc_tr->wrapWords($obj->me_remarks) ?></td>
                                                                        <td><?php echo $this->cbc_tr->wrapWords($obj->ee_remarks) ?></td>
                                                                    </tr>

                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </td>


                                                </tr>
                                            <?php $index++;
                                            } ?>


                                        </tbody>
                                    </table>

                                </div>


                            <?php } else { ?>
                                <div class="tab-content terms" id="vertical-tabContent">
                                    <div class="tab-pane fade show active" id="vertical-terms" role="tabpanel" aria-labelledby="vertical-terms-tab" tabindex="0">
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <div class="card border-top border-info">
                                                <div class="card-body text-center">
                                                    <span class="avatar avatar-lg bg-info rounded-circle"><i class="fe fe-bell" aria-hidden="true"></i></span>
                                                    <h4 class="fw-semibold mb-1 mt-3">Alert</h4>
                                                    <p class="card-text text-muted">Please select Strand and Substrand first!</p>
                                                </div>
                                                <div class="card-footer text-center border-0 pt-0">
                                                    <div class="row">
                                                        <div class="text-center">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-check d-inline-block">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            Send a copy on my email
                        </label>
                    </div>
                    <div class="float-end d-inline-block btn-list">
                        <a class="btn btn-primary">Decline</a>
                        <a class="btn btn-secondary">Agree and Continue</a>
                    </div>
                </div>
            </div>

        <?php } else { ?>

            <div class="col-md-6 col-lg-6 col-xl-6"></div>
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-header border-0 bg-danger-transparent">
                        <div class="alert-icon-style"><span class="avatar avatar-lg bg-danger rounded-circle"><i class="fe fe-info" aria-hidden="true"></i></span></div>
                        <div class="card-options">
                            <a href="javascript:void(0);" class="card-options-remove z-index1 text-danger go_back" data-bs-toggle="card-"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h4 class="fw-semibold mb-1 mt-3">Warning</h4>
                        <p class="card-text text-muted">OPPS!!! Content for <?php echo $subject ?> not found</p>
                    </div>
                    <div class="card-footer text-center border-0 pt-0">
                        <div class="row">
                            <div class="text-center">
                                <a href="javascript:void(0);" class="btn btn-danger me-2 go_back">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<style>
    .word-wrap {
        word-wrap: break-word;
        /* Ensure long words are broken */
        overflow-wrap: break-word;
        /* Ensure breaks occur within words */
        word-break: break-all;
        /* Force break between every pair of letters */
    }

    /* Forcing word breaks after every third word */
    .word-wrap::after {
        content: '\A';
        white-space: pre;
    }

    .word-wrap-three {
        /* Ensure long words are broken */
        word-wrap: break-word;
        /* Ensure breaks occur within words */
        overflow-wrap: break-word;
        /* Force break between every pair of letters */
        word-break: break-all;
    }

    /* Forcing word breaks after every third word */
    .word-wrap-three::after {
        content: '\A';
        white-space: pre;
        /* Insert space after every third word */
        display: inline;
        width: 100%;
    }
</style>