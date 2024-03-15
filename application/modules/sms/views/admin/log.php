<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>SMS Log </h2>
    <div class="right">  
    </div>
</div>

<?php if ($sms): ?>
         <div class="block-fluid">
             <div class="timeline">
                 <div class="event">                        
                     <div class="icon"><span class="icos-arrow-down4"></span></div>
                     <div class="body">
                         <div class="arrow"></div>
                         <div class="head"><a href="#"><?php echo $links; ?></a></div>                            
                     </div>
                 </div>  
                 <?php
                 $i = 0;
                 if ($this->uri->segment(5) && ( (int) $this->uri->segment(5) > 0))
                 {
                      $i = ($this->uri->segment(5) - 1) * $per;
                 }
                 $this->load->library('dates');
                 foreach ($sms as $p):
                      $i++;
                      $srt = $this->dates->createFromTimeStamp($p->created_on)->diffForHumans();
                      $px = explode(' ', $srt);
                      $tp = isset($px[0]) ? $px[0] : '-';
                      $tp1 = isset($px[1]) ? $px[1] : '-';
                      $tp2 = isset($px[2]) ? $px[2] : '-';
                      $dd = $p->created_on > 10000 ? date('d M Y H:i:s', $p->created_on) : '';
                      $title = $p->dest . '- (' . $dd . ' ) - ' . $p->source;
                      $user = $this->ion_auth->get_user($p->created_by)
                      ?>
                      <div class="event">
                          <div class="date red"><?php echo $tp; ?><span>
                                  <?php echo $tp1 . ' ' . $tp2; ?></span></div>
                          <div class="icon"><span class="icos-comments3"></span></div>
                          <div class="body">
                              <div class="arrow"></div>
                              <div class="user"><a href="#"><?php echo $title; ?></a></div>
                              <div class="text">
                                  <blockquote>
                                      <p>
                                           <?php echo $p->relay; ?>
                                      </p>
                                      <small>
                                          <cite title="Sent by"><?php echo $user->first_name . ' ' . $user->last_name; ?></cite>
                                      </small>
                                  </blockquote>
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
<style>
    blockquote p { font-size: 12px;}
</style>