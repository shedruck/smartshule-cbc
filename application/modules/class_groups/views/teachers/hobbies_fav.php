<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Favourites and Hobbies</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <button data-bs-toggle="modal" data-bs-target="#hobies" class="btn btn-primary"><i class="mdi  mdi-plus"></i> Record Favourites and Hobbies</button>
                    <?php echo anchor('class_groups/trs/ViewHobbies/', '<i class="fa fa-search"></i> View Students Hobbies', 'class="btn btn-success"'); ?>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead class="bg-default">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Year</th>
                                <th>Languages Spoken</th>
                                <th>Hobbies</th>
                                <th>Favourite Subjects</th>
                                <th>Favourite Books</th>
                                <th>Favourite Food</th>
                                <th>Favourite Bible Verse</th>
                                <th>Favourite Cartoon</th>
                                <th>Favourite Career</th>
                                <th>Others</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            foreach ($hobbies as $hobby) { ?>
                                <tr>
                                    <td><?php echo $index; ?></td>
                                    <td><?php echo ucfirst($hobby->st->first_name . ' ' . $hobby->st->last_name) ?></td>
                                    <td><?php echo $hobby->year ?></td>
                                    <td><?php echo $hobby->languages_spoken ?></td>
                                    <td><?php echo $hobby->hobbies ?></td>
                                    <td><?php echo $hobby->favourite_subjects ?></td>
                                    <td><?php echo $hobby->favourite_books ?></td>
                                    <td><?php echo $hobby->favourite_food ?></td>
                                    <td><?php echo $hobby->favourite_bible_verse ?></td>
                                    <td><?php echo $hobby->favourite_cartoon ?></td>
                                    <td><?php echo $hobby->favourite_career ?></td>
                                    <td><?php echo $hobby->others ?></td>
                                </tr>
                            <?php $index++;
                            } ?>
                        </tbody>
                    </table>
                </div>
                <!-- </div> -->
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

<!-- Basic Modal -->
<div class="modal fade" id="hobies" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Record Student Hobbies and Favourites</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <?php echo form_open('class_groups/trs/recordStudentFavHobbies') ?>
                <!-- Form Fields Start Here -->
                <?php
                foreach ($mykids as $key => $value) : ?>
                    <input type="hidden" value="<?php echo $value->class; ?>" name="class">
                <?php endforeach ?>
                <div class='form-group'>
                    <label>Student <span class='required'>*</span></label>
                    <select name="student" class="form-control js-example-placeholder-exam" style="" tabindex="-1" required>
                        <option value="">Select Student</option>
                        <?php

                        foreach ($mykids as $key => $value) :
                        ?>
                            <option value="<?php echo $value->id; ?>"><?php echo ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('student'); ?>

                </div>

                <div class='form-group'>
                    <label>Year </label>
                    <input type="number" class="form-control" name="year" placeholder="Year eg <?php echo date('Y') ?>" required>
                </div>

                <div class='form-group'>
                    <label>Languages Spoken </label>
                    <textarea class="form-control" name="languages_spoken" placeholder="Languanges Spoken"></textarea>
                </div>

                <div class='form-group'>
                    <label>Hobbies </label>
                    <textarea class="form-control" name="hobbies" placeholder="Hobbies"></textarea>
                </div>

                <div class='form-group'>
                    <label>Favourite Subject </label>
                    <textarea class="form-control" name="favourite_subjects" placeholder="Favourite Subject"></textarea>
                </div>

                <div class='form-group'>
                    <label>Favourite Books </label>
                    <textarea class="form-control" name="favourite_books" placeholder="Favourite Books"></textarea>
                </div>

                <div class='form-group'>
                    <label>Favourite Food </label>
                    <textarea class="form-control" name="favourite_food" placeholder="Favourite Food"></textarea>
                </div>

                <div class='form-group'>
                    <label>Favourite Bible Verse </label>
                    <textarea class="form-control" name="favourite_bible_verse" placeholder="Favourite Bible Verse"></textarea>
                </div>

                <div class='form-group'>
                    <label>Favourite Cartoon </label>
                    <textarea class="form-control" name="favourite_cartoon" placeholder="Favourite Cartoon"></textarea>
                </div>

                <div class='form-group'>
                    <label>Favourite Career </label>
                    <textarea class="form-control" name="favourite_career" placeholder="Favourite Career"></textarea>
                </div>

                <div class='form-group'>
                    <label>Others </label>
                    <textarea class="form-control" name="others" placeholder="Others"></textarea>
                </div>

                <!-- Form Fields End Here -->
            </div>
            <div class="modal-footer">
                <button name="fav" type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>