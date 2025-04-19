<div class="inner_title">
	<h3>
		<?php echo __('Service Group Report'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Payable_Details',array('id'=>'payableDetails','url'=>array('controller'=>'Accounting','action'=>'service_group_report','admin'=>false),));?>
	<table align="center" style="margin-top: 10px" width="100%">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
	<table align="center" style="margin-top: 10px">
		<tr>
			<td align="center"><strong><?php echo __('Service Group');?></strong></td>
			<td>
				<?php echo $this->Form->input("VoucherEntry.name",array('class' => 'validate[required,custom[mandatory-enter]]','id'=>"service_type",'type'=>'select','label'=>false,
						'options'=>array('Laboratory'=>'Laboratory','Radiology'=>'Radiology'),'empty'=>'Please Select'));?>
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From'));?>
			</td>
			<td>
				<?php echo $this->Form->input('VoucherEntry.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To'));?>
			</td>
			<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
			<td><?php if($this->request->data){
						$qryStr=$this->request->data['VoucherEntry'];
					}
	 			echo $this->Html->link(__('Export To Excel'),array('controller'=>'Accounting','action'=>'service_group_report','excel','?'=>$qryStr,'admin'=>false),array('class'=>'blueBtn','div'=>false,'label'=>false))?></td>
		</tr>
	</table>
	<?php 
	if($click==1){?>
	<table cellspacing="0" cellpadding="0" width="80%" align="center"
		style="margin-top: 20px">
		<tr>
			<td><b><?php 
			echo __('Ledger : '); echo ucwords($serviceType);?>
			</b></td>
			<td align="right"><?php  $from1=explode(' ',$from);echo $from1[0];
			echo "  To ";  $to1=explode(' ',$to);echo $to1[0];?>
			</td>
		</tr>
	</table>
	
	<table class="formFull" width="80%" align="center" cellspacing="0" >
		<tr class="row_gray">
			<th class="tdLabel" style="width:9%"><?php echo __('Date');?></th>
			<th class="tdLabel" style="width:39%"><?php echo __('Particulars');?></th>
			<th class="tdLabel" style="width:7%"><?php echo __('Voucher Type');?></th>
			<th class="tdLabel" style="width:9%"><?php echo __('Voucher Number');?></th>
			<th class="tdLabel" style="width:14%"><?php echo __('Debit');?></th>
			<th class="tdLabel" style="width:14%"><?php echo __('Credit');?></th>
		</tr>
	<?php
	$toggle=0;$row=0;ksort($ledger);
			foreach($ledger as $key=>$entry){	
					ksort($entry);
					foreach($entry as $key=>$data)
					{
					if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr class='row_gray'>";
						$toggle = 0;
					}

	//for journal entry
	if(isset($data['VoucherEntry'])){?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel">
				<?php echo $data['AccountAlias']['name'];?>
				<br><i><?php echo __('Narration : ').$data['VoucherEntry']['narration'];?></i>
			</td>
			<td class="tdLabel"><?php echo 'Journal'; ?></td>
			<td class="tdLabel"><?php echo $data['VoucherEntry']['id'];?></td>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel">
				<?php 
				$credit=$credit+$data['VoucherEntry']['debit_amount'];
					echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
				?>
			</td>	 
			<?php }
			} 
		}
			 // if no data to display...	
			 if(empty($ledger)){?>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="4" style="text-align: center;"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr><?php    }
			//?>
			<tr><td colspan="6" style="border-top: solid 2px #3E474A;margin-bottom:-1px"></td></tr>
	
		<tr>
		<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Opening Balance :');?></td>
		<?php if(empty($opening)){?>
		<td class="tdLabel"><?php echo " ";?></td>		
		<?php }
		else{
				if($type=='Dr'){
						$close=($opening+$debit)-$credit;	?>
						<td class="tdLabel">
						<?php echo $this->Number->currency($opening).' Dr';?></td>
						<td class="tdLabel" ><?php echo " ";?></td>
						
			<?php }
			elseif($type=='Cr'){
						$close=($opening+$credit)-$debit;	?>
						<td class="tdLabel" ><?php echo " ";?></td>
						<td class="tdLabel" >
						<?php echo $this->Number->currency($opening).' Cr';?></td>					
			<?php }	
   		}?>
		</tr>
		<tr class="row_gray">
		<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Current Balance :');?></td>
		<td class="tdLabel">
		<?php if(!empty($debit)){
				echo $this->Number->currency($debit).' Dr';
			}
				else echo " ";
		?>
		</td>
		<td class="tdLabel"><?php if(!empty($credit)){
				echo $this->Number->currency($credit).' Cr';
			}
				else echo " ";?>
		</td>
		</tr>
		<tr>
		<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Closing Balance :');?>
		</td>
		<?php 
		if(empty($opening)){
			$close=$credit-$debit;
			if(empty($close)){ ?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td class="tdLabel"><?php echo " ";?></td><?php
			}elseif($close<0){ ?>
				<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
				<td class="tdLabel"><?php echo " ";?></td><?php 
			}else{ ?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
			<?php } 
		}//end of if
		elseif($close==$opening){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo $this->Number->currency($close * (-1)).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
		<?php }
		}//end  of else if
		elseif($close>0){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
		<?php }
		}
		elseif($close<0){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Cr'?></td>
		<?php }elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}
		} ?>
		</tr>  
</table>
<?php } ?>
</td>
</tr>
</table>
<script>
$(document).ready(function(){
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
	//	maxDate: new Date(),
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		//yearRange: '1950',
		//maxDate: new Date(),
		yearRange: '-100:' + new Date().getFullYear(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	 $( "#payableDetails" ).click(function(){ 	
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 if(!result){ 
		 	alert("To date should be greater than from date");
		 }
		 return result ;
	});

	 jQuery("#payableDetails").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});
</script>
