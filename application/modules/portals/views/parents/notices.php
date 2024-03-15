<div class="row1"> 
    <?php
    if (count($notices))
    {
        $i = 0;
        foreach ($notices as $p)
        {
            $i++;
            ?>
            <div class="wd-event ">
                <div class="date-event">
                    <h6>Posted On:</h6>
                    <span class="date-start"><?php echo date('d', $p->created_on); ?></span><span class="month-start"><?php echo date('M', $p->created_on); ?> <?php echo date('Y', $p->created_on); ?></span>
                    <span class="day-start"><?php echo date('l', $p->created_on); ?>  <hr></span>
                </div>
                <div class="info-event">
                    <div class="event-content">
                        <h3><?php echo $p->title; ?></h3>
                        <?php echo nl2br($p->description); ?>                                 
                    </div>
                </div>
            </div>
            <?php }
        ?>
        <?php echo $links; ?>   
        <?php
    }
    else
    {
        ?>
         <div class="alert alert-soft-warning mb-0 p-8pt">
            <div class="d-flex align-items-start">
                <div class="mr-8pt">
                    <i class="material-icons">error_outline</i>
                </div>
                <div class="flex">
                    <small class="text-100"> <strong>Empty.</strong> Nothing posted at the moment.</small>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<style>
     .page-link {background-color: #ccc9c9;}
    h6 { font-size: 12px; color: #e6e6e6;}
    .wd-event
    {        -webkit-box-shadow:0 0 15px 0 rgba(0,0,0,0.10);box-shadow:0 0 15px 0 rgba(0,0,0,0.10);
             border: 1px solid  #428bca;
             display:-webkit-flex;display:-webkit-box;display:-moz-flex;display:-moz-box;display:-ms-flexbox;
             display:flex;margin-bottom:30px;transition:all 0.3s;-webkit-transition:all 0.3s;-moz-transition:all 0.3s;-ms-transition:all 0.3s;
    }
    .wd-event:hover{-webkit-box-shadow:0 0 15px 0 rgba(50,250,0,0.10);box-shadow:0 0 15px 0 rgba(50,250,0,0.10);}
    @media only screen and (max-width: 767px){.wd-event{display:block;overflow:hidden}}
    .wd-event .date-event{width: 25%; float:left;background:#428bca;text-align:center;padding: 10px 10px 10px;}
    @media only screen and (max-width: 992px){.wd-event .date-event{width:19%}.wd-event .date-event{width:19%}}@media only screen and (max-width: 767px){.wd-event .date-event{width:100%}}
    .wd-event .date-event .date-start{font-size:42px;color:#fff;display:inline-block;vertical-align:middle;line-height:1;margin-right:10px}
    .wd-event .date-event .month-start{font-size:14px;color:#fff;text-transform:uppercase;display:inline-block;vertical-align:middle;
                                       line-height:1}.wd-event .date-event .day-start{display:block;font-size:14px;color:#fff;text-align:center;text-transform:uppercase;letter-spacing:3px;line-height:1;margin-top:10px}.wd-event .info-event{width:100%;float:left;background:#fff;padding:25px 20px 20px 25px}
    @media only screen and (max-width: 767px)
    {.wd-event .info-event{width:100%}
     .wd-event .info-event .event-content{width:100%;float:none}
    }
    .wd-event .info-event .event-content h3{font-size:24px;margin-top:0;line-height:1;   padding: 0 0 15px; letter-spacing:2px; border-bottom: 1px solid #dbdbdb;}.wd-event .info-event .event-content
    p{margin-bottom:20px;font-size:14px;letter-spacing:1px}.wd-event .info-event .event-content p
    i{font-size:18px;margin-right:5px}.wd-event .info-event .event-content p.time-event{margin:0} 
</style>