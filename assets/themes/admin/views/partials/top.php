<!--Start of Tawk.to Script
<div class="tawk">
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b6c2cb4df040c3e9e0c7151/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</div>

 
			
			
<div class="header hidden-print" >
 <?php $settings = $this->ion_auth->settings();?>
    <h2 class="toplogo"> <?php echo $settings->school;?> </h2>
    <div class="buttons">
	
	
	   <div class="popup">
                <div class="label"><span class="icos-search1"></span></div>
                <div class="body">
                    <div class="arrow"></div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">                    
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>                                    
                                   <select name="student" class="select select_stud" id="select_stud" style="" tabindex="-1">
										<option value="">Search For Student</option>
										<?php
										$data = $this->ion_auth->students_full_details();
										foreach ($data as $key => $value):
												?>
												<option value="<?php echo $key; ?>"><?php echo $value ?></option>
										<?php endforeach; ?>
									</select>
                                   
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			  <script>
				$(document).ready(function(){
						
					$("#select_stud").change(function(e){
						
					var slug = $("#select_stud").val();
					
					//alert(slug);
					
					 window.location.href = "<?php echo base_url('admin/admission/view/');?>/" + slug;
				  
					  
					});
				});
					  
	</script>
			
        <div class="popup" id="subNavControll">
            <div class="label"><span class="icos-list"></span></div>
        </div>
        <div class="dropdown pull-left">
        </div>   
        <div class="dropdown">
            <div class="label">
                <img style="padding:1px;"src="<?php echo base_url('assets/themes/admin/img/us.jpg'); ?>" width="20" height="20" /> 
                <?php
                echo trim($this->user->first_name . ' ' . $this->user->last_name);
                ?> 
                <span class="glyphicon glyphicon-chevron-down glyphicon glyphicon-white"></span></div>
            <div class="body" style="width: 160px;">
                <div class="itemLink">
                    <?php
                    if ($this->acl->is_allowed(array('settings'), 1))
                    {
                            ?> 
                            <a href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white">
							</span> Settings</a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/change_password'); ?>"><span class="glyphicon glyphicon-edit glyphicon glyphicon-white">
					</span> Change Password</a>
                </div>
                <div class="itemLink">
                    <?php
                    if ($this->acl->is_allowed(array('sms', 'create'), 1))
                    {
                            ?>
                            <a href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-comment glyphicon glyphicon-white">
							</span> Messaging</a><?php } ?>
                    <?php
                    if ($this->acl->is_allowed(array('users', 'create'), 1))
                    {
                            ?>
                            <a href="<?php echo base_url('admin/permissions'); ?>"><span class="glyphicon glyphicon-lock glyphicon glyphicon-white">
							</span>  Permissions</a>
                    <?php } ?>

                    <?php
                    if ($this->acl->is_allowed(array('users', 'create'), 1))
                    {
                            ?>
                            <a href="<?php echo base_url('fee_payment/calc'); ?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white"></span> Run Process Fee</a>
                    <?php } ?>
                    <?php
                    if ($this->ion_auth->is_in_group($this->user->id, 11))
                    {
                            ?>
                            <a href="<?php echo base_url('switch_account'); ?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white"></span> Switch Account</a>
                    <?php } ?>
					
					 
					<a href="<?php echo base_url('admin/help'); ?>" target="_blank"><span class="glyphicon glyphicon-question-sign"></span> Help / Manual</a>
					 
					 
					 <?php if($settings->exam_lock==0){?>
				
					<a href="#" id="exam_lock"><span class="glyphicon glyphicon-lock"></span> Lock Exams</a>
					
					  <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#exam_lock").click(function ()
                                                {
												
                                                    var exam_lock = {'exam_lock': '1'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/exam_lock') ?>",
                                                        data: exam_lock,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Exams was successfully locked");
															
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
						<?php }else{?>
					<a href="#" id="exam_unlock"><span class="glyphicon glyphicon-edit"></span> Unlock Exams</a>
					
					  <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#exam_unlock").click(function ()
                                                {
												
                                                    var exam_lock = {'exam_lock': '0'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/exam_lock') ?>",
                                                        data: exam_lock,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Exams was successfully unlocked");
															
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
					<?php } ?>
                </div>                    
                <div class="itemLink">
                    <a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-off glyphicon glyphicon-white"></span> Logout</a>
                </div>                                        
            </div>                
        </div>            

        <div class="popup">
            <div class="label"><span class="icos-cog"></span></div>
            <div class="body">
                <div class="arrow"></div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">SCHOOL TERM:</span>
                            <div class="themes">
							 
                               <input id="t1" type="radio" name="navigation" id="fixedNav"/> Term 1
							   
							    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#t1").click(function ()
                                                {
												
                                                    var dashboard = {'term': '1'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/update_set') ?>",
                                                        data: dashboard,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Term was successfully updated to TERM 1");
															
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
							 
                               <input  id="t2" type="radio" name="navigation" id="collapsedNav"/> Term 2
							 <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#t2").click(function ()
                                                {
													
                                                    var dashboard = {'term': '2'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/update_set') ?>",
                                                        data: dashboard,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Term was successfully updated TERM 2");
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                   

								   <input  id="t3" type="radio" name="navigation" id="collapsedNav"/> Term 3
							 <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#t3").click(function ()
                                                {
													
                                                    var dashboard = {'term': '3'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/update_set') ?>",
                                                        data: dashboard,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                               alert("Term was successfully updated TERM 3");
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>


									<input  id="t4" type="radio" name="navigation" id="collapsedNav"/> Term 4
							 <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#t4").click(function ()
                                                {
													
                                                    var dashboard = {'term': '4'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/update_set') ?>",
                                                        data: dashboard,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Term was successfully updated TERM 4");
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                   
						
							</div>	
							</div>	
				</div>	


				<div class="form-group">
                        <div class="col-md-12">
                            <span class="top">DASHBOARD:</span>
                            <div class="themes">
							 
                               <input id="grid" type="radio" name="navigation" id="fixedNav"/> Grid View 
							   
							    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#grid").click(function ()
                                                {
												
                                                    var dashboard = {'dashboard': 'grid'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_dashboard') ?>",
                                                        data: dashboard,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Dashboard was successfully saved");
															
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
							 
                               <input  id="overview" type="radio" name="navigation" id="collapsedNav"/> Overview
							 <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#overview").click(function ()
                                                {
													
                                                    var dashboard = {'dashboard': 'overview'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_dashboard') ?>",
                                                        data: dashboard,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Dashboard was successfully saved");
															location.reload();
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                   
						
							</div>	
							</div>	
				</div>	
				
				
				
							<div class="form-group">
                        <div class="col-md-12">	
								<span class="top">THEMES:</span>
                            <div class="themes">
                                <a href="#" data-theme="" id="one" class="tip" title="Default">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/default.jpg'); ?>" />

                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#one").click(function ()
                                                {
                                                    var themes = {'theme': 'default'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>                                    
                                <a href="#" data-theme="ssDaB" id="two" class="tip" title="DaB">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/dab.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#two").click(function ()
                                                {
                                                    var themes = {'theme': 'ssDaB'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssTq" id="three" class="tip" title="Tq">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/tq.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#three").click(function ()
                                                {
                                                    var themes = {'theme': 'ssTq'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssGy" id="four" class="tip" title="Gy">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/gy.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#four").click(function ()
                                                {
                                                    var themes = {'theme': 'ssGy'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssLight" id="five" class="tip" title="Light">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/light.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#five").click(function ()
                                                {
                                                    var themes = {'theme': 'ssLight'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssDark" id="six" class="tip" title="Dark">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/dark.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#six").click(function ()
                                                {
                                                    var themes = {'theme': 'ssDark'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssGreen" id="seven" class="tip" title="Green">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/green.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#seven").click(function ()
                                                {
                                                    var themes = {'theme': 'ssGreen'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssRed" id="eight" class="tip" title="Red">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/red.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#eight").click(function ()
                                                {
                                                    var themes = {'theme': 'ssRed'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">BACKGROUNDS:</span>
                            <div class="backgrounds">
                                <a href="#" data-background="bg_default" class="bg_default" id="bg_default"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_default").click(function ()
                                            {
                                                var themes = {'bg': 'bg_default'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_mgrid" class="bg_mgrid" id="bg_mgrid"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_mgrid").click(function ()
                                            {
                                                var themes = {'bg': 'bg_mgrid'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_crosshatch" class="bg_crosshatch" id="bg_crosshatch"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_crosshatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_crosshatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_hatch" class="bg_hatch" id="bg_hatch"></a> 
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_hatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_hatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>								
                                <a href="#" data-background="bg_light_gray" class="bg_light_gray" id="bg_light_gray"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_light_gray").click(function ()
                                            {
                                                var themes = {'bg': 'bg_light_gray'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_dark_gray" class="bg_dark_gray" id="bg_dark_gray"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_dark_gray").click(function ()
                                            {
                                                var themes = {'bg': 'bg_dark_gray'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_texture" class="bg_texture" id="bg_texture"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_texture").click(function ()
                                            {
                                                var themes = {'bg': 'bg_texture'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_light_orange" class="bg_light_orange" id="bg_light_orange"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_light_orange").click(function ()
                                            {
                                                var themes = {'bg': 'bg_light_orange'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_yellow_hatch" class="bg_yellow_hatch" id="bg_yellow_hatch"></a> 
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_yellow_hatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_yellow_hatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_green_hatch" class="bg_green_hatch" id="bg_green_hatch"></a> 
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_green_hatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_green_hatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>								
                            </div>
                        </div>          
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Navigation:</span>
                            <input type="radio" name="navigation" id="fixedNav"/> Fixed 
                            <input type="radio" name="navigation" id="collapsedNav"/> Collapsible
                            <input type="radio" name="navigation" id="hiddenNav"/> Hidden
                        </div>                                
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php     
        if($this->license == 1){?>
            <!-- echo '<script>alert("Your License has expired")</script>';
        }  -->
  

    <!-- <script>
        $(document).ready(function(){
            $("#myModal").modal('show');
        });
    </script> -->
    <script>
	
    $(document).ready(function (){
            swal({
            title: "License Expiry",
            text: "Your Termly Lisence has expired Kindly renew",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                swal("Make payment to avaoid inconviniencies, Contact Smartshule +254733586830 / 254785222399", {
                icon: "success",
                });
            } else {
                swal("Contact Smartshule +254733586830 / 254785222399");
            }
            });
            
    
    });


</script>
    <?php }?>

    <div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">License</h5>
                <!-- <button type="button" class="btnclose" data-dismiss="modal">&times;</button> -->
            </div>
            <div class="modal-body">
                <div class="col-md-2"></div>
                <h2>Thank you for Choosing Smartshule, <strong class="red">Your License has expired</strong></h2>
                <p>For more information contact <a href="mailto:sales@smartshule.com" target="_blank">sales@smartshule.com</a></p>
                <button class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
