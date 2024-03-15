<div class="head">
    <div class="icon"></div>
    <h2><?php echo $thread->title ?></h2>
    <div class="right"></div>    					
</div>
<?php
$sslist = array();
foreach ($this->classlist as $ssid => $s)
{
    $sslist[$ssid] = $s['name'];
}

// $s1 = $rank ? '' : ' checked="checked" ';
// $s2 = '';
// $s3 = '';
// if ($rank)
// {
//     $s1 = $rank == 1 ? ' checked="checked" ' : '';
//     $s2 = $rank == 2 ? ' checked="checked" ' : '';
//     $s3 = $rank == 3 ? ' checked="checked" ' : '';
// }
?>
<div class="toolbar">
    <div class="row row-fluid">
        <div class="col-md-12 span12">
            <?php echo form_open(current_url()); ?>
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    Class  
                    <?php echo form_dropdown('group', array("" => " Select ") + $this->classes, $this->input->post('group'), 'class ="tsel" required'); ?>
                </div>
                <div class="col-lg-1 col-md-1">
                    OR
                </div>
                <div class="col-lg-3 col-md-3">
                    Stream
                    <?php echo form_dropdown('class', array('' => 'Select') + $sslist, $this->input->post('class'), 'class ="tsel" '); ?>
                </div>
                <div class="col-lg-3 col-md-3">
                    Grading
                    <?php 
                        $gradings = $this->igcse_m->populate('grading_system','id','title');
                        echo form_dropdown('grading', array('' => 'Select') + $gradings, $this->input->post('grading'), 'class ="tsel" required'); 
                    ?>
                </div>
                <div class="col-lg-2 col-md-2">
                    <h6>CATS - <b>(<?php echo count($this->igcse_m->cats($id)) ?>) = <?php echo $thread->cats_weight ?>% Weight</b></h6>
                    <h6>Main Exam - <b>(<?php echo count($this->igcse_m->mains($id)) ?>) = <?php echo $thread->main_weight ?>% Weight</b></h6>
                </div>
            </div>
            
            <h6 class="text-center"><button class="btn btn-primary"  type="submit">Compute Marks</button></h6>
            
            <div class="pull-right">
                <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php
// echo "<pre>";
// print_r($thread);
// echo "</pre>";
?>
<script>
    $(document).ready(
            function ()
            {
                $(".tsel").select2({'placeholder': 'Please Select', 'width': '200px'});
                $(".tsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
                $(".fsel").select2({'placeholder': 'Please Select', 'width': '400px'});
                $(".fsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
            });
</script>

<style>
    .xxd, .editableform textarea {
        height: 150px !important; 
    }
    .editable-container.editable-inline 
    {
        width: 89%;
    }
    .col-sm-2{
        width: 16.66666667%;
    }
    .col-sm-8{
        width: 66.66666667%;
    }

    .editable-input {
        display: inline; 
        width: 89%;
    }
    .editableform .form-control {
        width: 89%;
    }
    .invoice{padding: 20px;}
    .topdets {
        width:85%;
        margin: 6px auto;
        border: 0;
    }
    .topdets th,  .topdets td ,.topdets 
    {
        border: 0;
    }
    .morris-hover{position:absolute;z-index:1000;}.morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
    .morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}
    .tablex{ width: 95% !important; margin: auto 15px  !important; border:1px solid #000 !important;}
    .tablex tr{
        border:1px solid #000 !important;
    }
    .tablex td{
        border:1px solid #000;
    }
    .tablex th{
        border:1px solid #000 !important;
    }
    .page-break{margin-bottom: 15px;}
    .dropped
    {
        border-bottom: 3px solid silver !important;
    }
    legend{
        width: auto;
        padding: 4px;
        margin-bottom: 0;
        border: 0;
        font-size: 11px;
    }
    fieldset {
        padding: 5px;
        border: 1px solid silver;
        border-radius: 7px;
    }
    @media print 
    {
        .invoice{padding: 20px !important;}
        .topdets {
            width: 85% !important; margin: auto 15px  !important;
            border: 0;
        }
        .tablex{ width: 100%;}
        .page-break{ display: block; page-break-after: always; position: relative;}
        table td, table th { padding: 4px; }
        .editable-click, a.editable-click, a.editable-click:hover {
            text-decoration: none;
            border-bottom: none !important;
        }
        .dropped
        {
            border-bottom: 3px solid silver !important;
        }
    }
</style>
