<?php  if($this->Session->read('website.instance')=="kanpur" || $this->Session->read('website.instance')=="vadodara") 
   { ?>
	  <?php 
   
  //	$data= $data[0] ;
	$Person = Classregistry::init('Person');
	$person = $Person->find("first",array("conditions"=>array("Person.id"=>$data['Patient']['person_id'])));
 ?>

<tr>
	<td width="90%" valign="top" style="border-right: 0px solid #333333; ">
	
	<table width="90%">
<!-- 	   <tr>
	      <td height="35px"></td>
	   </tr> --> 
	
		<tr>
			<td width="45%" class="" >
			<?php if( isset($data['Patient']['id'])){	?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" 	style="float: left">
					<tr>
						<td width = "50px"></td>
						<td width="130px" class="" style="text-align: left;font-size: 13px;"><?php echo "Doctor Name : "; ?></td>
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
						<td width = "50px"></td>
						<td width="130" class="" style="text-align: left;font-size: 13px;"><?php echo "Patient Name : "; ?></td>
						<td></td>
						<td class="" style="font-size: 13px;"><?php echo $data['Patient']['lookup_name'];?></td>
					</tr>
					<?php if($this->Session->read('website.instance')=='vadodara'){?>
					<tr>
					    <td width = "50px"></td>
					    <td width="130" class="" style="text-align: left;font-size: 13px;"><?php echo "Patient Type : "; ?></td>
						<td></td>
						<td class="" style="font-size: 13px;"><?php echo $data['TariffStandard']['name'];?></td>
					</tr>
					<?php }?>
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
			<table width="90%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120">Patient Name : </td>
					<td width="10"></td>
					<td class="" style="font-size: 13px;"><?php echo $data['PharmacyDuplicateSalesBill']['customer_name'];?></td>

				</tr>
				<tr>
					<td width="120">Doctor Name : </td>
					<td width="10"></td>
					<td class="" style="font-size: 13px;"><?php echo $data['PharmacyDuplicateSalesBill']['p_doctname'];?></td>

				</tr>
				
			</table>
			<?php
			}
			?>
		<!-- 	<table><tr><td height="15px"></td></tr></table> -->
			</td>
			<td style="padding-left: 50px" class="" valign="top" width="45%">
			<table width="90%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" class="" style="text-align: left;font-size: 13px;"><?php  if(strtolower($data['PharmacyDuplicateSalesBill']['payment_mode'])== 'cash'){ /* Sales Bill Receipt No. */
					        echo "CASH MEMO NO."; }else{
						    echo "CREDIT MEMO NO.";
					}?></td>
					<td width="10%">:</td>
					<td class="" style="font-size: 13px;"><?php echo $data['PharmacyDuplicateSalesBill']['bill_code'];?></td>
				</tr>
				<tr>
					<td class="" style="text-align: left;font-size: 13px;"><?php echo "Date"; ?></td>
					<td>:</td>
					<td class="" style="font-size: 13px;"><?php 
					 if(!empty($data['PharmacyDuplicateSalesBill']['modified_time'])){
					 	echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['modified_time'],Configure::read('date_format'),false);
					 }else{
					 	echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format'),false);
					 }
					
					?></td>
				</tr>
					<?php if($this->Session->read('website.instance')=='vadodara' && isset($data['Patient']['id'])){?>
				<tr>
					<td width="50%" class="" style="text-align: left;font-size: 13px;"><?php  echo "Patient ID";
					      
					?></td>
					<td width="10%">:</td>
					<td class="" style="font-size: 13px;"><?php echo $data['Patient']['patient_id'];?></td>
				</tr>
				<?php }?>
				<?php if($data['PharmacyDuplicateSalesBill']['by_nurse'] == 1){ ?>
				<tr>
						<td width="50%" class="" style="text-align: left;font-size: 13px;"><?php echo __("Bed No: "); ?></td>
						<td>:</td>
						<td class="" style="font-size: 13px;"><?php echo $bedType['Bed']['bedno'];?></td>
					</tr>
				<?php }?>	
			</table>
	<!-- 		<table><tr><td height="15px"></td></tr></table> -->
			</td>
		</tr>	
	</table>
	</td>
