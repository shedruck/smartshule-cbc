<div class="maincontent">
	<div class="breadcrumbs">
    	<a href="<?php echo site_url('admin/')?>">Dashboard</a>
        <span>[module_label]</span>
    </div><!-- breadcrumbs -->
    <div class="left">
		<div class="post">
														<p>
												Title : <?php echo $post->title; ?>
											</p>											<p>
												Slug : <?php echo $post->slug; ?>
											</p>											<p><strong>description <strong></p> 
											<div>
												<?php echo $post->description; ?>
											</div>											<p><strong>content <strong></p> 
											<div>
												<?php echo $post->content; ?>
											</div>
		</div>
	</div> <!-- end left -->
</div>  <!-- end main content -->