<?php
if (isset($message))
{
    if ($message)
    {
        if (is_array($message['text']))
        {
            echo "<div class='msg_" . $message['type'] . "'>";

            echo "<ul>";

            foreach ($message['text'] as $msg)
            {
                echo "<li><span>" . $msg . "</span></li>";
            }

            echo "<ul>";

            echo "</div>";
        }
        else
        {
            echo "<div class='alert alert-info'>" . $message['text'] . "</div>";
        }
    }
}
?>
<style>label {
display: inline;
margin-bottom: 1px;
}</style>
<div class="widget-block col-md-6">
    <div class="widget-head">
        <h5><i class="black-icons graph"></i> Generator</h5>
    </div>
    <div class="widget-content">
        <div class="widget-box">

            <?php
            $attributes = array('class' => 'tform', 'id' => '');
            echo form_open_multipart('admin/tools/', $attributes);
            ?>
            <p>
                <label class='labelform' for="description"><?php echo lang('scaffolds_cont_name') ?> <span class="required">*</span></label>

                <input id="controller_name" type="text" name="controller_name" maxlength="256" value="<?php echo set_value('controller_name'); ?>"  />

                <br><?php echo form_error('controller_name'); ?>

            </p>

            <p>
                <label class='labelform' for="description"><?php echo lang('scaffolds_mod_name') ?> <span class="required">*</span></label>
                <input id="model_name" type="text" name="model_name" maxlength="256" value="<?php echo set_value('model_name'); ?>"  />
                <br><?php echo form_error('model_name'); ?>
            </p>

            <label class='labelform' for="description">Elements Code <span class="required">*</span><br></label>
            <textarea  id="elastic-textarea" style="width: 360px;" name="scaffold_code"  class='codde_area' /><?php echo set_value('scaffold_code', ''); ?></textarea>
            <br><?php echo form_error('scaffold_code'); ?>
            <span class='forminfo'><?php echo lang('scaffolds_code_info') ?></span>

            <?php echo lang('web_options') ?>:

            <label for='scaffold_model_type'>Database Class:</label>
            <select name='scaffold_model_type' id='scaffold_model_type'>
                <option value="activerecord">Codeigniter Active Record Class</option>
                <option value="phpactiverecord">PHP-ActiveRecord</option>
            </select><br/>
         <label>   
             <input type='checkbox' checked name='scaffold_delete_bd' id='scaffold_delete_bd' value="<?php echo set_value('scaffold_delete_bd', '1'); ?>" />
            <span class="lbl">  </span> <label class='labelforminline' for="scaffold_delete_bd"><?php echo lang('scaffolds_delete_bd') ?></label><br/>
            </label>
            <label>
            <input type='checkbox' checked name='scaffold_bd' id='scaffold_bd' value='<?php echo set_value('scaffold_bd', '1'); ?>' />
            <span class="lbl">  </span><label class='labelforminline' for="scaffold_bd"><?php echo lang('scaffolds_create_bd') ?></label><br/>
            <label>
             <input type='checkbox' checked name='scaffold_routes' id='scaffold_routes' value='<?php echo set_value('scaffold_routes', '1'); ?>' /> 
           <span class="lbl">  </span> <label class='labelforminline' for="scaffold_routes"><?php echo lang('scaffolds_modify_routes') ?></label><br/>
            </label>
             <label>
            <input type='checkbox' checked name='scaffold_menu' id='scaffold_menu' value='<?php echo set_value('scaffold_menu', '1'); ?>' /> 
            <span class="lbl">  </span><label class='labelforminline' for="scaffold_menu"><?php echo lang('scaffolds_modify_menu') ?></label>
	 </label>	
              <label>
            <input type='checkbox' checked name='create_controller' id='create_controller' value='<?php echo set_value('create_controller', '1'); ?>' />
            <span class="lbl">  </span><label class='labelforminline' for="create_controller"><?php echo lang('scaffolds_create_controller') ?></label><br/>
            </label>
            <label>
            <input type='checkbox' checked name='create_model' id='create_model' value='<?php echo set_value('create_model', '1'); ?>' />
            <span class="lbl">  </span><label class='labelforminline' for="create_model"><?php echo lang('scaffolds_create_model') ?></label><br/>
            </label>
            <label>
            <input type='checkbox' checked name='create_view_create' id='create_view_create' value='<?php echo set_value('create_view_create', '1'); ?>' />
           <span class="lbl">  </span> <label class='labelforminline' for="create_view_create"><?php echo lang('scaffolds_create_view_create') ?></label><br/>
            </label>
             <label>
            <input type='checkbox' checked name='create_view_list' id='create_view_list' value='<?php echo set_value('create_view_list', '1'); ?>' /> 
            <span class="lbl">  </span><label class='labelforminline' for="create_view_list"><?php echo lang('scaffolds_create_view_list') ?></label>
             </label>
            
            </p>

            <p>
                <?php
                $bt = array(
                    'name' => 'submit',
                    'id' => 'generate',
                    'class' => 'btn btn-blue',
                    'type' => 'submit',
                    'content' => 'Generate!'
                );

                echo form_button($bt);
                ?>
            </p>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<div class="col-md-5">
    <div id="accordion-widget" class="accordion boot-accordion">
        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#One" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Textbox </a> </div>
            <div class="accordion-body collapse in" id="One">
                <div class="accordion-inner">
                    <pre>
