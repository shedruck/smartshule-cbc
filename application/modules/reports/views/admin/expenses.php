
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Expense Summary Report</h2> 

</div>
<div class="toolbar">
    <div class="noovf">
        <?php echo form_open(current_url()); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
        <button class="btn btn-primary"  type="submit">View Report</button>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">

    <?php if (!empty($post)): ?>
        <table cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="">Category</th>
                    <th width="">Amount</th> 
                    <th width="">Last Record</th>
                    <th width="">Last Recorded by</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $ext = 0;
                foreach ($post as $p)
                {
                    $expense_total = (object) $p->expense_total;
                    $u = $this->ion_auth->get_user($p->created_by);

                    $i++;
                    $ext +=$p->expense_total;
                    ?>

                    <tr>
                        <td><?php echo $i . '. '; ?></td>
                        <td><?php echo $cats[$p->category]; ?></td>
                        <td class="rttb"><b > <?php echo number_format($p->expense_total, 2) ?></b></td>
                        <td><?php echo date('d M Y', $p->created_on) ?></td>
                        <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="2" > </td>
                    <td class="rttbd"><?php echo $this->currency;?><?php echo number_format($ext, 2); ?></td>
                    <td colspan="2" > </td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <h3>No Expenses recorded at the moment</h3>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">

        </div>
    </div>

</div>
<script>
    $(document).ready(
            function ()
            {
                $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                $(".fsel").on("change", function (e) {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
            });
</script>