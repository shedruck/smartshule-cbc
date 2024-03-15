<?php echo $template['partials']['perms']; ?>
<div class="row">
    <div class="col-md-4">
        <div class="head"> 
            <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>   Select User Groups </h2>
            <div class="right">  
            </div>
        </div>
        <div class="block-fluid">

            <div class="db" style="height:400px">
                <ul class="list tickets">
                    <?php
                    $i = 0;
                    foreach ($groups as $gid => $title)
                    {
                        if ($gid == 1 || $gid == 2)//Admin & Members
                        {
                            continue;
                        }
                        $i++;
                        ?> 
                        <li>
                            <a class="permaget" href="javascript:void(0)" data-rec="<?php echo $gid; ?>">
                                <span class="desc"> <?php echo $i . '. '; ?></span>
                                <span class="label label-info"><?php echo ucwords($title); ?></span>
                            </a>
                        </li>
                    <?php } ?> 
                </ul>   
            </div>
            <div class="panel-footer">
                <div class="col-md-6"> 
                </div>
                <div class="col-md-6">
                </div>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="block-fluid">
            <div class="head">
                <div class="icon"><span class="icosg-target1"></span> </div>
                <h2>    Assign Permissions</h2>
                <div class="right">  
                </div>
            </div>
            <div class="panel-body panel-scroll" >
                <table class='table table-striped table-bordered table-hover' id="per_table" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Permission</th>
                            <th>Description.</th>
                            <th><?php echo lang('web_options'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>

            </div>
            <div class="panel-footer">
                <div class="col-md-6"> 
                </div>
                <div class="col-md-6">
                </div>
                <p>&nbsp;</p>
            </div>

        </div>
    </div>

</div>

<!-- -->

<div class="modal fade in" style="display: none; position: absolute !important" id="edmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open(current_url(), 'id="fotor"'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="motitle">Manage Permissions</h4>
            </div>
            <div class="modal-body" style="overflow-y:scroll">
                <div id="spinn" style="display: none;" ><img src="<?php echo base_url('assets/ico/ajax-loader.gif'); ?>"/></div>
                <input type="hidden" name="modd" id="modd" value=""/>
                <input type="hidden" name="mogg" id="mogg" value=""/>
                <div  id="moo"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="fotsave" class="btn btn-green"  >Save</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
    #edmodal .modal-dialog  {padding :5px;}
</style>
<script type="text/javascript">
        $(function ()
        {
            $('body').on('click', 'a.refk', function ()
            {
                var rec = $(this).closest('tr').find('td > a.refk').data('modid');
                var grp = $(this).closest('tr').find('td > a.refk').data('group');
                $(".modal-body #modd").val(rec);
                $(".modal-body #mogg").val(grp);
                $('#edmodal').modal('show');
            });
            $('body').on('show.bs.modal', '#edmodal', function (e) {
                $('#spinn').show();
                var rec = $('#modd').val();
                var grp = $('#mogg').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/permissions/get_routes'); ?>" + "/" + grp + "/" + rec,
                    data: {'group': rec},
                    success: function (data)
                    {
                        var res = $.parseJSON(data);
                        $('#motitle').html(res.title);
                        $('#moo').html(res.text);
                        $('#spinn').hide();
                    }
                });
            });

            $('body').on('click', '#edmodal button#fotsave', function (e)
            {
                e.preventDefault();
                var chek = new Array();
                var group = $('#mogg').val();
                var rec = $('#modd').val();

                $("input:checked").each(function ()
                {
                    chek.push($(this).val());
                });

                $.ajax({
                    url: "<?php echo base_url('admin/permissions/set_scope'); ?>",
                    type: "POST",
                    data: 'ids=' + chek + '&group=' + group + '&res=' + rec,
                    success: function (dt)
                    {
                        $('#moo').html('<div class="notify successbox"> <h1>Success!</h1> <span class="alerticon"><img src="<?php echo base_url('assets/ico/check.png'); ?>" alt="checkmark" /></span> <p class="messer">Success</p> </div>');
                        setTimeout(function ()
                        {
                            $('#edmodal').modal('hide');
                        }, 2000);
                    }
                });
            });

        });
        $(function ()
        {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '70%'});

            $(".permaget").on("click", function ()
            {
                // show a loader img
                var oTable;
                var rec = $(this).attr('data-rec');
                oTable = $('#per_table').dataTable({
                    "dom": 'TC lfrtip',
                    "bProcessing": true,
                    "bDestroy": true,
                    "bServerSide": true,
                    "sServerMethod": "GET",
                    "sAjaxSource": "<?php echo base_url('admin/permissions/list_assoc'); ?>" + '/' + rec,
                    "iDisplayLength": <?php echo $this->list_size; ?>,
                    "aLengthMenu": [[10, 25, 50, 200], [10, 25, 50, 200]],
                    "aaSorting": [[0, 'asc']],
                    "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                        var oSettings = oTable.fnSettings();
                        var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                        $("td:first", nRow).html(preff + '. ');
                        $("td:last", nRow).html("<a class='refk btn btn-success' data-group='" + rec + "' data-modid='" + aData[1] + "'>Edit</a> <a onClick='return confirm(\"Are you sure you want to Remove Permission?\")' class='kftt btn btn-danger' href ='<?php echo base_url('admin/permissions/remove/'); ?>" + "/" + aData[0] + "' ' >X</a>" + '');
                        return nRow;
                    },
                    "oLanguage": {
                        "sProcessing": "<img src='<?php echo base_url('assets/ico/loader.gif'); ?>'>"
                    },
                    "aoColumns": [
                        {"bVisible": true, "bSearchable": false, "bSortable": false},
                        {"bVisible": false, "bSearchable": false, "bSortable": false},
                        {"bVisible": true, "bSearchable": true, "bSortable": true},
                        {"bVisible": true, "bSearchable": true, "bSortable": true},
                        {"bVisible": true, "bSearchable": false, "bSortable": false}
                    ],
                    "columnDefs": [{
                            "targets": -1,
                            "data": null,
                            "defaultContent": "null"
                        }
                    ]
                });
            });
        });

        $(function () {

            jQuery(function ($) {
                $('form[data-async]').on('submit', function (event) {
                    var $form = $(this);
                    var $target = $($form.attr('data-target'));

                    $.ajax({
                        type: $form.attr('method'),
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        success: function (data, status) {
                            $target.html(data);
                        }
                    });

                    event.preventDefault();
                });
            });
        });
</script> 

                <style>
                .modal {
           position:absolute !important;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    display: none;
    overflow: visible;
    -webkit-overflow-scrolling: touch;
    outline: 0;
}
                </style>
<style>
    .successbox h1 { color: #678361;  text-align: center;}
    .successbox h1:before, .successbox h1:after { background: #cad8a9; }
    .notify .alerticon {
        display: block;
        text-align: center;
        margin-bottom: 10px;
    }
    .messer{  text-align: center;}
</style>