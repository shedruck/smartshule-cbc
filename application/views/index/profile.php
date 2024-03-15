<div class="col-md-12 whitebg">
    <?php
    $user = $this->ion_auth->get_user();
    ?> 
    <div class="row">
        <div class="col-md-4">

            <div class="widget">
                <div class="profile clearfix">
                    <div class="image sps center">
                        <?php echo theme_image('member.png', array('class' => "img-polaroid")); ?>
                    </div>                        
                    <div class="info-s">
                        <h2><?php echo trim($user->first_name . ' ' . $user->last_name); ?></h2>
                        <p><strong>&nbsp;</strong> </p>
                        <p><strong>Email:</strong> <?php echo $user->email; ?></p>
                        <p><strong>Phone:</strong> <?php echo $user->phone; ?></p>
                        <p><strong>Registration Date:</strong> <?php echo $user->created_on > 0 ? date('d M Y H:i', $user->created_on) : ' - '; ?></p>
                        <p><strong>Last Login:</strong> <?php echo $user->last_login > 0 ? date('d M Y H:i', $user->last_login) : 'Never'; ?></p>
                        <?php
                        //    foreach ($gs as $g)
                        //  {
                        ?>
                        <div class="status"><?php //echo rtrim($g->description, 's');   ?></div>
                        <?php //} ?>
                    </div>

                </div>
            </div>
        </div>

      

    </div>
</div>
