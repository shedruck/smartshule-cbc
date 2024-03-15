<div class="col-md-12 whitebg">

    <div class="product-tab">
        <ul class="nav nav-tabs">
            <?php
            $i = 0;
            foreach ($list as $p):
                $i++;
                ?>
                <li class="<?php echo $i==1? 'active' :'';?>  ">
                    <a href="#tab<?php echo $i; ?>" data-toggle="tab"><?php echo $p->day_of_the_week; ?></a>
                </li>
            <?php endforeach ?> 

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <?php
                foreach ($monday as $p):
                    $user = $this->ion_auth->get_user($p->teacher);
                    ?>
                    <div class="grid" >
                        <div class="widget3">
                            <h3 style=""><strong><i class="glyphicon glyphicon-calendar"></i></strong> <?php echo $p->start_time; ?> - <?php echo $p->end_time; ?></h3>
                            <div class="head">
                                <?php if ($p->subject == 10000001): ?>
                                    Free Lesson<br>
                                <?php elseif ($p->subject == 10000002): ?>
                                    Lunch Break<br>
                                <?php elseif ($p->subject == 10000003): ?>
                                    Games Lesson<br>
                                <?php else: ?>
                                    <strong>Subject:</strong> <?php echo $subject[$p->subject]; ?><br>
                                <?php endif ?>
                                <strong>Teacher:</strong> <?php echo $user->first_name . ' ' . $user->last_name; ?> <br>
                                <?php if (!$p->room == 0): ?>
                                    <strong>Room:</strong> <?php echo $rooms[$p->room]; ?><br>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> 
                <?php endforeach ?> 
            </div>
            <div class="tab-pane" id="tab2">
                <?php foreach ($tuesday as $p): $user = $this->ion_auth->get_user($p->teacher); ?>
                    <div class="grid" >
                        <div class="widget3">
                            <h3 style=""><strong><i class="glyphicon glyphicon-calendar"></i></strong> <?php echo $p->start_time; ?> - <?php echo $p->end_time; ?></h3>
                            <div class="head">
                                <?php if ($p->subject == 10000001): ?>
                                    Free Lesson<br>
                                <?php elseif ($p->subject == 10000002): ?>
                                    Lunch Break<br>
                                <?php elseif ($p->subject == 10000003): ?>
                                    Games Lesson<br>
                                <?php else: ?>
                                    <strong>Subject:</strong> <?php echo $subject[$p->subject]; ?><br>
                                <?php endif ?>
                                <strong>Teacher:</strong> <?php echo $user->first_name . ' ' . $user->last_name; ?> <br>
                                <?php if (!$p->room == 0): ?>
                                    <strong>Room:</strong> <?php echo $rooms[$p->room]; ?><br>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> 
                <?php endforeach ?> 
            </div>
            <div class="tab-pane" id="tab3">
                <?php foreach ($wednesday as $p): $user = $this->ion_auth->get_user($p->teacher); ?>
                    <div class="grid" >
                        <div class="widget3">
                            <h3 style=""><strong><i class="glyphicon glyphicon-calendar"></i></strong> <?php echo $p->start_time; ?> - <?php echo $p->end_time; ?></h3>
                            <div class="head">
                                <?php if ($p->subject == 10000001): ?>
                                    Free Lesson<br>
                                <?php elseif ($p->subject == 10000002): ?>
                                    Lunch Break<br>
                                <?php elseif ($p->subject == 10000003): ?>
                                    Games Lesson<br>
                                <?php else: ?>
                                    <strong>Subject:</strong> <?php echo $subject[$p->subject]; ?><br>
                                <?php endif ?>
                                <strong>Teacher:</strong> <?php echo $user->first_name . ' ' . $user->last_name; ?> <br>
                                <?php if (!$p->room == 0): ?>
                                    <strong>Room:</strong> <?php echo $rooms[$p->room]; ?><br>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> 
                <?php endforeach ?> 
            </div>
            <div class="tab-pane" id="tab4">
                <?php foreach ($thursday as $p): $user = $this->ion_auth->get_user($p->teacher); ?>
                    <div class="grid" >
                        <div class="widget3">
                            <h3 style=""><strong><i class="glyphicon glyphicon-calendar"></i></strong> <?php echo $p->start_time; ?> - <?php echo $p->end_time; ?></h3>
                            <div class="head">
                                <?php if ($p->subject == 10000001): ?>
                                    Free Lesson<br>
                                <?php elseif ($p->subject == 10000002): ?>
                                    Lunch Break<br>
                                <?php elseif ($p->subject == 10000003): ?>
                                    Games Lesson<br>
                                <?php else: ?>
                                    <strong>Subject:</strong> <?php echo $subject[$p->subject]; ?><br>
                                <?php endif ?>
                                <strong>Teacher:</strong> <?php echo $user->first_name . ' ' . $user->last_name; ?> <br>
                                <?php if (!$p->room == 0): ?>
                                    <strong>Room:</strong> <?php echo $rooms[$p->room]; ?><br>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> 
                <?php endforeach ?> 
            </div>
            <div class="tab-pane" id="tab5">
                <?php foreach ($friday as $p): $user = $this->ion_auth->get_user($p->teacher); ?>
                    <div class="grid" >
                        <div class="widget3">
                            <h3 style=""><strong><i class="glyphicon glyphicon-calendar"></i></strong> <?php echo $p->start_time; ?> - <?php echo $p->end_time; ?></h3>
                            <div class="head">
                                <?php if ($p->subject == 10000001): ?>
                                    Free Lesson<br>
                                <?php elseif ($p->subject == 10000002): ?>
                                    Lunch Break<br>
                                <?php elseif ($p->subject == 10000003): ?>
                                    Games Lesson<br>
                                <?php else: ?>
                                    <strong>Subject:</strong> <?php echo $subject[$p->subject]; ?><br>
                                <?php endif ?>
                                <strong>Teacher:</strong> <?php echo $user->first_name . ' ' . $user->last_name; ?> <br>
                                <?php if (!$p->room == 0): ?>
                                    <strong>Room:</strong> <?php echo $rooms[$p->room]; ?><br>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> 
                <?php endforeach ?> 
            </div>
        </div><!--end tab-content-->
    </div>
</div><!--end col-md-12-->
