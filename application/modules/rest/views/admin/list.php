<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> API Credentials  </h2>
    <div class="right">  
    </div>
</div>
<section id="main-content">
    <!-- !Main Content -->
    <div id="content" class="region">
        <div class="block-fluid">
            <div class="field-items">
                <h2>Generate Client Credentials</h2>
                <ol>
                    <li>To Access the <strong>API</strong>, All requests must supply a token in the header.</li>
                    <li><strong>Generate</strong> credentials which will enable you to request a token.</li>
                    <li>Head to the<strong> API Documentation</strong> for more</li>
                </ol>
            </div>
            <div id="conten">
                <h3>Oauth 2.0 Credentials</h3>
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?><input type="hidden" value="<?php echo time(); ?>" name="tok"/>
                <button class="btn btn-lg btn-default" type="submit" onclick="return confirm('Confirm regenerate credentials?')">Generate Credentials</button>
                <?php echo form_close(); ?>
                <div class="creds">
                    <p class="spacer">---------------------------------------------------------------</p>
                    <table class='code'>
                        <?php
                        if ($gen)
                        {
                                ?>
                                <tr>
                                    <td>client id:</td>
                                    <td><?php echo $creds->client_id; ?></td>
                                </tr>
                                <tr>
                                    <td>client secret:</td>
                                    <td><?php echo $creds->client_secret; ?></td>
                                </tr>
                                <?php
                        }
                        elseif (!empty($creds))
                        {
                                ?>
                                <tr>
                                    <td>client id:</td>
                                    <td><?php echo $creds->client_id; ?></td>
                                </tr>
                                <tr>
                                    <td>client secret:</td>
                                    <td><div class="flip btn btn-danger btn-sm">show</div><span class="panell"><?php echo $creds->client_secret; ?></span></td>
                                </tr>
                        <?php } ?>
                    </table>
                    <p class="spacer">---------------------------------------------------------------</p>
                </div>
            </div>
        </div>
    </div>
</section>
<style>    
    .creds{ margin-top: 50px;}
    .code{border: 0;  }
    .code tr td {
        border: 0;
        color: #4dd0e1;
        background: #262626 !important;
        unicode-bidi: embed;
        font-family: monospace;
        white-space: pre;
    }
    .spacer,spa{color: #4dd0e1; padding: 0;}
    span.panell{display: none;color: #4dd0e1; padding: 0;}

    #conten { padding: 12px;
              background: #262626;
              margin: 1% auto;
              box-shadow: 2px 2px 10px rgba(0, 0, 0, .5);
              color: #c1c1c1;
    } 
    .flip{cursor: pointer;}
</style>
<script>
        $(document).ready(function () {
            $(".flip").click(function () {
                $(".panell").toggle();
                $(this).toggle();
            });
        });
        var pres = document.querySelectorAll('pre,kbd,blockquote');
        for (var i = 0; i < pres.length; i++) {
            pres[i].addEventListener("dblclick", function () {
                var selection = getSelection();
                var range = document.createRange();
                range.selectNodeContents(this);
                selection.removeAllRanges();
                selection.addRange(range);
            }, false);
        }
</script>