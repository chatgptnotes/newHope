<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable-'.$patientData['Patient']['lookup_name'], true); ?>
	</h3>
</div> 
<!-- 
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
<tr>
		<th width="100" align="center" valign="top" style="text-align: center; min-width: 100px;">Date</th>
		<th width="100" align="center" valign="top" style="text-align: center;">Ref No.</th>
		<th width="150" align="center" valign="top" style="text-align: center; min-width: 150px;">Party's Name</th>
		<th width="90" align="center"  valign="top"  style="text-align: center;">Pending Amount</th>
		<th width="125" align="center" valign="top" style="text-align: center;">Due On</th>
		<th width="125" align="center" valign="top" style="text-align: center;">Overdue by Days</th>
	</tr> 
	<?php 
	$bal=0;
	 
	//foreach($data as $key => $userData){
		$date=$this->DateFormat->formatDate2Local($datas['Billing']['date'],Configure::read('date_format'),true);?>
		<tr>
			<td align="center" valign="top" style="text-align: center;"><?php echo $date ?> </td>
			<td align="center" valign="top" style="text-align: center;"><?php   ?> </td>
			<td align="center" valign="top" style="text-align: center;"><i><?php echo $data['User']['full_name'] ?> </i></td>
			<td align="center" valign="top" style="text-align: center;"><?php echo ($data['User']['payment']*$month)-$data[0]['month_total'];  ?> 	</td> 
			<td align="center" valign="top" style="text-align: center;"><?php   echo "1st ".date('F',strtotime($data['AccountEmployee']['paid_on']."+1 month")); ?> </td>
			<td align="center" valign="top" style="text-align: center;"><?php 
			$current_date=date('j');
			echo  $current_date-1 ; 
			//$getDif = $this->General->diff($current_date,$stopDate);
			?></td>
		</tr>
	<?php 
		/* $bal=$bal+$datas['Billing']['amount'];
	//}
	$total=0;
	foreach($getIpdServices as $amount){
		$total=$total+$amount['Icd10pcMaster']['charges'];
	}
	$current_bal=$total-$bal;
	echo $this->Form->create('AccountEmployee');
	echo $this->Form->hidden('user_id',array('value'=>$user_id)) ; */
	?>
	<tr>
		<td colspan="4"></td>
		<td colspan="2">
			<table width="100%">
				<tr>
					<td style="text-align:right;"> Date:</td>
					<td style="text-align:left;"> <?php echo $this->Form->input('paid_on',array('type'=>'text','id'=>'paid_on','label'=>false,'div'=>false));?></td>
				</tr> 
				<tr>
					<td style="text-align:right;"> Pay:</td>
					<td style="text-align:left;"> <?php echo $this->Form->input('paid_amount',array('label'=>false,'div'=>false));?></td>
				</tr> 
				<tr>
					<td style="text-align:right;"> Narration:</td>
					<td style="text-align:left;"> <?php echo $this->Form->input('description',array('type'=>'textarea','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<?php //echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;')) ; ?>
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
</table>
 -->
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
	<tr> 
		<th width="100" align="center" valign="top" style="text-align: left;;"><?php echo __('Perticulars')?></th>
		<th width="150" align="center" valign="top" style="text-align: center; min-width: 150px;"><?php echo __('Amount	')?></th> 
	</tr> 
	<?php
		$totalPaid = '' ;
		foreach($data as $key => $userData){ pr($userData) ; ?>
		<tr>
			<td>
				<table>
					<tr>
						<td align="left" valign="top" style= "text-align: left;"  >
							<?php echo $userData['User']['full_name'] ;?>
						</td> 
					</tr> 
					<tr>
						<td valign="top" style= "text-align: left;"><i>
							<?php echo $userData['AccountEmployee']['description'] ;?></i>
						</td> 
					</tr>
				</table>
			</td>
			<td style= "text-align: center;">
				<?php echo $userData['AccountEmployee']['paid_amount'] ;?>
			</td>
		</tr> 
	<?php
		//add pending amount
		$totalPaid += $userData['AccountEmployee']['paid_amount']; 	
		$paymentPerMonth = $userData['User']['payment'] ;		
	}  
	echo $this->Form->create('AccountEmployee');
	echo $this->Form->hidden('user_id',array('value'=>$user_id)) ;  
	?>
	<tr>
		 
		<td >
			<table width="100%">
				<tr>
					<td style="text-align:right;"> Date:</td>
					<td style="text-align:left;"> <?php echo $this->Form->input('paid_on',array('class'=>'textBoxExpnd','type'=>'text','id'=>'paid_on','label'=>false,'div'=>false));?></td>
				</tr> 
				<tr>
					<td style="text-align:right;"> Pay:</td>
					<td style="text-align:left;"> <?php echo $this->Form->input('paid_amount',array('label'=>false,'div'=>false));?></td>
				</tr> 
				<tr>
					<td style="text-align:right;"> Narration:</td>
					<td style="text-align:left;"> <?php echo $this->Form->input('description',array('type'=>'textarea','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<?php  echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;')) ; ?>
					</td>
				</tr>
			</table>
		</td> 
		<td>
			<table width="100%">
				<tr>
					<td>
						Account 
						<?php 
							echo $pendingAmt = ($paymentPerMonth*$month)-$totalPaid;
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr> 
	<?php echo $this->Form->end(); ?>
</table>

<script>
	$(document).ready(function(){
		$("#paid_on" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
		});
	});
</script>