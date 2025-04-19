<style>
body{
font-size:13px;
}
.green {
    color: seagreen;
    font-size: 19px;
}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		background: none repeat scroll 0 0 #fff ;
	    color: #000 ;
	    font-size: 13px;
	    padding: 3px 8px;
	}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Nurse Outstanding Report', true); ?>
	</h3>
</div> 
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
				<td align="center"><strong><?php echo __('Ward');?></strong></td>
				<td>
					<?php echo $this->Form->input("Ward.type",array('class'=>'ward','id'=>"ward_type",'type'=>'select','label'=>false,
						'options'=>array($wardList),'empty'=>'Please Select'));?>
				</td>
				<td align="center"><strong><?php echo __('Patient Name');?></strong></td>
				<td>
					<?php echo $this->Form->input('Patient.name',array('id'=>'patient','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off',
					'class' => 'validate[required,custom[mandatory-enter]]','style'=>"width:230px"));
					echo $this->Form->hidden('Patient.patient_id',array('id'=>'patient_id'));?>
				</td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn search','label'=> false, 'div' => false));?></td>
				<td>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Billings',
					'action'=>'patient_outstanding_report'),array('escape'=>false));?>
				</td>
				<div style="float:right;">
					<?php echo $this->Html->link(__('Back'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
				</div>
				<div style="float:right; margin-right: 25px;" class="green">
					<b><?php echo __('Total IP :'); echo $count;?></b>
				</div>
			</tr>
		</table>

		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="5%" align="center" valign="top" style="text-align: left;"><?php echo __('Ward/Bed No');?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient ID');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient Name');?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient Type');?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Mobile No');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Consultant');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Admission Date');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Bill Amount');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Discount Amount');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Amount Paid');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Amount Due');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Pay Card');?></th>
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Pay Amount');?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php 
					$totalSurgeryAmount = '';
					$cardiologist='';
					$asstSurgeonTwoCharge='';
					$asstSurgeonOneCharge='';
					$anaesthesiaCost=''; 
					 
					foreach($surgeryDetails as $key => $surgeryData){ 
						foreach($surgeryData as $key => $surgery){ 
							if($surgery['start'] !='' && is_array($surgery)) {
								 
								$anaesthesiaCost = ($surgery['anaesthesist'] != '') ? $surgery['anaesthesist_cost'] : 0;
								$asstSurgeonOneCharge = ($surgery['asst_surgeon_one'] != '') ? $surgery['asst_surgeon_one_charge'] : 0;
								$asstSurgeonTwoCharge = ($surgery['asst_surgeon_two'] != '') ? $surgery['asst_surgeon_two_charge'] : 0;
								$cardiologist = ($surgery['cardiologist'] != '') ? $surgery['cardiologist_charge'] : 0;
								$totalSurgeryAmount[$surgeryData['patient_id']][] = $surgery['cost'] + $anaesthesiaCost + $surgery['ot_charges'] + $surgery['surgeon_cost'] + $asstSurgeonOneCharge +
								$asstSurgeonTwoCharge + $cardiologist + $surgery['ot_assistant'] + $surgery['extra_hour_charge'] + array_sum($surgery['ot_extra_services']) ;
							}
						}
					}
					 
				 	foreach ($patientDetails as $key=> $data){
						$patientTotal=''; 
						if(is_array($totalSurgeryAmount[$data['Patient']['id']])){
							$patientTotal = array_sum($totalSurgeryAmount[$data['Patient']['id']]);
						}
						$finalTotalAmount = round(array_sum($totalSurgeryAmount[$data['Patient']['id']])+$data['total_amount']);
						$amountDue =  round($finalTotalAmount-($data['amount_paid']+$data['amount_discount']));
						$payAmount =  round($amountDue - $data['card_balance']);
						
						if($payAmount>'0'){
							$bgclass='pending_payment';
						}else{
							$bgclass='';
						}
					?> 
					
					<tr>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['Ward']['name']."/".$data['Room']['bed_prefix'].$data['Bed']['bedno'];?>
						</td>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['Patient']['patient_id'];?>
						</td>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['Patient']['lookup_name']." (".$data['Patient']['admission_id'].")";?>
						</td>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['TariffStandard']['name'];?>
						</td>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['Person']['mobile'];?>
						</td>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['DoctorProfile']['doctor_name'];?>
						</td>
						<td class ="<?php echo $bgclass;?>" align="left" valign="top" style= "text-align: left;">
							<?php echo $data['Patient']['form_received_on'];?>
						</td>
						<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
							<?php echo $finalTotalAmount;
							$totalRevenue +=  (int) $finalTotalAmount;?>
						</td>
						<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
							<?php echo  round($data['amount_discount']);
							$totalDiscount +=  (int)  round($data['amount_discount']);?>
						</td>
						<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
							<?php echo  round($data['amount_paid']);
							$totalPaidAmount +=  (int)  round($data['amount_paid']);?>
						</td>
						<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
							<?php echo $amountDue;
							$totalAmountDue +=  (int) $amountDue;?>
						</td>
						<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
							<?php echo  round($data['card_balance']);
							$totalCardBalance +=  (int)  round($data['card_balance']);?>
						</td>
						<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
							<?php echo $payAmount;
							$totalPayAmount +=  (int) $payAmount;?>
						</td>
				  	</tr>
				<?php } ?>
				</tbody>
					<tr>
						<td class="tdLabel" colspan="7" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
						<?php
						if(empty($totalRevenue)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(" ");?></td></b></font><?php
							}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRevenue)?></b></font></td>
						<?php } 
						if(empty($totalDiscount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(" ");?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalDiscount)?></b></font></td>
						<?php } 
						if(empty($totalPaidAmount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(" ");?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalPaidAmount)?></b></font></td>
						<?php } 
						if(empty($totalAmountDue)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(" ");?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalAmountDue)?></b></font></td>
						<?php } 
						if(empty($totalCardBalance)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(" ");?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalCardBalance)?></b></font></td>
						<?php } 
						if(empty($totalPayAmount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(" ");?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalPayAmount)?></b></font></td>
						<?php } ?>
					</tr>  
			<?php echo $this->Form->end();?>
				</table>
			</div>
		</td>
	</tr>
</table>

<script>
$(document).ready(function(){
	$(".ward").change(function(){
		 var id = ($(this).val()) ? $(this).val() : 'null' ;
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "ajax_patient_outstanding_report", "admin" => false));?>";
			$.ajax({
			type:'POST',
			data: 'ward_id=' + id,
			url : ajaxUrl,
			beforeSend:function(data){
			$('#busy-indicator').show();
			},
			success: function(data){
				$("#container").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}
		 });
	 });

	$(".search").click(function(){
		 var id = ($("#patient_id").val()) ? $("#patient_id").val() : 'null' ;
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "ajax_patient_outstanding_report", "admin" => false));?>";
			$.ajax({
			type:'POST',
			data: 'patient_id=' + id,
			url : ajaxUrl,
			beforeSend:function(data){
			$('#busy-indicator').show();
			},
			success: function(data){
				$("#container").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}
		 });
	 });
	
	$("#patient").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","admission_id","inventory" => true,"plugin"=>false)); ?>",
		 minLength: 1, 
		 select: function( event, ui ) {
			$('#patient_id').val(ui.item.id);
		},
			messages: {
		        noResults: '',
		        results: function() {}
		 }	
	});
	jQuery("#voucher").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});	

	
});
</script>