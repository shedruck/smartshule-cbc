<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);

$range = range(date('Y') - 1, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Schemes of Work</h6>
				<div class="btn-group btn-group-sm float-end" role="group">
					<button onClick="window.print();
                          return false" class="btn btn-primary " type="button"><span class="fa fa-print"></span> Print Receipt </button>
					<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<div class="row justify-content-center">
					<div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
						<div class="card">
							<div class="card-header bg-default">
								<h6 class="text-center">Schemes of Work Details</h6>
							</div>
							<div class="card-body">

								<div class='row'>
									<div class="col-md-4 bg-default m-0 font-weight-20" for='day'>Year </div>
									<div class="col-md-8">
										<?php

										echo $result->year;

										?>

									</div>
									
								</div>
								<hr>



								<div class='row'>
									<div class="col-md-4 bg-default" for='day'>Term </div>
									<div class="col-md-8">
										<?php
										echo $result->term
										?>

									</div>
									
								</div>
								<hr>


								<div class='row'>
									<div class="col-md-4  bg-default" for='class'>Class/Level </div>
									<div class="col-md-8">
										<?php
										$classes = $this->portal_m->get_class_options();
										echo $classes[$result->level];
										?>

									</div>
									
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='week'>Week </div>
									<div class="col-md-8">
										<?php echo $result->week  ?>

									</div>
									
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='subject'>Subject/Learning Area </div>
									<div class="col-md-8">
										<?php
										$sub = $this->portal_m->get_subject($result->level);
										echo strtoupper($sub[$result->subject]);

										?>
									</div>
									
								</div>
								<hr>


								<div class='row'>
									<div class="col-md-4 bg-default" for='strand'>Strand </div>
									<div class="col-md-8">
										<?php echo $result->strand; ?>

									</div>
									
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='substrand'>Sub-strand </div>
									<div class="col-md-8">
										<?php echo $result->substrand; ?>

									</div>
									
								</div>
								<hr>


								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Lesson</div>
									<div class="col-md-8">
										<?php echo isset($result->lesson) ? htmlspecialchars_decode($result->lesson) : ''; ?>


									</div>
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Specific Learning Outcomes</div>
									<div class="col-md-8">
										<?php echo isset($result->specific_learning_outcomes) ? htmlspecialchars_decode($result->specific_learning_outcomes) : ''; ?>

									</div>
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Key Inquiry Question</div>
									<div class="col-md-8">
										<?php echo isset($result->key_inquiry_question) ? htmlspecialchars_decode($result->key_inquiry_question) : ''; ?>

									</div>
								</div>

								<hr>
								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Learning Experiences</div>
									<div class="col-md-8">
										<?php echo isset($result->learning_experiences) ? htmlspecialchars_decode($result->learning_experiences) : ''; ?>


									</div>
								</div>
								<hr>
								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Learning Resources</div>
									<div class="col-md-8">
										<?php echo isset($result->learning_resources) ? htmlspecialchars_decode($result->learning_resources) : ''; ?>

									</div>
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Assessment</div>
									<div class="col-md-8">
										<?php echo isset($result->assessment) ? htmlspecialchars_decode($result->assessment) : ''; ?>

									</div>
								</div>
								<hr>

								<div class='row'>
									<div class="col-md-4 bg-default" for='topic'>Reflection</div>
									<div class="col-md-8">
										<?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?>

									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
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
<?php echo form_close(); ?>
<style>
	.card-header {
		display: flex;
		justify-content: space-between;
	}
</style>