</tr>
	
	
 <?php }else
   {
	?>
<?php
  	//$data= $data[0] ;
	$Person = Classregistry::init('Person');
	$person = $Person->find("first",array("conditions"=>array("Person.id"=>$data['Patient']['person_id'])));
 ?>

<tr>
	<td width="100%" valign="top" style="border-right: 0px solid #333333; padding: 0px;">
	<?php if( isset($data['Patient']['id'])){	?>
	<table width="100%">
		<tr>
			<td width="70%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="float: left">
				<tr>
					<td width="130px" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php echo "Dr. ".$data['DoctorProfile']['doctor_name'];?></td>
				</tr>
				<tr>
					<td width="130" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td></td>
					<td class="lableFont"><?php echo $data['Patient']['lookup_name'];?></td>
				</tr>
				<tr>
					<td width="130" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php echo $data['Patient']['city'];?></td>
				</tr>
				<?php
				if(!empty($address)){
					?>
				<tr>
					<td valign="top" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td valign="top"></td>
					<td class="lableFont"><?php echo $address;?></td>
				</tr>
				<?php
				}
				?>
			</table>
			<?php }else{ ?>
			<table width="100%">
				<tr>
					<td width="70%" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						style="float: left">
						<tr>
							<td width="130px" class="lableFont"><?php echo "$nbsp"; ?></td>
							<td width="10"></td>
							<td class="lableFont"><?php echo "Dr. ".$data['PharmacyDuplicateSalesBill']['p_doctname'];?></td>
						</tr>
						<tr>
							<td width="130" class="lableFont"><?php echo "$nbsp"; ?></td>
							<td></td>
							<td class="lableFont"><?php echo $data['PharmacyDuplicateSalesBill']['customer_name'];?></td>
						</tr>
						<tr>
							<td width="130" class="lableFont"><?php echo "$nbsp"; ?></td>
							<td width="10"></td>
							<td class="lableFont"><?php echo $data['Patient']['city'];?></td>
						</tr>
						<?php
						if(!empty($address)){
							?>
						<tr>
							<td valign="top" class="lableFont"><?php echo "$nbsp"; ?></td>
							<td valign="top"></td>
							<td class="lableFont"><?php echo $address;?></td>
						</tr>
						<?php
						}
						?>
					</table>
			
			<!-- commnted by pankaj w because its not working in hope
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="130px" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10">:</td>
					<td class="lableFont"><?php //echo $data['PharmacySalesBill']['customer_name'];?></td>

				</tr>
				<tr>
					<td width="120">Doctor Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php //echo $data['PharmacySalesBill']['p_doctname'];?></td>

				</tr>
			</table>  -->
			<?php
			}
			?></td>

			<td valign="top" style="padding: 2px 0px 2px 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="40" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php  echo ($data['PharmacyDuplicateSalesBill']['bill_code'])?$data['PharmacyDuplicateSalesBill']['bill_code']:$data['PharmacyDuplicateSalesBill']['bill_code'];?></td>
				</tr>
				<tr>
					<td class="lableFont"><?php echo "&nbsp"; ?></td>
					<td></td>
					<td class="lableFont"><?php 
				if($data['PharmacyDuplicateSalesBill']['modified_time']){
					echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['modified_time'],Configure::read('date_format'),true);
				}else if($data['PharmacyDuplicateSalesBill']['create_time'])
					echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format'),true);
			    else if($data['PharmacyDuplicateSalesBill']['create_time'])
					echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format'),true);
					?></td>
				</tr>
				<tr>
					<td class="lableFont"><?php echo "$nbsp"; ?></td>
					<td></td>
					<td class="lableFont"><?php 
						if($data['PharmacySalesBill']['payment_mode']){	
							echo ucfirst($data['PharmacyDuplicateSalesBill']['payment_mode']);
						}else{
							echo ucfirst($data['PharmacyDuplicateSalesBill']['payment_mode']);
						}
					?></td>
				</tr>

				<!--<?php //if(isset($data['PharmacySalesBill']['credit_period']) || isset($data['User']['username'])){ ?>
<tr>
<td width="70" class="lableFont"> Credit Days </td>
<td>:</td>
<td width="50" class="lableFont"><?php //echo $data['PharmacySalesBill']['credit_period']; ?></td>
</tr>
<tr>
<td width="67" class="lableFont">Guarantor </td>
<td>:</td>
<td width="35" class="lableFont"><?php //echo $data['User']['username'];?></td>
</tr>
<?php // }?>-->

			</table>
			</td>

		</tr>
	</table>
	</td>
</tr>
<?php }?>