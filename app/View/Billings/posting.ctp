<style>
#singleScreen{
 width: 100%;
}
#singleScreen th{
	font-size: 10px;
}
input{
	width: 30px;
}
.staticFields{
	background-color:gray;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Posting', true); ?>
	</h3>
	<span></span>
</div>

<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<table  id="singleScreen">
<tr style="height:20px;">
<th><?php echo __("DateFrom");?></th>
<th><?php echo __("Procedure");?></th>
<th><?php echo __("Mod");?></th>
<th><?php echo __("Qty");?></th>
<th><?php echo __("Amount");?></th>
<th><?php echo __("Pay");?></th>
<th><?php echo __("Cy");?></th>
<th><?php echo __("Diag1");?></th>
<th><?php echo __("Diag2");?></th>
<th><?php echo __("Diag3");?></th>
<th><?php echo __("Diag4");?></th>
<th><?php echo __("Prov");?></th>
<th><?php echo __("Prov Name");?></th>
<th><?php echo __("Ref Phy");?></th>
<th><?php echo __("Ref Name");?></th>
<th><?php echo __("2Ref Phy");?></th>
<th><?php echo __("2Ref Name");?></th>
<th><?php echo __("PLC");?></th>
<th><?php echo __("Place Name");?></th>
<th><?php echo __("Dep");?></th>
<th><?php echo __("InsFlag");?></th>
<th><?php echo __("Reference");?></th>
<th><?php echo __("Ins Msg");?></th>
<th><?php echo __("Authorization");?></th>
<th><?php echo __("Cas");?></th>
<th><?php echo __("Cost");?></th>
</tr>

<tr>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][service_date_time]','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd serice_date_picker','label'=>false,'type'=>'text','id'=>'service_date_time'));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][cbt]','class'=>'searchCDM staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][modifier]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][quantity]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][amount]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][pay]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][cy]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][diagnosis1]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][diagnosis2]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][diagnosis3]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][diagnosis4]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][doctor_id]','name'=>'data[Billing][][provider]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][doctor_name]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][refering_physician_id]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][refering_physician_name]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][refering_physician_id_2]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][refering_physician_name_2]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][place]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][place_name]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][department_id]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][ins_flag]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][reference]','class'=>'staticFields','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][ins_msg]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][authorization]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][cash]','class'=>'','label'=>false,'type'=>'text',));?></td>
<td><?php echo $this->Form->input('',array('name'=>'data[Billing][][cost]','class'=>'','label'=>false,'type'=>'text',));?></td>


</tr>

</table>


<script>
var lastCBTCode = '';
var _this = undefined;
var timeoutReference = '';
var tariffStandardId = "<?php echo $tariffStandardId;?>";
var calling_url = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCDMServiceDetails",$patientId,$tariffStandardId,"admin" => false)); ?>" ;
$(function() {
			

			$( ".service_date_picker" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  	
				
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
function geCDMDetails(){
	var cbtCode = $(_this).val();alert(cbtCode);
	if(httpRequest) httpRequest.abort();
	
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  
			  },
		      url: calling_url+"/"+cbtCode,
		      context: document.body,
		      success: function(data){ 
		    	  
			  },
			  error:function(){
					alert('Please try again');
					
				  }
		});
	
		lastCBTCode = cbtCode;
}
		
$(function() {
	$('.searchCDM').live('keyup',function() { 
		
		_this = this; // copy of this object for further usage
	    
	    if (timeoutReference) clearTimeout(timeoutReference);
	    timeoutReference = setTimeout(function() {
	    	geCDMDetails()
	    }, 2000);
	});
	});

</script>