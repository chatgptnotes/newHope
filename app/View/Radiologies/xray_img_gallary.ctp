<?php echo $this->Html->script(array('ninja-slider.js','thumbnail-slider.js'));?>
<?php echo $this->Html->css(array('thumbs.css','ninja-slider.css','thumbnail-slider.css'));?>

<style type="text/css">
.active {
	z-index: 99;
}
body {
	font: normal 0.9em Arial;
	margin: 0;
}
a {
	color: #1155CC;
}
a.group2-Play {
    background-position: 0 -20px;
}
.new_slider{
	transition-property: transform; 
	transition-timing-function: cubic-bezier(0.2, 0.88, 0.5, 1); 
	transition-duration: 0ms; 
	transform: translateX(-4.5px);
}
div#ninja-slider {padding:90px 0 60px;}
a.group2-Play {
    background-position: 0 -20px;
}

a.group2-Pause {
    background-position: 0 0;
}

a.group2-Pause {
    background-position: 0 0;
}
</style>

<html>
<head>
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<div id="ninja-slider">
		<div class="slider-inner">
			<ul style="overflow: hidden; padding-top: 50%; height: 0px;">
				<?php 
				$radImages = explode(',',$patientData['Patient']['radiology_images']);
				foreach ($radImages as $key=>$imgPath){
					$path = explode('./', $imgPath);
					$imgName = explode('/', $path[1]);				// image name
					$url = "ftp://hope:hope12345@192.168.1.228/".$path[1];			//actual Image Path which opens image
					if((strpos($url, '.dcm')) === false ){
				?>
				<li><a class="ns-img" href="<?php echo $url;?>"></a>
				</li>
				<?php }?>
				<?php }?>
				
			</ul>
			<div id="ninja-slider-pager">
				<?php 
				$radImages = explode(',',$patientData['Patient']['radiology_images']);
				foreach ($radImages as $key=>$imgPath){
				$path = explode('./', $imgPath);
				$imgName = explode('/', $path[1]);				// image name
				$url = "ftp://hope:hope12345@192.168.1.228/".$path[1];			//actual Image Path which opens image
				if((strpos($url, '.dcm')) === false ){
		?>
				<a class="" rel="<?php echo $url; ?>"><?php echo $key;?> </a>
				<?php }?>
				<?php }?>
			</div>
			<div id="ninja-slider-prev"></div>
			<div id="ninja-slider-next"></div>
			
		</div>
		<div class="thumb">
					<?php
					$radImages = explode(',',$patientData['Patient']['radiology_images']);
					foreach ($radImages as $key=>$imgPath){
						$path = explode('./', $imgPath);
						$imgName = explode('/', $path[1]);				// image name
						$url = "ftp://hope:hope12345@192.168.1.228/".$path[1];			//actual Image Path which opens image
						if((strpos($url, '.dcm')) === false ){
	   				?>
	   				<!--  <span onclick="nslider.displaySlide('<?php echo $key; ?>')"><?php echo $this->Html->image($url,array('width'=>'50','height'=>'50'));?></span>-->
					<?php }?>
					<?php }?>
				
			
		</div>
	
		<div class="slider-inner">
			<div id="thumbnail-slider">
				<div class="inner">
				<ul class = "new_slider">
					<?php
					$radImages = explode(',',$patientData['Patient']['radiology_images']);
					foreach ($radImages as $key=>$imgPath){
						$path = explode('./', $imgPath);
						$imgName = explode('/', $path[1]);				// image name
						$url = "ftp://hope:hope12345@192.168.1.228/".$path[1];			//actual Image Path which opens image
						if((strpos($url, '.dcm')) === false ){
				   			?>
					<li class="" style="display: inline-block; height: 50px; width: 100px; z-index: 0;">
						<a class="thumb pause" id="pauseOnClick_<?php echo $key;?>" href="<?php echo $url;?>" style="background-image: url('<?php echo $url;?>');" ></a>
					</li>
					<?php }?>
				<?php }?>
				</ul>
				</div>
			</div>
		</div>
	</div>
	<div style="width: 700px; margin: 90px auto;" ></div>

</body>
</html>
</body>
</html>

<script>


</script>

