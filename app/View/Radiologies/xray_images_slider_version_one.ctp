
<?php echo $this->Html->script(array('js-image-slider-1.js'));?>
<?php echo $this->Html->css(array('js-image-slider-1.css'));?>
<style>
.rightTopBg {
    height: auto;
    padding: 0 0px !important;
    width: 72%;
}
</style>
<html>
<head>
 <style type="text/css">
        #slider div.navBulletsWrapper {left: 750px;}
        .ul1 b {font-family: "Courier New", Georgia;}
        .postWrap1 {background-color:#f6f6f6;} .postWrap2 {background-color:white;}
 </style>
</head>
<body style="margin: 0px;">
	<div id="sliderFrame">
		<div id="slider">
		<?php 
				$radImages = explode(',',$patientData['Patient']['radiology_images']);
				foreach ($radImages as $key=>$imgPath){
					$path = explode('./', $imgPath);
					$imgName = explode('/', $path[1]);				// image name
					$url = "ftp://hope:hope12345@192.168.1.228/".$path[1];			//actual Image Path which opens image
					echo $url;
					if((strpos($url, '.dcm')) === false ){
				?>
			<img alt="" src="<?php echo $url;?>" style="display: none;">
				
		<?php }?>
		<?php }?>
		</div>
		<!--Navigation buttons on both sides-->
        <div class="group1-Wrapper">
            <a onclick="imageSlider.previous()" class="group1-Prev"></a>
            <a onclick="imageSlider.next()" class="group1-Next"></a>
        </div>
        <!--nav bar-->
        <div style="position:relative; top:-42px;text-align:center;z-index:20;">
            <a onclick="imageSlider.previous()" class="group2-Prev"></a>
            <a id='auto' onclick="switchAutoAdvance()"></a>
            <a onclick="imageSlider.next()" class="group2-Next"></a>
        </div>
	</div>
	<div class="clear"></div>
</body>
</html>

<script>
function switchAutoAdvance() {
    imageSlider.switchAuto();
    switchPlayPauseClass();
}
function switchPlayPauseClass() {
    var auto = document.getElementById('auto');
    var isAutoPlay = imageSlider.getAuto();
    auto.className = isAutoPlay ? "group2-Pause" : "group2-Play";
    auto.title = isAutoPlay ? "Pause" : "Play";
}
switchPlayPauseClass();
</script>
