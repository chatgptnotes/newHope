<?php  echo $this->Html->css(array('internal_style.css'));?>
<style>
.sms{font-size:13px;float:left; width:600px;padding:20px;border:1px solid #ccc;}
.sms ul{float:left;}
.sms ul li{float:left;list-style:decimal;} 

</style>
  <div style="margin:0 auto;width:600px;">
	<div style="margin-top: 30%" class="sms"><?php echo "<b style='color:red;'>Book appointment through SMS feature :</b><br> <br>
		Now you can send simple SMS commands to book doctor appointments. You need to send SMS commands to 56767 with the keyword 1patient1ID as the detailed instruction available below.
		Quick & Easy 3 steps:
		<ul>
		<li>Sign-up your mobile with 1patient1ID</li>
		<li>Know a doctors appointment schedule - SMS : 1patient1ID LS <Doctors DrMHope ID>  <date> E.g. 1patient1ID LS 106 2012/03/01</li>
		<li>Book an appointment after knowing the available slots - SMS : 1patient1ID LS  <Doctors DrMHope ID> <Date> <Slot> E.g. 1patient1ID LS 106 2012/03/01 2:30 PM</li>
		</ul><br>
		Each doctor's DrMHope ID will be available on their profile page in our DrMHope.com patient portal. You can keep your favorite doctor's DrMHope ID to your mobile phone or on a sticky note, thus it help you to book quick SMS appointments later."?>
	</div>
	<div class="btns">
						<?php 
							echo $this->Html->link(__('Cancel', true),array('controller'=>'Users','action' => '/'), array('escape' => false,'class'=>'blueBtn'));
						?>
 </div>
</div>