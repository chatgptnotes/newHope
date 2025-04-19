<?php 
	echo $this->Html->css(array('internal_style'));
	//pr($billingData) ;
?>  
<div class="inner_title">
	<h3>
		<?php echo __('Payment Voucher-'.$patientData['Patient']['lookup_name'], true); ?>
	</h3>
</div> 
<div class="clr">&nbsp;</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
			         echo $errorsval[0];
			         echo "<br />";
			     }     
			     ?>
		</div>
		</td>
	</tr>
</table>
<?php }  
echo $this->Form->create('accounting', array('url'=>array('controller'=>'Accounting','action'=>'updateNarration',$billingData['Billing']['id']),'id'=>'Complaintfrm','inputDefaults' => array(
															        'label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
?>
<table width="100%" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td>Payment Voucher No. <?php echo $billingData['Billing']['id'] ?></td>
		<td><?php echo $hospital ?></td>
		<td></td>
	</tr>
	<tr>
		<td>Account: <?php echo $patientData['Patient']['lookup_name'] ?></td>
		<td>Current Balance: <?php  echo $getIpdServices[0][0]['charges']-$billingData['Billing']['amount'] ;  ?></td>
		<td>Date: <?php echo $patientData['Patient']['form_received_on'] ; ?></br>
		Day: <?php echo date('l', strtotime($patientData['Patient']['form_received_on']));?></td>
		
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
	<tr> 
		<th width="100" align="center" valign="top" style="text-align: left;;">Perticulars</th>
		<th width="150" align="center" valign="top" style="text-align: center; min-width: 150px;">Amount</th> 
	</tr> 
	<tr>
		<td>
			<table>
				<tr>
					<td align="left" valign="top" style= "text-align: left;"  >
						<?php echo $patientData['Patient']['lookup_name'] ;?>
					</td> 
				</tr>
				<tr>
					<td valign="top" style= "text-align: left;;">
						Current Balance <?php echo $getIpdServices[0][0]['charges']-$billingData['Billing']['amount'] ;  ?>
						
					</td> 
				</tr>
				
				<tr>
					<td valign="top" style= "text-align: left;"><i>
						<?php echo $billingData['Billing']['narration'] ;?></i>
					</td> 
				</tr>
			</table>
		</td>
		<td style= "text-align: center;">
			<?php echo $billingData['Billing']['amount'] ;?>
		</td>
	</tr>
	
	
	
	<!--  <tr>
		<td ></td>
		<td >
			<table width="100%">
				<tr>
					<td style="text-align:right;"> Opening Balance:</td>
					<td style="text-align:right;"> <?php echo $getIpdServices[0][0]['charges']  ; ?></td>
				</tr>
				<tr>
					<td style="text-align:right;" > Current Total:</td>
					<td style="text-align:right;"  > <?php echo $getIpdServices[0][0]['charges']-$billingData['Billing']['amount'] ;  ?></td>
				</tr> 
			</table>
		</td> 
	</tr>-->
</table>
</br></br>
<table>
	<tr>
		<td valign="top">
			Narration  <?php echo $this->Form->input(__('narration'),array('type'=>'textarea','value'=>$billingData['Billing']['narration'] ));?>
		</td>
		<td><?php echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;')) ; ?> </td>
	</tr>
</table>
<?php  echo $this->Form->end(); ?>