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
	 
     	
     	 
     	echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.datePicker.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','default'));
     	 

   		echo $this->Html->css(array('internal_style.css','datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css'));

	?>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td width="5%">&nbsp;</td>
        <td align="left" valign="top">

		<div id="main">
		
		<!-- Header Div -->
			<div class="header_internal">
				<a href="#"><img src="<?php echo $this->Html->url("/img/Portal_images/logo.png");?>" alt="Hopes Hospital" border="0"/></a>
				<span class="logout_section">
		                 <?php 
		                       $firstname = $this->Session->read('first_name');
		                       if(!empty($firstname)) {
		                         echo $firstname."&nbsp;".$this->Session->read('last_name')." logged in as ". $this->Session->read('role')." | ";
		                       }
		                 ?>Account settings | <?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin'=>false));?></span>
			</div>
		<!-- Header Div Ends here -->
