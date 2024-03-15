<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Activities Report</h2> 
    <div class="right">                       
    </div>    					
</div>

<div class="toolbar">
    <div class="col-md-10"><br/>
        <?php echo form_open(current_url()); ?>
        Activity
        <?php echo form_dropdown('act', array('' => 'Select Activity') + $list, $this->input->post('act'), 'class ="tsel" '); ?>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->classes, $this->input->post('class'), 'class ="tsel" '); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>

    </div>
    <div class="col-md-2"><br/>
        <button class="btn btn-primary"  type="submit">View Report</button>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <h1> </h1>

    <div class="row">
        <div class="col-md-10">

            <h3>Activities Report </h3>
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="3%">#</th>
                        <th width="20%">Name</th>
                        <th width="20%">Class</th>
                        <th width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $fsum = 0;
                    $tsum = 0;
                    foreach ($roster as $kl => $specs)
                    {
                            $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                            ?>
                            <tr>
                                <td> </td>
                                <td colspan="3" ><strong><?php echo $cname; ?>  </strong></td>
                            </tr>
                            <?php
                            foreach ($specs as $ky => $det)
                            {
                                    $s = (object) $det;
                                    $i++;
                                    $stu = $this->worker->get_student($s->student);
                                    ?>               

                                    <tr>
                                        <td><?php echo $i . '. '; ?></td>
                                        <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                                        <td><?php echo $cname; ?></td>
                                        <td> </td>
                                    </tr>

                            <?php }
                            ?> <tr>
                                <td colspan="2" > </td>
                                <td class="rttb"></td>
                                <td class="rttb">&nbsp;</td>
                            </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>

    </div>    

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>
<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                    $(".tsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e) {
                        console.log(e);
                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>