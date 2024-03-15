<div class="portfolio_area">
    <div class="portfolio_area_left">
        <?php
        foreach ($pics as $p)
        {
                echo theme_image(base_url('uploads/' . $p->link . $p->filename), array('alt' => ''));
                echo ' <div class="clearfix margin_top5"></div>';
        }
        if (!count($pics))
        {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    No Images Uploaded.
                </div>
        <?php } ?> 

    </div>
    <div class="portfolio_area_right white-bg">
        <h4 class="light">Advert Description</h4>
        <div class="project_details"> 
            <span><strong>Start</strong> <em><?php echo $ad->start > 10000 ? date('d M Y', $ad->start) : ''; ?></em></span>
            <span><strong>End</strong> <em><?php echo $ad->end > 10000 ? date('d M Y', $ad->end) : ''; ?></em></span>
            <span><strong>Brand</strong><em><?php echo isset($brands[$ad->brand]) ? $brands[$ad->brand] : '-'; ?></em></span> 
            <span><strong>Brand ID</strong><em><?php echo $ad->brand_id; ?></em></span> 
            <div class="clearfix margin_top5"></div>
        </div>  

        <div class="clearfix"></div>
        <div class="project_details"> 
            <h5 class="light">Billboard:</h5>
            <span><strong>Road</strong> <em><?php echo!empty($ad->bill) && isset($roads[$ad->bill->road]) ? $roads[$ad->bill->road] : '-'; ?></em></span>
            <span><strong>Rate</strong> <em> <?php echo empty($ad->bill) ? '  ' : number_format($ad->bill->rate, 2); ?> </em></span> 
            <div class="clearfix margin_top5"></div>
        </div>  
    </div>
</div><!-- end section -->