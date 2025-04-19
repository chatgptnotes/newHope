<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Us</title>
<style>
	body{margin:0;}
	.container{margin:15px;}
	h1{color:#0a8cc4; font-family:Arial, Helvetica, sans-serif; font-size:22px; font-weight:400; margin:0 0 10px 0; padding:0;}
	h2{color:#333333; font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:400; margin:5px 0 5px 0; padding:0;}
	p.email{margin:0; padding:12px 0 0 60px; font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#6d6e71; font-weight:bold; float:left; width:300px; background:url(img/email.png) no-repeat 0 0; height:50px;}
	p.email a{color:#63aadb; text-decoration:none;}
	p.phone{margin:0; padding:12px 0 0 60px; font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#92be3a; font-weight:bold; float:left; width:200px;  background:url(img/phone.png) no-repeat 0 0; height:50px;}	
	#ibox_footer_wrapper a{text-decoration:none; color:#000; font-weight:bold; text-transform:inherit;}
	.leftSide{width:330px; float:left; line-height:22px; font-family:Arial, Helvetica, sans-serif; font-size:14px; padding-bottom:20px; padding-top:20px;}
	.rightSide{width:380px; padding-left:20px;border-left:1px solid #CCCCCC; float:right; margin-left:30px;}
	h3 {margin:0px; padding:0px;}
	p{margin:0px; padding:0px;}
	.blockContact h3 {
		padding:10px 0px;
		clear:both;
		margin-bottom:10px;
		border-bottom:1px dotted #ccc;
	}
	.blockContact {
		display:block;
		
		height:150px;
	}
	.clear {
		clear:both;
		margin-bottom:20px;
	}
</style>
</head>

<body>
<div class="container">
<!--<h1>Contact Us</h1>-->	
    <div class="leftSide">	
		<span><?php echo $this->Html->image('/img/logo_check.png');?>	</span><br />
    	<strong>Address:</strong><br />
        <h2>DrMHope Business System</h2>
		<h3>INDIA</h3>
        <p>51, Dhantoli, Nagpur - 440 012, India</p>
		<br>
		<h3>AUSTRALIA</h3>
		<p>19 Park View Drive, Melbourne 3163, Australia</p>
    </div>
    <div class="rightSide">
		<div class="blockContact"><h3>INDIA </h3>
		<div class="clear"></div>
        <p class="email"><a href="mailto:info@drmhope.com">info@drmhope.com</a></p>
        <p class="phone">+91 992 355 5053</p>
		</div>
		
		<div class="blockContact"><h3>AUSTRALIA </h3>
		<div class="clear"></div>
        <p class="email"><a href="mailto:contact@drmhope.com">contact@drmhope.com</a></p>
        <p class="phone">+61 40 5837 756</p>
		</div>
    </div>
</div>

</body>
</html>