<div class="block-fluid">

    <div id="pctb">
        <div class="pc-table featured col-sm-3 col-xs-12">
            <h3>School Setup Complete!  </h3>

            You have Successfully setup your School. Below is Your Setup Summary.

            <ul>
                <li> <span class="capt orange"><?php echo $teachers; ?></span><?php echo $teachers < 2 ? ' Teacher ' : ' Teachers'; ?>    </li>
                <li>  <span class="capt purple "><?php echo $classes; ?></span><?php echo $classes < 2 ? ' Class ' : ' Classes'; ?>  </li>
                <li> <span class="capt orange"><?php echo $subjects; ?></span><?php echo $subjects < 2 ? ' Subject ' : ' Subjects'; ?>   </li>
                <li> <span class="capt green"><?php echo $houses; ?></span><?php echo $houses < 2 ? ' House ' : ' Houses'; ?> </li> 
                <li>  &nbsp; </li>
            </ul>

            <div class="pagination pagination-centered pagination-large">
                <?php echo anchor('admin/setup/houses', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Previous', 'class="btn btn-warning  btn-large"'); ?> 
                <?php echo anchor('admin/', '<i class="glyphicon glyphicon-monitor"></i> Dashboard', 'title="6"  id="nexti" class="btn btn btn-primary  btn-large"'); ?>
            </div>
        </div>
    </div>
</div>