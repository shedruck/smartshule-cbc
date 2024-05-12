<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>E-Videos</b></h5>
        <div>
          <?php echo anchor('evideos/trs/evideos_landing', '<i class="fa fa-list"></i> List All Videos', 'class="btn btn-primary btn-sm "'); ?>
          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>


      <div class="card-body p-2">
        <div class="col-xxl-12 col-xl-12 col-sm-12">
          <div class="row">


            <!-- start of  big side -->
            <div class="col-xxl-8 col-xl-8 col-sm-8">
              <div class="post-image">
                <?php

                $classes = $this->portal_m->get_class_options();
                $sys = $this->ion_auth->populate('class_groups', 'id', 'education_system');
                $sub844 = $this->ion_auth->populate('subjects', 'id', 'name');
                $cbc = $this->ion_auth->populate('cbc_subjects', 'id', 'name');

                if ($sys[$post->level] == 1) {
                  $sub = $sub844;
                } elseif ($sys[$post->level] == 2) {
                  $sub = $cbc;
                }

                ?>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo $post->video_embed_code ?>?playlist=<?php echo $post->video_embed_code ?>&loop=1">
                </iframe>


                <span class="badge bg-secondary-gradient fs-17 mt-2"> <?php echo $subject ?> </span>

              </div>

              <hr>
              <div class="text-muted">
                <span>By <a class="text-dark font-secondary">
                    <?php $u = $this->ion_auth->get_user($post->created_by);
                    echo $u->first_name . ' ' . $u->last_name; ?>
                  </a>,</span>
                <span> <?php echo date('F d, Y', $post->created_on) ?></span>
              </div>
              <div class="post-title">
                <!-- <h5><a href="javascript:void(0);"><?php echo strtoupper($post->title); ?></a></h5> -->
                <h1 class="page-title text-uppercase mt-2 mb-2"><a href="javascript:void(0);"><?php echo strtoupper($post->title); ?></a></h1>
              </div>


              <div class="card">
                <div class="card-status card-status-left bg-red br-bs-7 br-ts-7"></div>
                <div class="card-body">
                  <div>

                    <h6 class="text-uppercase text-primary">
                      <?php echo $post->description; ?>
                    </h6>

                    <span class="fs-14 fw-semibold mb-0">Level :</span> <label class="form-check-label" for="flexRadioDefault1">
                      <?php if ($post->level == '999') echo 'General';
                      else  echo $classes[$post->level]; ?>
                    </label><br>
                    <span class="fs-14 fw-semibold mb-0">Subject :</span> <label class="form-check-label" for="flexRadioDefault1">
                      <?php echo $sub[$post->subject]; ?>
                    </label><br>
                    <span class="fs-14 fw-semibold mb-0">Topic :</span> <label class="form-check-label" for="flexRadioDefault1">
                      <?php echo $post->topic; ?>
                    </label><br>
                    <span class="fs-14 fw-semibold mb-0">Sub Topic :</span> <label class="form-check-label" for="flexRadioDefault1">
                      <?php echo $post->subtopic; ?>
                    </label><br>
                  </div>
                </div>
              </div>

              <hr>
              <div class="m-t-50 blog-post-comment">
                <!-- <h5 class="text-uppercase">Comments <small>(<?php echo count($comments) ?>)</small></h5> -->
                <h1 class="page-title text-uppercase mt-3 mb-3">Comments <small>(<?php echo count($comments) ?>)</small></h1>
                <ul class="media-list notification">

                  <?php foreach ($comments as $c) {
                    $u = $this->ion_auth->get_user($c->created_by); ?>


                    <li>
                      <div class="notification-time">
                        <span class="date"><?php echo  date('F, d Y', $c->created_on) ?></span>
                        <span class="time"><?php echo  date('H:i A', $c->created_on) ?></span>
                      </div>
                      <div class="notification-icon">
                        <a href="javascript:void(0);" class="border-secondary"></a>
                      </div>
                      <div class="notification-time-date mb-2 d-block d-md-none">
                        <span class="date"><?php echo  date('F, d Y', $c->created_on) ?></span>
                        <span class="time ms-2"><?php echo  date('H:i A', $c->created_on) ?></span>
                      </div>
                      <div class="notification-body col-xl-8">
                        <div class="media mt-0">
                          <div class="main-avatar avatar-md offline">
                            <?php
                            $first_letter_first_name = substr($u->first_name, 0, 1);
                            $first_letter_last_name = substr($u->last_name, 0, 1);

                            ?>
                            <span class="avatar avatar-md rounded-circle bg-secondary me-3"><?php echo
                                                                                            $first_letter_first_name . '' . $first_letter_last_name ?></span>
                          </div>
                          <div class="media-body ms-3 d-flex">
                            <div class="">
                              <p class="fs-15 text-dark fw-bold mb-0"><?php echo $u->first_name . ' ' . $u->last_name ?></p>
                              <p class="mb-0 fs-13 text-dark"><?php echo ucwords($c->comment); ?></p>
                            </div>
                            <div class="notify-time">
                              <p class="mb-0 text-muted fs-11"><?php echo  date('H:i A', $c->created_on) ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>

                  <?php } ?>

                  <li id="now_response" style="display:none">
                    <div class="notification-time">
                      <span class="date"><?php echo  date('F, d Y', $c->created_on) ?></span>
                      <span class="time"><?php echo  date('H:i A', $c->created_on) ?></span>
                    </div>
                    <div class="notification-icon">
                      <a href="javascript:void(0);" class="border-secondary"></a>
                    </div>
                    <div class="notification-time-date mb-2 d-block d-md-none">
                      <span class="date"><?php echo  date('F, d Y', $c->created_on) ?></span>
                      <span class="time ms-2"><?php echo  date('H:i A', $c->created_on) ?></span>
                    </div>
                    <div class="notification-body col-xl-8">
                      <div class="media mt-0">
                        <div class="main-avatar avatar-md offline">
                          <?php
                          $first_letter_first_name = substr($u->first_name, 0, 1);
                          $first_letter_last_name = substr($u->last_name, 0, 1);

                          ?>
                          <span class="avatar avatar-md rounded-circle bg-secondary me-3"><?php echo
                                                                                          $first_letter_first_name . '' . $first_letter_last_name ?></span>
                        </div>
                        <div class="media-body ms-3 d-flex">
                          <div class="">
                            <p class="fs-15 text-dark fw-bold mb-0"><?php echo $u->first_name . ' ' . $u->last_name ?></p>
                            <p class="mb-0 fs-13 text-dark" id="user_comment<?php echo ucwords($post->id); ?>"></p>
                          </div>
                          <div class="notify-time">
                            <p class="mb-0 text-muted fs-11"><?php echo  date('H:i A', $c->created_on) ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                </ul>

                <h1 class="page-title text-uppercase mt-3 mb-3"><i class="fas fa-comment"></i> Leave a comment</h1>
                <div class="form-group">
                  <textarea class="form-control" id="comment_<?php echo $post->id; ?>" name="message" rows="5" placeholder="Message" required=""></textarea>

                </div>
                <!-- /Form Msg -->

                <div class="row">
                  <div class="col-xs-12">
                    <div class="">
                      <button type="submit" class="btn btn-primary" id="submt_<?php echo $post->id; ?>"><i class="fa fa-share"></i> Submit</button>
                    </div>
                  </div> <!-- /col -->
                </div> <!-- /row -->
              </div>
            </div>
            <!-- end of a big side -->

            <!-- start of  small side -->
            <div class="col-xxl-4 col-xl-4 col-sm-4">
              <div class="p-20">

                <div class="">
                  <h1 class="page-title text-uppercase mt-3 mb-3">Search Video</h1>
                  <div class="input-group ms-2">
                    <input type="text" class="form-control border-end-0" placeholder="Search ..." id="search-input">
                    <button class="input-group-text bg-transparent border-start-0   border-end text-muted">
                      <i class="fe fe-search text-muted" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>

                <div class="m-t-50">
                  <h1 class="page-title text-uppercase mt-5 mb-3">RELATED TOPICS</h1>
                  <?php
                  $i = 0;

                  foreach ($evideos as $p) :
                    $u = $this->ion_auth->get_user($p->created_by);
                    $i++;
                  ?>
                    <div class="media latest-post-item mt-2">
                      <div class="media-left bg-light d-flex justify-content-center align-items-center" style="margin-right: 10px; border: 1px solid #495057; background-image: url('<?php echo $p->preview_link; ?>'); background-size: cover; background-position: center; width: 105px; height: 66px;">
                        <i class="bi bi-play-btn-fill" style="font-size: 27px;"></i> <!-- Play icon -->
                       
                      </div>


                      <div class="media-body ml-2">
                        <h6 class="text-primary">
                          <a href="<?php echo base_url('evideos/trs/watch/' . $p->subject . '/' . $class . '/' . $this->session->userdata['session_id'] . '/' . $p->id) ?>"><?php echo strtoupper($p->title); ?></a>
                        </h6>
                        <p class="font-13 text-muted">
                          <?php echo date('F d, Y', $p->created_on) ?> | <?php echo $u->first_name . ' ' . $u->last_name; ?>
                        </p>
                      </div>
                    </div>
                  <?php endforeach ?>


                </div>
              </div>
            </div>
            <!-- end of a small side -->

          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>

<script>
  $(document).ready(function() {

    //******   POST THE COMMENT ON REPLIES ******//

    $("#submt_<?php echo $post->id; ?>").click(function() {

      var id = <?php echo $post->id; ?>;
      var comment = $('#comment_<?php echo $post->id; ?>').val();

      var dataString = '&comment=' + comment + '&id=' + id + '&type=1';

      if (comment == '' || id == '') {
        alert("Atleast write something before submitting !");
      } else {
        //alert(comment);
        // AJAX Code To Submit Form.
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('trs/post_comment'); ?>",
          data: dataString,
          cache: false,
          success: function(result) {


            document.getElementById("user_comment<?php echo $post->id; ?>").innerHTML += "<span>" + comment + "</span>";
            document.getElementById('comment_<?php echo $post->id; ?>').value = ''

            $('#now_response').show('fast');


          }
        });

      }


    });
  })
</script>