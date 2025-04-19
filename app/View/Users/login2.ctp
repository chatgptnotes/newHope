<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hospital Management System</title>
<style>
	 .error{
		 background: none repeat scroll 0 0 #D7C487;
	    border: 1px solid #E8D495;
	    color: #8C0000;
	    display: block;
	    font-size: 13px;
	    font-weight: bold;
	    margin: 5px 0;
	    padding: 7px 5px;
	    text-align: center;
	    text-shadow: 1px 1px 1px #ECDCA8;
	    }
	    
	    
</style>
<!-- home banner img -->
<link href="css/home-slider.css" rel="stylesheet" type="text/css" />  
<link href="css/style.css" rel="stylesheet" type="text/css" /> 
<?php 

echo $this->Html->meta('icon');    
echo $this->Html->css(array('validationEngine.jquery.css')); ?>
</head>  
<body>
	<script type='text/javascript' src='js/jquery.min.js?ver=3.3'></script>
	<script type='text/javascript' src='js/jquery-ui-1.8.5.custom.min.js?ver=3.3'></script>
	<script type='text/javascript' src='js/slides.min.jquery.js?ver=1.1.9'></script>
	<script type='text/javascript' src='js/jquery.isotope.min.js?ver=1.5.03'></script>
	<script type='text/javascript' src='js/jquery.custom.js?ver=1.0'></script>
	<!-- sign in -->
	<script type='text/javascript' src='js/login.js'></script>
	
	<!-- Pop up -->
	<script type="text/javascript" src="js/ibox.js"></script>
	<?php 
		echo $this->Html->script('jquery.fancybox-1.3.4');
 		echo $this->Html->css('jquery.fancybox-1.3.4.css');
		echo $this->Html->script(array('jquery.validationEngine','languages/jquery.validationEngine-en'));
		 
	?>
	<div class="wrapper"> 
    <div class="header">
    	<div class="logo">
    	<?php echo $this->Html->link($this->Html->image("logo.jpg", array("alt" => "DRM Hope", "title" => "DRM Hope")),array('controller' => 'users', 'action' => 'login'),array('escape' => false)); ?>    	</div>
    	<div style="float:left; padding-top:15px;margin-left:40px;">
    	<div class="footLeft" style="width: 515px;">
	<?php echo $this->Html->link($this->Html->image("cloud-computing-btn.png", array("alt" => "Cloud Computing", "title" => "Cloud Computing")),array('controller' => 'pages', 'action' => 'cloud_computing'),array('escape' => false)); ?>

	<?php echo $this->Html->link($this->Html->image("icon-story-so-far.png", array("alt" => "Story So Far", "title" => "Story So Far")),array('controller' => 'pages', 'action' => 'story_so_far'),array('escape' => false)); ?>
	<?php echo $this->Html->link($this->Html->image("electronic-patient-btn.png", array("alt" => "Electronic Patient Record", "title" => "Electronic Patient Record")),array('controller' => 'pages', 'action' => 'electronic_patient'),array('escape' => false)); ?>
	<?php echo $this->Html->link($this->Html->image("hosp-mgmt-sys-btn.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'hms'),array('escape' => false)); ?>
	
	<?php echo $this->Html->link($this->Html->image("icon-faqs.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'clinical_data'),array('escape' => false)); ?>
	<?php echo $this->Html->link($this->Html->image("drmh-benefits-btn.png", array("alt" => "DRM Hope Benefits", "title" => "DRM Hope Benefits")),array('controller' => 'pages', 'action' => 'drm_benefits'),array('escape' => false)); ?>			
</div>
    	
    	</div>
        <!-- Login Starts Here -->
        <div id="loginContainer">
            <a href="#" id="loginButton"><span>Sign In</span><em></em></a>            
            <div style="clear:both"></div>
            <?php echo $this->Session->flash(); ?>
            <div id="loginBox">                
            	<!-- <form id="loginForm"> -->
            	<?php echo $this->Form->create('User', array('id'=>'loginForm','action' => 'login2')); ?>
                	<div style="padding-left:12px;">Access your SaaS Business System.</div>
                    <fieldset id="body">
                        <fieldset>
                            <label for="email"><strong>Username</strong></label>
                            <?php  echo $this->Form->input('username',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));
                           
                            ?>
                        </fieldset>
                        <fieldset>
                            <label for="password"><strong>Password</strong></label>
                            <?php echo $this->Form->input('password',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false)); ?>
                        </fieldset>
                        <input type="submit" id="login" value="Sign In" />
                        <div><a href="#" id="forgot" title="Forgot Password" >Forgot Password!</a></div>
                    </fieldset>
                    <input type="hidden" name="client_time_zone" id="client_time_zone" />
                    <?php echo $this->Form->end(); ?> 
                 
            </div>
        </div>
        <!-- Login Ends Here -->
        
    </div><!-- .header end here -->
    
    <div class="clr"></div>
    <div class="banner">
    
        <div class="homeBannerText">
            <img src="img/cloud-animation.gif" alt="" />
        </div><!-- .homeBannerText end here -->
        
        <div class="page-template-template-home-php">
            <!--BEGIN #slider-->
            <div id="home-slider" data-speed="4000" data-loader="img/ajax-loader.gif" class="slider">			
                <!--BEGIN .slides_container-->
                <div class="slides_container">
                    <div class="slide">
                        <img src="img/hope_banner1.jpg" alt="" />
                    </div>				
                    <div class="slide">
                        <img src="img/hope_banner2.jpg" alt="" />
                    </div>
                </div><!--END .slides_container-->
            </div><!--END #slider-->
        </div><!-- .page-template-template-home-php end here -->
    	<div class="clr"></div>
    	<div class="iconScroll">
    	  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="550" height="74">
            <param name="movie" value="img/scroll.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <embed src="img/scroll.swf" quality="high" wmode="transparent" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="550" height="74"></embed>
  	    </object></div>
    
    </div><!-- .banner end here -->
    <div class="clr"></div>
    <div class="body_container">
    	<div class="homeBanner">
        	<div class="homeBannerLeft"><a href="home/winnerbestsolutions" rel="ibox" title="Multiple Award Winner in Heathcare Innovation" >Multiple Award Winner in Heathcare Innovation</a></div>
            <!-- <div class="homeBannerRight"><a href="home/websolutions" rel="ibox" title="Web Solutions with an Innovative Touch" >Web Solutions with an Innovative Touch</a></div> -->
			<div class="homeBannerRight" style="padding:0px; text-align:left; float:left;padding-left:2px;">
					<a href="home/websolutions" rel="ibox"
						title="Web Solutions with an Innovative Touch" >
						<img src="img/iigp-top50.gif" />
						</a>
				</div>
            <div class="clr"></div>
            </div>
        </div>
    	<!--<div class="homeLeftBanner"><a href="winner-best-innovation.html" rel="ibox" title="Multiple Award Winner in Heathcare Innovation" ><img src="img/home-mid-banner1.gif" alt="Multiple Award Winner in Heathcare Innovation" /></a><a href="web-solutions.html" rel="ibox" title="Web solutions with an innovative touch" ><img src="img/home-mid-banner2.gif" alt="Web solutions with an innovative touch" /></a></div>-->
    </div>
    <div class="clr"></div>


</div>
<div class="footer_container">
<div class="footer">
<div class="footLeft" style="width: 515px; display:none;">
	<?php echo $this->Html->link($this->Html->image("cloud-computing-btn.png", array("alt" => "Cloud Computing", "title" => "Cloud Computing")),array('controller' => 'pages', 'action' => 'cloud_computing'),array('escape' => false)); ?>

	<?php echo $this->Html->link($this->Html->image("icon-story-so-far.png", array("alt" => "Story So Far", "title" => "Story So Far")),array('controller' => 'pages', 'action' => 'story_so_far'),array('escape' => false)); ?>
	<?php echo $this->Html->link($this->Html->image("electronic-patient-btn.png", array("alt" => "Electronic Patient Record", "title" => "Electronic Patient Record")),array('controller' => 'pages', 'action' => 'electronic_patient'),array('escape' => false)); ?>
	<?php echo $this->Html->link($this->Html->image("hosp-mgmt-sys-btn.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'hms'),array('escape' => false)); ?>
	
	<?php echo $this->Html->link($this->Html->image("icon-faqs.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'clinical_data'),array('escape' => false)); ?>
	<?php echo $this->Html->link($this->Html->image("drmh-benefits-btn.png", array("alt" => "DRM Hope Benefits", "title" => "DRM Hope Benefits")),array('controller' => 'pages', 'action' => 'drm_benefits'),array('escape' => false)); ?>			
</div>

    <div class="footRight">
	
		<div class="contact">
		<a href="http://drmhope.com/downloads/brochure-drmhope.pdf" alt="Download Brochure"   title="Download Brochure" target="_blank">
							<?php echo $this->Html->image('btn-download.png'); ?>
					</a>
		<a href="home/contactus" rel="ibox" title="Contact Us" ><img src="img/contact-us.png" alt="Contact Us" /></a></div>
    	<ul class="social">
        	<li><a href="http://www.twitter.com/DrMHope" target="_blank"><img src="img/twitter-btn.png" alt="Twitter" /></a></li>
          	<li><a href="http://www.facebook.com/drmhopeCLOUD"  target="_blank"><img src="img/facebook-btn.png" alt="Facebook" /></a></li>
            <li><a href="http://www.linkedin.com/company/drmhope" target="_blank"><img src="img/linkedin-btn.png" alt="Linkdin" /></a></li>
            <li><a href="http://www.youtube.com/drmhopedemos" target="_blank"> <?php echo $this->Html->image('youtube-icon1.png'); ?>
					</a>
					</li>
			<li>
					<?php echo $this->Html->link($this->Html->image("help-btn.png", array("alt" => "DRM Hope Help", "title" => "DRM Hope Help")),array('controller' => 'pages', 'action' => 'manual'),array('escape' => false)); ?>
					</li>	
            <!-- <li><a href="#"><img src="img/orkut-btn.png" alt="Orkut" /></a></li>
            <li><a href="#"><img src="img/rss-btn.png" alt="RSS" /></a></li>  -->
            <li><a href="mailto:info@drmhope.com"><img src="img/email-btn.png" alt="Mail" /></a></li>
        </ul>
    </div>
    <div class="clr"></div>
</div>
</div>
<script>
jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#loginForm").validationEngine();	

			$('#forgot').click(function(){
				$.fancybox(
					    { 
				            'width'    : '60%',
						    'height'   : '60%',
						    'autoScale': true,
						    'transitionIn': 'fade',
						    'transitionOut': 'fade',
						    'type': 'iframe',
						    'href': '<?php echo $this->Html->url(array("controller" => "home", "action" => "password_recovery")); ?>',
						    
				});
			});
			
		});
		
// for timezone of the user
function calculate_time_zone() {
	var rightNow = new Date();
	var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
	var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
	var temp = jan1.toGMTString();
	var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	temp = june1.toGMTString();
	var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
	var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
	var dst;
	if (std_time_offset == daylight_time_offset) {
		dst = "0"; // daylight savings time is NOT observed
	} else {
		// positive is southern, negative is northern hemisphere
		var hemisphere = std_time_offset - daylight_time_offset;
		if (hemisphere >= 0)
			std_time_offset = daylight_time_offset;
		dst = "1"; // daylight savings time is observed
	}
	var i;
	$("#client_time_zone").val(convert(std_time_offset));
	// check just to avoid error messages
	
}

function convert(value) {
	var hours = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var mins = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var secs = parseInt(value);
	var display_hours = hours;
	// handle GMT case (00:00)
	if (hours == 0) {
		display_hours = "00";
	} else if (hours > 0) {
		// add a plus sign and perhaps an extra 0
		display_hours = (hours < 10) ? "+0"+hours : "+"+hours;
	} else {
		// add an extra 0 if needed 
		display_hours = (hours > -10) ? "-0"+Math.abs(hours) : hours;
	}
	
	mins = (mins < 10) ? "0"+mins : mins;
	return display_hours+":"+mins;
}

onload = calculate_time_zone;
</script>
<?php echo $this->element('sql_dump'); ?>

</body>
</html>