<div class="row card-box table-responsive">

<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> MY ASSIGNED CLASSES 
             <div class="pull-right"> 

 <button data-toggle="modal"  data-target="#hobies" class="btn btn-primary"><i class="mdi  mdi-plus"></i> Record Favourites and Hobbies</button>			 
             <?php echo anchor( 'trs/ViewHobbies/', '<i class="fa fa-search"></i> View Students Hobbies', 'class="btn btn-success"');?>
			 
			
             
                </div>
			</h3>	
	<hr>			
   </div>
    <div class="col-md-4">
        <div class="card-bx">
           
			
            <div class="inbox-widget slimscroll-alt">
                <?php
                $i = 0;
                foreach ($students as $s)
                {
                    $i++;
                    ?>
                    <a href="<?php echo base_url('trs/students/' . $s->id); ?>" class="<?php echo preg_match('/^(trs\/students\/' . $s->id . ')/', $this->uri->uri_string()) ? 'active' : ''; ?>" >
                        <div class="inbox-item">

                            <div class="inbox-item-img "><span class="avatar-sm-box bg-primary"><?php echo $i; ?>.</span>	</div>
                            <h4 class="inbox-item-author "><?php echo strtoupper($s->name); ?></h4>
						
							<hr>
							
							<ul>
                            <?php echo trim($s->title, ', '); ?>
							</ul>
                            <h5 class="inbox-item-date bg-green" style="font-size:15px !important;"><?php echo number_format($s->count); ?> Student<?php echo $s->count > 1 ? 's' : ''; ?> </h5>
							<?php 
							$ct = $this->trs_m->get_teacher_classes();
                            // print_r($ct);
							if (in_array($s->id, $ct))
							  {
							  echo '<span class="bg-red pull-right">'.ucfirst($s->name).' -  Class Teacher</span>';
							  }
						
							?>
							

                        </div>
                    </a>
                <?php } ?>
                <?php
                $j = count($students);
                foreach ($extras as $x)
                {
                    $j++;
                    ?>
                    <a href="<?php echo base_url('trs/students/?extras=' . $x->id); ?>">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><span class="avatar-sm-box bg-primary"><?php echo $j; ?>.</span></div>
                            <p class="inbox-item-author"><?php echo $x->title; ?></p>
                            <p class="inbox-item-text">Teacher</p>
                            <p class="inbox-item-date"><?php echo number_format($x->count); ?> Student<?php echo $x->count > 1 ? 's' : ''; ?> </p>
                        </div>
                    </a>
                <?php } ?>               
            </div>

        </div> <!-- end card -->
        <hr class="hidden-lg hidden-md" />
    </div>
    <div class="col-md-8">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Students List</h4>
            <div class="table-responsive">
                <table class="table table table-hover m-0" id="mixt">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Passport</th>
                            <th>Name</th>
                            <th>Admission No.</th>
                            <th>Class</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div> <!-- table-responsive -->
        </div> <!-- end card -->
    </div>
    <!-- end col -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('#mixt').dataTable({
            dom: "Bfrtip",
            buttons: [{
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdf",
                    className: "btn-sm"
                }],
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('trs/list_students/' . $class_id); ?>",
            "iDisplayLength": 25,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<a class='btn btn-purple waves-effect waves-light' href ='<?php echo base_url('trs/view_student/'); ?>" + "/" + aData[0] + "' ><i class=\"mdi mdi-star-circle\"></i> View</a> ");
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "null"
                }
            ]
        });
    });
</script>

<div class="modal fade"  id="hobies" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Record Student Hobbies and Favourites </h4>
            </div>
          
            <div class="modal-body" id="here">
    
        <?php echo form_open('trs/recordStudentFavHobbies')?>
        <?php 
        foreach ($mykids as $key => $value) :?>
        <input type="hidden" value="<?php echo $value->class; ?>" name="class">
        <?php endforeach?>
            <div class='form-group'>
                <label>Student <span class='required'>*</span></label>
                <select name="student" class="form-control" style="" tabindex="-1" required>
                    <option value="">Select Student</option>
                    <?php

                    foreach ($mykids as $key => $value):
                            ?>
                            <option value="<?php echo $value->id;?>"><?php echo ucfirst($value->first_name).' '.ucfirst($value->last_name) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('student'); ?>

            </div>

        <div class='form-group'>
            <label>Year </label>
            <input type="number" class="form-control" name="year" placeholder="Year eg <?php echo date('Y')?>" required>
        </div>

        <div class='form-group'>
            <label>Languages Spoken </label>
            <textarea class="form-control" name="languages_spoken" placeholder="Languanges Spoken"></textarea>
        </div>

        <div class='form-group'>
            <label>Hobbies </label>
            <textarea class="form-control" name="hobbies" placeholder="Hobbies"></textarea>
        </div>

        <div class='form-group'>
            <label>Favourite Subject </label>
            <textarea class="form-control" name="favourite_subjects" placeholder="Favourite Subject"></textarea>
        </div>

        <div class='form-group'>
            <label>Favourite Books </label>
            <textarea class="form-control" name="favourite_books" placeholder="Favourite Books"></textarea>
        </div>

        <div class='form-group'>
            <label>Favourite Food </label>
            <textarea class="form-control" name="favourite_food" placeholder="Favourite Food"></textarea>
        </div>

        <div class='form-group'>
            <label>Favourite Bible Verse </label>
            <textarea class="form-control" name="favourite_bible_verse" placeholder="Favourite Bible Verse"></textarea>
        </div>

        <div class='form-group'>
            <label>Favourite Cartoon </label>
            <textarea class="form-control" name="favourite_cartoon" placeholder="Favourite Cartoon"></textarea>
        </div>

        <div class='form-group'>
            <label>Favourite Career </label>
            <textarea class="form-control" name="favourite_career" placeholder="Favourite Career"></textarea>
        </div>

        <div class='form-group'>
            <label>Others </label>
            <textarea class="form-control" name="others" placeholder="Others"></textarea>
        </div>

        <div class='form-group'>

            <button name="fav" class="btn btn-sm btn-primary" type="submit">Save</button>
            <button  class="btn btn-sm btn-danger" data-dismiss="modal" type="button">Cancel</button>
            
        </div>
 
        <?php echo form_close(); ?>
            
       
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>