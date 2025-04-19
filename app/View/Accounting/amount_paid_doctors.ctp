<?php 
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>
 
     <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<div class="inner_title">
	<h3>
		<?php echo __('Ledger Vouchers'); ?>
	</h3>
	<span>
		<?php
// 			echo $this->Form->button(__('Export To Excel'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'excel'));
// 			echo $this->Form->button(__('Print'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'print'));
		?>
	</span>
	  <button id="downloadExcel" class="btn btn-success right">Download Excel</button>
</div>
<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	 background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}	
</style>
<div class="clr">&nbsp;</div>
<?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<?php echo $this->Form->create('Payable_Details',array('id'=>'payableDetails','url'=>array('controller'=>'Accounting','action'=>'amount_paid_doctors','admin'=>false),));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">
			<td align="center"><strong><?php echo __('MRN#');?></strong></td>
			<td>
				<?php echo $this->Form->input('Patient.admission_id',array('id'=>'mrn','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off'));
				echo $this->Form->hidden('Patient.admission_id',array('id'=>'admission_id'));?>
			</td>
			<td align="center"><strong><?php echo __('Account');?></strong></td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.name',array('id'=>'user','label'=>false,'div'=>false,'type'=>'text',
						'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]','value'=>$userName['Account']['name']));
					echo $this->Form->hidden('VoucherEntry.user_id',array('id'=>'user_id','value'=>$userid));?>
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false,
						'div' => false, 'error' => false,'placeholder'=>'From','readonly'=>'readonly','value'=>$from));?>
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false,
						'div' => false, 'error' => false,'placeholder'=>'To','readonly'=>'readonly','value'=>$to));?>
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.narration', array('type'=>'text','class'=>'textBoxExpnd','style'=>'width:160px',
						'id'=>'narration','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Search by Narration', 'autocomplete'=>'off'));?>
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.amount', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'amount','label'=> false,
						'div' => false, 'error' => false,'placeholder'=>'Search by Amount', 'autocomplete'=>'off'));?>
			</td>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?>
			</td>
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'legder_voucher'),array('escape'=>false));?>	
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.isHide',array("type" => "checkbox",'id'=>'isShowNarration','label'=>false,'legend'=>false));?>
			</td>
			<td><?php echo __("Hide Narration");?></td>
		</tr>
	</tbody>
