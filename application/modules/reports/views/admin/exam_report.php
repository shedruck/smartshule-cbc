<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Exams Report </h2>
    <div class="right">
    </div>
    <div class="toolbar">
        <div class="left TAR">
            <div class="btn-group" data-toggle="buttons-radio">
                <a href="<?php echo base_url('admin/reports/sms_exam/'); ?>" class="btn btn-primary "><span class="glyphicon glyphicon-comment"></span> SMS Results</a>
                <a href="<?php echo base_url('admin/reports/grade_analysis/'); ?>" class="btn btn-warning "><span class="glyphicon glyphicon-signal"></span> Grade Analysis</a>
            </div>
        </div>
    </div>
</div>

<div class="toolbar">
    <div class="noof">
        <?php echo form_open(current_url()); ?>
        <div class="col-md-10">
            <?php echo form_dropdown('group', array("" => " Select Class Group") + $this->classes, $this->input->post('group'), 'class ="selecte" '); ?> or
            <?php echo form_dropdown('class', array("" => " Select Stream") + $this->streams, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <?php echo form_checkbox('grade', '1', 0, 'title="Show Grades" ') ?>Grades

        </div>
        <div class="col-md-2">
            <div class="date  right" id="menus"> </div>
            <button class="btn btn-primary" type="submit">View Results</button>
            <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>






<script>
    $(document).ready(function() {
        $(".selecte").select2({
            'placeholder': 'Select Option',
            'width': '200px'
        });

        $('[id^="r2"]').popover({
            placement: "top",
            title: "Best 7 - Option 1",
            content: "3 Compulsory <br> 2 Sciences <br>1 Humanity , <br>1 best from any category "
        });
        $('[id^="r3"]').popover({
            placement: "top",
            title: "Best 7 - Option 2",
            content: "4 Compulsory (including Chem.) <br>3 best subjects from all others"
        });
    });
</script>
<style>
    .fless {
        width: 100%;
        border: 0;
    }

    .dropped {
        border-bottom: 3px solid silver;
    }

    legend {
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

    @media print {
        td.nob {
            border: none !important;
            background-color: #fff !important;
        }

        .stt td,
        th {
            border: 1px solid #ccc;
        }

        .dropped {
            border-bottom: 3px solid silver !important;
        }
    }
</style>