<?php
if ($this->input->get('sw'))
{
        $sel = $this->input->get('sw');
}
elseif ($this->session->userdata('pw'))
{
        $sel = $this->session->userdata('pw');
}
else
{
        $sel = 0;
}
?>
<?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
<div class="col-md-7">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Custom SMS to Parents</h2>
    </div>
    <div class="block-fluid">
        <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th >Student Name</th>
                    <th>Class</th>
                    <th>ADM. No.</th>
                    <th width="5%"><input type="checkbox" class="checkall"/></th>
                    <th ><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        <?php echo form_error('sids', '<p class="error" style="width:200px; margin: 15px auto;" >', '</p>'); ?>
    </div>
</div>
<div class="col-md-5">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Message</h2>
        </div>
        <div class="block-fluid">
            <div id="type1" class="hider">
                <textarea name="sms" placeholder="Write Your Message Here....." style="min-height:100px;"class="common autoExpand" rows='10' data-min-rows='10'></textarea>
            </div>
            <div id="type2" class="hider" style="display:none; padding:4px;">This option will send an SMS to the selected parents<br/> with their Login details</div>
            <div class="p-action">
                <div class="col-md-12">
                    <div class="radio">
                        <span><input type="radio" checked="checked" name="stype" value="1"></span>
                    </div>Custom Message 
                    <div class="hidden">
                        <div class="radio ">
                            <span class="checked"><input type="radio" name="stype" value="2"></span>
                        </div>Parent Logins                  
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="pull-right">
                    <input type="submit" class="btn btn-primary " value="Export" name="export"/>&nbsp;
                    <input type="submit" class="btn btn-success pull-right" value="Send SMS" onClick="return confirm('Confirm Send SMS')" name="send" />
                </div>
            </div>
            <div class="clearfix"></div>
            <ul class="list tickets">
                <?php
                $i = 0;
                foreach ($this->classlist as $cid => $cl)
                {
                        $i++;
                        $cc = (object) $cl;
                        $cll = $sel == $cid ? 'sel' : '';
                        ?> 
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href = "<?php echo current_url() . '?sw=' . $cid; ?>"><?php echo $cc->name; ?></a>
                                <p><?php echo $cc->size; ?> Students</p>
                            </div>
                        </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<style>
    .autoExpand{  
        display:block;
        width:100%;       
        border-radius:6px;
    }
    .p-action{margin: 7px;}
</style>
<script type = "text/javascript">
        $(function () {
            $("input:radio[name=stype]").on('click', function ()
            {
                $('.hider').hide();
                $("#type" + $(this).val()).show('slow');
            });
        });
        $(document).ready(function () {
            $("textarea.autoExpand").on("input", function ()
            {
                $(this).css("height", 50);
                $(this).css({"overflow": "hidden", "height": this.scrollHeight + "px"});
            });

            var oTable;
            oTable = $('#adm_table').dataTable({
                "dom": 'TC lfrtip <"clear">',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/fee_structure/get_table'); ?>",
                "iDisplayLength": 50,
                "aLengthMenu": [[10, 25, 50, 250], [10, 25, 50, 250]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:nth-child(5)", nRow).html('<input type="checkbox" name="sids[]" value="' + aData[0] + '"/>');
                    $("td:last", nRow).html("<a class='btn btn-success' href ='<?php echo base_url('admin/admission/view/'); ?>" + "/" + aData[0] + " ' >View</a>");
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
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }]
            }).fnSetFilteringDelay(700);
        });
</script>