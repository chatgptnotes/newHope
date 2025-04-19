<style>
body {
	font-family: Arial;
	font-size: 13px;
}

h1 {
	color: #0A8CC4;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 22px;
	font-weight: 400;
	margin: 0 0 10px;
	padding: 0;
}

h2 {
	color: #0A8CC4;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	margin: 0 0 10px;
	padding: 0;
	border-bottom: 1px dotted #ccc;
	margin-top: 20px;
}

.btnBlack {
	background-color: #222222;
	border: medium none;
	color: #FFFFFF;
	cursor: pointer;
	font-size: 13px;
	padding: 5px 10px;
}
a, a:link, a:visited, a:hover {
	color:#0C8DC5;
	text-decoration:none;
	}
.sucMessage {
color:green;
}
</style>
<div><?php //echo $successMessage; ?></div>
<table width="100%" border="0" style="border: none;" cellspacing="0"
	cellpadding="0">
	<tr>
		<td height="500" valign="top" style="padding-top: 0px;">
			<div class="leftBlock"
				style="float: left; width: 48%; margin-top: 30px; padding-left: 20px; margin-bottom: 20px; border-right: 1px dotted #ccc;">
				<div>
					<h1>DrMHope Softwares Pvt. Ltd.</h1>
					<h2>INDIA</h2>
					<p>Plot No 2, Teka Naka Square, Kamptee Road Nagpur 17, India<br> Mob.: +91-9373111709 /+91-7276623928<br>
						Email: <a href="mailto:info@drmhope.com">info@drmhope.com</a>
					</p>
					<div
						style="border: 1px solid #ccc; width: 425px; height: 150px; margin-bottom: 30px;">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3720.290198669956!2d79.11298059999999!3d21.18062780000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd4c6d26635fabf%3A0x3ce27b75d43b7d19!2sHope+Hospitals!5e0!3m2!1sen!2sin!4v1441349613607" width="425" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
						<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7447.1727050353675!2d79.02948984594423!3d21.049230851926122!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd4be3dbe21195d%3A0xc9c744ba3de0a8fd!2sCentral+Facility%2C+MIHAN%2C+Nagpur%2C+Dahegaon%2C+Maharashtra+441108%2C+India!5e0!3m2!1sen!2sin!4v1412086001118" width="425" height="150" frameborder="0" style="border:0"></iframe>-->
						
						<br /><!-- <small> <a
							href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Hope+Hospital,+51,+Dhantoli,+Nagpur+-+440+012,+India&amp;aq=&amp;sll=21.141845,79.084276&amp;sspn=0.084857,0.169086&amp;g=51,+Dhantoli,+Nagpur+-+440+012,+India&amp;ie=UTF8&amp;hq=Hope+Hospital,+51,+Dhantoli,+Nagpur+-+440+012,+India&amp;t=m&amp;ll=21.1584,79.067316&amp;spn=0.006003,0.018239&amp;z=15&amp;iwloc=A"
							style="color: #0000FF; text-align: left">View Larger Map</a>  </small>-->
					</div>
				</div>
				<div>
					<h2>AUSTRALIA</h2>
					<p>
						19 Park View Drive, Melbourne 3163, Australia<br> Mob.: +61 40
						5837 756<br> Email: <a href="mailto:contact@drmhope.com">contact@drmhope.com</a>
					</p>
				</div>

				<br>
				<iframe width="425" height="150" frameborder="0" scrolling="no"
					marginheight="0" marginwidth="0"
					src="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=+19+Park+View+Drive,+Melbourne+3163,+Australia&amp;aq=&amp;sll=21.164923,79.067316&amp;sspn=0.022492,0.042272&amp;ie=UTF8&amp;hq=&amp;hnear=19+Parkview+Dr,+Carnegie+Victoria+3163,+Australia&amp;t=m&amp;ll=-37.90459,145.058327&amp;spn=0.010159,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
				<br /> <!-- <small><a
					href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=+19+Park+View+Drive,+Melbourne+3163,+Australia&amp;aq=&amp;sll=21.164923,79.067316&amp;sspn=0.022492,0.042272&amp;ie=UTF8&amp;hq=&amp;hnear=19+Parkview+Dr,+Carnegie+Victoria+3163,+Australia&amp;t=m&amp;ll=-37.90459,145.058327&amp;spn=0.010159,0.036478&amp;z=14&amp;iwloc=A"
					style="color: #0000FF; text-align: left">View Larger Map</a> </small> -->
			</div>
			<div class="columnLeft facilities"
				style="width: 40%; float: right; margin-top: 30px;">
				<h1>Contact</h1>
				<p>Please fill up the form and send it to us if you have any
					querires or need any information.</p>

				<div class="contactForm">
					<?php if(isset($successMessage)) {?>
					<div class="sucMessage">
						<?php echo $successMessage;?>
					</div>
					<?php } else {?>
					<?php echo $this->Session->flash(); ?>
					<h2>Contact Form</h2>
					<span class="space"></span>
					<?php echo $this->Form->create('Contacts', array('type' => 'post','id'=>'contact_us'));?>
					<table width="100%" cellpadding="2" class="table1" cellspacing="0">
						<tr>
							<td>Name<font color='red'>*</font></td>
							<td><?php echo $this->Form->input('name', array('type' => 'text','class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd','label' => false)); ?>
							</td>
						</tr>
						<tr>
							<td>Email<font color='red'>*</font></td>
							<td><?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'validate[required,custom[email]] textBoxExpnd','label' => false)); ?>
							</td>
						</tr>
						<tr>
							<td>Mobile Number<font color='red'>*</font></td>
							<td><?php echo $this->Form->input('mobile', array('type' => 'text', 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','maxlength'=>'10','label' => false)); ?>
							</td>
						</tr>
						<tr>
							<td valign="top">Address</td>
							<td><?php echo $this->Form->input('address', array('type' => 'textarea', 'rows'=> '3', 'class' => 'textarea200','label' => false)); ?>
							</td>
						</tr>
						<tr>
							<td valign="top">Message</td>
							<td><?php echo $this->Form->input('message', array('type' => 'textarea', 'rows'=> '6', 'class' => 'textarea200','label' => false)); ?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td style="padding-top:20px;"><?php echo $this->Form->input('Submit', array('type' => 'button', 'id'=>'submit','label' => false, 'class' => 'btnBlack', 'div' => false)); ?>
								<?php echo $this->Form->input('Reset', array('type' => 'reset','label' => false, 'class' => 'btnBlack', 'div' => false)); ?>
							</td>
						</tr>
					</table>
					<?php echo $this->Form->end();?>
					<?php }?>
					<span class="space"></span><span class="space"></span>
				</div>

			</div>
		</td>
	</tr>
	<tr>
		<td valign="top"></td>
	</tr>
</table>
<script>
jQuery("#contact_us").validationEngine({
    validateNonVisibleFields: true,
    updatePromptsPosition:true,
});
$('#submit')
.click(
		function() { 
			var validatePerson = jQuery("#contact_us").validationEngine('validate');
			if (validatePerson) {$(this).css('display', 'none');}
		});
</script>


