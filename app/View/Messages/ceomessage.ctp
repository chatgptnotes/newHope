<?php echo $this->Html->script(array('jquery.tokeninput.js','aes.js')); ?>
<?php echo $this->Html->css(array('token-input.css','token-input-facebook.css')); ?>
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>

<script>
var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";
var encrypted = CryptoJS.AES.encrypt("Pawan", hashKey);//alert(encrypted);

	jQuery(document).ready(function(){
		jQuery("#ceomsgfrm").validationEngine();
	});
</script>

<style>

.form-data{
    background-color: transparent;
    border: 1px solid;
    height: 25px;
    font-size: 14px;
}
.box{
	 width: 97%;
	
}
.drop{
	width: 20%;
}
.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	
}
</style>

<div class="inner_title">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Message') ?>
	</h3>
</div>

<?php echo $this->Form->create('CeoMessage',array('id'=>'ceoForm')); ?>

<table width="100%"  cellspacing='0' cellpadding='0'>
	<tr> 
		<td class="td_second" valign="top">


<table cellpadding="0" cellspacing="0" width="100%" class="formFull" style="margin-top:25px;">
		<tr>
		<td> </td>
		<td>
			<?php 
	
			echo $this->Form->input('CeoMessage.msg_date', array('label'=>'Date','div'=>false,'type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-date]]',
				'value'=>!empty($message['0']['CeoMessage']['msg_date']),'style'=>'width: 118px;','readonly'=>'readonly', 'size'=>'20','id' => 'msgdate'));?>
		
		</td>
		</tr>
				<tr>
					<td width="6%" height="40px" valign="top" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;">Message</font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
					<?php echo $this->Form->textarea('message', array('class' => 'ckeditor validate[required,custom[mandatory-enter]]','id' => 'message'));
							  echo $this->Form->hidden("",array('name'=>"message_enc",'id'=>'message_enc','class'=>'blueBtn'));
						?>  
					</td>
				</tr>
			<tr>
					<td>
						
					</td>
					<td class="btn" valign="center" style="padding-left: 10px">
					<?php //echo $this->Form->submit(__("Send"),array('class'=>'blueBtn','div'=>false,'name'=>"Send"));?>
					
					<!--<button type="submit" id="send" value="Send" name="Send"><img src="../Themed/Black/webroot/img/send.png"/></button>-->
					<input class="blueBtn" type=submit id="Send" value="Send" name="Send"/> 
						 
						<?php 
							echo $this->Html->link('Cancel',array('controller'=>'Messages','action'=>'ceomessage'),array('class'=>'blueBtn'));
						?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end();?>
		</td>
	</tr>	
</table> 
<?php echo $this->Form->end(); ?>

<script>
	$(document).ready(function(){
			//var Editor2 = CKEDITOR.instances.message.getData(); 
		      jQuery("#ceoForm").validationEngine(); 


		      CKEDITOR.replace( 'message' );
        $("#ceoForm").submit( function(e) {
            var messageLength = CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                alert( 'Please enter a message' );
                e.preventDefault();
            }
        });

			<?php if(!empty($is_refill)) { ?>
			   setTimeout(function(){

				   var Editor2 = CKEDITOR.instances.message.getData() ;
				   seperator ="<p></p><p>---------- Forwarded message ----------</p><P></p>";
				   	CKEDITOR.instances.message.setData(seperator+$("#printLetter").html()+Editor2); 
				   }, 1000);

			   <?php } ?>
		});
				 
$(function() {
	
	$( "#send_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	});

});
$("#msgdate").datepicker({
	showOn : "both",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	buttonText: "Calendar",
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
	}
});





</script>

