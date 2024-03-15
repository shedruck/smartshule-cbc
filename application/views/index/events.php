<div class="col-md-12">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="wpb_wrapper">
            <h3>SCHOOL EVENTS</h3>
            <hr>
            <?php
            foreach ($events as $e)
            {
                    if ($e->cat == 1)
                    {
                            ?>
                            <div class="wd-event ">
                                <div class="date-event">
                                    <span class="date-start"><?php echo date('d', $e->date) ?></span><span class="month-start"><?php echo date('M Y', $e->date); ?></span>
                                    <span class="day-start"><?php echo date('l', $e->date); ?>  <hr><?php echo $e->start; ?></span>
                                </div>
                                <div class="info-event">
                                    <div class="event-content">
                                        <h3><?php echo $e->title; ?></h3>
                                        <p><?php echo $e->description; ?>
                                        <p class="time-event">  <?php echo $e->start; ?> <?php echo empty($e->end) ? '' : '-' . $e->end; ?>  &nbsp;  <i class="fa fa-map-marker"></i>Venue:<?php echo $e->venue; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                    }
                    else
                    {
                            ?>
                            <div class="wd-event ">       
                                <div class="info-event">
                                    <div class="event-content">
                                        <h3><?php echo $e->title; ?></h3>
                                        <p><?php echo $e->description; ?></p>
                                        <p class="time-event">&nbsp;</p>
                                    </div>

                                </div>
                            </div>
                    <?php } ?>

            <?php } ?>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>