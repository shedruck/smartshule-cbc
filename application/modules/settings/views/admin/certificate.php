
	<style>
	    body {
		margin: 0;
		padding: 0;
	 }
 

 
 #background 
{ 
	 left: 0px; 
	 top: 0px; 
	 position: relative; 
	 margin-left: auto; 
	 margin-right: auto; 
	 width: 1130px;
	 height: 880px; 
	 overflow: hidden;
	 z-index:0;
	} 

 #Background 
{ 
	 left: 0px; 
	 top: 0px; 
	 position: absolute; 
	 width: 1130px;
	 height: 880px;
	 z-index:1;
} 

 #Background_0 
{ 
	 left: 0px; 
	 top: 0px; 
	 position: absolute; 
	 width: 1130px;
	 height: 880px;
	 z-index:2;
} 

 #Frame 
{ 
	 left: 30px; 
	 top: 72px; 
	 position: absolute; 
	 width: 1130px;
	 height: 830px;
	 z-index:3;
} 

 #Certificate 
{ 
	 left: 350px; 
	 top: 180px; 
	 position: absolute; 
	 
	 z-index:4;
} 

 #withhighhonorsto 
{ 
	 left: 220px; 
	 top: 300px; 
	 position: absolute; 
	 width: 607px;
	 height: 61px;
	 z-index:5;
	 font-size:25px;
	 text-align:center;
} 

 #LaraCroft 
{ 
	 left: 130px; 
	 top: 380px; 
	 position: absolute; 
	 width: 850px;
	 height: 258px;
	 z-index:6;
	 font-size:45px;
	 text-align:center;
	 font-family: 'Ranga', cursive;
font-family: 'Lobster', cursive;
	 
} 

 #Line 
{ 
	 left: 300px; 
	 top: 420px; 
	 position: absolute; 
	 width: 500px;
	 height: 7px;
	 z-index:7;
} 

 #Line img
{ 

	 width: 500px;
	 text-align:center;
	
} 

 #Loremipsumdolorsitam 
{ 
	 left: 100px; 
	 top: 450px; 
	 position: absolute; 
	 width: 850px;
	 height: 278px;
	 z-index:8;
	 font-size:26px;
	 text-align:center;
	 font-family: 'Ranga', cursive;
} 

 #Stamp 
{ 
	 left: 450px; 
	 top: 550px; 
	 position: absolute; 
	 width: 542px;
	 height: 515px;
	 z-index:9;
} 

 #date 
{ 
	 left: 730px; 
	 top: 670px; 
	 position: absolute; 
	 width: 250px;
	 height: 48px;
	 z-index:10;
	 font-size:25px;
	 font-family: 'Ranga', cursive;
} 

 #Line_0 
{ 
	 left: 650px; 
	 top: 650px; 
	 position: absolute; 
	 width: 604px;
	 height: 7px;
	 z-index:11;
} 

 #layer_10122017 
{ 
	 left:700px; 
	 top: 620px; 
	 position: absolute; 
	 width: 470px;
	 height: 78px;
	 font-size:25px;
	 z-index:12;
} 

 #signature 
{ 
	 left: 200px; 
	 top: 670px; 
	 position: absolute; 
	 width: 237px;
	 height: 55px;
	 z-index:13;
	 font-size:25px;
	 font-family: 'Ranga', cursive;
} 

 #Line_1 
{ 
	 left: 100px; 
	 top: 650px; 
	 position: absolute; 
	 width: 604px;
	 height: 7px;
	 z-index:14;
} 

 #Signature_0 
{ 
	 left: 150px; 
	 top: 550px; 
	 position: absolute; 
	 width: 526px;
	 height: 203px;
	 z-index:15;
} 

	</style>
	
	
	<div class="col-md-12">
<div class=" right">
    <a class="print" href="" onclick="window.print();
        return false"><button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print  </button></a>

		
</div>
</div>



<div class="col-md-12">
  <div class="widget">
  
  
		<div id="background">
			<div id="Background"><?php echo theme_image('cert/Background.png')?></div>
			<div id="Background_0"><?php echo theme_image('cert/Background_0.png')?></div>
			<div id="Frame"><?php echo theme_image('cert/Frame.png')?></div>
			<div id="Certificate"><?php echo theme_image('cert/Certificate.png')?></div>
			<div id="withhighhonorsto">with high honors to</div>
			<div id="LaraCroft"><?php echo $p->school;?></div>
			<div id="Line"><?php echo theme_image('cert/Line.png')?></div>
			<div id="Loremipsumdolorsitam">
			   A quick and simplified answer is that Lorem Ipsum refers to text that the DTP (Desktop Publishing) industry use as replacement text when the real text is not available. Lorem Ipsum is dummy text which has no meaning however looks very similar to real text.
			</div>
			<div id="Stamp"><?php echo theme_image('cert/Stamp.png')?></div>
			<div id="date">Date Issued</div>
			<div id="Line_0"><?php echo theme_image('cert/Line_0.png')?></div>
			<div id="layer_10122017"><?php echo date('d F Y',$p->modified_on);?></div>
			<div id="signature">Signature</div>
			
			<div id="Line_1"><?php echo theme_image('cert/Line_1.png')?></div>
			<div id="Signature_0"><?php echo theme_image('cert/evo-signature.png',array("height"=>"150","width"=>"200"))?></div>
		</div>
   
</div>
</div>

