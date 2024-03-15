

<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Event Details </h2> 
    <div class="right">
        <button onClick="window.print();
                    return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                <?php echo anchor('admin/school_events/list_view/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
    </div>

</div>
<div class="widget">

    <div class="block invoice1">

        <div class="clearfix"></div>
        <div class="col-md-11 view-title center">
            <h1><img src="<?php echo base_url('assets/themes/admin/img/logo-sm.png'); ?>" />
                <h5><?php $settings = $this->ion_auth->settings();
                echo ucwords($settings->motto);
                ?>
                    <br>
                    <span style="font-size:0.6em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                </h5>
            </h1>

        </div>
        <div class="clearfix"></div>

        <div class="col-md-2 dates">
            <div class="widget">
                <div class="head dark">
                    <div class="icon"><i class="icos-user3"></i></div>
                    <h2>Events Dates</h2>
                    <ul class="buttons">                                                        
                        <li><a href="#"><span class="icos-calendar"></span></a></li>
                    </ul>                                                  
                </div>                    
                <div class="block-fluid events">
                    <div class="item" style="min-height:80px;">
                        <div class="date ">
                            <div class="caption"><span class="glyphicon glyphicon-tags glyphicon glyphicon-calendar"></span></div>
                            <span class="day"><?php echo date('d', $post->start_date); ?></span>
                            <span class="month"><?php echo date('M, Y', $post->start_date); ?></span>
                        </div>

                    </div>                        

                    <div class="item" style="min-height:80px;">
                        <div class="date" >
                            <div class="caption red"><span class="glyphicon glyphicon-info-sign glyphicon glyphicon-calendar"></span></div>
                            <span class="day"><?php echo date('d', $post->end_date); ?></span>
                            <span class="month"><?php echo date('M, Y', $post->end_date); ?></span>
                        </div>

                    </div>                         

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="widget">
                <div class="head dark">
                    <div class="icon"><i class="icos-user3"></i></div>
                    <h2>Events Details</h2>
                    <ul class="buttons">                                                        
                        <li><a href="#"><span class="icos-calendar"></span></a></li>
                    </ul>                                                  
                </div>                    
                <div class="block-fluid events">

                    <ul class="sList ui-sortable" id="sort_1">

                        <li><b>Title:</b> <span style="margin-left:20px;"><?php echo $post->title; ?></span></li>
                        <li><b>Start Date:</b> <span style="margin-left:20px;"><?php echo date('d M Y', $post->start_date); ?></span></li>
                        <li><b>End Date:</b> <span style="margin-left:20px;"><?php echo date('d M Y', $post->end_date); ?></span></li>
                        <li><b>Venue:</b> <span style="margin-left:20px;"><?php echo $post->venue; ?></span></li>
                        <li><b>Guests:</b> <span style="margin-left:20px;"><?php echo $post->visibility; ?></span></li>
                        <li><b>Description:</b>
                            <br>
                            <span style="margin-left:20px;"><?php echo $post->description; ?></span>
                        </li>

                    </ul>                       

                </div>
            </div>
        </div>

    </div>

</div>

<style>
    @media print{

        .navigation{
            display:none;
        }
        .head{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .dates{
            display:none;
        } 
        .date{
            display:none;
        }
        .item{
            display:none;
        }
        .view-title h1{border:none !important; }
        .view-title h3{border:none !important; }

        .split{

            float:left;
        }
        .header{display:none}
        .invoice { 
            width:100%;
            margin: auto !important;
            padding: 0px !important;
        }
        .invoice table{padding-left: 0; margin-left: 0; }

        .smf .content {
            margin-left: 0px;
        }
        .content {
            margin-left: 0px;
            padding: 0px;
        }
    }
</style>   