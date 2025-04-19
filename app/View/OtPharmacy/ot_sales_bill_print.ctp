 <?php 
 	//$data= $data[0] ;
	$Person = Classregistry::init('Person');
	$person = $Person->find("first",array("conditions"=>array("Person.id"=>$data['Patient']['person_id'])));
 ?>

<tr>
	<td width="90%" valign="top" style="border-right: 0px solid #333333; ">
	
	<table width="90%">
		<tr>
			<td width="45%" class="" >
			<?php if( isset($data['Patient']['id'])){	?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" 	style="float: left">
					<tr>
						<td width="130px" class="" style="text-align: right;font-size: 13px;"><?php echo "Doctor Name : "; ?></td>
						<td width="10"></td>
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
						<td width="130" class="" style="text-align: right;font-size: 13px;"><?php echo "Patient Name : "; ?></td>
						<td></td>
						<td class="" style="font-size: 13px;"><?php echo $data['Patient']['lookup_name'];?></td>
					</tr>
					
				</table>
			<?php }else{ ?>
			<table width="90%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120">Customer Name : </td>
					<td width="10"></td>
					<td class="" style="font-size: 13px;"><?php echo $data['OtPharmacySalesBill']['customer_name'];?></td>

				</tr>
				<tr>
					<td width="120">Doctor Name : </td>
					<td width="10"></td>
					<td class="" style="font-size: 13px;"><?php echo $data['OtPharmacySalesBill']['p_doctname'];?></td>

				</tr>
				
			</table>
			<?php
			}
			?>
		</td>
		<td style="padding-left: 50px" class="" valign="top" width="45%">

			<table width="90%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" class="" style="text-align: left;font-size: 13px;"><?php echo /* Sales Bill Receipt No. */"CREDIT MEMO NO."; ?></td>
					<td width="10%">:</td>
					<td class="" style="font-size: 13px;"><?php echo $data['OtPharmacySalesBill']['bill_code'];?></td>
				</tr>
				<tr>
					<td class="" style="text-align: left;font-size: 13px;"><?php echo "Date"; ?></td>
					<td>:</td>
					<td class="" style="font-size: 13px;"><?php 
					 if(!empty($data['OtPharmacySalesBill']['modified_time'])){
					 	echo $this->DateFormat->formatDate2Local($data['OtPharmacySalesBill']['modified_time'],Configure::read('date_format'),false);
					 }else{
					 	echo $this->DateFormat->formatDate2Local($data['OtPharmacySalesBill']['created_time'],Configure::read('date_format'),false);
					 }
					
					?></td>
				</tr>
			</table>
	
			</td>
		</tr>	
	</table>
	</td>
</tr>
	