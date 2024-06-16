<div class="row card-box table-responsive">

<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3>Favourites and Hobbies
             <div class="pull-right"> 

 <button data-toggle="modal"  data-target="#hobies" class="btn btn-primary"><i class="mdi  mdi-plus"></i> Record Favourites and Hobbies</button>			 
             <?php echo anchor( 'trs/ViewHobbies/', '<i class="fa fa-search"></i> View Students Hobbies', 'class="btn btn-success"');?>
			 
			
             
                </div>
			</h3>	
	<hr>			
   </div>
    
    <div class="col-md-12">
        <div class="card-box">
          
           
            <div class="table-responsive">
                <table class="table table table-hover m-0" id="mixt">
                    <thead>
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
                            $index=1;
                            foreach($hobbies as $hobby){?>
                            <tr>
                                <td><?php echo $index;?></td>
                                <td><?php echo ucfirst($hobby->st->first_name.' '.$hobby->st->last_name)?></td>
                                <td><?php echo $hobby->year?></td>
                                <td><?php echo $hobby->languages_spoken?></td>
                                <td><?php echo $hobby->hobbies?></td>
                                <td><?php echo $hobby->favourite_subjects?></td>
                                <td><?php echo $hobby->favourite_books?></td>
                                <td><?php echo $hobby->favourite_food?></td>
                                <td><?php echo $hobby->favourite_bible_verse?></td>
                                <td><?php echo $hobby->favourite_cartoon?></td>
                                <td><?php echo $hobby->favourite_career?></td>
                                <td><?php echo $hobby->others?></td>
                            </tr>
                        <?php $index++; }?>
                    </tbody>
                </table>
            </div> <!-- table-responsive -->
        </div> <!-- end card -->
    </div>
    <!-- end col -->
</div>


<div class="modal fade"  id="hobies" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Record Student Hobbies and Favourites </h4>
            </div>
          
            <div class="modal-body" id="here">
    
        <?php echo form_open('trs/recordStudentFavHobbies')?>
        <?php 
        foreach ($mykids as $key => $value) :?>
        <input type="hidden" value="<?php echo $value->class; ?>" name="class">
        <?php endforeach?>
            <div class='form-group'>
                <label>Student <span class='required'>*</span></label>
                <select name="student" class="form-control" style="" tabindex="-1" required>
                    <option value="">Select Student</option>
                    <?php

                    foreach ($mykids as $key => $value):
                            ?>
                            <option value="<?php echo $value->id;?>"><?php echo ucfirst($value->first_name).' '.ucfirst($value->last_name) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('student'); ?>

            </div>

        <div class='form-group'>
            <label>Year </label>
            <input type="number" class="form-control" name="year" placeholder="Year eg <?php echo date('Y')?>" required>
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

        <div class='form-group'>

            <button name="fav" class="btn btn-sm btn-primary" type="submit">Save</button>
            <button  class="btn btn-sm btn-danger" data-dismiss="modal" type="button">Cancel</button>
            
        </div>
 
        <?php echo form_close(); ?>
            
       
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>