<style>
    @media print{

        .navigation{
            display:none;
        }
        .widget{
            width:420px;

        }
        .head{
            display:none;
        }
        .print{
            display:none;
        }

        
    }
</style> 
<div class="col-md-12">
<div class=" right">
    <a class="print" href="" onclick="window.print();
        return false"><button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print  </button></a>

		<a class="print" href="<?php echo base_url('admin/admission/view/'.$u->id)?>"><button class="btn btn-success" ><span class="glyphicon glyphicon-user"></span> Profile  </button></a>
   <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list">
                    </i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?>
</div>
</div>
<div class="col-md-1">
</div>
<div class="col-md-10">
  <div class="widget">

	<div id="background">
			<div id="Background"><?php echo theme_image('card/Background.png')?></div>
			<div id="Background_0"><?php echo theme_image('card/Background_0.png')?></div>
			
			<div id="Bitmap" class="logo"> <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>"  align="left"  width="180" height="180" /></div>
			
			<div id="layer_4"><?php echo theme_image('card/layer_4.png')?></div>
			
			<div id="Rectangle3"><?php echo theme_image('card/Rectangle3.png')?></div>
			
			<div id="SHETUWANG" class="school-name"style="font-size:25px;color:#000"><?php echo strtoupper($this->school->school); ?></div>
			
			<div id="Bitmap_0" class="student_photo" style="border-radius:50%">
			    <?php if (!empty($passport)): ?>	
						<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" style="border-radius:50%; " align="left" width="190" height="200" class="img-polaroid" style="align:left">

					<?php else: ?>   
						<?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'align'=>"left" ,'style' => "width:180px; height:180px; align:left")); ?>

					<?php endif; ?>  
			</div>
			
			
			<div id="Rectangle2"><?php echo theme_image('card/Rectangle2.png')?></div>
			<div id="Rectangle1" ><?php echo theme_image('card/Rectangle1.png')?></div>
			
			
			<div id="shetuwang123com" class="bio" style="font-size:25px; color:#fff" >
			Gender: 
			<?php if ($u->gender == 1) echo 'Male'; elseif($u->gender == 2) echo 'Female'; else echo $u->gender; ?>
			</div>
			
			
			<div id="shetuwang123com_0" class="bio" style="font-size:25px; color:#fff">Blood Group: AB</div>
			
			<div id="Shanghaishipudongxin" class="dates" style="font-size:20px; font-weight:700"> DATE ISSUED: <?php echo date('d M Y')?></div>
			
			<div id="shetuwang123com_1" class="bio" style="font-size:25px; color:#fff">Tel: <?php echo $u->emergency_phone; ?></div>
			
			<div id="www699piccom" class="bio" style="font-size:25px; color:#fff">DOB: <?php echo $u->dob > 1000 ? date('d M Y', $u->dob) : ''; ?></div>
			
			<div id="layer_02180187116" class="adm-no" style="font-size:50px;color:#fff">ADM. <?php if (!empty($u->old_adm_no)) echo $u->old_adm_no;
                else echo $u->admission_number; ?></div>
			
			<div id="SHETUWANG_0" class="name" style="font-size:22px; text-transform:uppercase" ><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></div>
			
			<div id="Shanghaishipudongxin_0" class="dates" style="font-size:20px; font-weight:700">VALID - <?php echo date('Y')?> / <?php echo date('Y', strtotime('+4 years'));?></div>
			
			<div id="POBox458790020" class="box" style="font-size:22px;color:#000">   
			      <?php   echo $this->school->postal_addr ;?>
			</div>
			
			<div id="Tel02012548958" class="tel" style="font-size:18px;">   
			       <?php   echo  ' Tel:' . $this->school->tel . ' Cell:' . $this->school->cell;?>
			</div>
			
			<div id="MottoTogetherWeS" class="motto" style="font-size:15px;" ><i>Motto: "<?php echo strtoupper($this->school->motto); ?>"</i></div>
		</div>

 




  
</div>

<div class="col-md-1">
</div>

<div class="col-md-12">
<div id="background">
			<div id="Background"><?php echo theme_image('card/Background_b.png')?></div>
			<div id="Background_0_b"><?php echo theme_image('card/Background_0_b.png')?></div>
			<div id="Rectangle3_b"><?php echo theme_image('card/Rectangle3_b.png')?></div>
			<div id="Bitmap_b"><?php echo theme_image('card/Bitmap_b.png')?></div>
			<div id="Bitmap_0_b"><img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>"  align="left"  width="250" height="250" /></div>
			<div id="Rectangle2_b"><?php echo theme_image('card/Rectangle2_b.png')?></div>
			<div id="ScanToShowDetails"><?php echo theme_image('card/ScanToShowDetails.png')?> </div>
		</div>
</div>

