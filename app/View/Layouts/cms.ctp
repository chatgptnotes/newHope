<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php  if($this->params->pass[0]=='ehr-software'){ //for this only   ?>
<title>Electronic Health Records EHR | PCMH and Meaningful Use of EHR</title> 
		<meta name="description" content="DRMHOPE is completely certified which implements PCMH and meaningful use of Electronic Health Records EHR to help doctors in benefiting all patient groups."/>
		<meta name="keywords" content="Meaningful Use certified ehr, Top Electronic Health Records EHR, PCMH ready EHR"/>
		<meta name="owner" content="info@drmhope.com" />
		<meta name="copyright" content="drmhope" />
		<meta name="author" content="yogesh@cityweb.in" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="English" />
		<meta name="rating" content="General" />
		<meta name="robots" content="index,follow" />
		<meta name="revisit-after" content="7 days" />  
<?php  	} else{ ?>
<title>Hospital Management System</title>
<?php }?>
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
.footer .footLeft {width: 569px!important;}
.footer .footRight{ float:left !important;}
</style>
<!-- home banner img -->
<?php 

echo $this->Html->meta('icon');
echo $this->Html->css(array('validationEngine.jquery.css', 'style', 'home-slider'));
echo $this->Html->script(array('jquery-1.5.1.min','fullcalendar', 'slides.min.jquery.js?ver=1.1.9', 'jquery.custom', 'ibox',
					'login', 'jquery.isotope.min.js?ver=1.5.03',   'validationEngine.jquery','date','jquery.datePicker',
					'jquery.validationEngine','/js/languages/jquery.,validationEngine-en','jquery-ui-1.8.16.custom.min'));


?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55133303-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body class="bgcms" style="background-color: #fff !important;">
	<?php 
	echo $this->Html->script('jquery.fancybox-1.3.4');
	echo $this->Html->css('jquery.fancybox-1.3.4.css');
	echo $this->Html->css('skeleton.css');
	echo $this->Html->script(array('jquery.validationEngine','languages/jquery.validationEngine-en'));

	?>
	<div class="wrapper">
		<div class="header">
    	<div class="logo">
    	<?php echo $this->Html->link($this->Html->image("logo.jpg", array("alt" => "DRM Hope", "title" => "DRM Hope")),array('controller' => 'users', 'action' => 'login'),array('escape' => false)); ?>    	</div>
    	<div style="float:left; padding-top:15px;margin-left:25px;">
		
    	<div class="footLeft" style="width: 700px;">
	
		
		
