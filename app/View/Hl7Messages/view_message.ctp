<?php
 	 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3','jquery.ui.widget','jquery.ui.mouse','jquery.ui.core'));
	 echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
	 echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
 <style>
 .loginContainer {
    position:relative;
    float:right;
    font-size:12px;
    margin-top:40px;
    z-index:100;
}

/* Login Button */
#loginButton { 
    display:inline-block;
    float:right;
    background:#ffffff; 
    border:1px solid #cacaca; 
    border-radius:3px;
    -moz-border-radius:3px;
    position:relative;
    z-index:30;
    cursor:pointer;
}

/* Login Button Text */
#loginButton span {
    color:#0c8dc5; 
    font-size:14px; 
    font-weight:bold; 
    text-shadow:1px 1px #fff; 
    padding:7px 25px 9px 10px;
    background:url(../img/loginArrow.png) no-repeat 60px 9px;
    display:block
}

#loginButton:hover {
    background:#ffffff;
}

/* Login Box */
/*#loginBox {
    position:absolute;
    top:34px;
    right:0;
    display:none;
    z-index:29;
}*/

/* If the Login Button has been clicked */    
#loginButton.active {
    border-radius:3px 3px 0 0;
}

#loginButton.active span {
    background-position:60px -78px;
}

/* A Line added to overlap the border */
#loginButton.active em {
    position:absolute;
    width:100%;
    height:1px;
    background:#ffffff;
    bottom:-1px;
}

/* Login Form */
.loginForm {
    width:248px; 
    border:1px solid #cacaca;
    border-radius:3px 0 3px 3px;
    -moz-border-radius:3px 0 3px 3px;
    margin-top:-1px;
    background:#ffffff;
    padding:6px;
}

.loginForm fieldset {
    margin:0 0 12px 0;
    display:block;
    border:0;
    padding:0;
}

fieldset#body {
    background:#fff;
    border-radius:3px;
    -moz-border-radius:3px;
    padding:10px 13px;
    margin:0;
}

.loginForm #checkbox {
    width:auto;
    margin:1px 9px 0 0;
    float:left;
    padding:0;
    border:0;
    *margin:-3px 9px 0 0; /* IE7 Fix */
}

#body label {
    color:#3a454d;
    margin:9px 0 0 0;
    display:block;
    float:left;
}

.loginForm #body fieldset label {
    display:block;
    float:none;
    margin:0 0 6px 0;
}

/* Default Input */
.loginForm input {
    width:92%;
    border:1px solid #899caa;
    border-radius:3px;
    -moz-border-radius:3px;
    color:#3a454d;
    font-weight:bold;
    padding:8px 8px;
    box-shadow:inset 0px 1px 3px #bbb;
    -webkit-box-shadow:inset 0px 1px 3px #bbb;
    -moz-box-shadow:inset 0px 1px 3px #bbb;
    font-size:12px;
}

/* Sign In Button */
.loginForm #login {
    width:auto;
    float:left;
    background:#339cdf;
	background-image: -ms-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -moz-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -o-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #59ACEA), color-stop(1, #0197D8));
	background-image: -webkit-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: linear-gradient(top, #59ACEA 0%, #0197D8 100%);
    color:#fff;
	font-size:13px;
    padding:7px 10px 8px 10px;
    text-shadow:0px -1px #278db8;
    border:1px solid #339cdf;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    margin:0 12px 0 0;
    cursor:pointer;
    *padding:7px 2px 8px 2px; /* IE7 Fix */
}

/* Forgot your password */
.loginForm span {
    text-align:center;
    display:block;
    padding:7px 0 4px 0;
}

.loginForm span a {
    color:#3a454d;
    text-shadow:1px 1px #fff;
    font-size:12px;
}

input:focus {
    outline:none;
}
.loginBox {
     display:none;
    position: absolute;
    right: 0;
    top: 34px;
    z-index: 29;
}

#WardWardId{
	margin:10px 0px 0px 20px;
}

 </style>
 <!--[if IE]>
 <style>
 	#WardWardId{
		margin:2px 0px 0px 20px;
	} 
 </style>
 <![endif]-->
 
 <?php //pr($patient);exit;?>
<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>

<div class="inner_title">
	<h3>&nbsp; <?php echo __('View Patient', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?> 
 
    <p class="ht5"></p>
	      
   <?php 
       echo $this->element('patient_information');
    ?>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-left:10px">
	<tr><td>Patient Demographics</td></tr>
	<tr><td>&nbsp; </td></tr>
	<tr><td><?php echo $this->Form->textarea('hl7_text', array('type'=>'text','class' => '','id' => 'customdescription','readonly'=>true,'value'=>$hl7message,'style'=>'width:600px;height:200px')); ?></td></tr>
	<tr><td style="padding-top:20px;"><?php echo $this->Html->link(__('Save to DB'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'patientdemographicsid')); ?></td></tr>
	</table>

	<SCRIPT type="text/javascript">
      function save_allergy(allergytype){

	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "save_allergy",$patient['Patient']['id'],"admin" => false)); ?>";
	   var formData = $('#diagnosisfrm').serialize();
      patientid="<?php echo $patient['Patient']['id']?>";
	  
           $.ajax({
            type: 'POST',
            url: ajaxUrl+"/"+allergytype,
            data: formData,
            dataType: 'html',
            success: function(data){
			
				window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+patientid;
            },  
			error: function(message){
                alert(message);
            }        });
      
      return false;
}
	</script>
              
