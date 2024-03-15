<?php
$range = array();
for ($i = 1; $i <= 12; $i++)
{
        $range[$i] = date('F', mktime(0, 0, 0, $i, 10));
}
$students = array();
foreach ($this->parent->kids as $k)
{
        $usr = $this->admission_m->find($k->student_id);
        $students[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name);
}
$yrange = range(date('Y') - 2, date('Y'));
$yrs = array_combine($yrange, $yrange);
krsort($yrs);

function draw_calendar($month, $year, $att)
{
        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array('Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri ', 'Sat');
        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;

        /* row for week one */
        $calendar .= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for ($x = 0; $x < $running_day; $x++):
                $calendar .= '<td class="calendar-day-np"> </td>';
                $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
                $calendar .= '<td class="calendar-day">';
                /* add in the day number */
                if ($running_day == 6 || $running_day == 0)
                {
                        $calendar .= '<span class="circle off"></span>
                            <span class="date">' . $list_day . '</span>';
                }
                else
                {
                        if ($att[$list_day] == 1)
                        {
                                $calendar .= '<span class="circle present"></span>
                                                    <span class="date">' . $list_day . '</span>';
                        }
                        elseif ($att[$list_day] == 3)
                        {
                                $calendar .= '<span class="circle off"></span>
                                                    <span class="date">' . $list_day . '</span>';
                        }
                        else
                        {
                                $calendar .= '<span class="circle absent"></span>
                                                    <span class="date">' . $list_day . '</span>';
                        }
                }

                $calendar .= '</td>';
                if ($running_day == 6):
                        $calendar .= '</tr>';
                        if (($day_counter + 1) != $days_in_month):
                                $calendar .= '<tr class="calendar-row">';
                        endif;
                        $running_day = -1;
                        $days_in_this_week = 0;
                endif;
                $days_in_this_week++;
                $running_day++;
                $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if ($days_in_this_week < 8):
                for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
                        $calendar .= '<td class="calendar-day-np"> </td>';
                endfor;
        endif;

        /* final row */
        $calendar .= '</tr>';
        /* end the table */
        $calendar .= '</table>';
        /*  done, return result */
        return $calendar;
}
?>
<div class="row " id="x-acts">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h6>&nbsp;</h6>
        <?php echo form_open(current_url()); ?>
        Student:
        <?php echo form_dropdown('student', array('' => 'Select Student') + $students, $this->input->post('student'), 'class="xsel"'); ?>
        Month:
        <?php echo form_dropdown('month', array('' => 'Select') + $range, $this->input->post('month'), 'class="tsel"'); ?>
        &nbsp;
        Year:
        <?php echo form_dropdown('year', array('' => 'Select') + $yrs, $this->input->post('year'), 'class="tsel"'); ?>
        &nbsp;
        <button type="submit" class="btn btn-custom">Submit</button>
        <?php
        echo form_close();
        ?>
        <?php
        if (!empty($att))
        {
                ?>
                <div class="app">
                    <div class="topwid">
                        <div class="ft">
                            <span class="result">
                                <h3 class="numx"><?php echo date('F', mktime(0, 0, 0, $month, 10)); ?> <?php echo $year; ?></h3><hr>                        
                            </span>
                        </div>
                    </div>
                    <div class="attwid">
                        <div class="attendance"> 
                            <?php echo draw_calendar($month, $year, $att); ?>              
                            <div class="clearfix"></div>
                            <hr>
                            <div class="leg">
                                <span class="circle present"></span>
                                <span class="dess">Present</span>
                            </div>
                            <div class="leg">
                                <span class="circle absent"></span>
                                <span class="dess">Absent</span>
                            </div>
                            <div class="leg">
                                <span class="circle off"></span>
                                <span class="dess">Not Recorded</span>
                            </div>

                        </div>
                    </div>

                </div>
        <?php } ?>
    </div>
</div>
<script>
        $(document).ready(function ()
        {
            $(".xsel").select2({'placeholder': 'Please Select', 'width': '260px'});
            $(".tsel").select2({'placeholder': 'Please Select', 'width': '120px'});

        });
</script>

<style>
    table.calendar{ border-left:1px solid #999;     width: 100%;}
    table.calendar   td.calendar-day-head
    { 
        font-weight:bold; text-align:center; width:14.3%;  
        text-transform: uppercase;
        font-size: 12px;
        padding-top: 20px;
        color: rgba(255,255,255,0.2);
    }
    /* shared */
    table.calendar  td.calendar-day, td.calendar-day-np {  padding:5px; }
</style>