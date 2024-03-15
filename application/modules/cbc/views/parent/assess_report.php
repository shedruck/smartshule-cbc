<?php
$range = range(date('Y') - 10, date('Y'));
$yrs = array_combine($range, $range);
krsort($yrs);

$y_opt = [];
foreach ($yrs as $k => $v)
{
    $y_opt[$k] = $v;
}
?>
<div class="cr bg-white" id="assess">
    <div class="card-body">
        <div class="row hidden-print">
            <div class="col-md-10">
                <h4 class="text-uppercase">CBC Assessment Report</h4>
            </div>
            <div class="col-md-2">
                  <?php
                if ($this->input->get('p'))
                {
                    ?>
                    <button type="button"class="btn btn-info" onclick="window.print(); return false"><i class="fa fa-print"></i> Print</button>
                <?php } ?>
            </div>
        </div>
        <hr class="hidden-print">
        <?php echo form_open(current_url(), 'class="horizontal form-main p-10 hidden-print" '); ?>
        <div class="form-group row">
            <div class="col-sm-4">
                Learning Area: <br>
                <div>
                    <?php echo form_dropdown('subject', ['' => ''] + $subjects, $sel, ' class="fsel form-control" '); ?>
                </div>
            </div>
            <div class="col-sm-4">
                Term: <br>
                <div>
                    <?php echo form_dropdown('term', ['' => ''] + $this->terms, $term, ' class="fsel form-control" '); ?>
                </div>
            </div>
            <div class="col-sm-4">
                Year: <br>
                <div>
                    <?php echo form_dropdown('year', ['' => ''] + $y_opt, $year, ' class="fsel form-control" '); ?>
                </div>
            </div>
        </div>
        <div class='clearfix'></div>
        <div class="row">
            <div class="offset-md-3 col-sm-4">
                <button type="submit" class="btn btn-info" ><i class="fa fa-check"></i> Submit</button>
              
            </div>
        </div>
        </form>
        <hr class="hidden-print"> 
        <?php
        if (empty($assess))
        {
            ?>
            <div class="alert alert-danger" role="alert">
                <strong>Sorry!</strong> No result found.
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="img-container">
                <img src="<?php echo base_url('uploads/r-header.png'); ?>" style="width:358px;" alt="header">
            </div>
            <div class="text-center">
                <h4><strong>ASSESSMENT REPORT</strong></h4>
                <h4 class="text-uppercase"><ins>NAME:</ins> <?php echo $assess->student; ?>  &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; <?php echo $assess->adm; ?> &nbsp;&nbsp;&nbsp; <ins>Age:</ins><?php echo $assess->age; ?></h4>
                <p>
                    <span class="text-uppercase"><?php echo $assess->class ?> Term <?php echo $term; ?> - <?php echo $year; ?></span>
                </p>
            </div>

            <div class="clearfix"></div>
            <hr>
            <div class="">
                <center><img src="<?php echo base_url('/uploads/files/key.png'); ?>"></center>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <?php
                        foreach ($assess->strands as $index => $mk)
                        {
                            ?>
                            <tr class="fbg">
                                <td><?php echo $index + 1; ?>.0</td>
                                <td class="text-uppercase"><?php echo $mk->name ?></td>
                                <td><?php echo $mk->rating ?></td>
                                <?php
                                if ($index == 0)
                                {
                                    ?>
                                    <td width='30%'><span>Teacher Comments</span></td>
                                <?php } ?>
                            </tr>
                            <?php
                            foreach ($mk->subs as $sx => $sub)
                            {
                                ?>
                                <tr>
                                    <td class="<?php echo count((array) $sub->tasks) ? 'fbg' : ''; ?>"><?php echo $index + 1; ?>.<?php echo $sx + 1; ?></td>
                                    <td class="<?php echo count((array) $sub->tasks) ? 'fbg' : ''; ?>"><strong><?php echo $sub->name; ?></strong></td>
                                    <td class="<?php echo count((array) $sub->tasks) ? 'fbg' : ''; ?>">
                                        <?php echo $sub->rating; ?>
                                    </td>
                                    <?php
                                    if ($sx != 0)
                                    {
                                        ?>
                                        <td class="<?php echo count((array) $sub->tasks) ? 'fbg' : ''; ?>" ></td>
                                    <?php } ?>
                                    <?php
                                    if ($sx == 0)
                                    {
                                        ?>
                                        <td rowspan="<?php echo (count((array) $sub->tasks)) + 1; ?>"><?php echo $sub->remarks; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                foreach ($sub->tasks as $tx => $t)
                                {
                                    ?>
                                    <tr>
                                        <td> </td>
                                        <td><?php echo $t->task; ?></td>
                                        <?php
                                        if ($sx == 0)
                                        {
                                            ?>
                                            <td><?php echo $t->rating; ?></td>
                                        <?php } ?>
                                        <?php
                                        if ($sx != 0)
                                        {
                                            ?>
                                            <td><?php echo $t->rating; ?></td>
                                        <?php } ?>
                                        <?php
                                        if ($sx != 0 && $tx == 0)
                                        {
                                            ?>
                                            <td rowspan="<?php echo count((array) $sub->tasks); ?>">
                                                <?php echo ucfirst($sub->remarks); ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>

    </div>
</div>
<script type="text/javascript">
    $(function ()
    {
        $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
    });
</script>
<style>
    @media print {
        .inner-wrapper .header, .theiaStickySidebar, .hidden-print, .hidden-print * { display: none !important; }
        .page-wrapper { padding: 0px 15px 0 15px;   margin-top: 0px; }
    }
    .img-container{text-align: center;display: block; } 
    .fbg{background: #f5f6fa; font-weight: bold;}
</style>