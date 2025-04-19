<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
<?php  	header("Cache-Control: no-cache, must-revalidate"); ?>

<?php echo $this->Html->charset(); ?>
<title>
<?php if(!empty($strDate)){echo $strDate;}else{echo __('Hope', true);} ?> <?php echo $title_for_layout; ?>
</title>
<?php 
	echo $this->Html->meta('icon'); 
	echo $this->Html->css(array('compressed_css','advance_css'/*'internal_style.css','jquery-ui-1.8.16.custom' ,'validationEngine.jquery.css','jquery.ui.all.css','jquery-ui.css'*/ )); 
	/*echo $this->Html->link(__('New patient Added'),array('controller'=>'Patients','action' =>'new_patient_hub'));*/
?>

<style>


/*.tabularForm tr:nth-child(even) {background: #CCC !important}
.tabularForm tr:nth-child(odd) {background: #e7e7e7 !important}*/

#model-alert{color:#000 !important ;display:none;}

#page {
	position: relative;
	width: 100%;
}

#loader {
	position: absolute;
	width: 100%;
	text-align: center;
	display: table;
	background-color: #d7c487;
	opacity: 0.8;
	color: #8c0000;
}
.pateintpic {
	border-radius: 25px !important;
}

#loader span {
	display: table-cell;
	vertical-align: middle;
}

.footer,.push {
	height: 4em;
}

.ui-dialog-titlebar-close
{
    display:none;
}
.new{
background-color: #30D5C7;
width:100%;
text-align:center;
color:orange !important;



}
</style>
<script>
  /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55133303-1', 'auto');
  ga('send', 'pageview');*/

</script>

<!--  <div class="new"><?php echo $this->Html->link(__('We Have A New Feature Patient Hub! Take a Look.'),
		array('controller'=>'Patients','action' =>'new_patient_hub'),
		array('style'=>'color:white !important;font-weight:bold;'));?></div>-->
<?php if(strtolower($this->params->controller) == 'billings'){  ?>
<SCRIPT type="text/javascript">
    window.history.forward();
    function noBack() { window.history.forward(); }
    
</SCRIPT>


</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();"
	onunload="">
	<?php }else{ ?>


</head>
<body>
	<!-- div added by pankaj w please do not remove  -->
	
	<?php 
} //EOF else part

echo $this->Html->script(array(/*'jquery-1.9.1.js','jquery-ui-1.10.2.js',
	 	'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js'*/ 'jscompress'));

?>
<noscript>
    <div style="text-align:center;background-color:red;width:100%;color:white;font-weight:bold;">
    It seems JavaScript is either disabled or not supported by your browser,
    enable JavaScript by changing your browser options </div>
</noscript>
	<script>
 

	window.alert = function(message) {
		 
		var modal = $("#model-alert").text(message).dialog({ 
	    	hide: { /*effect: "explode",*/ duration: 1000 },
	    	modal:true,
	        title:'<?php //echo $this->Session->read('username');?>',
	        buttons: {
	            'OK':function(){ 
	            	$(this).dialog( "close" );
	            	$(this).dialog( "destroy" ); 
	            }
	        }, 
	        dialogClass: "no-close",
	    });
	};

	  
var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;

//type is the "class" or "id"
function loading(target, type) {
	if (type == 'id')
		target = "#" + target;
	else
		target = "." + target;

	$(target).block( { 
						message : '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>',
						css : {
							 padding: '5px 0px 5px 18px',
					         border: 'none', 
					         padding: '15px', 
					         backgroundColor: '#000000', 
					         '-webkit-border-radius': '10px', 
					         '-moz-border-radius': '10px',               
					         color: '#fff',
					         'text-align':'left' 
						},
						overlayCSS : {
							backgroundColor: '#000000'
						}
					}); 
     
}

function onCompleteRequest(target, type) {
	if (type == 'id')
		target = "#" + target;
	else
		target = "." + target;
	$(target).unblock();
}


