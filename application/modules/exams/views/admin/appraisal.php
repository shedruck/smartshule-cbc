<?php
$posts = $this->input->post();
if (empty($result) && $this->input->post('editt'))
{
        foreach ($posts as $p => $k)
        {
                $posts[$p] = '';
        }
}
?>
<div class="row slip">
    <div class="roff">
        <h3>Student Appraisal</h3><hr>
        <?php echo form_open(current_url()); ?>
        <?php $data = $this->ion_auth->students_full_details(); ?>
        <?php echo form_dropdown('student', array('' => 'Select') + $data, $this->input->post('student'), 'class="select"') ?> 
        <?php echo form_error('student'); ?>
        Month:
        <?php echo form_dropdown('term', array('' => 'Select') + $terms, $this->input->post('term'), 'class="fsel"') ?> 
        <?php echo form_error('term'); ?>
        Year:
        <?php echo form_dropdown('year', array('' => 'Select') + $years, $this->input->post('year'), 'class="fsel"') ?>
        <?php echo form_error('year'); ?>
        &nbsp;
        &nbsp;
        <button class="btn btn-primary" name="editt" value="100" style="height:30px;" type="submit"><i class="glyphicon glyphicon-play-circle"></i> Edit Appraisal</button>
        <br>
        <div class="widget">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="widget">
                        <div class="head dark">
                            <h2>PERSONAL PRESENTATION</h2>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Correct Uniform:</div>
                            <div class="col-md-4"><?php echo form_input('uniform', (isset($result->uniform)) ? $result->uniform : $posts['uniform'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('uniform'); ?>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Shoes:</div>
                            <div class="col-md-4"><?php echo form_input('shoes', (isset($result->shoes)) ? $result->shoes : $posts['shoes'], 'class="spinn"') ?></div>                              
                            <?php echo form_error('shoes'); ?>                          
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Personal Hygiene:</div>
                            <div class="col-md-4"><?php echo form_input('hygiene', (isset($result->hygiene)) ? $result->hygiene : $posts['hygiene'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('hygiene'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Neatness:</div>
                            <div class="col-md-4"><?php echo form_input('neatness', (isset($result->neatness)) ? $result->neatness : $posts['neatness'], 'class="spinn"') ?></div>                             
                            <?php echo form_error('neatness'); ?>                           
                        </div>
                    </div> 
                    <hr> 
                    <div class="widget">
                        <div class="head dark">
                            <h2>EXTRACURRICULAR ACTIVITIES</h2>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Creativity:</div>
                            <div class="col-md-4"><?php echo form_input('creativity', (isset($result->creativity)) ? $result->creativity : $posts['creativity'], 'class="spinn"') ?></div>                             
                            <?php echo form_error('creativity'); ?>                           
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Swimming:</div>
                            <div class="col-md-4"><?php echo form_input('swimming', (isset($result->swimming)) ? $result->swimming : $posts['swimming'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('swimming'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Games/ P.E:</div>
                            <div class="col-md-4"><?php echo form_input('games', (isset($result->games)) ? $result->games : $posts['games'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('games'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Clubs:</div>
                            <div class="col-md-4"><?php echo form_input('clubs', (isset($result->clubs)) ? $result->clubs : $posts['clubs'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('clubs'); ?>                            
                        </div>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="widget">
                        <div class="head dark">
                            <h2>PERSONALITY & CONDUCT</h2>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Respect for Teachers:</div>
                            <div class="col-md-4"><?php echo form_input('respect', (isset($result->respect)) ? $result->respect : $posts['respect'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('respect'); ?>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Polite to School mates:</div>
                            <div class="col-md-4"><?php echo form_input('polite', (isset($result->polite)) ? $result->polite : $posts['polite'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('polite'); ?>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Willingness to Help others:</div>
                            <div class="col-md-4"><?php echo form_input('help', (isset($result->help)) ? $result->help : $posts['help'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('help'); ?>                  
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Self Discipline:</div>
                            <div class="col-md-4"><?php echo form_input('discipline', (isset($result->discipline)) ? $result->discipline : $posts['discipline'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('discipline'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Class Behaviour:</div>
                            <div class="col-md-4"><?php echo form_input('behaviour', (isset($result->behaviour)) ? $result->behaviour : $posts['behaviour'], 'class="spinn"') ?></div>                             
                            <?php echo form_error('behaviour'); ?>                           
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Confidence:</div>
                            <div class="col-md-4"><?php echo form_input('confidence', (isset($result->confidence)) ? $result->confidence : $posts['confidence'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('confidence'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Team Spirit:</div>
                            <div class="col-md-4"><?php echo form_input('teamwork', (isset($result->teamwork)) ? $result->teamwork : $posts['teamwork'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('teamwork'); ?>                            
                        </div>
                    </div>
                    <hr>
                    <div class="widget">
                        <div class="head dark">
                            <h2>PARENT COOPERATION</h2>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Parent Cooperation</div>
                            <div class="col-md-4"><?php echo form_input('parent_coop', (isset($result->parent_coop)) ? $result->parent_coop : $posts['parent_coop'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('parent_coop'); ?>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget">
                        <div class="head dark">
                            <h2>CLASSWORK</h2>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Work Presentation:</div>
                            <div class="col-md-4"><?php echo form_input('presentation', (isset($result->presentation)) ? $result->presentation : $posts['presentation'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('presentation'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Handwriting:</div>
                            <div class="col-md-4"><?php echo form_input('handwriting', (isset($result->handwriting)) ? $result->handwriting : $posts['handwriting'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('handwriting'); ?>                            
                        </div> 
                        <div class="form-group">
                            <div class="col-md-8">Completion of Class Assignments:</div>
                            <div class="col-md-4"><?php echo form_input('assignments', (isset($result->assignments)) ? $result->assignments : $posts['assignments'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('assignments'); ?>                            
                        </div> 
                        <div class="form-group">
                            <div class="col-md-8">Completion of Homework:</div>
                            <div class="col-md-4"><?php echo form_input('homework', (isset($result->homework)) ? $result->homework : $posts['homework'], 'class="spinn"') ?></div>                             
                            <?php echo form_error('homework'); ?>                           
                        </div>
                    </div>
                    <hr>&nbsp;
                    <div class="widget">
                        <div class="head dark">
                            <h2>CARE OF PERSONAL ITEMS</h2>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Stationery:</div>
                            <div class="col-md-4"><?php echo form_input('stationery', (isset($result->stationery)) ? $result->stationery : $posts['stationery'], 'class="spinn"') ?></div>                            
                            <?php echo form_error('stationery'); ?>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">School Diary:</div>
                            <div class="col-md-4"><?php echo form_input('diary', (isset($result->diary)) ? $result->diary : $posts['diary'], 'class="spinn"') ?></div>                             
                            <?php echo form_error('diary'); ?>                           
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">Exercise Books:</div>
                            <div class="col-md-4"><?php echo form_input('books', (isset($result->books)) ? $result->books : $posts['books'], 'class="spinn"') ?></div>                             
                            <?php echo form_error('books'); ?>                           
                        </div>
                    </div> 
                </div>
                <div class='clearfix'></div>
                <div class='form-group'>
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<style>
    .lixx{margin-bottom: 2px; }
    .roff{padding: 12px;}
    .spinn{width: 100%; }
</style>
<script>
        $(document).ready(function ()
        {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
            $(".spinn").spinner({
                max: 4,
                min: 1
            }).on('input', function () {
                if ($(this).data('onInputPrevented'))
                    return;
                var val = this.value,
                        $this = $(this),
                        max = $this.spinner('option', 'max'),
                        min = $this.spinner('option', 'min');
                //only numbers, no alpha. 
                //set it to previous default value.         
                if (!val.match(/^[+-]?[\d]{0,}$/))
                    val = $(this).data('defaultValue');
                this.value = val > max ? max : val < min ? min : val;
            }).on('keydown', function (e)
            {
                //set default value for spinner.
                if (!$(this).data('defaultValue'))
                    $(this).data('defaultValue', this.value);
                // To handle backspace
                $(this).data('onInputPrevented', e.which === 8 ? true : false);
            });
        });
</script>