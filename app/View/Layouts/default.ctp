<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
	</title>
<?php
		echo $this->Html->meta('icon');    
	 
     	
     	 
     	echo $this->Html->script(array('jquery-1.5.1.min','fullcalendar','validationEngine.jquery','date.js','jquery.datePicker.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
     	 

   		echo $this->Html->css(array('internal_style.css','fullcalendar','datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css'));

	?>
</head>

<body>
<div id="main">

<!-- Header Div -->
	<div class="header_internal">
		<a href="#"><img src="<?php echo $this->Html->url("/img/Portal_images/logo.png");?>" alt="Hopes Hospital" border="0"/></a>
		<span class="logout_section">Account settings | <?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin'=>false));?></span>
	</div>
<!-- Header Div Ends here -->
	
	
<!-- Body Part Template -->
<div class="body_template">

<!-- Left Part Template -->
<div class="left_template">

<!-- First Tab Department -->
<div class="tab_dept">
<?php   
#echo '<pre>';print_r($_SESSION);exit;
$roleType = $this->Session->read('role');
$usertype = $this->Session->read('facilityu',$facility['Facility']['usertype']);
if($roleType == 'superadmin'){
	echo $this->element('left_navigation_superadmin');	
}else if($roleType == 'admin'){
	echo $this->element('left_navigation_admin');	
}else{
	echo $this->element('left_navigation');	
}
?>

<!-- First Tab Department Ends Here -->








</div>
<!-- Left Part Template Ends here -->

<!-- Right Part Template -->
<div class="right_template">


<p class="ht5"></p>
<div><?php echo $this->Session->flash(); ?></div>
<?php echo $content_for_layout; ?>
 
          
 




</div>
<!-- Right Part Template ends here -->



</div>
<!-- Body Part Template Ends here -->
<?php //echo $this->element('sql_dump'); ?>

</div>





</body>
</html>