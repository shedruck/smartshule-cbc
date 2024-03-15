<div class="maincontent">
	<div class="breadcrumbs">
    	<a href="<?php echo site_url('admin/')?>">Dashboard</a>
        <span>Email Templates</span>
    </div><!-- breadcrumbs -->
    <div class="left">
	<?php if (!empty($posts)): ?>
	<?php foreach ($posts as $post): ?>
		<div class="articles">
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
	<?php endforeach; ?>

	<?php echo $pagination['links']; ?>

	<?php else: ?>
		<p><?php echo 'No Current Email Templates(s)';?></p>
	<?php endif; ?>
	</div> <!-- end left -->
</div>  <!-- end main content -->