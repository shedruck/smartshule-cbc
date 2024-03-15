<div class="card" id="assess">
    <div class="card-body">
        <div class="row">
            <div class="col-md-11 hidden-print">
                <h4 class="text-uppercase">CBC Assessment Report</h4>
            </div>
            <div class="col-md-1 hidden-print">
            </div>
        </div>
		
		<?php $set = $this->ion_auth->settings(); if($set->exam_lock==1){?>
     <div class="card-header d-flex align-items-center justify-content-between">
      <h4 class="card-title mb-0 d-inline-block" style="color:red">Sorry CBC Assessment results has been locked for recording purpose. You will be alerted once it has been opened</h4>
     </div>
   <?php }else{?>
   
   
        <hr class="hidden-print">
        <div class="resp">
            <div class="row header">
                <div class="cell">#</div>
                <div class="cell">TYPE</div>
                <div class="cell">NAME</div>
                <div class="cell">CLASS</div>
                <div class="cell">YEAR</div>
                <div class="cell">TERM</div>
                <div class="cell">&nbsp;</div>
            </div>
            <?php
            $i = 0;
            foreach ($assess as $exm)
            {
                $rw = (object) $exm;

                $i++;
                ?>
                <div class="row">
                    <div class="cell"><?php echo $i; ?>.</div>
                    <div class="cell"><?php echo $rw->cat == 1 ? 'TERMLY ASSESSMENT' : 'SUMMATIVE REPORT'; ?></div>
                    <div class="cell"><span class="text-uppercase"><?php echo $rw->student; ?></span></div>
                    <div class="cell"><?php echo $rw->class; ?></div>
                    <div class="cell"><?php echo $rw->year; ?></div>
                    <div class="cell">Term <?php echo $rw->term; ?></div>
                    <div class="cell">
                        <?php
                        if ($rw->cat == 1)
                        {
                            ?>
                            <div class="dropdown">
                                <button type="button" class="dropdown-toggle btn btn-info" data-toggle="dropdown">
                                    Subject
                                </button>
                                <div class="dropdown-menu dropdown-menu-right fls">
                                    <?php
                                    foreach ($rw->subs as $s)
                                    {
                                        ?>
                                        <a class="dropdown-item" href="<?php echo base_url('parents/cbc/report/' . $rw->sid . '/' . $s . '/' . $rw->term . '/' . $rw->year); ?>"><?php echo isset($subjects[$s]) ? $subjects[$s] : '-'; ?></a>
                                        <div class="divider"></div>
                                    <?php } ?>  
                                </div>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="btn btn-primary" href="<?php echo base_url('parents/cbc/summative/' . $rw->sid . '/' . $rw->term . '/' . $rw->year); ?>">View Report</a>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
		
   <?php } ?>
    </div>

</div>
<style>
    .fls .dropdown-menu a{color:#337ab7;text-decoration:none;}
    .fls  .dropdown-menu a:focus,a:hover{color:#23527c;text-decoration:underline;}
    .fls  .dropdown-menu a:focus{outline:thin dotted;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px;}
    ul.fls{margin-top:0;margin-bottom:10px;}
    .fls{position:absolute;top:100%;z-index:1000;display:none;float:left;min-width:160px;padding:5px 0;margin:2px 0 0;font-size:14px;text-align:left;list-style:none;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #ccc;border:1px solid rgba(0,0,0,.15);border-radius:4px;-webkit-box-shadow:0 6px 12px rgba(0,0,0,.175);box-shadow:0 6px 12px rgba(0,0,0,.175);}
    .fls   .divider{height:1px;margin:9px 0;overflow:hidden;background-color:#e5e5e5;}
    .fls  >li>a{display:block;padding:3px 20px;clear:both;font-weight:400;line-height:1.42857143;color:#333;white-space:nowrap;}
    .fls >li>a:focus,.dropdown-menu>li>a:hover{color:#fff;text-decoration:none;background-color:#17a2b8;}
    .fls  .open>.dropdown-menu{display:block;}
    #assess {min-height: 100vh;}
    .table-responsive{overflow-y:visible; overflow-x:visible;}
    .resp {
        color: #616161;
        display: table;
        margin: 0 0 1em 0;
        width: 100%;
        padding: 8px;
        border: 1px solid #d3d3d3;
    }
    .resp .row {
        display: table-row;   margin-right: 0;   margin-left: 0;
    }
    .resp .row:nth-of-type(odd) {
        background-color: #eee;
    }
    .resp .row.header {
        color: #fff;
        font-weight: 700;
        border-bottom: 2px solid #ddd;
        text-shadow: 1px 1px 1px #fff;
        background: #e8eaeb;
        font-weight: 500;
        color: #324148;
        font-size: 14px;
    }
    .resp .cell {
        display: table-cell;
        padding: 6px 12px;
    }

    @media screen and (max-width: 599px) {
        .resp .row.header {display: none;}
        .resp {
            display: block;
        }
        .resp .row {
            display: block;
            padding: 8px 0;
        }
        .resp .cell {
            display: block;
            padding: 2px 12px;
        }
    }

</style>