"name" :
{
  "type" :  "text",
  "minlength"	:  "0",
  "maxlength"	 :  "60",
  "required"  :  "FALSE",
  "multilanguage"	:  "FALSE",
  "is_unique"  : "FALSE"
}
                    </pre> </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Two" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Textarea </a> </div>
            <div class="accordion-body collapse" id="Two">
                <div class="accordion-inner">
                    <pre>
        "description" 	:
        {
          "type": "textarea",
          "minlength": "0",
          "maxlength": "500",
          "required"	: "FALSE",
          "multilanguage"  : "FALSE",
          "ckeditor"	 : "FALSE"
        }
                    </pre> </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Three" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Checkbox </a> </div>
            <div class="accordion-body collapse" id="Three">
                <div class="accordion-inner">
                    <pre>
    "public" :
    {
      "type": "checkbox",
      "required"	: "FALSE",
      "checked"	: "FALSE",
      "label": "Is public?"
    }
                    </pre></div>
            </div>
        </div>

        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Four" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Select </a> </div>
            <div class="accordion-body collapse" id="Four">
                <div class="accordion-inner">
                    <pre>
   "language" :
    {
      "type":"select",
      "size":"1",
      "required"	:"FALSE",
      "option_choose_one"	:"TRUE",
      "with_translations":"FALSE",
      "options" :
      {
        "0" :
        {
          "text"	: "Spanish",
          "selected": "TRUE",
          "value"	: "spanish"
        },
        "1" :
        {
          "text"	: "English",
          "selected": "FALSE",
          "value"	: "english"
        }
      }
    }
                    </pre></div>
            </div>
        </div>

        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Five" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Select 1:N </a> </div>
            <div class="accordion-body collapse" id="Five">
                <div class="accordion-inner">
                    <pre>
     "category_id" :
    {
      "type"  : "selectbd",
      "size"       	: "1",
      "required"  : "TRUE",
      "options"	:
      {
        "model" 	: "category_m",
        "field_value": "id",
        "field_text": "name",
        "order"      : "name ASC"
      }
    }
                    </pre></div>
            </div>
        </div>


        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Six" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Radio Buttons </a> </div>
            <div class="accordion-body collapse" id="Six">
                <div class="accordion-inner">
                    <pre>
"gender" :
{
  "type"       	: "radio",
  "required"  	: "FALSE",
  "checked"	: "male",
  "options"    	:
  {
    "0" :
    {
      "label"      	: "Male",
      "value"      	: "male"
    },
    "1" :
    {
      "label"      	: "Female",
      "value"      	: "female"
    }
  }
}
                    </pre></div>
            </div>
        </div>


        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Seven" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Datepicker </a> </div>
            <div class="accordion-body collapse" id="Seven">
                <div class="accordion-inner">
                    <pre>
    "day" :
    {
      "type"		: "datepicker",
      "required"	: "FALSE"
    }
                    </pre></div>
            </div>
        </div>

        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Eight" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Image </a> </div>
            <div class="accordion-body collapse" id="Eight">
                <div class="accordion-inner">
                    <pre>
    "user_image" :
    {
      "type"                 : "image",
      "required"           : "FALSE",
      "multilanguage"   : "FALSE",
      "upload"  :
      {
        "allowed_types"  : "gif|jpg|png",
        "encrypt_name"  : "TRUE",
        "max_width"       : "2000",
        "max_height"      : "1500",
        "max_size"          : "2048"
      },
      "thumbnail" :
      {
       "maintain_ratio"   :  "FALSE",
       "master_dim"       : "width",
       "width"                : "100",
       "height"               : "100"
      }
    }
                    </pre></div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Nine" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> File </a> </div>
            <div class="accordion-body collapse" id="Nine">
                <div class="accordion-inner">
                    <pre>
    "file" :
    {
      "type"                 : "file",
      "required"           : "FALSE",
      "multilanguage"   : "FALSE",
      "upload"  :
      {
        "allowed_types"  : "pdf",
        "encrypt_name"  : "TRUE",
        "max_size"         : "2048"
      }
    }
                    </pre></div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading"> <a href="#Ten" data-parent="#accordion-widget" data-toggle="collapse" class="accordion-toggle"> Hidden Relational </a> </div>
            <div class="accordion-body collapse" id="Ten">
                <div class="accordion-inner">
                    <pre>
     "category_id" :
    {
      "type"           : "hidden",
      "controller"    : "name_controller",
      "model"         : "name_model"
    }
                    </pre></div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12  ">
    <div class="box">
        <div class="box-head">
            <h5><i class="black-icons money"></i> </h5>

        </div>
        <div class="box-body">
            <div class="widget-box">
                <div class="white-box ">

                </div>
            </div>

        </div> </div>

</div>