<ul id="nav">
	<li><!-- <a href="/pages/about_us">About Us</a>  -->
		<?php echo $this->Html->link('About Us',array('controller' => 'pages', 'action' => 'about_us'),array('escape' => false)); ?>
	</li>
	
	<li><a href="#nogo">Solution</a>
		<ul>
			<li><a href="#nogo">Ambulatory Solutions</a>
				<ul>
					<li><!-- <a href="/pages/patient_portal">Patient Portal</a> -->
						<?php echo $this->Html->link('Patient Portal',array('controller' => 'pages', 'action' => 'patient_portal'),array('escape' => false)); ?>
					</li>
					<li><!-- <a href="/pages/ambulatory_emr">Ambulatory EMR</a> -->
						<?php echo $this->Html->link('Ambulatory EMR',array('controller' => 'pages', 'action' => 'ambulatory_emr'),array('escape' => false)); ?>
					</li>
					
					
				</ul>
			</li>
		
			<li><a href="#nogo">Hospital solutions</a>
				<ul>
					<li><!-- <a href="/pages/hosptal_info_manage">Hospital Information Management</a> -->
						<?php echo $this->Html->link('Hospital Information Management',array('controller' => 'pages', 'action' => 'hosptal_info_manage'),array('escape' => false)); ?>
					</li>
					<li><!-- <a href="/pages/impatient_emr">Inpatient EMR</a> -->
						<?php echo $this->Html->link('Inpatient EMR',array('controller' => 'pages', 'action' => 'impatient_emr'),array('escape' => false)); ?>
					</li>
					
				</ul>
			</li>
		
			<li><a href="#nogo">Public Sector Solutions</a>
				<ul>
					<li>
						<!-- <a href="/pages/public_health">Public Health</a> -->
						<?php echo $this->Html->link('Public Health',array('controller' => 'pages', 'action' => 'public_health'),array('escape' => false)); ?>
					</li>
					<li>
					<!-- 	<a href="/pages/telemedecine">Telemedecine</a> -->
						<?php echo $this->Html->link('Telemedecine',array('controller' => 'pages', 'action' => 'telemedecine'),array('escape' => false)); ?>
					</li>
					
				</ul>
			</li>
			
			<li><a href="#nogo">Specility Solutions</a>
				<ul>
					<li>
						<!-- <a href="/pages/ot_s_m">OT Scheduling and Management </a> -->
						<?php echo $this->Html->link('OT Scheduling and Management',array('controller' => 'pages', 'action' => 'ot_s_m'),array('escape' => false)); ?>
					</li>
					<li>
						<!-- <a href="/pages/dental">Dental </a> -->
						<?php echo $this->Html->link('Dental',array('controller' => 'pages', 'action' => 'dental'),array('escape' => false)); ?>
					</li>
					<li>
					<!-- 	<a href="/pages/physio">Physiotherapy </a> -->
						<?php echo $this->Html->link('Physiotherapy',array('controller' => 'pages', 'action' => 'physio'),array('escape' => false)); ?>
					</li>
					<li>
						<!-- <a href="/pages/obest_gyna">Obestrics/Gynacology </a> -->
						<?php echo $this->Html->link('Obestrics/Gynacology',array('controller' => 'pages', 'action' => 'obest_gyna'),array('escape' => false)); ?>
					</li>
					<li>
						<!-- <a href="/pages/opth">Opthalmology </a> -->
						<?php echo $this->Html->link('Opthalmology',array('controller' => 'pages', 'action' => 'opth'),array('escape' => false)); ?>
					</li>
					<li>
						<!-- <a href="/pages/oncology">Oncology </a> -->
						<?php echo $this->Html->link('Oncology',array('controller' => 'pages', 'action' => 'oncology'),array('escape' => false)); ?>
					</li>
					<li>
						<!-- <a href="/pages/cardio">Cardiology </a> -->
						<?php echo $this->Html->link('Cardiology',array('controller' => 'pages', 'action' => 'cardio'),array('escape' => false)); ?>
					</li>
				</ul>
			</li>
			
			<li>
				<!-- <a href="/pages/ehr-software">EHR Software</a> -->
				<?php echo $this->Html->link('EHR Software',array('controller' => 'pages', 'action' => 'ehr-software'),array('escape' => false)); ?>
			</li>		
			
	</ul></li>
	<li>
		<!-- <a href="/pages/drm-brochure">Handout</a> -->
		<?php echo $this->Html->link('Handout',array('controller' => 'pages', 'action' => 'drm-brochure'),array('escape' => false)); ?>		
	</li>
	

	
<li>
	<!-- <a href="/pages/service">Services</a> -->
	<?php echo $this->Html->link('Services',array('controller' => 'pages', 'action' => 'service'),array('escape' => false)); ?>	
	<ul>
		<li>
			<!-- <a href="/pages/consulting_implement">Consulting and Implementations </a> -->
			<?php echo $this->Html->link('Consulting and Implementations',array('controller' => 'pages', 'action' => 'consulting_implement'),array('escape' => false)); ?>	
		</li>
		<li>
			<!-- <a href="/pages/healthcare_itservice">Healthcare IT Services </a> -->
			<?php echo $this->Html->link('Healthcare IT Services',array('controller' => 'pages', 'action' => 'healthcare_itservice'),array('escape' => false)); ?>	
		</li>
		<li>
		<!-- 	<a href="/pages/hats">Healthcare Application Training Services </a> -->
			<?php echo $this->Html->link('Healthcare Application Training Services',array('controller' => 'pages', 'action' => 'hats'),array('escape' => false)); ?>	
		</li>
		<li>
			<!-- <a href="/pages/infra_support">Infrastructure Support Services </a> -->
			<?php echo $this->Html->link('Infrastructure Support Services',array('controller' => 'pages', 'action' => 'infra_support'),array('escape' => false)); ?>	
		</li>
	</ul>
</li>

