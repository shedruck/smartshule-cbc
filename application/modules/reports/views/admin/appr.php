<div class="toolbar">
    <div class="noof">
        <div class="col-md-10"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('class', array('' => '') + $classes, $this->input->post('class'), 'class ="select" '); ?>
            <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
            <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
            <button class="btn btn-primary"  type="submit">View</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"><div class="date  right" id="menus"> </div>
            <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
    </div>
</div>
<?php
foreach ($res as $r)
{
        $st = $this->worker->get_student($r->student);
        $adm = empty($st->old_adm_no) ? $st->old_adm_no : $st->admission_number;
        ?>
        <div class="print-container clearfix">
            <div class="headder">
                <div class="contednt">
                    <div class="invoice-from">
                        <h4 class="center">Student Appraisal</h4>
                    </div>
                </div>
            </div>
            <div class="body">
                <hr>        
                <div class="break-d">
                    <p><strong>Student:</strong> <?php echo $st->first_name . ' ' . $st->last_name; ?> <strong>ADM: </strong><?php echo $adm; ?> &nbsp; <strong>Period:</strong> Term <?php echo $term; ?> <?php echo $year; ?></p>
                    <p> </p>
                    <table class="table summary">
                        <thead>
                            <tr>
                                <th>PERSONAL PRESENTATION</th>
                                <th>PERSONALITY & CONDUCT</th>
                                <th>CLASSWORK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="simple">
                                <td>Correct Uniform:<span class="score right"><?php echo $r->uniform; ?></span></td>
                                <td>Respect for Teachers:<span class="score right"><?php echo $r->respect; ?></span></td>
                                <td>Work Presentation:<span class="score right"><?php echo $r->presentation; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <td>Shoes: <span class="score right"><?php echo $r->shoes; ?></span></td>
                                <td>Polite to School mates: <span class="score right"><?php echo $r->polite; ?></span></td>
                                <td>Handwriting:<span class="score right"><?php echo $r->handwriting; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <td>Personal Hygiene: <span class="score right"><?php echo $r->hygiene; ?></span></td>
                                <td>Willingness to Help others:<span class="score right"><?php echo $r->help; ?></span></td>
                                <td>Completion of Class Assignments:<span class="score right"><?php echo $r->assignments; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <td>Neatness: <span class="score right"><?php echo $r->neatness; ?></span></td>
                                <td>Self Discipline:<span class="score right"><?php echo $r->discipline; ?></span></td>
                                <td>Completion of Homework:<span class="score right"><?php echo $r->homework; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <th class="th">EXTRACURRICULAR ACTIVITIES </th>
                                <td>Class Behaviour: <span class="score right"><?php echo $r->behaviour; ?></span></td>
                                <td class="th">CARE OF PERSONAL ITEMS</td>
                            </tr>
                            <tr class="simple">
                                <td>Creativity: <span class="score right"><?php echo $r->creativity; ?></span></td>
                                <td>Confidence: <span class="score right"><?php echo $r->confidence; ?></span></td>
                                <td>Stationery: <span class="score right"><?php echo $r->stationery; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <td>Swimming: <span class="score right"><?php echo $r->swimming; ?></span></td>
                                <td>Team Spirit: <span class="score right"><?php echo $r->teamwork; ?></span></td>
                                <td>School Diary: <span class="score right"><?php echo $r->diary; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <td>Games/ P.E: <span class="score right"><?php echo $r->games; ?></span></td>
                                <td class="th">PARENT COOPERATION </td>
                                <td>Exercise Books: <span class="score right"><?php echo $r->books; ?></span></td>
                            </tr>
                            <tr class="simple">
                                <td>Clubs: <span class="score right"><?php echo $r->clubs; ?></span></td>
                                <td>Parent Cooperation <span class="score right"><?php echo $r->parent_coop; ?></span></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="other-rates clearfix">
                                <span class="blue">KEY</span>
                                <span>[4] Very Good &nbsp; [3] Good &nbsp; [3] Satisfactory &nbsp; [1] Poor &nbsp; </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
<script>
        $(document).ready(function ()
        {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
        });
</script>
<style>
    .summary td{width: 33% !important;}
    .summary th{width: 33% !important;}
    .th {
        vertical-align: bottom;
        border-bottom: 2px solid #ddd;
        text-transform: uppercase;
        background: #F1F1F1 !important;
        color: #333;
        font-weight: bold;
    }
    .print-container
    {
        max-width:100%;
        margin:30px auto;
        background:white;
        padding: 10px;      
    }
    table{
        tbody tr.no-border:first-child
            {
            opacity:0.6!important;
        }
    }
    .ft-18{
        font-size:20px;
        margin-bottom:10px;
    }
    .adder{
        font-size:16px;
        font-weight:500;
        text-align:right;
        border-left:0;
        border-right:0;
        border-bottom:0;
    }
    .total{
        font-size:22px;
    }
    .mega{
        font-size:33px;
        margin-bottom:10px;
    } 

    .summary-info{
        border-bottom:1px solid #dbdbdb;
        margin-bottom:20px;
        padding-bottom:10px;
    }
    .score{border: 1px solid#000; padding: 2px 9px;}

    @media print {
        table td{padding: 2px !important;}
        span.right{margin-right: 1px;}
        .print-container
        {
            margin: 1px !important;
            padding: 1px !important;
            page-break-after: always;
        }
        h1,h2,h3,h4,h5,h6
        {
            font-weight:bold;
            &:first-letter{
                font-size:inherit;
            }
        }
    }
</style>