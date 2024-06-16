<div class="portlet mt-2">
	<div class="portlet-heading portlet-default border-bottom hidden-print">
		<h3 class="portlet-title text-dark">
			<b> Record Of Work Covered </b>
		</h3>
		<div class="pull-right">

			<button onClick="window.print();
                          return false" class="btn btn-primary " type="button"><span class="fa fa-print"></span> Print </button>

			<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		</div>
		<div class="clearfix"></div>
		<hr>
	</div>



	<div class="block-fluid">

		<div class="row">
			<div class="col-xm-12">
				<div class="col-xm-4"></div>
				<div class="col-xm-4">
					<center>
						<img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
						<h4><?php echo $this->school->school ?></h4>
						<h3>RECORD OF WORK</h3>
					</center>
				</div>
				<div class="col-xm-3"></div>
			</div>
		</div>
	 
		<div class="row">
			<table class="table table-bordered">
				<tr>
					<th>
						LEARNING AREA/SUBJECT
					</th>
					<td><?php
						echo isset($subjects[$post->schemes->subject]) ? $subjects[$post->schemes->subject] : ''; ?>
					</td>
				</tr>

				<tr>
					<th>
						NAME TEACHER
					</th>
					<td><?php
						$tr =  isset($teacher[$post->created_by]) ? strtoupper($teacher[$post->created_by]) : ''; 
						echo $tr;
						?>
					</td>
				</tr>

				<tr>
					<th>
						LEVEL
					</th>
					<td><?php
						echo isset($this->classes[$post->schemes->level]) ? strtoupper($this->classes[$post->schemes->level]) : ''; ?>
					</td>
				</tr>
			</table>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DATE</th>
						<th>LESSON</th>
						<th>WORK DONE</th>
						<th>REFLECTION</th>
						<th>SIGN</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($result as $p) {
					?>
						<tr>
							<td><?php echo date('dS M Y', $p->date) ?></td>
							<td><?php echo $p->schemes->lesson ?></td>
							<td><?php echo $p->work_covered ?></td>
							<td><?php echo $p->reflection ?></td>
							<td>_____________</td>
						</tr>

					<?php    } ?>
				</tbody>
			</table>
		</div>






	</div>
</div>



<style>
	.phead {
		opacity: 0%;
	}
	 .dropdown
	{
		opacity: 0%;
	}
</style>