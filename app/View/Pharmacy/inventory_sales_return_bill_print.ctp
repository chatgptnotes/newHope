
  <?php
	$Person = Classregistry::init('Person');
	$person = $Person->find("first",array("conditions"=>array("Person.id"=>$data['Patient']['person_id'])));
 ?>
<?php  if($this->Session->read('website.instance')=="kanpur" || $this->Session->read('website.instance')=="vadodara" ) 
   {  ?>
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
					<td class="lableFont"><?php echo "Dr. ".$data['DoctorProfile']['doctor_name'];?></td>
				</tr>
				<tr>
					<td width="130" class="lableFont" style="text-align: right;"><?php echo "Patient Name : "; ?></td>
					<td></td>
					<td class="lableFont"><?php echo $data['Patient']['lookup_name'];?></td>
				</tr>
				<?php if($this->Session->read('website.instance')=='vadodara'){?>
					<tr>
					    <td width="130" class="lableFont" style="text-align: right;"><?php echo "Patient Type : "; ?></td>
						<td></td>
						<td class="lableFont" ><?php echo $data['TariffStandard']['name'];?></td>
					</tr>
				<?php }?>
			<!-- 	<tr>
					<td width="130" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php echo $data['Patient']['city'];?></td>
				</tr> -->
				<?php
				if(!empty($address)){
					?>
		<!-- 		<tr>
					<td valign="top" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td valign="top"></td>
					<td class="lableFont"><?php echo $address;?></td>
				</tr> -->
				<?php
				}
				?>
			</table>
			<?php }else{ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120">Customer Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo $data['InventoryPharmacySalesReturn']['customer_name'];?></td>

				</tr>
				<tr>
					<td width="120">Doctor Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo "Dr. ".$data['DoctorProfile']['doctor_name'];?></td>

				</tr>
			</table>
			<?php
			}
			?></td>

			<td valign="top" style="padding: 2px 0px 2px 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="42%" class="lableFont" style="text-align: left;"><?php echo "Sales Return Receipt No."; ?></td>
					<td width="">:</td>
					<td class="lableFont"><?php echo $data['InventoryPharmacySalesReturn']['id'];?></td>
				</tr>
				<tr>
					<td class="lableFont" style="text-align: left;"><?php echo "Date"; ?></td>
					<td>:</td>
					<td class="lableFont"><?php if($data['InventoryPharmacySalesReturn']['create_time'])
					echo $this->DateFormat->formatDate2Local($data['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'),true);
					?></td>
				</tr>
				<?php if($this->Session->read('website.instance')=='vadodara' && isset($data['Patient']['id'])){?>
				<tr>
					<td width="40%" class="lableFont" style="text-align: left;"><?php  echo "Patient ID";
					      
					?></td>
					<td width="10%">:</td>
					<td class="lableFont" style=""><?php echo $data['Patient']['patient_id'];?></td>
				</tr>
				<?php }?>
			<!-- 	<tr>
					<td class="lableFont"><?php echo "$nbsp"; ?></td>
					<td></td>
					<td class="lableFont"><?php echo ucfirst("Debit");//ucfirst($data['InventoryPharmacySalesReturn']['payment_mode']);?></td>
				</tr> -->

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
<?php }else 
        {?>
		<tr>
	<td width="100%" valign="top" style="border-right: 0px solid #333333; padding: 8px 5px;">
	<?php if( isset($data['Patient']['id'])){	?>
	<table width="100%">
		<tr>
			<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="float: left">
				<tr>
					<td width="130px" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php //echo "Dr. ".$data['Doctor']['first_name']." ".$data['Doctor']['last_name'];?></td>
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120">Customer Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo $data['InventoryPharmacySalesReturn']['customer_name'];?></td>

				</tr>
				<tr>
					<td width="120">Docter Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo $data['InventoryPharmacySalesReturn']['p_doctname'];?></td>

				</tr>
			</table>
			<?php
			}
			?></td>

			<td valign="top" style="padding: 2px 0px 2px 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="40" class="lableFont"><?php echo "$nbsp"; ?></td>
					<td width="10"></td>
					<td class="lableFont"><?php echo $data['InventoryPharmacySalesReturn']['bill_code'];?></td>
				</tr>
				<tr>
					<td class="lableFont"><?php echo "&nbsp"; ?></td>
					<td></td>
					<td class="lableFont"><?php if($data['InventoryPharmacySalesReturn']['create_time'])
					echo $this->DateFormat->formatDate2Local($data['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'),true);
					?></td>
				</tr>
				<tr>
					<td class="lableFont"><?php echo "$nbsp"; ?></td>
					<td></td>
					<td class="lableFont"><?php echo ucfirst("Debit");//ucfirst($data['InventoryPharmacySalesReturn']['payment_mode']);?></td>
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

<!-- commented code by Swapnil G.Sharma
<tr>
	<td width="100%">
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		class="prescribeDetail">
		<tr>
			<td width="60%" valign="top"
				style="border-right: 1px solid #333333; padding: 2px 5px;"><?php
				if( isset($data['Patient']['id'])){
					?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>
					<td width="120" class="lableFont">Patient's Name</td>
					<td>:</td>
					<td class="lableFont"><?php echo $data['Patient']['lookup_name'];?></td>
				</tr>
				<tr>
					<td width="120" class="lableFont">Patient ID</td>
					<td>:</td>
					<td class="lableFont"><?php echo $data['Patient']['patient_id'];?></td>
				</tr>
				<?php
				if(!empty($address)){
					?>
				<tr>
					<td valign="top" class="lableFont">Address</td>
					<td valign="top">:</td>
					<td class="lableFont"><?php echo $address;?></td>
				</tr>
				<?php
				}
				?>
			</table>
			<?php }else{ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120" class="lableFont">Customer Name</td>
					<td width="10">:</td>
					<td class="lableFont"><?php echo $data['InventoryPharmacySalesReturn']['customer_name'];?></td>

				</tr>
			</table>

			<?php
			}
			?></td>
			<td valign="top" style="padding: 2px 5px 2px 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>

					<td class="lableFont">Return Date</td>
					<td>:</td>
					<td class="lableFont"><?php echo $this->DateFormat->formatDate2Local($data['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'));?></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</td>
</tr>
-->