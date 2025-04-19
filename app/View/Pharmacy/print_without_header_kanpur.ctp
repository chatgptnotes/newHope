<style>

@media print {
    @page{
     size: 8.66in 5.55in;
     size: portrait;
   }
  
 }
</style>

<div>
     <table width='90%' align="center" height="133px" border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
       <tr>
       		<td></td>
       </tr>
     </table> 
</div>
	
	<?php
		$Person = Classregistry::init('Person');
		$person = $Person->find("first",array("conditions"=>array("Person.id"=>$data['Patient']['person_id'])));
 ?>
<table width='90%' align="center"  border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
<tr>
	<td width="90%" valign="top" style="border-right: 0px solid #333333; ">
	
	<table width="100%" > 
	
		<tr>
			<td align="left" class="" >
			<?php if( isset($data['Patient']['id'])){	?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" 	style="float: left">
					<tr> 
						<td width="130px" class="" style="text-align: left;font-size: 13px;"><?php echo "Doctor Name : "; ?></td>
						<td class="" style="font-size: 13px;"><?php  if(!empty($data['DoctorProfile']['doctor_name']))
													{
													 echo /* "Dr. ". */$data['DoctorProfile']['doctor_name']; 
													}
													 else
													{
														echo /* "Dr. ". */$doctorName['User']['first_name']." ".$doctorName['User']['last_name'];
														     
													}?></td> 
					</tr>
					<tr> 
						<td width="130" class="" style="text-align: left;font-size: 13px;"><?php echo "Patient Name : "; ?></td>
						<td class="" style="font-size: 13px;"><?php echo $data['Patient']['lookup_name'];?></td>
					</tr>
					<?php if($data['PharmacySalesBill']['by_nurse'] == 1){ ?>
					<tr>
						<td width = "50px"></td>
						<td width="130px" class="" style="text-align: left;font-size: 13px;"><?php echo __("Ward/Room Type: "); ?></td>
						<td></td>
						<td class="" style="font-size: 13px;"><?php echo $bedType['Room']['room_type'];?></td>
					</tr>
					
					<?php }?>
				</table>
			<?php }else{ ?>
			<?php if($section =='DirectSalesReturn'){
				$doctorName = $data['InventoryPharmacySalesReturn']['doctor_name'];
				$patient_name = $data['InventoryPharmacySalesReturn']['customer_name'];
			}else{
				$doctorName = $data['PharmacySalesBill']['p_doctname'];
				$patient_name = $data['PharmacySalesBill']['customer_name'];
			}
				?>
			<table width="90%" border="0" cellspacing="0" cellpadding="0" 	style="float: left">
					<tr> 
						<td width="130px" class="" style="text-align: left;font-size: 13px;"><?php echo "Doctor Name : "; ?></td>
						<td class="" style="font-size: 13px;"><?php echo  $doctorName ;?></td> 
					</tr>
					<tr> 
						<td width="130" class="" style="text-align: left;font-size: 13px;"><?php echo "Patient Name : "; ?></td>
						<td class="" style="font-size: 13px;"><?php echo $patient_name;?></td>
					</tr> 
				</table> 
			<?php
			}
			?>
		<!-- 	<table><tr><td height="15px"></td></tr></table> -->
			</td>
			<td align="right">
			<table width="100%" align="right" border="0" cellspacing="0" cellpadding="0" border="0">
				<tr>
				<?php  if(!empty($data['InventoryPharmacySalesReturn']['id'])){?>  
				     <td width="50%" style="text-align: right; font-size: 13px;"><?php  /* Sales Bill Receipt No. */
					    echo "Sales Return Receipt No."; 
						echo "&nbsp : &nbsp";
						echo $data['InventoryPharmacySalesReturn']['bill_code'];
					?>
				  <?php }else{?>
					<td style="text-align: right; font-size: 13px;"><?php  if($data['PharmacySalesBill']['payment_mode']=='Cash'){ /* Sales Bill Receipt No. */
					        echo "CASH MEMO NO."; 
					        echo "&nbsp : &nbsp";
					        if(!empty($data['PharmacyDuplicateSalesBill']['bill_code'])){
					        	echo $data['PharmacyDuplicateSalesBill']['bill_code'];
					        }else{
					            echo $data['PharmacySalesBill']['bill_code'];
					        }
					} else{
						    echo "CREDIT MEMO NO.";
						    echo "&nbsp : &nbsp";
						     if(!empty($data['PharmacyDuplicateSalesBill']['bill_code'])){
					        	echo $data['PharmacyDuplicateSalesBill']['bill_code'];
					        }else{
					            echo $data['PharmacySalesBill']['bill_code'];
					        }
					}?>
					</td> 
				<?php }?>
				</tr>
				<tr>	
				<?php  if(!empty($data['InventoryPharmacySalesReturn']['id'])){?>  
				   	<td class="lableFont" style="text-align: right;"><?php echo "Date"; 
						echo "&nbsp : &nbsp";
						if($data['InventoryPharmacySalesReturn']['create_time'])
						echo $this->DateFormat->formatDate2Local($data['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'),false);?></td>
					<?php }else{?>	
					<td style="text-align: right; font-size: 13px;"><?php 
					  echo "Date";
					  echo "&nbsp : &nbsp";
					  if(!empty($data['PharmacyDuplicateSalesBill']['create_time'])){
						echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format'),false);
					
					  }else{
					  if(!empty($data['PharmacySalesBill']['modified_time'])){
					 	echo $this->DateFormat->formatDate2Local($data['PharmacySalesBill']['modified_time'],Configure::read('date_format'),false);
					  }else{
					 	echo $this->DateFormat->formatDate2Local($data['PharmacySalesBill']['create_time'],Configure::read('date_format'),false);
					  }
					}
					?></td>
					<?php }?>
				</tr> 
				<?php if($data['PharmacySalesBill']['by_nurse'] == 1){ ?>
				<tr>
						<td class="" style="text-align: right;font-size: 13px;"><?php echo __("Bed No: "); 
						echo "&nbsp : &nbsp";
						echo $bedType['Bed']['bedno'];
						?></td>
				</tr>
				<?php }?>	
			</table> 
			</td>
		</tr>	
	</table>
	</td>
</tr>
</table>