<li>
	<!-- <a href="/pages/partners">Partners</a> -->
	<?php echo $this->Html->link('Partners',array('controller' => 'pages', 'action' => 'partners'),array('escape' => false)); ?>	
		<ul>
			<li>
				<!-- <a href="/pages/partnership">Partnerships </a> -->
				<?php echo $this->Html->link('Partnerships',array('controller' => 'pages', 'action' => 'partnership'),array('escape' => false)); ?>	
			</li>
			<li>
				<!-- <a href="/pages/be_our_partner">Be Our Partner</a> -->
				<?php echo $this->Html->link('Be Our Partner',array('controller' => 'pages', 'action' => 'be_our_partner'),array('escape' => false)); ?>	
			</li>
		
		</ul>
	</li>
	
	<li><a href="#nogo">Company</a>
		<ul>
		<li>
			<!-- <a href="/pages/comp_awards_certi">Awards and Events </a> -->
			<?php echo $this->Html->link('Awards and Events',array('controller' => 'pages', 'action' => 'comp_awards_certi'),array('escape' => false)); ?>	
		</li>
		<li>
			<!-- <a href="/pages/certification">Certifications </a> -->
			<?php echo $this->Html->link('Certifications',array('controller' => 'pages', 'action' => 'certification'),array('escape' => false)); ?>
		</li>
		<li>
			<!-- <a href="/pages/faq">FAQ </a> -->
			<?php echo $this->Html->link('FAQ',array('controller' => 'pages', 'action' => 'faq'),array('escape' => false)); ?>
		</li>
		
		<li>
			<!-- <a href="/pages/story_so_far">Story So Far </a> -->
			<?php echo $this->Html->link('Story So Far',array('controller' => 'pages', 'action' => 'story_so_far'),array('escape' => false)); ?>
		</li>
		</ul>
	</li>
	<li><a href="#nogo">Benefits</a>
			
				<ul>
				<li>
					<!-- <a href="/pages/free_emr">Free EMR </a> -->
					<?php echo $this->Html->link('Free EMR',array('controller' => 'pages', 'action' => 'free_emr'),array('escape' => false)); ?>
				</li>
				<li>
					<!-- <a href="/pages/web_based">Web Based </a> -->
					<?php echo $this->Html->link('Web Based',array('controller' => 'pages', 'action' => 'web_based'),array('escape' => false)); ?>
				</li>
				<li>
					<!-- <a href="/pages/earn_money">Earn stimulus money </a> -->
					<?php echo $this->Html->link('Earn stimulus money',array('controller' => 'pages', 'action' => 'earn_money'),array('escape' => false)); ?>
				</li>
				<li>
					<!-- <a href="/pages/emr-software">EMR Software</a> -->
					<?php echo $this->Html->link('EMR Software',array('controller' => 'pages', 'action' => 'emr-software'),array('escape' => false)); ?>
				</li>
				<li>
					<!-- <a href="/pages/stay_secure">Stay secure </a> -->
					<?php echo $this->Html->link('Stay secure',array('controller' => 'pages', 'action' => 'stay_secure'),array('escape' => false)); ?>
				</li>
				<li>
					<!-- <a href="/pages/emr_comparison">EMR Comparison </a> -->
					<?php echo $this->Html->link('EMR Comparison',array('controller' => 'pages', 'action' => 'emr_comparison'),array('escape' => false)); ?>
				</li>
				<li>
					<!-- <a href="/pages/support">Unlimited Support </a> -->
					<?php echo $this->Html->link('Unlimited Support',array('controller' => 'pages', 'action' => 'support'),array('escape' => false)); ?>
				</li>
				<li><a href="#">Innovations</a>
					<ul>
						<li>
							<!-- <a href="/pages/adverse_events">Adverse event </a> -->
							<?php echo $this->Html->link('Adverse event',array('controller' => 'pages', 'action' => 'adverse_events'),array('escape' => false)); ?>
						</li>
						<li>
							<!-- <a href="/pages/support_portal">Support portal </a> -->
							<?php echo $this->Html->link('Support portal',array('controller' => 'pages', 'action' => 'support_portal'),array('escape' => false)); ?>
						</li>
						<li>
							<!-- <a href="/pages/language_interpreters">Language interpreter video/voice </a> -->
							<?php echo $this->Html->link('Language interpreter video/voice',array('controller' => 'pages', 'action' => 'language_interpreters'),array('escape' => false)); ?>
						</li>
						<li>
							<!-- <a href="/pages/smartroom">Smartest room </a> -->
							<?php echo $this->Html->link('Smartest room',array('controller' => 'pages', 'action' => 'smartroom'),array('escape' => false)); ?>
						</li>
						<li>
							<!-- <a href="/pages/vap_monitor">VAP quality monitor </a> -->
							<?php echo $this->Html->link('VAP quality monitor',array('controller' => 'pages', 'action' => 'vap_monitor'),array('escape' => false)); ?>
						</li>
						<li>
							<!-- <a href="/pages/dshbrd">Dashboards </a> -->
							<?php echo $this->Html->link('Dashboards',array('controller' => 'pages', 'action' => 'dshbrd'),array('escape' => false)); ?>
						</li>
						
					</ul>
				</li>
				</ul>
			</li>
</ul>
		
		
		 
