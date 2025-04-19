<style>.row_action img{float:inherit;}
.new{float:left; text-align:center; margin-left:28px;}
</style>
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3.js'));
echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
//'datePicker.css',
?>
</head>
<body>
<br/>
<br/>
<br/>
<?php if(isset($success) && !empty($success)){?>
	<script>
		var patId = "<?php echo $this->params->query['clickedId']; ?>" ;
		$('.cred_'+patId,parent.document).attr('src','../theme/Black/img/icons/green.png');   // for changing the icon of parent window field
	</script>
	<?php }
if(isset($status) && !empty($status)){?>
<?php if($status == 'status'){?>
<div  align="center">Username:<?php echo $username;?></div>
<div align="center">Password:<?php echo $password;?></div>
<div class="message" id="message" align="center"><?php echo $message;?></div>
<?php }else{  ?>
<script>
	$(function(){
		parent.$.fancybox.close();	
		});
</script>
<?php }?>
<?php }else{?>
<?php echo $this->Form->create('Person',array('type' => 'file','id'=>'Person','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			?>
			
			<table width="95%" border="0" cellspacing="0" cellpadding="0"
	class="formFull new">
	<tr>
		<th colspan="4"><?php echo __("Create Patient Credentials") ; ?></th>
	</tr>
	<tr>
		<td width="6%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Email Id");?><font color='red'>*</font>
		</td>
		
		<td width="41%" valign="middle" class="row_action" id="boxspace"><?php 
		echo $this->Form->input('email_id', array('type'=>'text','label'=>false,'class'=>'textBoxExpnd','id' => 'email_id','value'=>$person_data['Person']['person_email_address'])); ?>
		</td><td></td>
	</tr>
	<tr>
		<td width="20%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date");?><font color='red'>*</font>
		</td>
		<td  align="left" valign="middle" class=row_action id="boxspace"><?php
		$date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		 echo $this->Form->input('patient_credentials_created_date', array('type'=>'text', 'class'=>'textBoxExpnd','readonly'=>'readonly',
				'label'=>false,'id' => 'patient_credentials_created','value'=>$date)); ?>
		</td>
	</tr>
	
	<tr>
		<td width="20%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Declined");?>
		</td>
		<?php $checked = (!is_null($person_data['Person']['decline_portal'])) ? true : false;?>
		<td  align="left" valign="middle" class=row_action id="boxspace"><?php echo $this->Form->checkbox('',array('name'=>'declined','id'=>'declined','value'=>'','class'=>'declined','checked'=>$checked));?>
		</td>
	</tr>
	
	
</table>
<?php echo $this->Form->hidden('id',array('value'=>$person_data['Person']['id'],'id' => 'id'));
echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id' => 'patient_id'));
	

?>
		<input class="blueBtn" type=submit value="Submit" name="Send" id="send" style="margin: 15px 0 0 27px;" >
<?php echo $this->Form->end();?>
<?php }?>
</body>

<script>
//jQuery(document).ready(function() {alert($("namespace_id").val());
$('#declined').click(function(){
	 $('#email_id').val('');	
		$('#patient_credentials_created').val('');
/*	personid="<?php echo $person_data['Person']['id']?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "declinePortal","admin" => false)); ?>";
    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+personid,
     //data: formData,
     dataType: 'html',
     success: function(data){    
    //	 parent.$.fancybox.close();
     },
	 error: function(message){
        alert(message);
     }        
   });*/
	
});
$('#send').click(function() {
	/*if($('#declined').prop('checked')){
		
	}else{*/

		if($('#declined').attr('checked')){
		}else{
			if($('#patient_credentials_created').val()==''){
				alert('Please fill Date');
				return false;
			}
			if($('#email_id').val()==''){
				alert('Please fill email');
				return false;
			}		
	}
	});
		
$(function() { 
			$( "#patient_credentials_created" ).datepicker({
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

function changeImage(){
	var patId = <?php echo $this->params->query['clickedId'];?>;	
	$('.cred_'+patId,parent.document).attr('src','../theme/Black/img/icons/green.png');
	
}
</script>