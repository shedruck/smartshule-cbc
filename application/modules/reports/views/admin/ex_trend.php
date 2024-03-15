
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Detailed Expenses Report</h2> 

</div>
<div class="toolbar">
    <div class="noovf">
        <?php echo form_open(current_url()); ?>
        Category
        <?php echo form_dropdown('cat', array('' => 'Select Category') + $cats, $this->input->post('cat'), 'class ="tsel" '); ?>
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

        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

                <thead>
                <th>#</th>
                <th>Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Amount</th>
                <th> Responsible</th>
                <th>Description</th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $j = 0;

                    foreach ($post as $p):
                        $user = $this->ion_auth->get_user($p->person_responsible);
                        $u = $this->ion_auth->get_user($p->modified_by);

                        $i++;
                        $j++;
                        ?>
                        <tr>
                            <td><?php echo $j . '.'; ?></td>					
                            <td><?php echo date('d/m/Y', $p->expense_date); ?></td>
                            <td><?php echo isset($items[$p->title]) ? $items[$p->title] : ' '; ?></td>
                            <td><?php echo $cats[$p->category]; ?></td>
                            <td><?php echo number_format($p->amount, 2); ?></td>
                            <td><?php
                                $resp = $user->first_name . ' ' . $user->last_name;
                                echo isset($resp) ? $resp : ' ';
                                ?></td>
                            <td><?php echo $p->description; ?></td>

                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>

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
                 $(".tsel").select2({'placeholder': 'Please Select', 'width': '190px'});
                $(".tsel").on("change", function(e) {

                    notify('Select', 'Value changed: ' + e.added.text);
                });
            });
</script>