<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Self Appraisal</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="card">
                            <div class="card-header bg-default">
                                Target Details
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="bg-default">
                                        <tr>
                                            <th>Target</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($targets as $t) { ?>
                                            <tr>
                                                <td><?php echo ucfirst($t->target) ?></td>
                                                <td><?php echo ucfirst($t->description) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <hr>

                                <div class="card">
                                    <div class="card-header bg-default">
                                        Rating Legend
                                    </div>
                                    <div class="card-body">
                                        <fieldset class="border border-info p-2 w-100">
                                            <legend class="w-auto">Rating Legend</legend>
                                            <p>5 = Strongly Agree, <br>4 = Agree, <br>3 = Uncertain, <br>2 = Disagree, <br>1 = Strongly Disagree</p>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="card">
                            <div class="card-header bg-default">
                                Appraisal Form
                            </div>
                            <div class="card-body">
                                <?php echo form_open() ?>
                                <?php
                                foreach ($teacher as $mwalimu) {
                                ?>
                                    <input type="hidden" name="teacher" value="<?php echo $mwalimu->id ?>">

                                <?php } ?>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr class="bg-gradient-secondary">
                                            <th colspan="2" class=" p-1"><b>Targets</b></th>
                                            <th class="text-center">1</th>
                                            <th class="text-center">2</th>
                                            <th class="text-center">3</th>
                                            <th class="text-center">4</th>
                                            <th class="text-center">5</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tr-sortable">
                                        <?php
                                        $index = 1;
                                        foreach ($targets as $target) { ?>
                                            <tr class="bg-white">

                                                <td class="p-1 text-center" width="5px"><?php echo $index; ?></td>

                                                <td class="p-1" width="40%">
                                                    <?php echo $target->target ?>
                                                </td>
                                                <?php for ($c = 0; $c < 5; $c++) : ?>
                                                    <td class="text-center">
                                                        <div class="icheck-success d-inline">
                                                            <input type="radio" name="rate" id="<?php echo $c + 1 ?>" value="<?php echo $c + 1 ?>">
                                                            <label for="<?php echo $c + 1 ?>"><?php echo $c + 1 ?></label>
                                                        </div>
                                                    </td>
                                                <?php endfor; ?>
                                            </tr>
                                            <style>
                                                .icheck-success {
                                                    margin: 10px;
                                                }

                                                .icheck-success input[type="radio"] {
                                                    opacity: 0;
                                                    position: fixed;
                                                    width: 0;
                                                }

                                                .icheck-success label {
                                                    display: inline-block;
                                                    background-color: #ddd;
                                                    padding: 10px 20px;
                                                    font-family: sans-serif, Arial;
                                                    font-size: 16px;
                                                    border: 2px solid #444;
                                                    border-radius: 4px;
                                                }

                                                .icheck-success label:hover {
                                                    background-color: #dfd;
                                                }

                                                .icheck-success input[type="radio"]:focus+label {
                                                    border: 2px dashed #444;
                                                }

                                                .icheck-successinput[type="radio"]:checked+label {
                                                    background-color: #bfb;
                                                    border-color: #4c4;
                                                }
                                            </style>
                                        <?php $index++;
                                        } ?>
                                        <tr>
                                            <td colspan="7">
                                                <button style="float:right" class="btn btn-sm btn-success">Save</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
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