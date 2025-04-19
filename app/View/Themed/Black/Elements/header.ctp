<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--  <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>-->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
<?php  	header("Cache-Control: no-cache, must-revalidate"); ?>

<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout;?>
</title>
<?php
echo $this->Html->meta('icon');

echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','advance_css'));

?>
<style>


/*.tabularForm tr:nth-child(even) {background: #CCC !important}
.tabularForm tr:nth-child(odd) {background: #e7e7e7 !important}*/
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

.footer,.push { /*height: 4em;*/
	
}

.clear {
	clear: both;
	font-size: 0;
}
.noclose .ui-dialog-titlebar-close
{
    display:none;
}
</style>
<script>
//commented by as it is required only for drmhope.com
 /* (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55133303-1', 'auto');
  ga('send', 'pageview');*/

</script>

<?php if(strtolower($this->params->controller) == 'billings'){  ?>
<SCRIPT type="text/javascript">
   // window.history.forward();
  //  function noBack() { window.history.forward(); }
</SCRIPT>

<noscript>
    <div style="text-align:center;background-color:red;width:100%;color:white;font-weight:bold;">
    It seems JavaScript is either disabled or not supported by your browser,
    enable JavaScript by changing your browser options </div>
</noscript>
</head>
<body  onload="noBack();" onpageshow="if (event.persisted) noBack();"
	onunload="">
	<?php }else{ ?>


</head>

	<?php 
} //EOF else part
echo $this->Html->script(array('default_compressed'/*'jquery-1.5.1.min.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en',
	'jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js',
	'permission.js','pager','default.js'*//*,'mask/jquery.inputmask','mask/jquery.inputmask.date.extensions.js'*/));
