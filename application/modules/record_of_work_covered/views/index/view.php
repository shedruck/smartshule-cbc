<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header" id="pagecardheader">
				<h6 class="float-start">Record Of Work Covered</h6>
				<div class="btn-group btn-group-sm float-end">
					<button onClick="window.print();
                          return false" class="btn btn-primary " type="button"><span class="fa fa-print"></span> Print </button>

					<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<!-- View Start -->
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
				<!-- View End -->
			</div>
			<div class="card-footer">
				<div class="form-check d-inline-block">
					<!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
				</div>
				<div class="float-end d-inline-block btn-list">

				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.card-header {
		display: flex;
		justify-content: space-between;
	}
</style>