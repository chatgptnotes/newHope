<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		 background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
.idPatient:hover{
		cursor: pointer;
		}

</style>

<div class="inner_title">
	<h3>
		<?php echo __('Update OT Charges', true); ?>
	</h3>
</div> 
<?php echo $this->Form->create(''); ?>
<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="20%" align="center" valign="top" style="text-align: center; ">Surgery Services</th>
						<th width="20%" align="center" valign="top" style="text-align: center; ">Category</th>
						<th width="20%" align="center" valign="top" style="text-align: center; ">Doctor</th>
						<th width="15%" align="center" valign="top" style="text-align: center; ">Rate</th> 
						<!-- <th width="10%" align="center" valign="top" style="text-align: center; ">Unit</th>  
						<th width="15%" align="center" valign="top" style="text-align: center; ">Amount</th> -->
						
					</tr> 
				</thead>
				<tbody>
					<?php $count = 0; foreach ($surgService as $key=>$val){ $cnt = $count++; ?>
						<tr>
							<td class="tdLabel" style="text-align: center;">
								<?php echo $val['TariffList']['name'];
									echo $this->Form->hidden('',array('name'=>"data[OptAppointment][$cnt][id]",'value'=>$val['OptAppointment']['id']));
								?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php echo $val['ServiceCategory']['name'];?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php echo $val['DoctorProfile']['doctor_name']/* ." (".$userType.")" */;?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php $cost = !empty($val['OptAppointment']['surgery_cost'])?$val['OptAppointment']['surgery_cost']:0;	 ?>
								<?php echo $this->Form->input('', array('name'=>"data[OptAppointment][$cnt][surgery_cost]",'type'=>'text','class' => 'textBoxExpnd rates validInput','id'=>'rate_'.$cnt,'readonly' => false,
										'label'=> false,'div' => false, 'error' => false,'autocomplete'=>'off' ,'value'=>$cost,'amount'=>$cost));?></td>
						</tr>
						<?php }?>
						 
						<tr>
							<td class="tdLabel" style="text-align: center;">
								<?php $cnt = ($cnt+1); echo $anaesthesiaService['AnaeTariffList']['name'];
									echo $this->Form->hidden('',array('name'=>"data[OptAppointment][$cnt][id]",'value'=>$val['OptAppointment']['id']));
								 ?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php echo "Anaeshthesia";?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php echo $anaesthesiaService['Anaesthesist']['doctor_name'] ;?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php $anaescost = !empty($anaesthesiaService['OptAppointment']['anaesthesia_cost'])?$anaesthesiaService['OptAppointment']['anaesthesia_cost']:0;?>
								<?php echo $this->Form->input('', array('name'=>"data[OptAppointment][$cnt][anaesthesia_cost]",'type'=>'text','class' => 'textBoxExpnd rates validInput','id'=>'rate_'.$cnt,'readonly' => false,
										'label'=> false,'div' => false, 'error' => false,'autocomplete'=>'off' ,'value'=>$anaescost,'amount'=>$anaescost));?></td>
						</tr>	
						
						<tr>
							<td class="tdLabel" style="text-align: center;">
								<?php $cnt = ($cnt+1); echo $this->Form->hidden('',array('name'=>"data[OptAppointment][$cnt][id]",'value'=>$val['OptAppointment']['id']));
								 ?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php echo "OT Charges";?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php //echo $anaesthesiaService['Anaesthesist']['doctor_name'] ;?></td>
							<td class="tdLabel" style="text-align: center;">
								<?php $otcost = !empty($anaesthesiaService['OptAppointment']['ot_charges'])?$anaesthesiaService['OptAppointment']['ot_charges']:0; 
								?>
								<?php echo $this->Form->input('', array('name'=>"data[OptAppointment][$cnt][ot_charges]",'type'=>'text','class' => 'textBoxExpnd rates validInput','id'=>'rate_'.$cnt,'readonly' => false,
										'label'=> false,'div' => false, 'error' => false,'autocomplete'=>'off' ,'value'=>$otcost,'amount'=>$otcost));?></td>
						</tr>	 
				</tbody>
			</table>
						<div class="btns">
							<?php echo $this->Form->submit(__('Save'), array('class'=>'blueBtn','div'=>false,'id'=>'saveButt')); ?>
				
						</div>
		</div>
<?php echo $this->Form->end();?>
<script>
	$(".noOfTimes").keyup(function(){
		var id = $(this).attr('id');
		var count = id.split("_")[1];
		var noOfTime = parseInt($("#noOfTimes_"+count).val()!=''?$("#noOfTimes_"+count).val():0);
		var rate = parseInt($("#rate_"+count).val()!=''?$("#rate_"+count).val():0);
		var amount = noOfTime * rate;
		$("#totAmnt_"+count).val(amount);
	});

	$(document).on('input',".rates",function() { 
		if (/[^0-9\.]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9\.]/g,'');
	    }
	    if(this.value.split('.').length>2) 
		this.value =this.value.replace(/\.+$/,"");

	});
	var flagAlert=false;
	$(document).on('change','.validInput',function(){
		var thisAmount = $(this).attr('amount');
		if(thisAmount > $(this).val()){
			alert("Charges must be greater than current charges.");
			flagAlert=true;	
		}else{
			flagAlert=false;
		}
	});

	$("#saveButt").click(function(){
		if(flagAlert){
			alert("Charges must be greater than current charges.");
			return false;
		}
		parent.window.isCompleted = true;
	});

	
</script>