</div>
    	
    	</div>
        <!-- Login Starts Here -->
        <div id="loginContainer">
            <a href="#" id="loginButton"><span>Sign In</span><em></em></a>            
            <div style="clear:both"></div>
            <?php echo $this->Session->flash(); ?>
            <div id="loginBox">                
            	<!-- <form id="loginForm"> -->
            	<?php echo $this->Form->create('User', array('id'=>'loginForm','action' => 'login')); ?>
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
		<div class="body_container"
			style="min-height: 400px; margin: 0px; padding: 0px; background-color: #fff;">
			<?php echo $content_for_layout; ?>

		</div>
	</div>
	<div class="clr"></div>


	</div>
	<div class="footer_container">
		<div class="footer">
			<div class="footLeft" style="width: 515px;display:none;">
				<?php echo $this->Html->link($this->Html->image("cloud-computing-btn.png", array("alt" => "Cloud Computing", "title" => "Cloud Computing")),array('controller' => 'pages', 'action' => 'cloud_computing'),array('escape' => false)); ?>

				<?php echo $this->Html->link($this->Html->image("icon-story-so-far.png", array("alt" => "Story So Far", "title" => "Story So Far")),array('controller' => 'pages', 'action' => 'story_so_far'),array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image("electronic-patient-btn.png", array("alt" => "Electronic Patient Record", "title" => "Electronic Patient Record")),array('controller' => 'pages', 'action' => 'electronic_patient'),array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image("electronic-patient-btn.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'hms'),array('escape' => false)); ?>
				
				<?php echo $this->Html->link($this->Html->image("icon-faqs.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => 'pages', 'action' => 'clinical_data'),array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image("drmh-benefits-btn.png", array("alt" => "DRM Hope Benefits", "title" => "DRM Hope Benefits")),array('controller' => 'pages', 'action' => 'drm_benefits'),array('escape' => false)); ?>			
			</div>
			<div class="footLeft">
 <div style="float:left">
  <?php //echo $this->Html->link($this->Html->image("onc-ambulatory.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => '', 'action' => ''),array('escape' => false));
  echo $this->Html->image("onc-ambulatory.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System"));?>
	 
 </div>
 <div style="float:left">
 <?php //echo $this->Html->link($this->Html->image("onc-inpatient.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")),array('controller' => '', 'action' => ''),array('escape' => false));
  echo $this->Html->image("onc-inpatient.png", array("alt" => "Hospital Management System", "title" => "Hospital Management System")); ?>
 </div>
</div>
			<div class="footRight">
				<div class="contact">
					<a href="http://drmhope.com/downloads/brochure-drmhope.pdf" alt="Download Brochure"  title="Download Brochure" target="_blank">
							<?php echo $this->Html->image('btn-download.png'); ?>
					</a>
					<!--<a href="/contacts" rel="ibox2" title="Contact Us"><?php echo $this->Html->image('contact-us.png'); ?>
					</a> 
					<a href="/pages/drm-brochure"><?php echo $this->Html->image('handout.png',array('alt'=>'Contact Us','title'=>'Contact Us')); ?></a> -->
					<?php echo $this->Html->link($this->Html->image("contact-us.png", array("alt" => "Contact Us", "title" => "Contact Us")),array('controller' => 'contacts', 'action' => 'index'),array('escape' => false)); ?>
				</div>
			<ul class="social">
        	<li><a href="http://www.twitter.com/DrMHope" target="_blank"><?php echo $this->Html->image('twitter_new.png',array('alt'=>'Twitter','title'=>'Twitter')); ?></a></li>
          	<li><a href="http://www.facebook.com/drmhopeCLOUD"  target="_blank"><?php echo $this->Html->image('facebook_new.png',array('alt'=>'Facebook','title'=>'Facebook')); ?></a></li>
           <li><a href="https://plus.google.com/101489643999327172156"  target="_blank"><?php echo $this->Html->image('google_plus.png',array('alt'=>'Google Plus','title'=>'Google Plus')); ?></a></li> 
          
            <li><a href="http://www.linkedin.com/company/drmhope" target="_blank"><?php echo $this->Html->image('linkdin_new.png',array('alt'=>'Linkdin','title'=>'Linkdin')); ?></a></li>
            <li><a href="http://www.youtube.com/drmhopedemos" target="_blank"> <?php echo $this->Html->image('youtube_new.png',array('alt'=>'Youtube','title'=>'Youtube')); ?>
					</a>
					</li>
			
            <!-- <li><a href="#"><img src="img/orkut-btn.png" alt="Orkut" /></a></li>
            <li><a href="#"><img src="img/rss-btn.png" alt="RSS" /></a></li>  -->
            <li><a href="mailto:info@drmhope.com"><?php echo $this->Html->image('letter_new.png',array('alt'=>'Mail','title'=>'Mail')); ?></a></li>
            <li>
			
					<?php echo $this->Html->link($this->Html->image("help3.png", array("alt" => "DRM Hope Help", "title" => "DRM Hope Help")),array('controller' => 'pages', 'action' => 'manual'),array('escape' => false)); ?>
					</li>	
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