?>
<script>
//type is the "class" or "id"
function loading(target, type) {
	if (type == 'id')
		target = "#" + target;
	else
		target = "." + target;

	$(target).block( { 
						message : '<h1><?php echo $this->Html->image('/icons/ajax-loader_dashboard.gif');?> Please wait...</h1>',
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
<body>

<noscript>
    <div style="text-align:center;background-color:red;width:100%;color:white;font-weight:bold;">
    It seems JavaScript is either disabled or not supported by your browser,
    enable JavaScript by changing your browser options </div>
</noscript>
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
	<div style="width:100%;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="wrapper">
			<tr style="min-height: 650px;">
				<td width="1%">&nbsp;</td>
				<td align="left" valign="top">

					<div id="main">

						<!-- Header Div -->
						<div  class="header_internal" style="min-height:45px;">
							<?php 		
							if(trim($this->Session->read('facility_logo')) !='') {
					$logo = "/img/facility/".$this->Session->read('facility_logo');
					?>
							<?php if(strtolower($_SESSION['role']) == Configure::read('patientLabel')){?>
							<a
								href="<?php echo $this->Html->url(array('controller'=>'PatientAccess','action'=>'portal_home')); ?>">
								<?php echo $this->Html->image($logo,array('height'=>'45'));?>
							</a>
							<?php }else{?>
							<a href="<?php echo $this->Html->url("/"); ?>"> <?php echo $this->Html->image($logo,array('height'=>'45'));?>
							</a>
							<?php  
					}
			} else {?>
							<?php if(strtolower($_SESSION['role']) == Configure::read('patientLabel')){?>
							<a
								href="<?php echo $this->Html->url(array('controller'=>'PatientAccess','action'=>'portal_home')); ?>"><img
								src="<?php echo $this->Html->url("/img/Portal_images/logo.png");?>"
								alt="Hopes Hospital" border="0" height="45"/> </a>
							<?php }else{?>
							<a href="<?php echo $this->Html->url("/"); ?>"><img height="45"
								src="<?php echo $this->Html->url("/img/Portal_images/logo.png");?>"
								alt="Hopes Hospital" border="0" height="45"/> </a>
							<?php  }
			}
			?>   			<!-- <a href="<?php //echo $this->Html->url("/"); ?>"><img height="45" width="222" style="padding:15px 0 0 6px;margin: 0 0 0 -15px; float:left;"
								src="<?php //echo $this->Html->url("/img/Portal_images/Small-renaissanc.png");?>"
								alt="Renaissance Analytics" border="0" /> </a> -->
								<?php 
								$website = $this->Session->read('website.instance');
								if($website == 'kanpur' || $website == 'vadodara'){?>
								
											<div class='top-icons' style="padding-left: 0%"><?php $this->Navigation->getMenu('top');?></div> <!-- Menu icons in the top  -->
                                   
							<span class="logout_section" > 
							    <div>
							       <table cellpadding="0" cellspacing="0">
							          <tr>
							             <td style="font-size: 17px;font-weight: bold;"><?php $firstname = $this->Session->read('first_name');
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
			<!--  </br>-->
			<?php 	}}
			//}
	}?>
							             
							             </td>
							             <td style="padding-left: 0%">
							             <?php echo $this->Html->image('icons/9box_img.png',array('id'=>'nine-box')).'&nbsp;&nbsp;';
							$coreStatus = Configure::read('debug');?>
							             <!-- Notificatin_html start here -->
 <?php 
 	echo $this->element('notification') ;
 ?>

 <!-- Notificatin_html close here -->
 <a id='sign_out'>
 <?php $title = $this->Session->read('first_name').' '.$this->Session->read('last_name').' ('.$this->Session->read('role').')'?>
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
				  }?> </a> 
                     
 <?php
	   echo $this->Html->link(__('Config pages', true), array('controller' => 'innovations', 'action' => 'module_list', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
 									array('style'=> 'text-decoration:underline;color:#fff' ,'target'=>'_blank')).'&nbsp;&nbsp;';


	if($coreStatus > 0)
	echo $this->Html->link(__('Debug Off', true), array('controller' => 'Users', 'action' => 'changeConfig','0', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
			array('style'=> 'text-decoration:underline;color:#fff' )).'&nbsp;&nbsp;';
	echo $this->element('logout_box'); echo $this->element('nine_box_menu');

?>
							             </td>
							         </tr>
							      </table>
							  
							    </div>
							
                             
							</span>	
								
				<?php }else
				{?>				
								<div class='top-icons' style="padding-left: 80px;"><?php $this->Navigation->getMenu('top');?></div> <!-- Menu icons in the top  -->
                          
							<span class="logout_section"> 
							
							<?php 
							echo $this->Html->image('icons/9box_img.png',array('id'=>'nine-box')).'&nbsp;&nbsp;';
							$coreStatus = Configure::read('debug');
						
//else echo $this->Html->link(__('Debug On', true), array('controller' => 'Users', 'action' => 'changeConfig','1', 'admin' => false, 'superadmin' => false, 'plugin'=>false,), array('style'=> 'text-decoration:underline;color:#fff','class'=>'bluebtn')).'&nbsp;&nbsp;';
?> <?php
/* $firstname = $this->Session->read('first_name');
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
      //  echo $this->Html->link(__('Account settings | ', true), array('controller' => 'users', 'action' => 'change_password', 'admin' => false, 'superadmin' => false, 'plugin'=>false,), array('style'=> 'text-decoration:none;'));
 		//  echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin'=>false), array('style'=> 'text-decoration:none;'));
 ?>
 <!-- Notificatin_html start here -->
 <?php 
 	echo $this->element('notification') ;
 ?>

 <!-- Notificatin_html close here -->
 <a id='sign_out'>
 <?php $title = $this->Session->read('first_name').' '.$this->Session->read('last_name').' ('.$this->Session->read('role').')'?>
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
				  }?> </a> 
                     
 <?php
	   echo $this->Html->link(__('Config pages', true), array('controller' => 'innovations', 'action' => 'module_list', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
 									array('style'=> 'text-decoration:underline;color:#fff' ,'target'=>'_blank')).'&nbsp;&nbsp;';


	if($coreStatus > 0)
	echo $this->Html->link(__('Debug Off', true), array('controller' => 'Users', 'action' => 'changeConfig','0', 'admin' => false, 'superadmin' => false, 'plugin'=>false,),
			array('style'=> 'text-decoration:underline;color:#fff' )).'&nbsp;&nbsp;';
	echo $this->element('logout_box'); echo $this->element('nine_box_menu');

?>
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
												$personid=$this->Session->read('hub.personid');
												
												if(isset($patientId))
												{
													echo $this->Html->link(__('Patient Hub'),array('controller'=>'Patients','action' =>'new_patient_hub',$patientId), 
														array('escape' => false,'class'=>'blueBtn'));
												}
													
											?>
							   </div>
							   <!-- EOF Of New Patient Hub -->
							</span>
<?php }?>      
						</div>
					</div>
				</td>
			</tr>
			<br class="clear" />
		</table>
        <div class="clear"></div>
	</div>
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
	<!-- Boder commented by gulshan  -->
	<!-- <div class="clear headPatch"></div> -->
	<script> 

			$(function(){ //short script for document.ready();
				//$("input[type=submit]").attr("disabled",false ) ; 
			    $('#loader').fadeOut();
			    $('#page').fadeOut();
			    /*$("a").click(function(){
			    	$('#page').fadeIn();
				});*/

 
			});
		</script>

	<!-- Header Div Ends here -->