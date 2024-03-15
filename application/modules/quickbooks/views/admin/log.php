<div class="head"> 
    <style>
        p {white-space: pre-line;}
    </style>
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Quickbooks  </h2>
    <div class="right">  
         <?php echo anchor('quickbooks/clear/', '<i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i> Clear Log', 'class="btn btn-primary"'); ?>
    </div>
</div>

<?php if ($quickbooks): ?>
         <div class="block-fluid">

             <div class="timeline">
                  <?php
                  $i = 0;
                  if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                  {
                       $i = ($this->uri->segment(4) - 1) * $per;
                  }

                  foreach ($quickbooks as $p):
                       $i++;
                       $on = strtotime($p->log_datetime);
                       $srt = $this->dates->createFromTimeStamp($on)->diffForHumans();
                       $px = explode(' ', $srt);
                       $tp = isset($px[0]) ? $px[0] : '-';
                       $tp1 = isset($px[1]) ? $px[1] : '-';
                       $tp2 = isset($px[2]) ? $px[2] : '-';
                       $load = explode(':', $p->msg, 2);
                       $title = isset($load[0]) ? $load[0] : '-';
                       $body = isset($load[1]) ? $load[1] : '-';
                       ?>
                      <div class="event">
                          <div class="date red"><?php echo $tp; ?><span>
                                  <?php echo $tp1 . ' ' . $tp2; ?></span></div>
                          <div class="icon"><span class="icos-comments3"></span></div>
                          <div class="body">
                              <div class="arrow"></div>
                              <div class="user"><a href="#"><?php echo $title; ?></a></div>
                              <div class="text">
                                  <p>
                                       <?php
                                       if (strpos($p->msg, 'Incoming') === 0 || strpos($p->msg, 'Outgoing') === 0 || strpos($p->msg, 'XML') === 0 || strpos($p->msg, 'Importing invoice') === 0)
                                       {
                                            echo htmlentities(html_entity_decode($body));
                                       }
                                       else
                                       {
                                            //echo nl2br(htmlentities(wordwrap(substr($body, 0, 700), 100, "\n", true)));
                                            echo nl2br(htmlentities($body));
                                       }
                                       ?></p>
                              </div>

                          </div>

                      </div>                   
                 <?php endforeach ?>
                 <div class="event">                        
                     <div class="icon"><span class="icos-arrow-down4"></span></div>
                     <div class="body">
                         <div class="arrow"></div>
                         <div class="head"><a href="#"><?php echo $links; ?></a></div>                            
                     </div>
                 </div>                     
             </div>
         </div>
    <?php else: ?>
         <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>