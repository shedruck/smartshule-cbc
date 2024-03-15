<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Book Fund  </h2>
             <div class="right">  
             <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print The List</a>
                </div>
                </div>
         	                    
              
                 <?php if ($book_fund): ?>
                 <div class="block-fluid slip">
				 <h3 class="center"> Book Fund Stock</h3>
				<table class="" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Pages</th>
				<th>Category</th>
				<th>Author</th>
				
				<th>Quantity</th>
				
				<th>Given Out</th>
				<th>Remaining<br> Books</th>
				
			
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($book_fund as $p ): 
                 $i++;
				  $q_totals=$this->book_fund_m->total_quantity($p->id);
				 
				 $brwd=$this->book_fund_m->borrowed($p->id);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
					<td><?php echo $p->pages;?></td>
					<td><?php echo $category[$p->category];?></td>
					<td><?php echo $p->author;?></td>
					
					<td><?php 
					if(!empty($q_totals->t_quantity))echo $q_totals->t_quantity; else echo '0';
					?></td>
				
					<td style="color:red"><?php 
					if($brwd==0){echo 'None';}
					elseif($brwd==1){echo $brwd.' Book';}
					elseif($brwd>1){echo $brwd.' Books';}
					else{ //Nothing
					}
					?></td>
					<td><?php  
					$t=$q_totals->t_quantity-$brwd;
					if(!empty($q_totals->t_quantity)){
							if($t==0){echo 'None';}
					elseif($t==1){echo $t.' Book';}
					elseif($t>1){echo $t.' Books';}
					else{ //Nothing
					}
					 }
					 ?></td>
					

				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
</div>

<style>
    @media print{

         .buttons-hide{
              display:none !important;
         }
		  table tr{
			  border:1px solid #666 !important;
		  }
		  table th{
			  border:1px solid #666 !important;
			   padding:5px;
		  }
 table td{
			  border:1px solid #666 !important;
			  padding:5px;
		  }

		 .option{
              display:none !important;
         }
         .col-md-4 {
              width: 200px !important;
              float: left !important;
              margin:0px !important; 
         }

         .col-md-4 {
              width: 200px !important;
              float: left !important;
         }
         .right{
              float:right;

         }
         .bold{
              font-weight:bold;
              font-size:1.5em;
              color:#000;
         }
         .kes{
              color:#000;
              font-weight:bold;
         }
         .item{
              padding:3px;
         }
         .col-md-3 {
              width: 200px !important;
              float: left !important;
         }
         .col-md-6 {
              width: 300px !important;
              float: left !important;
         }
         .col-md-2 {
              width: 150px !important;
              float: left !important;
         }

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
         .header{display:none}
         .invoice { 
              width:100%;
              margin: auto !important;
              padding: 0px !important;
         }
         .invoice table{padding-left: 0; margin-left: 0; }

         .smf .content {
              margin-left: 0px;
         }
         .content {
              margin-left: 0px;
              padding: 0px;
         }
    }
</style>   

