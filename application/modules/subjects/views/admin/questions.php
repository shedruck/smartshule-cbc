
<div class="col-md-8">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icos-picture"></span></div>
            <h2>View Question Papers</h2>                    
        </div>                           
        <div class="sGallery clearfix">
            <?php  $this->load->library('img'); 
                  foreach ($papers as $p)
                  {
                          ?>
                          <div class="item" id="sgImg_1" style="margin-left: 19px; margin-right: 19px;">
                               <a href="<?php echo base_url('admin/subjects/thumbs/' . $p->filename . '/80/80/'); ?>" class="fb" rel="group">
                                  <?php echo $this->img->rimg(base_url('uploads/' . $p->fpath . '/' . $p->filename), array('width' => 100,'height' => 80, 'alt' => 'alt text')) ;   ?>
                              </a>
                              <ul class="controls" style="right: -150px;">
                                  <li><i class="glyphicon glyphicon-pencil"></i> <a href="<?php echo base_url('admin/subjects/thumbs/'.$p->exam);?> " class="fb">View</a></li>
                                   <li><i class="glyphicon glyphicon-download-alt"></i><?php echo $p->filesize; ?> Kb</li>
                               </ul>
                              <div class="g"><?php echo isset($exams[$p->exam]) ? $exams[$p->exam] : ' -'; ?></div>
                          </div>
                          <?php
                  }
             ?>

        </div>
    </div>

    <div class="clearfix"></div>

</div>