</table>
<?php  echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
	<?php 
	if($click==1){?>
	<table cellspacing="0" cellpadding="0" width="99%" align="center">
		<tr>
			<td><b><?php echo __('Ledger : '); echo ucwords($userName['Account']['name']);?></b></td>
			<td align="right">
				<?php $from1=explode(' ',$from);echo $from1[0]; echo "  To ";  $to1=explode(' ',$to);echo $to1[0];?>
			</td>
		</tr>
	</table>
	
	<!--<div style="margin-bottom: 10px; text-align: right;">-->
 <!--       <button id="downloadExcel" class="btn btn-success">Download Excel</button>-->
 <!--   </div>-->

	<table class="tabularForm" width="99%" align="center" cellspacing="1">
		<thead>
			<tr class="row_gray">
				<th style="width:10%"><?php echo __('VOU Date');?></th>
				<!--<th style="width:30%"><?php echo __('VOU No');?></th>-->
				<th style="width:10%"><?php echo __('Debit Ladger');?></th>
				<th style="width:10%"><?php echo __('Amount');?></th>
				<th style="width:15%; text-align: center;"><?php echo __('Credit Ladger');?></th>
				<th style="width:15%; text-align: center;"><?php echo __('Amount');?></th>
				<th style="width:10%;"><?php echo __('Narroation');?></th>
				<!--	<th style="width:15%; text-align: center;"><?php echo __('test1');?></th>-->
				<!--<th style="width:10%;"><?php echo __('test2');?></th>-->
			</tr>
		</thead>
	</table>
<table class="tabularForm" width="99%" align="center" cellspacing="1" id="container-table">
	<tbody>
	<?php
	ksort($ledger);
		foreach($ledger as $key=>$entry){	
		ksort($entry);
			foreach($entry as $key=>$data){ ?>
	<tr>
	<?php if(isset($data['VoucherPayment'])){?>
		<td style="width: 11%; text-align: center;">
			<?php echo $this->DateFormat->formatDate2Local($data['VoucherPayment']['date'],Configure::read('date_format'),false); ?>
		</td>
	
		<td style="width: 30%; text-align: left;"> <?php echo __('IPD Visit Charges'); ?> </td>
			
	
		<!--amount start-->
			<?php if($data['VoucherPayment']['account_id']==$userid){ ?>
				<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				<td style="width: 15%; text-align: right;">
					<?php 
						$credit=$credit+$data['VoucherPayment']['paid_amount'];
						echo number_format($data['VoucherPayment']['paid_amount'], 2);
					?>
				</td>
			<?php } elseif($data['VoucherPayment']['user_id']==$userid){?>
				<td style="width: 15%; text-align: right;">
					<?php 
						$debit=$debit+$data['VoucherPayment']['paid_amount'];
						echo number_format($data['VoucherPayment']['paid_amount'], 2);
					?>
				</td>
				<td style="width: 15%; text-align: right;">	<?php echo ucwords($userName['Account']['name']);?></td>
		<?php }?>
			<!--amount End-->
			
			<!--<td style="width: 30%; text-align: left;">	<?php echo ucwords($userName['Account']['name']);?> </td>-->
				<!--amount start-->
			<?php if($data['VoucherPayment']['account_id']==$userid){ ?>
				<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				<td style="width: 15%; text-align: right;">
					<?php 
						$credit=$credit+$data['VoucherPayment']['paid_amount'];
						echo number_format($data['VoucherPayment']['paid_amount'], 2);
					?>
				</td>
			<?php } elseif($data['VoucherPayment']['user_id']==$userid){?>
				<td style="width: 15%; text-align: right;">
					<?php 
						$debit=$debit+$data['VoucherPayment']['paid_amount'];
						echo number_format($data['VoucherPayment']['paid_amount'], 2);
					?>
				</td>
				<td style="width: 15%; text-align: right;">	<div style="padding-left:0px; padding-bottom:3px;">
				<?php 
				// 	if($data['VoucherPayment']['user_id']==$userid){
				// 		echo ucwords($data['AccountAlias']['name']);
				// 	} elseif ($data['VoucherPayment']['account_id']==$userid){
				// 		echo ucwords($data['Account']['name']);
				// 	}
				?>
			</div>
			<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
			<?php if((strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager'))) || (strtolower($this->Session->read('role')) == strtolower(Configure::read('adminLabel')))){?>
				<span id="updateNarration_<?php echo $data['VoucherPayment']['id'];?>" class="updateNarration">
					<?php echo __('Narration : ').$data['VoucherPayment']['narration'];?>
				</span>
				<span class="showEditNarration" id ="showEditNarration_<?php echo $data['VoucherPayment']['id'];?>">
					<?php echo $this->Form->input('',array('id'=>'editNarration_'.$data['VoucherPayment']['id'],'type'=>'textarea','label'=>false,
					'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['VoucherPayment']['narration']));
					echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['VoucherPayment']['id'],'value'=>"Payment"));
					echo $this->Form->hidden('',array('id'=>'modelName_'.$data['VoucherPayment']['id'],'value'=>"VoucherPayment"));
					?>
				</span>
			<?php }else{
					echo __('Narration : ').$data['VoucherPayment']['narration'];
				}?>
			</div></td>
		<?php }?>
			<!--amount End-->
			
			
		<!--<td style="width: 10%; text-align: left;"><?php echo __('Payment'); ?></td>-->
	
			<td style="width: 30%; text-align: left;">
		
		</td>
		<td style="width: 10%; text-align: center;">
			<?php echo $this->Html->image('print.png',
		   		array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printPaymentVoucher',
	     		$data['VoucherPayment']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
					
					if(strtolower($data['AccountAlias']['alias_name'])==Configure::read('SBIAlias') || strtolower($data['Account']['alias_name'])==Configure::read('SBIAlias')){
						 echo $this->Html->image('printer_mono.png',
	   				array('escape' => false,'title'=>'RTGS Remittance Print','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printRtgsRemittance',
     				$data['Account']['system_user_id'],$data['Account']['user_type'],$data['VoucherPayment']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,height=500,left=200,top=200');  return false;"));
					}
			?>	
			<?php /* echo $this->Html->image('print.png',
		   		array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printCheque',
	     		$data['VoucherPayment']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200');  return false;")); */
			?>
			<?php 
			if($userType == 'Consultant' && $data['VoucherPayment']['type']=='USER'){
				echo $this->Html->link(__('Pick'), 'javascript:void(0);', array('title'=>'Pick','class'=>'blueBtn pick',
					'id'=>'pick_'.$data['VoucherPayment']['id']));
			}?>
			<?php
				if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
					echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'payment_voucher',$data['VoucherPayment']['id']),
						array('escape'=>false,'title'=>'View','alt'=>'View'));
					echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'voucher_delete',$data['VoucherPayment']['id']),
					 array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
				}?>
		</td>
		<!--<td> <p> hii ashwin</p></td>-->
		<!--	<td> <p> hii pratik</p></td>-->
	<?php }
		
	//for Reciept data
	if(isset($data['AccountReceipt'])){ ?>
 		<td style="width: 11%; text-align: center;">
 			<?php echo $this->DateFormat->formatDate2Local($data['AccountReceipt']['date'],Configure::read('date_format'),false); ?>
 		</td>
 		<td style="width: 30%; text-align: left;">
 			<div style="padding-left:0px; padding-bottom:3px;">
	 			<?php 
	 				if($data['AccountReceipt']['user_id']==$userid){
	 					echo ucwords($data['AccountAlias']['name']);
	 				}elseif($data['AccountReceipt']['account_id']==$userid){
	 					echo ucwords($data['Account']['name']);
	 				}
	 			?>
 			</div>
 			
 			<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
 			<?php if((strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager'))) || (strtolower($this->Session->read('role')) == strtolower(Configure::read('adminLabel')))){?>
				<span id="updateNarration_<?php echo $data['AccountReceipt']['id'];?>" class="updateNarration">
					<?php echo __('Narration : ').$data['AccountReceipt']['narration'];?>
				</span>
				<span class="showEditNarration" id ="showEditNarration_<?php echo $data['AccountReceipt']['id'];?>">
					<?php 
						echo $this->Form->input('',array('id'=>'editNarration_'.$data['AccountReceipt']['id'],'type'=>'textarea','label'=>false,
						'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['AccountReceipt']['narration']));
						echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['AccountReceipt']['id'],'value'=>"Receipt"));
						echo $this->Form->hidden('',array('id'=>'modelName_'.$data['AccountReceipt']['id'],'value'=>"AccountReceipt"));
					?>
				</span>
				<?php }else{
					echo __('Narration : ').$data['AccountReceipt']['narration'];
	 			}?>
			</div>
 		</td>
 		<td style="width: 10%; text-align: left;"><?php echo __('Receipt'); ?></td>
 		<td style="width: 10%; text-align: center;"><?php echo $data['AccountReceipt']['id'];?></td>
 		<?php if($data['AccountReceipt']['user_id']==$userid){ ?>
	 		<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
	 		<td style="width: 15%; text-align: right;">
	 			<?php $credit=$credit+$data['AccountReceipt']['paid_amount'];
	 				echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
	 		</td>
 		<?php } elseif($data['AccountReceipt']['account_id']==$userid){?>
	 		<td style="width: 15%; text-align: right;">
	 			<?php 
	 			if(isset($data['AccountReceipt']['paid_amount'])){
		 			$debit=$debit+$data['AccountReceipt']['paid_amount'];
		 			echo $this->Number->currency($data['AccountReceipt']['paid_amount']);
		 		}else{
					$debit=$debit+$data['0']['paid_amount'];
					echo $this->Number->currency($data['0']['paid_amount']);
				}?>
	 		</td>
	 		<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
 		<?php }?>
 			
 		<td style="width: 10%; text-align: center;">
 			<?php echo $this->Html->image('print.png',
	   					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printReceiptVoucher',
     					$data['AccountReceipt']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
						?>	
			<?php if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
				echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'account_receipt',$data['AccountReceipt']['id']),
					array('escape'=>false,'title'=>'View','alt'=>'View'));
 				echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'receipt_delete',$data['AccountReceipt']['id']),
					array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
			}?>
 	   	</td>
	<?php }
	
		//for contra data
		if(isset($data['ContraEntry'])){?>
		<td style="width: 11%; text-align: center;">
			<?php echo $this->DateFormat->formatDate2Local($data['ContraEntry']['date'],Configure::read('date_format'),false); ?>
		</td>
		<td style="width: 30%; text-align: left;">
			<div style="padding-left:0px;padding-bottom:3px;">
				<?php
					if($data['ContraEntry']['user_id']==$userid){
						echo ucwords($data['AccountAlias']['name']);
					}elseif($data['ContraEntry']['account_id']==$userid){
				 		echo ucwords($data['Account']['name']);
					}
				?>
			</div>
			 <div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
			 <?php if((strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager'))) || (strtolower($this->Session->read('role')) == strtolower(Configure::read('adminLabel')))){?>
				<span id="updateNarration_<?php echo $data['ContraEntry']['id'];?>" class="updateNarration">
					<?php echo __('Narration : ').$data['ContraEntry']['narration'];?>
				</span>
				<span class="showEditNarration" id ="showEditNarration_<?php echo $data['ContraEntry']['id'];?>">
					<?php 
						echo $this->Form->input('',array('id'=>'editNarration_'.$data['ContraEntry']['id'],'type'=>'textarea','label'=>false,
						'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['ContraEntry']['narration']));
						echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['ContraEntry']['id'],'value'=>"Contra"));
						echo $this->Form->hidden('',array('id'=>'modelName_'.$data['ContraEntry']['id'],'value'=>"ContraEntry"));
					?>
				</span>
				<?php }else{
					echo __('Narration : ').$data['ContraEntry']['narration'];
				}?>
			</div>
		</td>
		<td style="width: 10%; text-align: left;"><?php echo __('Contra'); ?></td>
		<td style="width: 10%; text-align: center;">
			<?php echo $data['ContraEntry']['id']; ?>
		</td>
			<?php if($data['ContraEntry']['user_id']==$userid){ ?>
				<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				<td style="width: 15%; text-align: right;">
					<?php 
						$credit=$credit+$data['ContraEntry']['debit_amount'];
						echo $this->Number->currency($data['ContraEntry']['debit_amount']);
					?>
				</td>
			<?php } elseif($data['ContraEntry']['account_id']==$userid){?>
				<td style="width: 15%; text-align: right;">
					<?php 
						$debit=$debit+$data['ContraEntry']['debit_amount'];
						echo $this->Number->currency($data['ContraEntry']['debit_amount']);
					?>
				</td>
				<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
			<?php }?>
		<td style="width: 10%; text-align: center;">
			<?php echo $this->Html->image('print.png',
	   				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printContraVoucher',
     				$data['ContraEntry']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?>	
			<?php if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
				echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'contra_entry',$data['ContraEntry']['id']),
					array('escape'=>false,'title'=>'View','alt'=>'View'));
				echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'contra_delete',$data['ContraEntry']['id']),
					array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
			}?>
		</td>
		
	<?php }
	
	//for journal entry
	
			} 
		}
	
		
			 // if no data to display...	
		if(empty($ledger)){?>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
		<?php } ?>
		
		
	</table>
