
  <?php
	$Person = Classregistry::init('Person');
	$person = $Person->find("first",array("conditions"=>array("Person.id"=>$data['Patient']['person_id'])));
 ?>

<tr>
	<td width="100%" valign="top" style="border-right: 0px solid #333333; padding: 8px 5px;">
	
	<table width="100%">
		<tr>
			<td>
			<?php if( isset($data['Patient']['id'])){	?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="float: left">
				<tr>
					<td width="130px" class="lableFont" style="text-align: right;"><?php echo "Doctor Name : "; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php echo /* "Dr. ". */$data['DoctorProfile']['doctor_name'];?></td>
				</tr>
				<tr>
					<td width="130" class="lableFont" style="text-align: right;"><?php echo "Patient Name : "; ?></td>
					<td></td>
					<td class="lableFont"><?php echo $data['Patient']['lookup_name'];?></td>
				</tr>
			
				<?php
				if(!empty($address)){
					?>
		
				<?php
				}
				?>
			</table>
			<?php }else{ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120">Customer Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo $data['OtPharmacySalesReturn']['customer_name'];?></td>

				</tr>
				<tr>
					<td width="120">Doctor Name</td>
					<td width="10">:</td>
					<td class="lableFont">
					<?php if(!empty($data['DoctorProfile']['doctor_name']))
										{
										 echo /* "Dr. ". */$data['DoctorProfile']['doctor_name']; 
										}
										 else
										{
											echo /* "Dr. ". */$doctorName['User']['first_name']." ".$doctorName['User']['last_name'];
											     
										}?>
				</td>

				</tr>
			</table>
			<?php
			}
			?></td>

			<td valign="top" style="padding: 2px 0px 2px 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="165" class="lableFont" style="text-align: left;"><?php echo "Sales Return Receipt No."; ?></td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo $data['OtPharmacySalesReturn']['id'];?></td>
				</tr>
				<tr>
					<td class="lableFont" style="text-align: left;"><?php echo "Date"; ?></td>
					<td>:</td>
					<td class="lableFont"><?php if($data['OtPharmacySalesReturn']['created_time'])
					echo $this->DateFormat->formatDate2Local($data['OtPharmacySalesReturn']['created_time'],Configure::read('date_format'),true);
					?></td>
				</tr>

			</table>
			</td>

		</tr>
	</table>
	</td>
</tr>
</html>
