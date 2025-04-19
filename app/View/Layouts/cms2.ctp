<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hospital Management System</title>
<style>
.error {
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
.bgcms{
margin:0px; 
padding:0px;
background:url(../img/background-bg2.jpg) repeat-x !important;
font-family:Arial, Helvetica, sans-serif;
}
</style>
<!-- home banner img -->
<?php 

echo $this->Html->meta('icon');
echo $this->Html->css(array('validationEngine.jquery.css', 'style', 'home-slider'));
echo $this->Html->script(array('jquery-1.5.1.min','fullcalendar', 'slides.min.jquery.js?ver=1.1.9', 'jquery.custom', 'ibox',
					'login', 'jquery.isotope.min.js?ver=1.5.03',   'validationEngine.jquery','date','jquery.datePicker',
					'jquery.validationEngine','/js/languages/jquery.,validationEngine-en','jquery-ui-1.8.16.custom.min'));


?>
</head>
<body class="bgcms" style="background-color: #fff !important;">
	<?php 
	echo $this->Html->script('jquery.fancybox-1.3.4');
	echo $this->Html->css('jquery.fancybox-1.3.4.css');
	echo $this->Html->script(array('jquery.validationEngine','languages/jquery.validationEngine-en'));

	?>
	<div class="wrapper">
		<div class="header">
			<div class="logo">
				<a href="#"><?php echo $this->Html->image('logo.jpg'); ?> </a>
			</div>
			<!-- Login Starts Here -->
			<div id="loginContainer">
				<a href="#" id="loginButton"><span>Sign In</span><em></em> </a>
				<div style="clear: both"></div>
				<?php echo $this->Session->flash(); ?>
				<div id="loginBox">
					<!-- <form id="loginForm"> -->
					<?php echo $this->Form->create('User', array('id'=>'loginForm','action' => 'login')); ?>
					<div style="padding-left: 12px;">Access your SaaS Business System.</div>
					<fieldset id="body">
						<fieldset>
							<label for="email"><strong>Username</strong> </label>
							<?php  echo $this->Form->input('username',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));

							?>
						</fieldset>
						<fieldset>
							<label for="password"><strong>Password</strong> </label>
							<?php echo $this->Form->input('password',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false)); ?>
						</fieldset>
						<input type="submit" id="login" value="Sign In" />
						<div>
							<a href="#" id="forgot" title="Forgot Password">Forgot Password!</a>
						</div>
					</fieldset>
					<input type="hidden" name="client_time_zone" id="client_time_zone" />
					<?php echo $this->Form->end(); ?>

				</div>
			</div>
			<!-- Login Ends Here -->

		</div>
		<!-- .header end here -->

		<div class="clr"></div>
		<div class="body_container"
			style="min-height: 400px; margin: 0px; padding: 0px; background-color: #fff;">
			<?php echo $content_for_layout; ?>

		</div>
	</div>
	<div class="clr"></div>


	</div>
	<div class="footer_container">
		<div class="footer">
			<div class="footLeft" style="width: 515px;">
				<?php echo $this->Html->link($this->Html->image("cloud-computing-btn.png", array("alt" => "Cloud Computing", "title" => "Cloud Computing")),array('controller' => 'pages', 'action' => 'cloud_computing'),array('escape' => false)); ?>

				<?php echo $this->Html->link($this->Html->image("icon-story-so-far.png", array("alt" => "Story So Far", "title" => "Story So Far")),array('controller' => 'pages', 'action' => 'story_so_far'),array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image("electronic-patient-btn.png", array("alt" => "Electronic Patient Record", "title" => "Electronic Patient Record")),array('controller' => 'pages', 'action' => 'electronic_patient'),array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image("electronic-patient-btn.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'hms'),array('escape' => false)); ?>
				
				<?php echo $this->Html->link($this->Html->image("icon-faqs.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'clinical_data'),array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image("drmh-benefits-btn.png", array("alt" => "DRM Hope Benefits", "title" => "DRM Hope Benefits")),array('controller' => 'pages', 'action' => 'drm_benefits'),array('escape' => false)); ?>			
			</div>
			<div class="footRight">
				<div class="contact">
					<a href="home/contactus" rel="ibox" title="Contact Us"><?php echo $this->Html->image('contact-us.png'); ?>
					</a>
				</div>
				<ul class="social">
					<li><a href="http://www.twitter.com/DrMHope" target="_blank"> <?php echo $this->Html->image('twitter-btn.png'); ?>
					</a>
					</li>
					<li><a href="http://www.facebook.com/drmhopeCLOUD" target="_blank"> <?php echo $this->Html->image('facebook-btn.png'); ?>
					</a>
					</li>
					<li><a href="http://www.linkedin.com/company/drmhope" target="_blank"> <?php echo $this->Html->image('linkedin-btn.png'); ?>
					</a>
					</li>
					<li><a href="http://www.youtube.com/drmhopedemos" target="_blank"> <?php echo $this->Html->image('youtube-icon1.png'); ?>
					</a>
					</li>
					<li><a href="mailto:info@drmhope.com"> <?php echo $this->Html->image('email-btn.png'); ?>
					</a></li>
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
