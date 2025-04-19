<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		 
	</title>
	<?php echo $this->Html->css('internal_style.css');?> 
	<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
	.heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:14px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.tabularForm td{background:none;}
	@media print {

  		#printButton{display:none;}
    }
    .bor_right{border-right:1px solid #000;}
    .border{border-top:1px solid #000 !important;border-bottom:1px solid #000 !important;}
</style> 
 
</head>
<body style="background:none;width:98%;margin:auto;">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-left:30px;" align="center" >
		  <tr>
			  <td colspan="4" align="right">
			  	<div id="printButton">
			  	<?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
			  	</div>
		 	 </td>
		  </tr>
		  <tr>  
	  		<td valign="top" colspan="13" style="text-align:center;" align="center">
	  			<h2><?php echo "Nurse Outstanding Report";?></h2>
	  		</td>
    	</tr>  
	</table>
	
	<div id="container">
		<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
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
						<?php $date = $data['Patient']['form_received_on']=$this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);
						echo $date;?>
					</td>
					<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
						<?php echo $finalTotalAmount;
						$totalRevenue +=  (double) $finalTotalAmount;?>
					</td>
					<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
						<?php echo  round($data['amount_discount']);
						$totalDiscount +=  (double)  round($data['amount_discount']);?>
					</td>
					<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
						<?php echo  round($data['amount_paid']);
						$totalPaidAmount +=  (double)  round($data['amount_paid']);?>
					</td>
					<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
						<?php echo $amountDue;
						$totalAmountDue +=  (double) $amountDue;?>
					</td>
					<td class ="<?php echo $bgclass;?>" style= "text-align: center;">
						<?php echo  round($data['card_balance']);
						$totalCardBalance +=  (double)  round($data['card_balance']);?>
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
	</body>
</html>