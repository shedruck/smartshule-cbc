<!DOCTYPE html>
<html lang="en">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!--[if gt IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->        
        <title><?php echo $template['title']; ?></title>
        <?php echo theme_css('stylesheets.css'); ?>  

<link href="https://fonts.googleapis.com/css?family=Ranga" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lobster|Ranga" rel="stylesheet">		
        <!--[if lt IE 10]>
            <link href="css/ie.css" rel="stylesheet" type="text/css" />
        <![endif]-->        
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" /> 
       
		
		<style>

#myVideo {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%; 
    min-height: 100%;
	 background: rgba(0,0,0,0.8) !important;
}



#myBtn {
    width: 200px;
    font-size: 18px;
    padding: 10px;
    border: none;
    background: #000;
    color: #fff;
    cursor: pointer;
}

#myBtn:hover {
    background: #ddd;
    color: black;
}
</style>

    </head>
    <body class="<?php //echo $this->school->theme_color . ' ' . $this->school->background; ?>" id="video-content">
        
		
	
       
		
			
		
<div class="col-md-12">
<!--<span id="myBtn" onclick="myFunction()">Pause</span> -->
      <div class="col-md-8"> 
				<div class="content">

				</div>
		</div>
		
		<div class="col-md-4"> 
		
		 <?php echo $template['body']; ?>
		 
        </div>
		
		
</div>

 
		<script>
		
		
			var video = document.getElementById("myVideo");
			var btn = document.getElementById("myBtn");

			function myFunction() {
			  if (video.paused) {
				video.play();
				btn.innerHTML = "Pause";
			  } else {
				video.pause();
				btn.innerHTML = "Play";
			  }
			}
			
			
		</script>

    </body>
</html>
