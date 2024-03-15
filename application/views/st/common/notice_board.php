<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h4 class="m-b-10">  Notice Board    </h4>
                            </div>
                            <div class="col-md-8">
                                <div class="pull-right">
                                     <?php echo anchor( 'st/communication' , '<i class="fa fa-caret-left">
					</i> Exit', 'class="btn btn-danger"');?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

     <div class="block-fluid">
<p >&nbsp;</p>
<?php if($notice_board){?>
 <table id="dom-jqry" class="table table-striped table-bordered"> 
   <thead>
       <tr class="profile-th">
         <th>
            No
         </th>
		 <th>
            Title
         </th>
         <th>
             Posted By 
         </th>
         <th>
           Department
         </th>
         <th>
            Notice
         </th>
         <th>
            Date
         </th>
         <th>
            Action
         </th>
      </tr>
	 </thead> 
	 <tbody> 
	 
	 <?php $i = 0; foreach($notice_board as $p){ $i++; $u = $this->ion_auth->get_user($p->created_by);?> 
      <tr>
         <td >
            <p><?php echo $i?>.</p>
         </td>

		 <td >
            <p><?php echo $p->title?></p>
         </td>
         <td>
            <p><?php echo $u->first_name.' '.$u->last_name;?></p>
         </td>
         <td >
            <p><?php echo ucwords($p->department)?></p>
         </td>
         <td>
            <p><?php echo substr(strip_tags($p->description),0,50)?>...</p>
         </td>
         <td>
            <p><?php echo date('d M Y',$p->created_on)?></p>
         </td>
         <td class="text-center">
            <div class="btn-group">		 
				<a class="btn btn-success btn-sm" href='#'><i class='fa fa-share'></i> View </a>
			 </div>
         </td>
      </tr>
	<?php }?>  
</tbody>
</table>

<?php }else{?>
<h4>No records posted at the moment</h4>
<?php }?>

</div>
</div>
</div>
</div>
</div>