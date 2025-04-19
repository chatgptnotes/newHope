<style>
.td_second{
	border-left-style:solid; 
	padding-left: 25px; 

}
.lefty{
	float:left;
	background:#DEE5C4;
	border:1px solid #CCC;
}
.righty{
	float:right;
	background:#FFF799;
	border:1px solid #CCC;
}
.new{float:left;
paddimg-bottom:10px; margin:0px; font-weight:bold;padding-left:5px;font-style: italic;}
.msg{float:left; padding-top:5px;padding-left:5px;}
</style>

<div class="inner_title">
	<!--<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Conversation') ?>
	</h3>
--></div>

		<table cellpadding="0" cellspacing="0" width="80%" class="" style="margin-top: 25px;" align="center">
			<tr>
				<td valign="middle" style="background-color: #404040; color: #ffffff;">
					<div style="padding-left: 10px; padding-bottom: 3px;"><strong>Conversation</strong></div>
				</td>
			</tr>
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0" width="100%" class="formFull" style="margin-top: 0px; padding:15px;" border="0">
						<?php 
						if(!empty($messages)){
							foreach($messages as $message) 
								{	
									$dec_message = $this->GibberishAES->dec($message['Inbox']['message'],Configure::read('hashKey'));
									if($message['Inbox']['to'] == $to) { $float = "lefty";	}else{	$float = "righty";	}
									
						if(!empty($dec_message))
						 {
							?>
						<tr>
							<td>
								<table cellpadding="0" cellspacing="0" width="60%" class="formFull <?php echo $float;?>" align="left" style="border-radius: 10px;max-width:60%;">
									<tr>
										<td style="padding:3px;">
											<p class="new"><?php echo $message['Inbox']['from_name'];?></p><br>
											<span class="msg"><?php echo strip_tags($dec_message);?></span><br>
											<!--  At: <?php echo $message['Inbox']['create_time'];?>-->
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php }	//end of not empty message
								 } // end of foreach loop
									} else {?>
						<tr>
							<td>
								Sorry, There is no any conversation of you..!!
							</td>
						</tr>
						<?php }?>
					</table>
				</td>
			</tr>
		</table>