<script>
document.getElementById('downloadExcel').addEventListener('click', function () {
    // Get the ledger name dynamically
    var ledgerName = "<?php echo ucwords($userName['Account']['name']); ?>";

    // Define custom column headers
    var customHeaders = [
        ['VOU. DATE', 'DEBIT LEDGER', 'AMOUNT', 'CREDIT LEDGER', 'AMOUNT', 'NARRATION']
    ];

    // Get the table element
    var table = document.querySelector('#container-table');

    // Extract table rows into a 2D array
    var tableData = [];
    var rows = table.querySelectorAll('tr');
    rows.forEach(function (row) {
        var rowData = [];
        var cells = row.querySelectorAll('td');
        cells.forEach(function (cell) {
            rowData.push(cell.innerText.trim());
        });
        if (rowData.length > 0) {
            tableData.push(rowData);
        }
    });

    // Combine custom headers with table data
    var completeData = customHeaders.concat(tableData);

    // Create a new workbook and append the worksheet
    var workbook = XLSX.utils.book_new();
    var worksheet = XLSX.utils.aoa_to_sheet(completeData);

    // Apply styling to the header row
    const headerRange = XLSX.utils.decode_range(worksheet['!ref']);
    for (let col = headerRange.s.c; col <= headerRange.e.c; col++) {
        const cellAddress = XLSX.utils.encode_cell({ r: 0, c: col });
        if (worksheet[cellAddress]) {
            worksheet[cellAddress].s = {
                font: { bold: true, color: { rgb: "000000" } },
                fill: { fgColor: { rgb: "D9E1F2" } }, // Light blue background
                alignment: { horizontal: "center", vertical: "center" },
            };
        }
    }

    // Append the styled worksheet to the workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Ledger Data');

    // Download the workbook with the dynamic filename
    XLSX.writeFile(workbook, ledgerName + '_Ledger_Report.xlsx');
});
</script>



