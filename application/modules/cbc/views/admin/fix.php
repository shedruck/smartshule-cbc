<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Cbc  Subjects</h2>
        <div class="right"> 
            <?php echo anchor('admin/cbc/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Cbc')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/cbc', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Cbc')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    
    <div class="block-fluid" width="100%">
         <table class="fpTable" cellpadding="0" cellspacing="0" width="100%" id="cbc_class">
            <thead>
                <th>#</th>
                <th>Subject</th>
                <th>Class</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
              
                    $index = 1;
                    foreach($subs as $p){
                ?>
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo isset($subjects[$p->subject_id]) ? $subjects[$p->subject_id] : '-'; ?></td>
                    <td><?php echo isset($this->classes[$p->class_id]) ? $this->classes[$p->class_id] : '-';?></td>
                    <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#class_add" onclick="add_class(<?php echo $p->id?>)">Edit Class </button>
                    </td>
                </tr>
            <?php $index++; }?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<div class="modal fade" id="class_add" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-fusion-900 text-white">
            <div class="modal-header" style="background-color: green;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Manage Subjects</h4>
            </div>

            <div class="modal-body responsive" style="color:black" id="">
                <div id="val_form"></div>
                <select name="class"  id="class_id" class="fsel">
                       <?php
                        $data = $this->classes;
                        foreach ($data as $key => $value):
                                ?>
                                <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                        <?php endforeach; ?>

                </select>

                <button class="btn btn-success" id="save">Update</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="close btn-xs  btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function add_class(str) {
        if (str == "") {
            document.getElementById("val_form").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("val_form").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('admin/cbc/add_class?q=') ?>" + str, true);
            xmlhttp.send();
        }
    }


        $(document).on('click', '#save', function (event) {
        event.preventDefault();
        var class_id = $('#class_id').val();
        var item = $('#item').val();


        $.ajax({
            url: "<?php echo base_url('admin/cbc/fix_class')?>",
            method: 'POST',
            data: {'class_id':class_id, 'item':item},
            success: function (data) 
            {
                notify('Updated successfully');
                $('#class_add').modal('hide');
                $("#cbc_class").load(" #cbc_class > *");
            
            }
        });
      
    });

</script>

<script type="text/javascript">
      $(function ()
    {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '70%'});
             // $('select[multiple]').multiselect();
        });
</script>
