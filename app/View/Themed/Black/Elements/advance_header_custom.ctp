<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
<?php  	header("Cache-Control: no-cache, must-revalidate"); ?>

<?php echo $this->Html->charset(); ?>
<?php 
if($title_for_layout=='Notes'){
$Notes	= ClassRegistry::init('Note');
$getDate=$Notes->find('first',array('fields'=>array('create_time'),'conditions'=>array('id'=>$_SESSION['NoteId'])));
$newDate=explode(' ',$getDate['Note']['create_time']);
$nDate=explode('-',$newDate[0]);
$strDate=$nDate[2]."/".$nDate[1]."/".$nDate[0];
} ?>
<title>
<?php if(!empty($strDate)){echo $strDate;}else{echo __('Hope', true);} ?> <?php echo $title_for_layout; ?>
</title>
<?php

echo $this->Html->meta('icon');

echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','advance_css' ));

?>

<style>
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
</style>
<script>
  /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55133303-1', 'auto');
  ga('send', 'pageview');*/

</script>
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
	<?php 
} //EOF else part

echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2-DRM.js',
	 	'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js'/*,'mask/jquery.inputmask','mask/jquery.inputmask.date.extensions.js'*/,'default'));

?>
<noscript>
    <div style="text-align:center;background-color:red;width:100%;color:white;font-weight:bold;">
    It seems JavaScript is either disabled or not supported by your browser,
    enable JavaScript by changing your browser options </div>
</noscript>
	<script>
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
</script>
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
							<a href="<?php echo $this->Html->url("/"); ?>"><img height="45"
								src="<?php echo $this->Html->url("/img/Portal_images/logo.png");?>"
								alt="Hopes Hospital" border="0" height="45"/> </a>
							<?php  }?>
							<div class='top-icons'>
								<?php $this->Navigation->getMenu('top');?>
							</div>
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
	}}?>
							             
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
							</span>
<?php }?>

						</div>
					</div> <!-- Boder commented by gulshan  --> <!-- <div class="clear headPatch"></div> -->
	<?php /* elements added by swatin*/	
 if(strtolower($this->params->controller) == 'reports')
    {
     echo $this->element('reports_menu'); 
    } 
    if(strtolower($this->params->controller) == 'store')
    {
    	echo $this->element('store_menu');
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