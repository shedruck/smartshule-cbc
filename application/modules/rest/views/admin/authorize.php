<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Authorize  </h2>
    <div class="right">  
    </div>
</div>
<section>
    <div id="content" class="region">
        <div class="block-fluid">
            <div class="field-items">
            </div>
            <div>
                <h3>&nbsp;</h3>
                <?php
                $attributes = ['class' => 'form-horizontal', 'id' => 'mx'];
                echo form_open_multipart(current_url() . '?' . $qs, $attributes);
                ?>
                <label>Authorize Smartshule?</label><br />
                <input type="submit" name="authorized" value="yes">
                <input type="submit" name="authorized" value="no">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>