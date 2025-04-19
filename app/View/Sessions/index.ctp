<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo __('Hospital Management System'); ?></title>
</head>
<?php echo $this->Html->css('style.css');?>

<body>
<div class="wrapper">
	
    <div class="header"><a href="#"><img src="img/logo.jpg" /></a></div>
    <div class="clr"></div>
    <div class="banner">
    <div class="login">
    <h2>Start Your Business</h2>
    <span>View and access your SaaS Business System.</span><br /><br />
    <?php
	echo $this->Session->flash('auth');
		 echo $this->Form->create('Session', array('action' => 'login'));
		 echo $this->Form->input('username');
		 echo $this->Form->input('password');
		 echo $this->Form->end('Login');
    	
    ?>
   
    </div>
    </div>
    <div class="clr"></div>
    <div class="body_container"></div>
    <div class="clr"></div>


</div>
<div class="footer_container">
<div class="footer"><img src="img/footer_content.gif" /></div>
</div>
</body>
</html>
