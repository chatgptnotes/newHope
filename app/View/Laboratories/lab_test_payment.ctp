<style>
.row_action img {
	float: inherit;
}
</style>
<style>
body {
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #E7EEEF;
}

.boxBorder {
	border: 1px solid #3E474A;
}

.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorderRight {
	border-right: 1px solid #3E474A;
}

.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
}

.tdBorderRt {
	border-right: 1px solid #3E474A;
}

.tdBorderTpBt {
	border: 1px solid #3E474A;
}

.tdBorderTpRt {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}

.columnPad {
	padding: 5px;
}

.columnLeftPad {
	padding-left: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.totalPrice {
	font-size: 14px;
}

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}

.inner_title span {
	margin: -23px 0;
}
</style>
<div class="inner_title">
	<h3>Laboratory Test Payment</h3>
	<span>&nbsp; <?php echo $this->Html->link(__('Back'),array('action'=>'payment'),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>
<p class="ht5"></p>
<?php echo $this->element('patient_information');?>

<div class="clr ht5"></div>
<?php
echo $this->Form->create ( 'LabTestPayment', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'lab_test_payment',
				$patient_id 
		),
		'id' => 'orderfrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

?>
	<?php
	if (! empty ( $this->params->query ['identifier'] )) {
		?>
<!--<table width="100%" cellspacing="3" cellpadding="3" border="0" align="center" class="boxBorder">
  		<tbody>
  		<tr>
    		<td width="100%" valign="top" align="left" class="boxBorderBot">
				-->
<table width="100%" cellspacing="0" cellpadding="3" border="0"
	class="tdBorderTpBt">
	<tbody>
		<tr>
			<td valign="top" align="left" class="tdBorderTpRt"><strong>Test</strong></td>
			<td valign="top" align="right" class="tdBorderTpRt"><strong>Unit</strong></td>
			<td valign="top" align="right" class="tdBorderTp totalPrice"><strong>Amount</strong></td>
		</tr>
		<tr>
			<td valign="top" align="right" class="tdBorderTpRt">&nbsp;</td>
			<td valign="top" align="right" class="tdBorderTpRt">&nbsp;</td>
			<td valign="top" align="right" class="tdBorderTp totalPrice">&nbsp;</td>
		</tr>
			          <?php
		$lCost = '';
		$hosType = ($this->Session->read ( 'hospitaltype' ) == 'NABH') ? 'nabh_charges' : 'non_nabh_charges';
		foreach ( $labRate as $lab => $labCost ) {
			// if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$lCost += $labCost ['TariffAmount'] [$hosType];
			?>
			          				 <tr>
			<td class="tdBorderRt">&nbsp;&nbsp;<i><?php echo $labCost['Laboratory']['name'];?></i></td>
			<td align="right" valign="top" class="tdBorderRt"><strong>1</strong></td>
			<td align="right" valign="top"><strong><?php echo $this->Number->format($labCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false));?></strong></td>
		</tr>
			          				<?php
			// }
		}
		?>
			          <tr>
			<td valign="top" align="right" class="tdBorderTpRt"><strong>Total</strong></td>

			<td valign="top" align="right" class="tdBorderTpRt">&nbsp;</td>

			<td valign="top" align="right" class="tdBorderTp totalPrice"><strong><?php echo $this->Number->currency($lCost) ;?></strong></td>
		</tr>
		<tr>
			<td width="100%" align="left" valign="top" class="tdBorderTp"
				colspan="5">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="boxBorderRight columnPad">Amount
							Chargeable (in words): &nbsp;&nbsp;&nbsp; <strong><?php
		
		if ($labPayment ['LabTestPayment'] ['total_amount']) {
			// if($lCost > $labPayment['LabTestPayment']['total_amount']){
			$payAmt = $lCost - $labPayment [0] ['paid_amount'];
			// }else{
			// echo "sec".$payAmt = $labPayment['LabTestPayment']['total_amount']-$labPayment[0]['paid_amount'];
			// }
		} else {
			$payAmt = $lCost;
		}
		if ($payAmt < 0)
			echo $payAmt . "&nbsp;";
		echo $this->RupeesToWords->no_to_words ( $payAmt );
		?></strong>
						</td>
						<td width="292">
							<table width="100%" cellpadding="0" cellspacing="0" border="0"
								class="">
								<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Advance
										Paid</td>
									<td align="right" valign="top" class="tdBorderBt">
						                        	<?php echo $this->Number->currency($labPayment[0]['paid_amount']);?>
						                        </td>
								</tr>
								<tr>
									<td height="20" valign="top" class="tdBorderRtBt">&nbsp;To Pay</td>
									<td align="center" valign="top" class="tdBorderBt"
										style="text-align: right;">
						                	  		<?php
		
		if ($payAmt > 0)
			echo $this->Form->input ( 'paid_amount', array (
					'type' => 'text',
					'class' => 'validate[required,custom[onlyNumber]]',
					'size' => '5',
					'style' => "text-align:right;",
					'value' => $payAmt,
					'autocomplete' => 'off' 
			) );
		else
			echo "0.00";
		
		echo $this->Form->hidden ( 'total_amount', array (
				'size' => '40',
				'value' => $lCost 
		) );
		echo $this->Form->hidden ( 'before_paid', array (
				'size' => '40',
				'value' => $labPayment [0] ['paid_amount'] 
		) );
		echo $this->Form->hidden ( 'patient_id', array (
				'size' => '40',
				'value' => $patient_id 
		) );
		echo $this->Form->hidden ( 'batch_identifier', array (
				'size' => '40',
				'value' => $this->params->query ['identifier'] 
		) );
		
		// echo $this->Form->hidden('id',array());
		?>
						                	  </td>
								</tr>
								<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Remark</td>
									<td align="right" valign="top" class="tdBorderBt">
						                        	<?php  echo $this->Form->textarea('remark',array('style'=>'width:215px;','size'=>'40','value'=>$labPayment['LabTestPayment']['remark'])); ?>
						                        </td>
								</tr>
								<tr>
									<td align="right" colspan="2" height="40">
						               	  			<?php
		if ($payAmt > 0)
			echo $this->Form->submit ( 'Pay', array (
					'class' => 'blueBtn',
					'align' => 'right',
					'div' => false,
					'label' => false 
			) );
		
		echo $this->Html->link ( 'Cancel', array (
				'action' => 'lab_test_payment',
				$patient_id 
		), array (
				'escape' => false,
				'class' => 'grayBtn' 
		) );
		?>
						               	  		</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<?php
		echo $this->Form->end ();
		
		if ($paymentDone == 'yes' || isset ( $_GET ['payment'] )) {
			echo "<script>var openWin = window.open('" . $this->Html->url ( array (
					'action' => 'lab_test_payment_receipt_print',
					$_GET ['id'] 
			) ) . "', '_blank',
					           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>";
		}
	} else {
		?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
				<?php if(isset($test_ordered) && !empty($test_ordered)){  ?> 
						  <tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('LaboratoryTestOrder.order_id', __('Lab Order id', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('LaboratoryTestOrder.create_time', __('Order Time', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Laboratory.name', __('Test Name', true)); ?></strong></td>
		<!-- 
							   <td class="table_cell" align="left"><strong><?php echo  __('Status'); ?></strong></td>
							   -->
		<td class="table_cell" align=right><strong><?php echo  __('Action'); ?></strong></td>

	</tr>
						  <?php
			$toggle = 0;
			$time = '';
			if (count ( $test_ordered ) > 0) {
				foreach ( $test_ordered as $labs ) {
					/*
					 * $splitDateTime = explode(" ",$labs['LaboratoryTestOrder']['create_time']) ;
					 * $splitTime = explode(":",$splitDateTime[1]);
					 * $currentTime = $splitTime[0].":".$splitTime[1];
					 * $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;
					 */
					$currentTime = $labs ['LaboratoryTestOrder'] ['batch_identifier'];
					if ($time != $currentTime) {
						if (! empty ( $test_ordered )) {
							echo "<tr class='row_title'><td colspan='5' align='right' style='padding: 8px 5px;'>";
							echo $this->Html->link ( __ ( 'View' ), array (
									'action' => 'lab_test_payment',
									$patient_id,
									'?' => array (
											'identifier' => $currentTime 
									) 
							), array (
									'class' => 'blueBtn',
									'error' => false 
							) );
							echo "</td></tr>";
						} else {
							echo "<tr class='row_title'><td colspan='5'>&nbsp;</td></tr>";
						}
					}
					
					$time = $labs ['LaboratoryTestOrder'] ['batch_identifier'];
					if ($toggle == 0) {
						echo "<tr class='row_gray'>";
						$toggle = 1;
					} else {
						echo "<tr>";
						$toggle = 0;
					}
					// status of the report
					if ($labs ['LaboratoryResult'] ['confirm_result'] == 1) {
						$status = 'Resulted';
					} else {
						$status = 'Pending';
					}
					?>								  
										   <td class="row_format" align="left"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?></td>
	<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
	<td class="row_format" align="left"><?php echo ucfirst($labs['Laboratory']['name']); ?> </td>
	<!--
										   <td class="row_format" align="left"><?php echo $status; ?> </td>						   
										   -->
	<td class="row_format" align="left">
										   	<?php
					/*
					 * if($status == 'Pending'){
					 * echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));
					 * }
					 */
					?>
										   </td>
	</tr>
							  <?php
				}
				// set get variables to pagination url
				$this->Paginator->options ( array (
						'url' => array (
								"?" => $this->params->query 
						) 
				) );
				?>
							   <tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
							 </span>
		</TD>
	</tr>
					<?php } ?> <?php
		} else {
			?>
					  <tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.</TD>
	</tr>
					  <?php
		}
		
		echo $this->Js->writeBuffer ();
		?>
		</table>
<?php } ?>

<script>
	 
			
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#orderfrm").validationEngine();
	});
	
</script>
