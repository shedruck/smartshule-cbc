<div class="row card-box table-responsive">
    <div class="col-md-12 col-sm-12 col-xs-12  clearfix">
        <hr/>
        <div class="pull-right"> 
            <?php
            $action = $extras ? 'list_extras' : 'list_assign';
            echo anchor('trs/' . $action . '/' . $class, '<i class="mdi mdi-reply"> </i> Back', 'class="btn btn-primary"');
            ?> 
        </div>
    </div><!-- End .col-md-6 -->

    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="lg-margin visible-sm visible-xs"></div><!-- Space -->
        <h1 class="product-name"> <?php echo $p->title; ?></h1>
        <div class="ratings-container">
            &nbsp;
        </div><!-- End .rating-container -->
        <ul class="product-list">
            <li><span>Start Date:</span><?php echo $p->start_date > 10000 ? date('d M Y', $p->start_date) : ' - '; ?></li>
            <li><span>Due Date:</span><?php echo $p->end_date > 10000 ? date('d M Y', $p->end_date) : ' - '; ?></li>
            <li><span>Class: </span><?php
                $class_id = $this->assignments_m->get_classes($p->id);
                $class = $this->ion_auth->classes_and_stream();
                $i = 0;
                foreach ($class_id as $c)
                {
                        $i++;
                        echo $class[$c->class] . '<br>';
                }
                ?></li>
            <li><span>Teacher:</span><?php
                $u = $this->ion_auth->get_user($p->created_by);
                echo $u->first_name . ' ' . $u->last_name;
                ?> </li>
        </ul>
        <hr>
        <div class="product-color-filter-container">
            <span>Attachment:</span>
            <div class="xs-margin"></div>
            <?php
            if (!empty($p->document))
            {
                    ?>
                    <a href="<?php echo base_url('uploads/files/' . $p->document); ?>" class=" btn btn-primary"><i class="mdi mdi-download"></i> Download Attachment</a>
                    <?php
            }
            else
            {
                    ?>
                    <b >No Attachment</b>
            <?php } ?>
            <hr/>
        </div><!-- End .product-color-filter-container-->
        <div class="product-color-filter-container">
            <span>Details:</span>
            <div class="xs-margin"></div>
            <?php echo nl2br($p->assignment); ?>
        </div><!-- End .product-color-filter-container-->
        <div class="product-color-filter-container">
            <span>Additional Info:</span>
            <div class="xs-margin"></div>
            <?php echo empty($p->comment) ? ' --' : $p->comment; ?>
        </div><!-- End .product-color-filter-container-->
    </div> 
</div>

