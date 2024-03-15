<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Book List  </h2>

             <div class="right">  
             <?php echo anchor( 'admin/book_list/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Book List')), 'class="btn btn-primary"');?>
			 
			 
            <button class="btn btn-primary" onClick="window.location='<?php echo base_url()?>admin/book_list'"><i class="glyphicon glyphicon-list"></i>Grid View</button>
            <button class="btn btn-primary" onClick="window.location='<?php echo base_url()?>admin/book_list/listView'">List View</button>
             
                </div>
                </div>
         	                    
              
                <?php if ($books): ?>
                <div class="block-fluid">
                    <?php foreach($books as $book){?>
                        <div class="card col-md-3" >
                            <?php if(!$book->thumbnail){?>
                                <img src='<?php echo base_url()?>uploads/book_list/<?php echo date('Y')?>/noimage.png'
                              class="img-fluid card-img-top" style="width:100%; height:150px" alt=''>
                                <?php }else{?>
                            <img src='<?php echo base_url()?>uploads/book_list/<?php echo date('Y')?>/<?php echo $book->thumbnail?>'
                              class="img-fluid card-img-top" style="width:150px; height:150px" alt=''>
                              <?php }?>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <strong><small>Book Name </small>
                                        <?php echo ucfirst($book->publisher)?> 
                                        <?php echo ucfirst($book->book_name)?> 
                                        <?php echo ucfirst($book->class_name)?> 
                                    </strong>
                                </h5>
                                <h5 class="card-title"><strong><small>Subject </small><?php echo ucfirst($book->book_name)?></strong></h5>
                                <h5 class="card-title"><strong><small>Cost </small>Ksh <?php echo number_format($book->price,2)?></strong></h5>
                                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            </div>
                        </div>
                    <?php }?>


                </div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>

 <style>
	 .image{
		 width:9%
	 }
 </style>