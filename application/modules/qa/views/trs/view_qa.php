<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php echo $post->title?> - Question and Answers</b>
        </h3>
		
		
		<div class="pull-right">
		
		
		 <div class="btn-group">
				<button type="button" class="btn btn-success btn-sm" data-toggle="dropdown"><i class="fa fa-folder"></i>  Post Quiz to Students <span class="caret"></span> </button>
				<ul class="dropdown-menu">
				<h5 class="text-center"> MY CLASSES</h5>
					<?php
					foreach ($classes as $cl)
					{
						?>    
				 <li>
						
						<button class="btn btn-default  col-md-12 btn-sm "  style="width:100% !important" width="100%" id="post_<?php echo $cl->id;?>" value="<?php echo base_url('qa/trs/post_qa/'.$post->id.'/'.$cl->id.'/'.$this->session->userdata['session_id'])?>" ><i class='fa fa-caret-right'></i> <?php echo strtoupper($cl->name); ?></button>
						<hr>
				 </li>
						
						
							<script>
					$(document).ready(function ()
					{
								$("#post_<?php echo $cl->id;?>").click(function() { 
								
								var url = $("#post_<?php echo $cl->id;?>").val();
							

									swal({
										  title: "Post Assignemnt",
										  text: "Are you sure you want to Post this assignment to the learners?",
										  icon: "warning",
										  buttons: true,
										  dangerMode: true,
										})
										.then((willDelete) => {
										  if (willDelete) {
											  window.location= url;
											 swal("Posting assignment please wait....");
										  } else {
											//swal("Your imaginary file is safe!");
										  }
									});
										
					    	});
							
							

					})
          </script>	
						
					<?php } ?>
				</ul>
			</div>
        
		 <?php echo anchor( 'qa/trs/given_quiz/'.$post->id.'/'.$this->session->userdata['session_id'], '<i class="fa fa-thumbs-up"></i> View Given Quiz', 'class="btn btn-primary btn-sm "');?>
		 <?php echo anchor( 'qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "');?>
		  <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
      </div>
	  
	  
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
   <div class="slip">              
<div class="row">


<div class="col-md-12">

			        <div class="col-sm-12 text-center">
                                <span class="" style="text-align:center">
                                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="100" />
                                </span>
                                <h3>
                                    <span><?php echo strtoupper($this->school->school); ?></span>
                                </h3>
                                <small >
                                    <?php
                                    if (!empty($this->school->tel))
                                    {
                                            echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                    }
                                    else
                                    {
                                            echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                    }
                                    ?>
                                </small>
                                
								<br>
								<hr>
                                <h3 style=""><?php echo strtoupper($post->title)?></h3>
                                <h4 style=""><b>LEVEL:</b> <?php echo strtoupper($post->title)?></h4>
                                <h4 style=""><b>SUBJECT / LEARNING AREA:</b> <?php echo strtoupper($post->subject)?></h4>
								<?php if($post->topic){?>
									<h4 style=""><b>TOPIC / STRAND:</b> <?php echo strtoupper($post->topic)?></h4>
								<?php } ?>
								<hr>
                            </div>
							
				 <div class="col-sm-12">
					<h4>INSTRUSTIONS</h4>
					<p><?php echo $post->instruction?></p>
				</div>
				
			
	 </div> 
	 
	 </div>
	 
	 
	 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="timeline timeline-left">
                                    <article class="timeline-item alt">
                                        <div class="text-left">
                                            <div class="time-show first">
                                                <a href="#" class="btn btn-danger w-lg">QUESTIONS</a>
                                            </div>
                                        </div>
                                    </article>
									  <?php $i=0; if($questions){ ?>
									  
									    <?php foreach($questions as $p){ $i++; ?>
                                    <article class="timeline-item ">
                                        <div class="timeline-desk col-sm-12">
                                            <div class="panel">
                                                <div class="timeline-box">
                                                    <span class="arrow"><h4><?php echo $i?>) </h4></span>
                                                    <span class="timeline-icon"><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>
                                                    <h4> <span  class="text-black" style="font-size:24px !important;"> <?php echo $p->question;?></span> </h4>
                                                    <span class="timeline-date text-red"><small> Marks  ( <?php echo $p->marks?> )</small></span>
                                                    <p class="text-black"> Answer: <b class="text-green" ><?php echo $p->answer?></b> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
									  <?php  } ?>
                                    <?php }else{?>
										 No question has been added
									 <?php } ?>

                                </div>
                            </div>
                        </div>
                        <!-- end row -->


	 
	 
	 
	</div>
  </div>
 

<style>
    .amt{text-align: right;}
    .fless{width:100%; border:0;}
    .slip {margin: 12px;
           padding: 14px;
           border-radius: 5px;
           background: white;
           box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .actions{background-color: #fff; padding: 8px}
    .lower{margin-top: 6px;}
    .lethead
    {
        border: 0;width: 96%;
    }
    .topdets {
        width:100%;
        margin: 0 auto;
        border: 0;
    }
    .topdets th,  .topdets td ,.topdets 
    {
        border: 0;
    }

    .toppa img{
        width:150px;
        height:80px;
    }

    .toppa{
        text-align: center;
        color: #66B0EA;
        padding-top: 0;
    }
    .toppa span.stitle{font-size: 30.5px; font-family:  serif; font-weight: bold;}
    .redtop{color: #f00;
            font-size: 20px;
            text-decoration: underline;}
    .bltop{color: #0000ff; font-size: 20px;}
    .tocent{text-align: center;}
    .celll{margin: 0;}
    * { margin: 0; padding: 0; border: 0; }
    .slip{ background-color: #fff; }
    .strong{font-weight: bold;}
    .right{text-align: right;}
    .rightb{text-align: right; border-bottom: 3px double #000;}
    .center{text-align: center;}
    .green{color: green;}
    table td, table th {
        padding: 4px; font-size: 12px;
    }  .nob{border-right:0 !important;}

    @media print{
        .page-break{page-break-before: always; }
        .page-break:last-child {
            page-break-before: avoid;
        }
		img{
			width:80px !important;
			height:80px !important;
		}
        .slip{
            width:100%;
            padding: 0;
            margin: 0;
            border: initial;
        }
         .lethead img {width: 96%;}
        .lethead,    .lethead td.toppa ,    .lethead th
        {
            border: 0;
        }
        td.toppa 
        {
            border-right: none !important;
            border-bottom: none !important;
        }
        .toppa img{
            width:150px;
            height:80px;
        }
        body{background: #fff;font-family: OpenSans;}

        /**********/
        .ptable{ border: 1px solid #DDD;
                 border-collapse: collapse; }
        td, th {
            border: 1px solid #ccc;
        }
        th {
            background-color:  #ccc;
            text-align: center;
        }
        td.nob{  border:none !important; background-color:#fff !important;}
        /**********/
        .navigation{
            display:none;
        }
        .alert{
            display:none;
        }
        .alert-success{
            display:none;
        } 
        .img{
            align:center !important;
        } 
        .print{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; text-align:center }
        .view-title h3{border:none !important; }

        .split{
            float:left;
        }
        .right{
            float:right;
        }
        #scrollUp{display:none}
        .header{display:none}
        .center, .slip {
            width:100%;
            margin: 15px !important;
            padding: 0px !important;
        }

        .smf .content {
            margin-left: 0px;
        }
        .table{width: 92%; margin: 15px auto;}
    } .table{width: 92%; margin: 15px auto;}
    table.table-bordered th:last-child, table.table-bordered td:last-child {
        border-right-width: 1px;  
    }
</style> 
			
			
			
			
			
			
			