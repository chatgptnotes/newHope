<!DOCTYPE html>
<html>
<head>
    <title>Hope Hospitals - Xrays</title>
    <link href="1/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="1/js-image-slider.js" type="text/javascript"></script>
    <link href="1/generic.css" rel="stylesheet" type="text/css" />
</head>
<body>
     <div id="sliderFrame" >
        <div id="slider">
            <?php
                    $directory = "../../../PacsOne/php/images/";
                    $images = glob($directory . "*.jpg");
                    foreach($images as $image) {
                        $url= $image;
            
            ?>
            <img class ="size" src="<?php echo $url?>" alt="Welcome to Hope Hospitals"/>
            <?php }?>
        </div>
        <div id="htmlcaption" style="display: none;">
            <em>HTML</em> caption. Link to <a href="http://www.google.com/">Google</a>.
        </div>
    </div>
</body>
</html>
<style>
	.size{
		width: 100% !important;
		height: 70% !important;
	}
	#sliderFrame{
		margin-top: 25px;
		position: relative;
    	width: 4300px;

	}
	#slider, #slider div.sliderInner {
    	height: 3520px;
    	width: 4280px;
	}
	#slider div.navBulletsWrapper {
  		display: none !important;
	}
</style>