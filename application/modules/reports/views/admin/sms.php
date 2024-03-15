<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Exams Report </h2>
    <div class="right">
    </div>
</div>
<div class="toolbar">
    <div class="noof">
        <?php
        $s1 = $rank ? '' : ' checked="checked" ';
        $s2 = '';
        $s3 = '';
        if ($rank)
        {
                $s1 = $rank == 1 ? ' checked="checked" ' : '';
                $s2 = $rank == 2 ? ' checked="checked" ' : '';
                $s3 = $rank == 3 ? ' checked="checked" ' : '';
        }
        ?> 
        <div class="col-md-10"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('group', array("" => " Select Class Group") + $this->classes, $this->input->post('group'), 'class ="selecte" '); ?> or 
            <?php echo form_dropdown('class', array("" => " Select Stream") + $ccc, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <br>
            <br>
            <fieldset>
                <legend>Ranking Options</legend>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r1" value="1" <?php echo $s1; ?>>
                    All Subjects
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r2" value="2" data-html="true" <?php echo $s2; ?>>
                    Best 7 - Option 1
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r3" value="3" data-html="true" <?php echo $s3; ?>>
                    Best 7  - Option 2
                </label>
            </fieldset>
            <br>
            <hr>
            <button class="btn btn-primary" name="preview" value="12" type="submit">Preview</button>
            &nbsp;
            <button class="btn btn-success" name="send" value="10" type="submit" onClick="return confirm('Confirm Send SMS?')">Send SMS</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<?php
$i = 0;
if (isset($res['xload']) && isset($res['max']) && $subjects)
{
        $xload = $res['xload'];
        $maxw = $res['max'];

        $sorter = $rank == 1 ? 'tots' : 'total_ranked';
        aasort($xload, $sorter, TRUE);

        foreach ($xload as $student => $results)
        {
                $rw = (object) $results;
                $i++;

                $std = $this->worker->get_student($student);

                        $jj = 0;
                        $fav = array();
                        $ftos = array();
                        $spans = array();

                $name = $std->first_name . ' ' . $std->last_name;
                                $messg = 'Hello Parent,  ' . $ex->title . ' - Term ' . $ex->term . '  ' . $ex->year . ' Results For ' . $name . ': ';

                                $grading_system = 0;
                                $count = 0;

                                foreach ($subjects as $ksub => $mkkd)
                                {
                                        $dts = (object) $mkkd;
                        $hap = isset($rw->mks[$ksub]) ? $rw->mks[$ksub] : array();
                                        if (empty($hap))
                                        {
                                                continue;
                                        }
                                        $mkf = (object) $hap;

                                        $ksp = 0;
                                        $count++;

                                        $rgd = $this->ion_auth->remarks($mkf->grading, $mkf->marks);
                                        $hs_grade = isset($rgd->grade) && isset($grades[$rgd->grade]) ? $grades[$rgd->grade] : '';

                                        $messg .= ' ' . $dts->title . ':' . $mkf->marks . str_replace(' ', '', $hs_grade) . ' ';
                                        $grading_system = $mkf->grading;
                                }

                $average = $rank > 1 ? round($rw->total_ranked / count($rw->ranked), 2) : round($rw->tots / $count, 2);
                                $avg_rw = $this->ion_auth->remarks($grading_system, $average);
                                $avg_grade = isset($avg_rw->grade) && isset($grades[$avg_rw->grade]) ? $grades[$avg_rw->grade] : '';
                                if (empty($avg_grade))
                                {
                                        $avg_grade = ' - ';
                                }
                $total = $rank > 1 ? $rw->total_ranked : $rw->tots;
                $messg .= ' TOTAL: ' . $total . ' MEAN GRADE: ' . $avg_grade . ' POS. ' . $i . '/' . count($xload);
                                $message = str_replace('  ', ' ', str_replace(' / ', '/', $messg));

                                if ($this->input->post('send') && $this->input->post('send') == 10)
                                {
                        $parent = $this->portal_m->get_parent($std->parent_id);
                                        if ($parent->sms == 1)
                                        {
                                                //both parents
                                                $phone = $parent->phone;
                                                $this->sms_m->send_sms($phone, $message);

                                                $phone2 = $parent->mother_phone;
                                $this->sms_m->send_sms($phone2, $message);
                                        }
                                        else
                                        {
                                                $phone = $parent->phone;
                                                if (empty($phone))
                                                {
                                                        $phone = $parent->mother_phone;
                                                }
                                                $this->sms_m->send_sms($phone, $message);
                                        }
                                }
                                else if ($this->input->post('preview'))
                                {
                                        echo '<div class="quote">' . $message . '</div>';
                                }
                                else
                                {
                                        
                                }
                                $jj++;
                        }
                }
?>
<script>
        $(document).ready(function ()
        {
            $(".selecte").select2({'placeholder': 'Select Option', 'width': '200px'});
        });
</script>
<style>
    .fless{width:100%; border:0;}
    .quote:before 
    {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        border-width: 0 3px 3px 0;
        border-style: solid;
        border-color: #658E15 #FFF;
        box-shadow: -3px 3px 5px rgba(0, 0, 0, 0.15);
        -webkit-transition: border-width 500ms ease, box-shadow 500ms ease; 
        transition: border-width 500ms ease, box-shadow 500ms ease;
    }

    .quote:hover:before {
        border-width: 0 1rem 1rem 0;
        box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.15);
        -webkit-transition: border-width 500ms ease, box-shadow 500ms ease; 
        transition: border-width 500ms ease, box-shadow 500ms ease;
    }

    .quote
    {
        position: relative;
        width: 93%;
        padding: 1rem 1.6rem;
        margin: 2rem auto;
        font: italic 21px/1.4 Opensans, serif;
        color: #fff;
        background: #245991;
        border-radius: 1rem;
    }

    .quote:after 
    {
        content: "";
        position: absolute;
        top: 100%;
        right: 25px;
        border-width: 10px 10px 0 0;
        border-style: solid;
        border-color: #245991 transparent;
    }
    .dropped
    {
        border-bottom: 3px solid silver;
    }
    legend
    {
        width: auto;
        padding: 4px;
        margin-bottom: 0;
        border: 0;
        font-size: 11px;
    }
    fieldset
    {
        padding: 5px;
        border: 1px solid silver;
        border-radius: 7px;
    }
</style>