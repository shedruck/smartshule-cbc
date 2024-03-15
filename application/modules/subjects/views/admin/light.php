<style>
    .widget .paper {
        /*display: block;*/
        border: 1px solid #DDD;
        padding: 5px;
        background: #E5E5E5;
        background: -moz-linear-gradient(top, #F9F9F9 0%, #E5E5E5 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#F9F9F9), color-stop(100%,#E5E5E5));
        background: -webkit-linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
        background: -o-linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
        background: -ms-linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
        background: linear-gradient(top, #F9F9F9 0%,#E5E5E5 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#F9F9F9', endColorstr='#E5E5E5',GradientType=0 );
        -moz-box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2), inset 0px 1px 3px rgba(255, 255, 255, 0.5);
        -webkit-box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2), inset 0px 1px 3px rgba(255, 255, 255, 0.5);
        box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2), inset 0px 1px 3px rgba(255, 255, 255, 0.5);
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
    }
    .dox{
        position: relative;
        border: 5px solid #FFF;
        background: #F5F5F5;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        -moz-box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        -webkit-box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

</style>
<div class="col-md-8">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icos-picture"></span></div>
            <h2>View Question Papers</h2>                    
        </div>                           
        <div id="fb-root"></div>

        <?php
        $this->load->library('img');
        foreach ($papers as $exm => $ppr)
        {
                $p = (object) $ppr;
                ?>
                <div class="dox">
                    <div class="user"><h4><a > <?php echo isset($exams[$exm]) ? $exams[$exm] : ' -'; ?>:</a></h4></div>
                    <div class="paper">
                        <?php
                        foreach ($p->files as $index => $img)
                        {
                                $doc = (object) $img;
                                $link = base_url('uploads/' . $doc->fpath . '/' . $doc->filename);
                                ?>
                                <a data-pid="<?php echo $p->id; ?>" data-url="<?php echo $link; ?>" data-aname="<?php echo $doc->filename; ?>" class="fancybox fb" href="<?php echo $link; ?>">
                                    <?php echo $this->img->rimg(base_url('uploads/' . $doc->fpath . '/' . $doc->filename), array('class' => "img-polaroid", 'width' => 100, 'height' => 80, 'alt' => 'alt text')); ?>
                                    <span class="fancybox-caption" id="fancybox-caption-<?php echo $p->id; ?>">
                                      <?php //echo $doc->filename; ?>
                                      </span> <?php /* */ ?>
                                </a>
                        <?php } ?>
                    </div>
                </div>

        <?php } ?>
    </div>

    <div class="clearfix"></div>

</div>