<table class="tabularForm" width="99%" align="center" cellspacing="1">
	<tr>
		<td colspan="4" style="text-align: right; width: 60%;"><?php echo __('Opening Balance :');?></td>
	<?php if(empty($opening)){?>
		<td width="15%"><?php echo " ";?></td>		
		<td width="15%"><?php echo " ";?></td>
		<td width="10%"><?php echo " ";?></td>
	<?php }else{
		if($type=='Dr'){
			$close=($opening+$debit)-$credit;?>
			<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$opening).' Dr';?></td>
			<td width="15%"><?php echo " ";?></td>
			<td width="10%"><?php echo " ";?></td>		
		<?php }elseif($type=='Cr'){
			$close=($opening+$credit)-$debit;?>
			<td width="15%"><?php echo " ";?></td>
			<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$opening).' Cr';?></td>
			<td width="10%"><?php echo " ";?></td>				
		<?php }	
   		}?>
	</tr>
	<tr class="row_gray">
		<td colspan="4" style="text-align: right; width: 60%;"><?php echo __('Current Balance :');?></td>
		<td width="15%" style="text-align: right;">
			<?php 
				if(!empty($debit)){
					echo $this->Number->currency((double)$debit).' Dr';
				}else{
					echo " ";
				}
			?>
		</td>
		
		<td width="15%" style="text-align: right;">
			<?php 
				if(!empty($credit)){
					echo $this->Number->currency((double)$credit).' Cr';
				}else{
					echo " ";
				}
			?>
		</td>
		<td width="10%"><?php echo " ";?></td>
	</tr>
	
	<tr>
		<td colspan="4" style="text-align: right; width: 60%;"><?php echo __('Closing Balance :');?></td>
		<?php 
			if(empty($opening)){
				$close=$credit-$debit;
				if(empty($close)){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($close<0){ ?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency(-((double)$close)).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }else{ ?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php } 
				}elseif($close==$opening){
				if($type=='Dr'){?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }
				}elseif($close>0){
				if($type=='Dr'){?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }
				}elseif($close<0){
				if($type=='Dr'){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)-($close)).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)-($close)).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }
			} ?>
		</tr> 
	</tbody> 
