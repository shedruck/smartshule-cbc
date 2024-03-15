<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Inventory </h2> 
                     <div class="right">                            
               <a class="btn btn-primary" id="" href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-shopping-cart"></i>  Items</a>
				<a class="btn btn-primary" id="" href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-random" ></i>  Items Category</a>
				<a class="btn btn-primary" id="" href="<?php echo base_url('admin/add_stock'); ?>"><i class="glyphicon glyphicon-pencil"></i> Add Stock</a>
				<a class="btn btn-primary" id="" href="<?php echo base_url('admin/stock_taking/create'); ?>"><i class="glyphicon glyphicon-book"></i> Take Stock</a>
				<a href="<?php echo base_url('admin/inventory'); ?>" class="btn btn-success collapsed"><i class="glyphicon glyphicon-list-alt"></i> List All</a>
                     </div>    					
                </div>
         	        <?php if ($add_stock): ?>              
               <div class="block-fluid">
			     <?php  $total_cost = 0;

                            foreach ($add_stock as $p){
							$cost=$this->add_stock_m->total_cost($p->product_id);
								$total_cost +=$cost->totals; 
								}
								?>
			  	 <div class="middle">
			   <div class="informer">
                    <a href="#">
                        <span class="title"><?php echo $this->currency;?> <?php echo number_format($total_cost,2);?></span>
                        <span class="text">Total Assets Cost</span>
                    </a>
                </div>
                </div>
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

									<thead>
															  
										<th>#</th>
										<th>Date</th>
										<th>Item </th>
										<th>Total stock</th>
										<th>Issued Items</th>
										<th>Remaining</th>
										<th>Unaccounted</th>
										<th>Stock at Hand</th>
										<th>Total Cost</th>
										<th>Reorder Status</th>
										
										<th>Option</th>
								</thead>
                                <!-- END -->
                                <!-- BEGIN -->

                                <!-- END -->
                                <tbody >

                                    <?php
                                    $i = 0;
                                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                    {
                                        $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                    }

                                    foreach ($add_stock as $p):
                                        $i++;
                                      
										$quantity=$this->portal_m->total_quantity($p->product_id);
										$closing_stock=$this->portal_m->total_closing_stock($p->product_id);
										$cost=$this->portal_m->total_cost($p->product_id);
										$given_out=$this->portal_m->total_given($p->product_id);
										
										    $level = (int)$reorder_level[$p->product_id];
											$the_level = '';
									if(!empty($level)&& isset($level)){
									if($level>$closing_stock->quantity){
														$the_level = '<span class="label label-danger">Below Level</span>'; 
												    	}
										elseif($level==$closing_stock->quantity || $level == $quantity->quantity){
														
														$the_level = '<span class="label label-danger"> Reached level</span>';
													}					
								elseif($level>$quantity->quantity){
														$the_level = '<span class="label label-danger">Below Level</span>'; 
													}
								
										
											else{
												
											}
										} 
                                        ?>
                                  <tr class="gradeX">	
                                            <td ><?php echo $i . '.'; ?></td>
                                            <td ><?php echo date('d M, Y', $p->day); ?></td>
                                            <td ><?php echo $product[$p->product_id]; ?></td>
                                            <td ><?php echo $quantity->quantity; ?></td>
                                           
                                            <td ><?php echo $given_out->quantity; ?></td>
											 <td ><?php echo number_format($quantity->quantity - $given_out->quantity); ?></td>
                                            <td >
											<?php if(empty($closing_stock->quantity)) echo 0; else echo ($quantity->quantity-$closing_stock->quantity-$given_out->quantity); ?>
											</td>
                                            <td >
											<?php  
											if(!empty($closing_stock->quantity) && isset($closing_stock->quantity)){
												echo $closing_stock->quantity;
											}else{
												echo $quantity->quantity;
											}
												?>
											</td>
                                            <td><b><?php echo number_format($cost->totals,2); ?></b></td>
                                            <td><b><?php 
											//echo $the_level;
										?></b>
										</td>
                                           
                                            <td ><a class="delete" href="<?php echo base_url('admin/items/trend/'.$p->product_id); ?>">View Trend<div class="progress small progress-success">
                        <div class="bar tip" style="width: 70%;" data-original-title="50%"></div></a>
                    </div></td>
                                        </tr>
                                  <?php endforeach ?>		
                                </tbody>
                            </table>

                        </div>
                    <?php else: ?>
                        <h3>No Posts at the moment</h3>
<?php endif; ?>
                    <!-- END TABLE DATA -->
              




