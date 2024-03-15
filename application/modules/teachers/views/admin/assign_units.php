<div class="row">
  <div class="col-md-7">
<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> <?php echo $teacher_data->first_name." ".$teacher_data->last_name." (".$teacher_data->phone.")   - Assigned Units";
$tid = $teacher_data->id;

    ?>  </h2>
    <div class="right">
        <?php //echo anchor('admin/teachers/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?>

        <?php //echo anchor('admin/teachers', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?>

    </div>
</div>

<div class="block-fluid">
    <table id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
        <th>#</th>
        <th>Unit</th>
        <th>Class</th>


          <th width="10%"><?php echo lang('web_options'); ?></th>

        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

</div>
</div>
<div class="col-md-5">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Assign Unit </h2>
        <div class="right">
        </div>
    </div>
    <div class="block">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
		
        <div class='form-group'>
            <div class="col-md-3">Course<span class='required'>*</span></div>
            <div class="col-md-9">
                <?php
                $classes = $this->ion_auth->fetch_class_groups();
                echo form_dropdown('course', array('' => 'Select Course') + $classes, (isset($fee->course)) ? $fee->course : '', ' class="drp course " required="required" id="course" data-placeholder="Select  Options..." ');
                ?>
            </div>
        </div>

      
        <div class='form-group'>
            <div class="col-md-3" for='intake_year'>Intake Year:<span class='required'>*</span></div>
            <div class="col-md-9">
                <select name="intake_year" id="intake_year" required="required"  class="drp intake_year">
                    <option value="">Select Intake Year</option>
                    <?php
                      $cy = date('Y')+1;
                      for($l=$cy;$l>($cy-6);$l--)
                      {
                        ?>
  <option value="<?php echo $l;?>"><?php echo $l;?></option>
                        <?php
                      }

                     ?>
                </select>
            </div>
        </div>
        <div class='form-group' style="">
            <div class="col-md-3" for='intake'>Intake Month:<span class='required'>*</span></div>
            <div class="col-md-9">
                <?php
                $intake = array(
                    'January' => 'January',
                    'February' => 'February',
                    'March' => 'March',
                    'April' => 'April',
                    'May' => 'May',
                    'June' => 'June',
                    'July' => 'July',
                    'August' => 'August',
                    'September' => 'September',
                    'October' => 'October',
                    'November' => 'November',
                    'December' => 'December'
                );
                echo form_dropdown('intake_month[]', $intake, (isset($result->intake)) ? $result->intake : '', ' required="required" multiple class="drp " ');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='unit'>Unit:<span class='required'>*</span></div>
            <div class="col-md-9">
                <select name="unit[]" id="unit" required="required" multiple class="drp  unit">
                    <option value="">Select Unit</option>
                </select>
            </div>
        </div>






        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php echo form_submit('tuition', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>

            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
		 $(".drp").select2({'width': '100%'});
        var oTable;
        oTable = $('#ModeTable').dataTable({
            "dom": 'TC lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/teachers/get_table_assign/?id='.$tid); ?>",
            "iDisplayLength": <?php echo $this->list_size;?>,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html(" <div class='btn-group'> <a class='btn btn-primary'  onClick=\"return confirm('Do you want to remove this unit?')\" href ='<?php echo base_url('admin/teachers/remove_assign/'); ?>"  + "/<?php echo $tid; ?>/"+ aData[0] + "'  ><i class='glyphicon glyphicon-edit'></i> Remove</a>  </div>");
                        return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},

                {"bVisible": true, "bSearchable": false, "bSortable": false},
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
            ]
        }).fnSetFilteringDelay(700);
		
		

        $("#course_null").change(function () {

            $('#level').empty();
            $('#unit').empty();
          $("#unit option[value='']").attr('selected', true)
            $('#unit').children().remove();
            var options = '';
            $('#level').children().remove();

            $.getJSON("<?php echo base_url('admin/course_durations/get_levels/'); ?>", {id: $(this).val()}, function (data)
            {

                for (var i = 0; i < data.length; i++)
                {
                    options += '<option value="' + data[i].optionValue + '">' + data[i].optionDisplay + '</option>';
                }

                $('#level').append(options);
            });



        });

        $("#course").change(function () {


				var course =  $('#course').val();
				var inputs;
				$('#unit').empty();
				$('#unit').children().remove();
							var options = '';

				$.getJSON("<?php echo base_url('admin/course_units/get_units/'); ?>", {
				  id: $(this).val() }, function (datap) {


					for (var i = 0; i < datap.length; i++)
					{
						options += '<option value="' + datap[i].optionValue + '">' + datap[i].optionDisplay + '</option>';
					}


					$('#unit').append(options);


							});

						});
			});
</script>
