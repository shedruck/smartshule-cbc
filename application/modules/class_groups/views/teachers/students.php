<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start"><?php echo $this->streams[$class_id] ?> - Students</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <button data-bs-toggle="modal" data-bs-target="#hobies" class="btn btn-primary"><i class="mdi  mdi-plus"></i> Record Favourites and Hobbies</button>
                    <?php echo anchor('class_groups/trs/ViewHobbies/', '<i class="fa fa-search"></i> View Students Hobbies', 'class="btn btn-success"'); ?>
                    <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="mixt">
                        <thead class="bg-default">
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
                </div>
                <!-- </div> -->
            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
                </div>
                <div class="float-end d-inline-block btn-list">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Basic Modal -->
<div class="modal fade" id="hobies" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Record Student Hobbies and Favourites</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <?php echo form_open('class_groups/trs/recordStudentFavHobbies') ?>
                <!-- Form Fields Start Here -->
                <?php
                foreach ($mykids as $key => $value) : ?>
                    <input type="hidden" value="<?php echo $value->class; ?>" name="class">
                <?php endforeach ?>
                <div class='form-group'>
                    <label>Student <span class='required'>*</span></label>
                    <select name="student" class="form-control js-example-placeholder-exam" style="" tabindex="-1" required>
                        <option value="">Select Student</option>
                        <?php

                        foreach ($mykids as $key => $value) :
                        ?>
                            <option value="<?php echo $value->id; ?>"><?php echo ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('student'); ?>

                </div>

                <div class='form-group'>
                    <label>Year </label>
                    <input type="number" class="form-control" name="year" placeholder="Year eg <?php echo date('Y') ?>" required>
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

                <!-- Form Fields End Here -->
            </div>
            <div class="modal-footer">
                <button name="fav" type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
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
            "aLengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "aaSorting": [
                [0, 'asc']
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<a class='btn btn-purple waves-effect waves-light' href ='<?php echo base_url('class_groups/trs/view_student/'); ?>" + "/" + aData[0] + "' ><i class=\"mdi mdi-star-circle\"></i> View</a> ");
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [{
                    "bVisible": true,
                    "bSearchable": false,
                    "bSortable": false
                },
                {
                    "bVisible": true,
                    "bSearchable": true,
                    "bSortable": true
                },
                {
                    "bVisible": true,
                    "bSearchable": true,
                    "bSortable": true
                },
                {
                    "bVisible": true,
                    "bSearchable": true,
                    "bSortable": true
                },
                {
                    "bVisible": true,
                    "bSearchable": true,
                    "bSortable": true
                },
                {
                    "bVisible": true,
                    "bSearchable": true,
                    "bSortable": true
                }
            ],
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "null"
            }]
        });
    });
</script>