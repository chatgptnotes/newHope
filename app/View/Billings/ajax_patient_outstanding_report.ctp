<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
		<td width="100%" valign="top">
			<div id="container">
				<tr>
					<td style="float: right">
						<?php echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Nurse Outstanding Report')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Billings',
						'action'=>'patient_outstanding_report_print','?'=>array('ward_id'=>$wardId,'patient_id'=>$patientId,'is_print'=>'1')))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?>
					</td>
					
					<?php if($this->request->data){
						$qryStr=$this->request->data;
						}?>
					<td style="float: right">
						<?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Billings',
						'action'=>'ajax_patient_outstanding_report','excel','?'=>$qryStr,'admin'=>false),array('escape'=>false,'title' => 'Export To Excel'))?>
					</td>
					<td>
						<?php echo $this->Html->link($this->Html->image('icons/pdf.png'),array('controller'=>'Billings',
						'action'=>'ajax_patient_outstanding_report','pdf','?'=>$qryStr,'admin'=>false),array('escape'=>false,'title' => 'Export To PDF'))?>
					</td>
				</tr>
				<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
					<thead>
						<tr> 
							<th width="10%" align="center" valign="top" style="text-align: left;"><?php echo __('Ward/Bed No');?></th> 
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
						/*$totalSurgeryAmount = '';
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
						}*/
						 
					 	foreach ($patientDetails as $key=> $data){

							/*$patientTotal=''; 
							if(is_array($totalSurgeryAmount[$data['Patient']['id']])){
								$patientTotal = array_sum($totalSurgeryAmount[$data['Patient']['id']]);
							}*/

							$finalTotalAmount = round(array_sum($totalSurgeryAmount[$data['Patient']['id']])+$data['total_amount']);
							$finalTotalAmount = $data['total_amount'];
							$amountDue = round($finalTotalAmount-($data['amount_paid']+$data['amount_discount']));
							$payAmount = round($amountDue - $data['card_balance']);
							
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
								<?php echo $data['Patient']['lookup_name'];?>
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
							<?php $date = $data['Patient']['form_received_on']=$this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?>
								<?php echo $date;?>
							</td>
							<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
								<?php echo $finalTotalAmount;
								$totalRevenue +=  (double) $finalTotalAmount;?>
							</td>
							<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
								<?php echo round($data['amount_discount']);
								$totalDiscount +=  (double) round($data['amount_discount']);?>
							</td>
							<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
								<?php echo round($data['amount_paid']);
								$totalPaidAmount +=  (double) round($data['amount_paid']);?>
							</td>
							<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
								<?php echo $amountDue;
								$totalAmountDue +=  (double) $amountDue;?>
							</td>
							<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
								<?php echo round($data['card_balance']);
								$totalCardBalance +=  (double) round($data['card_balance']);?>
							</td>
							<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
								<?php echo $payAmount;
								$totalPayAmount +=  (double) $payAmount;?>
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