<?php
if ($this->input->get('sb'))
{
        $sel = $this->input->get('sb');
}
elseif ($this->session->userdata('sub'))
{
        $sel = $this->session->userdata('sub');
}
else
{
        $sel = 0;
}
?>
<div class="row card-box table-responsive">
<div class="col-md-4">
    <div class="card-bx">
        <h4 class="header-title m-t-0 m-b-30">Select a Subject</h4>
        <div class="inbox-widget ">
            <?php
            $i = 0;
            // print_r($subjects);die();
            foreach ($subjects as $sj => $dets)
            {
				  	$check = $this->trs_m->check_sub($this->profile->id,$sj);
				if ($check){
					
                    $ds = (object) $dets;
                    if ($ds->full == '')
                    {
                            continue;
                    }
                    $i++;
                    $cll = $sel == $sj ? 'sel' : '';
                    ?> 
                    <a href="<?php echo current_url() . '?sb=' . $sj; ?>&name=<?php echo $ds->full?>">
                        <div class="inbox-item <?php echo $cll; ?>">
                            <div class="inbox-item-img"><span class="avatar-sm-box bg-primary"><?php echo $i ?>.</span></div>
                            <p class="inbox-item-author"><?php echo $ds->full; ?></p>
                            <p class="inbox-item-text">&nbsp;</p>
                            <p class="inbox-item-date"> </p>
                        </div>
                    </a>
				<?php } ?>
            <?php } ?>

        </div>

    </div> <!-- end card -->
    <hr class="hidden-lg hidden-md">
</div>

