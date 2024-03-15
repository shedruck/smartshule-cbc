<div class="col-md-12">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Exams Management</h2>
        <div class="right">
            <?php echo anchor('admin/exams/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);

        if (count($subjects) < 1)
        {
                ?>
                <div class="col-md-6">
                    <div class="alert alert-block">     
                        <strong>Error!</strong> You Must Add All Subjects First Before Recording Exam Marks
                        <br><br>Add Subjects <?php echo anchor('admin/subjects', 'Here'); ?>
                    </div>
                </div>
                <?php
        }
        else
        {
                ?>
                <table class="table table-striped table-bordered " >
                    <!-- BEGIN -->
                    <thead>
                        <tr>
                            <th width="3%">#</th>
                            <th width="">Student</th>
                            <?php
                            foreach ($subjects as $sbj => $dtls):
                                    $dts = (object) $dtls;

                                    $sttr = '';
                                    if (isset($dts->units))
                                    {
                                            foreach ($dts->units as $utk => $utt)
                                            {
                                                    $sttr .=' ' . $utt . ', ';
                                                    ?>
                                                    <th><abbr title=" <?php echo $utt; ?>">
                                                            <?php echo $utt; ?>
                                                        </abbr>
                                                    </th>
                                                    <?php
                                            }
                                            $sttr = rtrim($sttr, ', ');
                                    }
                                    ?>
                                    <th><abbr title="<?php echo isset($dts->units) ? 'Total For :' . $sttr : $dts->title; ?>">
                                            <?php echo isset($dts->units) ? 'TOTAL ' : $dts->title; ?>
                                        </abbr>
                                    </th>
                                    <?php
                            endforeach;
                            ?>			
                            <th>Overall</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php
                        $sses = array();
                        foreach ($students as $tu)
                        {
                                if (!array_key_exists($tu->id, $result))
                                {
                                        foreach ($subjects as $skk => $pss)
                                        {
                                                $fk = array();
                                                $sp = (object) $pss;
                                                if (isset($sp->units))
                                                {
                                                        foreach ($sp->units as $utk => $utt)
                                                        {
                                                                $fk[$utk] = 0;
                                                        }
                                                }

                                                $result[$tu->id]['marks'][] = empty($fk) ? array('subject' => $skk, 'marks' => '') : array('subject' => $skk, 'marks' => '', 'units' => $fk);
                                                $result[$tu->id]['total'] = 0;
                                                $result[$tu->id]['remarks'] = '';
                                        }
                                }
                        }

                        $i = 1;

                        foreach ($result as $sid => $posts):
                                $std = $this->worker->get_student($sid);
                                $post = isset($posts['marks']) ? $posts['marks'] : array();
                                ?>
                                <tr>
                                    <td >
                                        <span id="reference" name="reference" class="heading-reference"><?php echo $i . '. '; ?></span>
                                    </td> 
                                    <td>
                                        <?php echo $std->first_name . ' ' . $std->last_name; ?>
                                    </td>
                                    <?php
                                    foreach ($subjects as $skid => $paas)
                                    {
                                            if (!in_multiarray($skid, $post, 'subject') && (isset($paas['opt']) && $paas['opt'] == 1))
                                            {
                                                    $post[] = array('subject' => $skid, 'marks' => '', 'add' => 0);
                                            }
                                    }

                                    foreach ($post as $sts)
                                    {
                                            $pst = (object) $sts;
                                            if (isset($pst->units))
                                            {
                                                    foreach ($pst->units as $uts => $utm)
                                                    {
                                                            ?>
                                                            <td>
                                                                <?php
                                                                $uval = $utm;
                                                                if ($this->input->post('marks'))
                                                                {
                                                                        $usetval = $this->input->post('marks');
                                                                        $uval = $usetval[$sid][$pst->subject . '_' . $uts];
                                                                }
                                                                $unm = 'marks[' . $sid . '][' . $pst->subject . '_' . $uts . ']';
                                                                echo form_input($unm, $uval, ' placeholder="Marks" class="umarks" ');
                                                                echo form_error('marks');
                                                                ?>
                                                            </td>
                                                            <?php
                                                    }
                                            }
                                            ?>
                                            <td>
                                                <?php
                                                $val = $pst->marks;
                                                $dclass = isset($pst->add) ? '' : 'class="marks"';
                                                if ($this->input->post('marks'))
                                                {
                                                        $setval = $this->input->post('marks');
                                                        $val = $setval[$sid][$pst->subject];
                                                }
                                                $nm = 'marks[' . $sid . '][' . $pst->subject . ']';
                                                echo form_input($nm, $val, '  placeholder="Marks" ' . $dclass);
                                                echo form_error('marks');
                                                ?>
                                            </td>
                                    <?php } ?>
                                    <td>
                                        <?php
                                        $ival = isset($posts['total']) ? $posts['total'] : '';
                                        if ($this->input->post('total'))
                                        {
                                                $tval = $this->input->post('total');
                                                $ival = $tval[$i - 1];
                                        }
                                        echo form_input('total[]', $ival, 'id="markst_' . $i . '" class="total" ');
                                        echo form_error('total');
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $rval = isset($posts['remarks']) ? $posts['remarks'] : '';
                                        if ($this->input->post('remarks'))
                                        {
                                                $rmval = $this->input->post('remarks');
                                                $rval = htmlspecialchars_decode($rmval[$i - 1]);
                                        }
                                        ?>
                                        <textarea name="remarks[]" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks_<?php echo $i; ?>"><?php echo $rval; ?></textarea>
                                        <?php echo form_error('remarks'); ?>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                        endforeach;
                        ?>		
                    </tbody>
                </table>
                <div class='form-group'>
                    <div class="col-md-10"> 
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                        <?php echo anchor('admin/exams_management', 'Cancel', 'class="btn btn-danger"'); ?>
                    </div>
                </div>

        <?php } ?> 

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script>

        $(function () {
            $('.marks, .marks_ng, .marks_ks, .marks_ss').on('blur', function ()
            {
                var tt = 0;
                $(this).closest('tr').find("input[class='marks']").each(function ()
                {
                    tt += parseInt($(this).val()) || 0;
                });

                $(this).closest('tr').find("input[class='total']").val(tt);
            });
        });

</script>