</table>
<?php } ?>
</td>
</tr>
</table>
<script>
$(document).ready(function(){
	$(".editNarration").hide();
	$("#container-table").freezeHeader({ 'height': '475px' });
	 $("#isShowNarration").val(0);
	 $("#excel").val(0);
	 $("#isShowNarration").click(function(){
			if($(this).prop('checked')){ 
				$(".narration").hide();
	            $("#isShowNarration").val(1);
	            $("#excel").val(1);
	        }else{
	        	$(".narration").show();
	            $("#isShowNarration").val(0);
	            $("#excel").val(0);
	        }
	     });
	$("#user").focus();
	$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '-100:' + new Date().getFullYear(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	 $( "#search" ).click(function(){ 	
		 var userVal = $("#user").val();
		 if(userVal == ''){
			 $("#user").addClass("validate[required,custom[mandatory-enter]]");
		 }
		 var mrnVal = $("#mrn").val();
		 if(mrnVal != ''){
			 $("#user").removeClass("validate[required,custom[mandatory-enter]]");
		 }
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 $("#to").validationEngine("hideAll");
		 if(!result){ 
			 $('#to').validationEngine('showPrompt', 'To date should be greater than from date', 'text', 'topLeft', true);
		 }
		 return result ;
	});
	 
	 $( "#user" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "ledger_search","name","plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#user_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
	 $("#user").attr('placeHolder','Enter Ledger Name');
	 $( "#mrn" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","admission_id&admission_id",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#admission_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
	 $("#mrn").attr('placeHolder','Enter Patient MRN No.');
	 jQuery("#payableDetails").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});
		
	 var childSubmitted = false;	
	 var spotAdvanceSharingURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "spotAdvanceSharing","admin" => false)); ?>" ;
	 $(".pick").click(function() {
	     id = $(this).attr('id');
	     receiptId = id.split("_");
	     $.fancybox({
	         'width' : '70%',
	         'height' : '80%',
	         'autoScale' : true,
	         'transitionIn' : 'fade',
	         'transitionOut' : 'fade',
	         'hideOnOverlayClick':false,
	         'type' : 'iframe',
	         'href' : spotAdvanceSharingURL + '/' + receiptId[1],
	         'onClosed':function(){
	                 if(childSubmitted == true){
	                	 parent.$.fancybox.close();
	                 }
	         }
	     });
	 });	
	 $("#print").click(function() {
		 var isHide = $('#isShowNarration').val();
		 var queryString = "?from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>"+"&user_id="+"<?php echo $userid;?>"+"&narration="+"<?php echo $narration;?>"+"&amount="+"<?php echo $amount;?>"+"&isHide="+isHide;
		 var url="<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'print_legder_voucher')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
		});
	 $("#excel").click(function() {
		 var isHide = $('#excel').val();
		 var queryString = "?from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>"+"&user_id="+"<?php echo $userid;?>"+"&narration="+"<?php echo $narration;?>"+"&amount="+"<?php echo $amount;?>"+"&isHide="+isHide;
		 var url="<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'amount_paid_doctors','excel')); ?>"+ queryString;
		 window.location.href=url;
		});	

	 $(".updateNarration").dblclick(function() {
		 var voucherId = $(this).attr('id');
			splittedId = voucherId.split("_");
			$("#showEditNarration_"+splittedId[1]).show();
			$("#updateNarration_"+splittedId[1]).hide();
			$("#editNarration_"+splittedId[1]).show();
		});
		
	 $('.editNarration').on('blur',function(){
		var voucherId = $(this).attr('id');
		splittedId = voucherId.split("_");
		newId = splittedId[1];
		
		var voucherType = $("#voucherType_"+newId).val();
		var modelName = $("#modelName_"+newId).val();
		var narration = $("#editNarration_"+newId).val();
		var queryString = "?id="+newId+"&voucherType="+voucherType+"&modelName="+modelName+"&narration="+narration;
		
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller"=>'Accounting',"action"=>"editNarration","admin"=>false));?>"+queryString,
	
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
	
			success: function(data){
				$('#busy-indicator').hide();
				
				if(data == 1){
					$("#showEditNarration_"+newId).hide();
					$("#editNarration_"+newId).hide();
					$("#updateNarration_"+newId).text('Narration :'+narration);
					$("#updateNarration_"+newId).show();
				}
			}
			});
		});	
});
</script>