</script>
	
	<div id="model-alert" class="clr"></div>
	<div>
		<input type="hidden" name="secondReg"
			value="({|$)(\w+(\s+\w+)*)(\:|$)[0-9]{1,100000}(\}|$)" id="secondReg">

		<input type="hidden" name="thirdReg"
			value="({|$)(\w+(\s+\w+)*)(\:|$)[0-9]{1,100000}(\::|$)(\w+(\s+\w+)*)(\}|$)"
			id="thirdReg">
	</div>
	<div id="page">
		<div id="loader">
			<span>Loading...</span>
		</div>
	</div>
	<div class="" style="width:100%;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="wrapper">
			<tr style="min-height: 650px;">
				<td width="2%">&nbsp;</td>
				<td align="left" valign="top">

					<div id="main">

						<!-- Header Div -->
						<div class="header_internal" style="min-height:45px;">
							<?php 		
							if(trim($this->Session->read('facility_logo')) !='') {
					$logo = "/img/facility/".$this->Session->read('facility_logo');
					?>
							<a href="<?php echo $this->Html->url("/"); ?>"> <?php //echo $this->Html->image($logo,array('height'=>'45'));?>
							</a>
							<?php  } else {?>
							<!--<a href="<?php echo $this->Html->url("/"); ?>"><img height="45"-->
							<!--	src="<?php echo $this->Html->url("/img/Portalimages/logo.png");?>"-->
							<!--	border="0" height="45"/> </a>-->
							<?php  }?>
							<!--code by dinesh-->
							<?php
                            $dbName = $this->Session->read('db_name');
                            
                            $hospitalLogo = $this->Html->url('/img/default_logo.png', true);
                            $style = ""; // Default CSS
                            
                            if ($dbName == 'db_Ayushman') {
                            	$hospitalLogo = $this->Html->url('/img/ayushmanlogo.png', true);
                            	$style = 'position: relative; right: 30px;height:45px; top:15px;';
                            } elseif ($dbName == 'db_HopeHospital') {
                            	$hospitalLogo = $this->Html->url('/img/hopelogo_transparent.png', true);
                            	$style = 'position: relative; right: 30px; height: 45px; top: 15px;';
                            } elseif ($dbName == 'db_hope') {
                            	$hospitalLogo = $this->Html->url('/img/hopeadmin.png', true);
                            	$style = 'position: relative;right: 30px;height: 45px;top: 15px;';
                            }
                            ?>

                        <img src="<?php echo $hospitalLogo; ?>" alt="Hospital Logo" title="Hospital Logo" <?php echo !empty($style) ? 'style="' . htmlspecialchars($style, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>

							<div class='top-icons'>
								<?php if ($this->Session->read('Auth.User')): ?>
									<?php $this->Navigation->getMenu('top'); ?>

									<div class="row_modules">
										<a href="<?php echo $this->Html->url(array('controller' => 'Appointments', 'action' => 'uniqueqr_list')); ?>">
											<img src="/theme/Black/img/icons/sacn_image.png" alt="Hospitals" title="Hospitals">
										</a>
										<p>Unique QR List</p>
									</div>

									<div class="row_modules">
										<a href="<?php echo $this->Html->url(array('controller' => 'Appointments', 'action' => 'referal_doctor')); ?>">
											<img src="/theme/Black/img/icons/patientoverview.png" alt="Hospitals" title="Hospitals">
										</a>
										<p>Doctor Overview Station</p>
									</div>

									<div class="row_modules">
										<a href="<?php echo $this->Html->url(array('controller' => 'Persons', 'action' => 'patient_overview')); ?>">
											<img src="/theme/Black/img/icons/External.png" alt="Miscellaneous" title="Miscellaneous">
										</a>
										<p>Patient Overview Station</p>
									</div>

									<div class="row_modules">
										<a href="<?php echo $this->Html->url(array('controller' => 'Billings', 'action' => 'doctors_handover')); ?>">
											<img src="<?php echo $this->Html->url("/theme/Black/img/icons/docterhandover.png");?>" alt="Miscellaneous" title="Miscellaneous">
										</a>
										<p>Doctors Handover</p>
									</div>
										<div class="row_modules">
										<a href="<?php echo $this->Html->url(array('controller' => 'MarketTeam', 'action' => 'index')); ?>">
											<img src="<?php echo $this->Html->url("/theme/Black/img/icons/External.png");?>" alt="Miscellaneous" title="Miscellaneous">
										</a>
										<p>Marketing Team </p>
										<!--https://hopesoftwares.com/MarketTeam/-->
									</div>
								<?php endif; ?>
							<!-- Menu icons in the top  -->
							<?php $website = $this->Session->read('website.instance');
								if($website == 'kanpur' || $website == 'vadodara'){?>
											<span class="logout_section"> 
							<div>
							       <table cellpadding="0" cellspacing="0">
							          <tr>
							             <td style="font-size: 17px;font-weight: bold;color: black;"><?php $firstname = $this->Session->read('first_name');  
		if($website!='vadodara'){
			if(!empty($firstname)) {
				$roleId = $this->Session->read('roleid');
				$userName = $this->Session->read('username');
				$roleTyp = $this->Session->read('role');
				$location_name = $this->Session->read('location_name');
				
				// if($roleId == 2 && $userName != 'admin'){
				//echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as Doctor in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
				//}else{
				if(strtolower($roleTyp) == strtolower(Configure::read('doctorLabel'))){
					echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in location </br> ";?></span>
					<span class="login_msg"><?php echo " ".ucfirst($this->Session->read('location_name'));?></span>
			<span style="font-size: 17px;font-weight: bold;">
			<?php }else{
				echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in location </br>" ;?></span>
				   <span class="login_msg"><?php echo " ".ucfirst($this->Session->read('location_name'));?>
				</span>
			<!--  </br> </br>-->
			<?php 	}
			//}
	}
}
	?>
							             
							             </td>
							             <td style="padding-left: 0%"><?php 
							echo $this->Html->image('icons/9box_img.png',array('id'=>'nine-box')).'&nbsp;&nbsp;';
							$coreStatus = Configure::read('debug');

							/*  $firstname = $this->Session->read('first_name');
							 if(!empty($firstname)) {
							   $roleId = $this->Session->read('roleid');
							$userName = $this->Session->read('username');
							$roleTyp = $this->Session->read('role');
							// if($roleId == 2 && $userName != 'admin'){
								//echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as Doctor in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
							//}else{
								if(strtolower($roleTyp) == strtolower(Configure::read('doctorLabel'))){
									echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as ".strtoupper($this->Session->read('department'))." in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
							}else{
		                         echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as ".strtoupper($this->Session->read('role'))." in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
							}
							//}
							} */
							//if($this->Session->read('role') == "doctor") {
           //echo $this->Html->link(__('Account settings', true), array('controller' => 'doctors', 'action' => 'account_settings', 'admin' => false, 'superadmin' => false, 'plugin'=>false, //AuthComponent::user('id')));
       // }
     //   echo $this->Html->link(__('Account settings | ', true), array('controller' => 'users', 'action' => 'change_password', 'admin' => false, 'superadmin' => false, 'plugin'=>false,), array('style'=> 'text-decoration:none;'));

     //   echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin'=>false), array('style'=> 'text-decoration:none;'));
							
?>
<!-- Notificatin_html start here -->
<?php

	echo $this->element('notification') ;
	 
?>
 <!-- Notificatin_html close here -->
 <?php $title = $this->Session->read('first_name').' '.$this->Session->read('last_name').' ('.$this->Session->read('role').')'?>
                                 <a id='sign_out'>
							<?php if($this->Session->read('role') == 'Patient'){
									if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$this->Session->read('person_photo')) && ($this->Session->check('person_photo'))){
										echo $this->Html->image("/uploads/patient_images/thumbnail/".$this->Session->read('person_photo'), array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
									}else{
										echo $this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
									}
								}else{
									if(file_exists(WWW_ROOT."/uploads/user_images/".$this->Session->read('user_photo')) && ($this->Session->check('user_photo'))){
										echo $this->Html->image("/uploads/user_images/".$this->Session->read('user_photo'), array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
									}else{
										echo $this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
									}
				 				 }?>
							
							</a> <?php
							echo $this->Html->link(__('Config pages', true), array('controller' => 'innovations', 'action' => 'module_list', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
		                 		array('style'=> 'text-decoration:underline;color:#fff' ,'target'=>'_blank')).'&nbsp;&nbsp;';
		    
		                 		if($coreStatus > 0)
		                 			echo $this->Html->link(__('Debug Off', true), array('controller' => 'Users', 'action' => 'changeConfig','0', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
		                 					array('style'=> 'text-decoration:underline;color:#fff' )).'&nbsp;&nbsp;';
		                 		echo $this->element('logout_box');echo $this->element('nine_box_menu');?>

		                 		
							             </td>
							         </tr>
							      </table>
							  
							    </div>
		                 		
								<div style="text-align: right;">
									<?php 
									/* $this->WorldTime->setTimeZone(0);
									 if ($this->WorldTime->query()) {
                                       echo date("M d Y, H:i:s", $this->WorldTime->getResult())."&nbsp;"."(".$this->WorldTime->getHost().")"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									}*/
									//echo $this->Session->read('last_login');exit;
									/* echo  __('Last Account Activity :');
									 $datediff = $this->DateFormat->dateDiff($this->Session->read('last_login'), date("Y-m-d H:i:s"));
									if($datediff->days > 0)
										echo $datediff->days." days ";
									if($datediff->h > 0)
										echo $datediff->h." hrs ";
									if($datediff->i > 0)
										echo $datediff->i." min ";
									else
										echo "0 min "; */
									//if($datediff->s > 0)
									// echo $datediff->s." sec ";
									?>
								</div>
							</span>
							<?php }else{?>
							<span class="logout_section"> <?php 
							echo $this->Html->image('icons/9box_img.png',array('id'=>'nine-box')).'&nbsp;&nbsp;';
							$coreStatus = Configure::read('debug');
							
							/*  $firstname = $this->Session->read('first_name');
							 if(!empty($firstname)) {
							   $roleId = $this->Session->read('roleid');
							$userName = $this->Session->read('username');
							$roleTyp = $this->Session->read('role');
							// if($roleId == 2 && $userName != 'admin'){
								//echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as Doctor in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
							//}else{
								if(strtolower($roleTyp) == strtolower(Configure::read('doctorLabel'))){
									echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as ".strtoupper($this->Session->read('department'))." in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
							}else{
		                         echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as ".strtoupper($this->Session->read('role'))." in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
							}
							//}
							} */
							//if($this->Session->read('role') == "doctor") {
           //echo $this->Html->link(__('Account settings', true), array('controller' => 'doctors', 'action' => 'account_settings', 'admin' => false, 'superadmin' => false, 'plugin'=>false, //AuthComponent::user('id')));
       // }
     //   echo $this->Html->link(__('Account settings | ', true), array('controller' => 'users', 'action' => 'change_password', 'admin' => false, 'superadmin' => false, 'plugin'=>false,), array('style'=> 'text-decoration:none;'));

     //   echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin'=>false), array('style'=> 'text-decoration:none;'));
							
?>
<!-- Notificatin_html start here -->
<?php

	echo $this->element('notification') ;
	 
?>
 <!-- Notificatin_html close here -->
 <?php $title = $this->Session->read('first_name').' '.$this->Session->read('last_name').' ('.$this->Session->read('role').')'?>
                                 <a id='sign_out'>
							<?php if($this->Session->read('role') == 'Patient'){
									if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$this->Session->read('person_photo')) && ($this->Session->check('person_photo'))){
										echo $this->Html->image("/uploads/patient_images/thumbnail/".$this->Session->read('person_photo'), array('width'=>'40','height'=>'40','class'=>'pateintpic','title'=>$title));
									}else{
										echo $this->Html->image('icons/default_img.png', array('width'=>'40','height'=>'40','class'=>'pateintpic','title'=>$title));
									}
								}else{
									if(file_exists(WWW_ROOT."/uploads/user_images/".$this->Session->read('user_photo')) && ($this->Session->check('user_photo'))){
										echo $this->Html->image("/uploads/user_images/".$this->Session->read('user_photo'), array('width'=>'40','height'=>'40','class'=>'pateintpic','title'=>$title));
									}else{
										echo $this->Html->image('icons/default_img.png', array('width'=>'40','height'=>'40','class'=>'pateintpic','title'=>$title));
									}
				 				 }?>
							
							</a> <?php
							echo $this->Html->link(__('Config pages', true), array('controller' => 'innovations', 'action' => 'module_list', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
		                 		array('style'=> 'text-decoration:underline;color:#fff' ,'target'=>'_blank')).'&nbsp;&nbsp;';
		    
		                 		if($coreStatus > 0)
		                 			echo $this->Html->link(__('Debug Off', true), array('controller' => 'Users', 'action' => 'changeConfig','0', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
		                 					array('style'=> 'text-decoration:underline;color:#fff' )).'&nbsp;&nbsp;';
		                 		echo $this->element('logout_box');echo $this->element('nine_box_menu');?>

								<div style="text-align: right;">
									<?php 
									/* $this->WorldTime->setTimeZone(0);
									 if ($this->WorldTime->query()) {
                                       echo date("M d Y, H:i:s", $this->WorldTime->getResult())."&nbsp;"."(".$this->WorldTime->getHost().")"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									}*/
									//echo $this->Session->read('last_login');exit;
									/* echo  __('Last Account Activity :');
									 $datediff = $this->DateFormat->dateDiff($this->Session->read('last_login'), date("Y-m-d H:i:s"));
									if($datediff->days > 0)
										echo $datediff->days." days ";
									if($datediff->h > 0)
										echo $datediff->h." hrs ";
									if($datediff->i > 0)
										echo $datediff->i." min ";
									else
										echo "0 min "; */
									//if($datediff->s > 0)
									// echo $datediff->s." sec ";
									?>
								</div>
								<!-- New Patient hub to be visible on al pages- Pooja -->
								<div style="float: right; top:0px; position:fixed; right: 324px;;" class="hub">
											<?php 
												$patientId=$this->Session->read('hub.patientid'); 
												$link=$this->params->action;
												if(in_array($link,Configure::read('hub_link'))){
												if(isset($patientId))
												{
													echo $this->Html->link(__('Patient Hub'),array('controller'=>'Patients','action' =>'new_patient_hub',$patientId), 
														array('escape' => false,'class'=>'blueBtn'));
												}
												}	
											?>
							   </div>
							   <!-- EOF Of New Patient Hub -->
							</span>
<?php }?>

						</div>
					</div> <!-- Boder commented by gulshan  --> <!-- <div class="clear headPatch"></div> -->
	<?php /* elements added by swatin*/	
 if(strtolower($this->params->controller) == 'reports')
    {
     //echo $this->element('reports_menu'); 
    } 
    if(strtolower($this->params->controller) == 'store')
    {
    	//echo $this->element('store_menu');
    } 
    ?>				
					<script>
			$(function(){
				//$("input[type=submit]").attr("disabled",false ) ; 
			    $('#loader').fadeOut();
			    $('#page').fadeOut();


			   
        $( "#homeicon" ).click(function() {	
	$( "#slidePanel" ).slideToggle( "fast" );
	$( "#slidePanelPatient" ).hide();
	$( "#patienticon" ).show();
	$( "#accounting_left_navigation" ).show();
	$( "#patienthubicon" ).hide();
	$( "#homeicon" ).hide();
	$( "#closeicon" ).hide();
	
   
	
});

	$( "#patienticon" ).click(function() {	
	$( "#slidePanel" ).hide();
	$( "#slidePanelPatient" ).slideToggle( "fast" );
	$( "#patienticon" ).hide();
	$( "#patienthubicon" ).show();
	$( "#homeicon" ).show();
	$( "#closeicon" ).show();
	
	
});

$( "#closeicon" ).click(function() {	
	
	$( "#slidePanelPatient" ).hide();
	$( "#closeicon" ).hide();
	$( "#patienticon" ).show();
	$( "#homeicon" ).hide();	
});
			    	 
$( "#hospital_mode_selection" ).change(function() {
	var mode = $("#hospital_mode_selection").val();
	$(location).attr('href',"<?php echo $this->Html->url(array("controller" => 'users', "action" => "changeHospitalMode","admin" => false)); ?>/"+mode);
});


 

			});
			</script> <!-- Header Div Ends here -->