<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Exams Marks
            <div class="pull-right">                          
                <?php echo anchor('trs/record/', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-primary"'); ?>
            </div>    					
        </h2> 
    </div>
    <div class="card-box">
        <br>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url() . '?sb=' . $sb, $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3 control-label" for='grading'>Grading System <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('grading', array('' => '') + $grading, isset($sel_gd) ? $sel_gd : '', ' class="select form-control" data-placeholder="Select Grading System" ');
                echo form_error('grading');
                ?>
            </div>
        </div>
        <h3 style="text-align:center; text-decoration:underline"><?php echo $class_name; ?></h3>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3 control-label">&nbsp;</div>
                <div class="col-md-9">
                    <div class="col-md-4 nof">
                        <span class="control-label pull-right">Convert to % From </span>
                    </div>
                    <div class="col-md-5 nof">
                        <div class="col-md-6 nof">
                            <?php echo form_input('outof', $this->input->post() ? $this->input->post('outof') : 100, ' id="outof" class="form-control" style="width:100%" placeholder="Marks out of" '); ?>
                        </div>
                        <div class="col-md-4 nof">
                            <button type="button" class="btn btn-primary" title="Update" id="reff"><i class="mdi mdi-refresh"></i></button>
                        </div>
                    </div>
                </div>
            </div>      
        </div>   
        <?php
        if (count($students))
        {
                ?>
                <table class="table table-striped table-bordered " id="scores" >
                    <thead>
                        <tr > 
                            <th width="3%">#</th>
                            <th width="20%">Student</th>
                            <?php
                            $sel = (object) $selected;
                            if (isset($sel->units))
                            {
                                    foreach ($sel->units as $utk => $utt)
                                    {
                                            ?>
                                            <th>
                                                <abbr title=" <?php echo $utt; ?>">
                                                    <?php echo $utt; ?>
                                                </abbr>
                                            </th>
                                            <?php
                                    }
                            }
                            ?>
                            <th> Total Marks</th>
                            <?php
                            if ($assign)
                            {
                                    ?>
                                    <th><input type="checkbox" class="checkall"/></th>                                    
                            <?php } ?>
        <!--                    <th width="15%">Remarks</th>-->
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php
                        //convert to array for sorting
                        $list = json_decode(json_encode($students), true);
                        //sort 
                        aasort($list, 'first_name');
                        //return to object
                        $students = json_decode(json_encode($list));
                        $i = 1;
                        $tot_class = '';

                        foreach ($students as $post):
                                $std = $this->worker->get_student($post->id);
                                $mk = isset($result[$post->id]) ? (object) $result[$post->id] : array();
                                $mkbase = isset($mk->marks) ? (object) $mk->marks : new stdClass();
                                ?>  
                                <tr>
                                    <td>
                                        <span id="reference" name="reference" class="heading-reference"><?php echo $i . '. '; ?></span>
                                    </td>
                                    <td> 
									<?php echo $std->first_name . ' ' . $std->last_name; ?>  <br>
									<b><?php
											if (!empty($std->old_adm_no))
											{
													echo $std->old_adm_no;
											}
											else
											{
													echo $std->admission_number;
											}
										?></b>
									</td>
                                    <?php
                                    if (isset($sel->units))
                                    {
                                            $tot_class = 'totd_' . $sb;
                                            $units = isset($mkbase->units) ? $mkbase->units : array();
                                            foreach ($sel->units as $utk => $utt)
                                            {
                                                    ?>
                                                    <td>
                                                        <?php
                                                        $uval = isset($units[$utk]) ? $units[$utk] : '';
                                                        if ($this->input->post('units'))
                                                        {
                                                                $usetval = $this->input->post('units');
                                                                $uval = $usetval[$post->id][$utk];
                                                        }
                                                        $unm = 'units[' . $post->id . '][' . $utk . ']';
                                                        echo form_input($unm, $uval, ' placeholder="Marks" id="'.$utk.'" class="umarks mkd_' . $sb . ' form-control" ');
                                                        echo form_error('units');
                                                        ?>
                                                    </td>
                                                    <?php
                                            }
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        $val = isset($mkbase->mk) ? $mkbase->mk : '';
                                        if ($this->input->post('marks'))
                                        {
                                                $setval = $this->input->post('marks');
                                                $val = $setval[$post->id];
                                        }
                                        $nm = 'marks[' . $post->id . ']';
                                        echo form_input($nm, $val, '  placeholder="Total Marks" id="'.$nm.'" class="marks ' . $tot_class . ' form-control" ');
                                        echo form_error('marks');
                                        ?>
                                    </td>                                 
                                    <?php
                                    if ($assign)
                                    {
                                            $elc = 'done[' . $post->id . ']';
                                            $chhk = (isset($mkbase->inc) && $mkbase->inc) ? 'checked="checked" ' : '';
                                            ?>
                                            <td><input type="checkbox" name="<?php echo $elc; ?>" <?php echo $chhk; ?> value="<?php echo $post->id; ?>"/></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                        endforeach;
                        ?>		
                    </tbody>
                </table>
                <div class='form-group'>
                    <div class="col-md-10"> 
                        <?php echo anchor('trs/record', 'Cancel', 'class="btn btn-default"'); ?>
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                    </div>
                </div>

        <?php } ?> 

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>
<style>
    label{padding-top: 0 !important;}
    .nof{padding-left: 1px !important;
         padding-right: 1px !important; 
         padding-top: 1px !important;}
    .sel{background: #d2d213;}
</style>
<script>
        $(document).ready(function ()
        {
            $('#reff').click(function ()
            {
                refresh();
            });
            function refresh()
            {
                $('#scores > tbody  > tr').each(function ()
                {
                    if ($(this).find(".umarks").length == 0)
                    {
                        return false;
                    }
                    var percent;
                    var totals = 0;
                    var $tr = $(this);
                    var outof = $('#outof').val();
                    $tr.find(".umarks").each(function ()
                    {
                        totals += parseInt($(this).val()) || 0;
                    });
                    if (outof == 100)
                    {
                        percent = totals;
                    }
                    else
                    {
                        percent = Math.round((totals / outof) * 100);
                    }
                    $tr.find(".marks").val(percent);
                });
            }
            $('.marks').on('blur', function ()
            {
                var tt = 0;
                $(this).closest('tr').find(".marks").each(function ()
                {
                    tt += parseInt($(this).val()) || 0;
                });

                $(this).closest('tr').find(".total").val(tt);
            });

            var val;
            $('.umarks').on('blur', function ()
            {
                var unit_tot = 0;
                var $tr = $(this).closest('tr');

                var get = $.grep(this.className.split(" "), function (v, i)
                {
                    return v.indexOf('mkd_') === 0;
                }).join();
                val = get.match(/\bmkd_(\d+)\b/)[1];

                $tr.find(".mkd_" + val).each(function ()
                {
                    unit_tot += parseInt($(this).val()) || 0;
                });
                $tr.find(".totd_" + val).val(unit_tot);

                /**--------------Update Total Score-------------------*/
                var tt = 0;
                $(this).closest('tr').find(".marks").each(function ()
                {
                    tt += parseInt($(this).val()) || 0;
                });

                $(this).closest('tr').find(".total").val(tt);

            });

            $(".marks,.umarks").on("keypress", function (event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                    notify('Only Numbers allowed');
                }
            });
        });
</script>
