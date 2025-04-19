<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
			
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('Bank account details');?>
				</th>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Bank name</td>
				<td width="30%"><?php echo $this->Form->input('HrDetail.bank_id', array('options'=>$bankNames,'empty'=>'Please Select','label'=>false,
                                    'div'=>false,'id' => 'bank_id','class'=> 'textBoxExpnd'));
				echo $this->Form->hidden('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd')); ?>
				<td width="21%" class="tdLabel"></td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Bank Branch</td>
				<td width="30%"><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd')); ?>
				</td>
				
			</tr>
		<tr>
		<td width="21%" class="tdLabel">Account number</td>
		<td width="30%"><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd')); ?>
												</td>
		</tr>
		<tr>
		<td width="21%" class="tdLabel">Bank pass book copy obtained :</td>
				<td width="30%">
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy ', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received')); ?>
								</td>
		</tr>
  
		<tr>
		<td width="21%" class="tdLabel">NEFT authorization received :</td>
				<td width="30%">
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received ', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received')); ?>
								</td>
		</tr>  		
		<tr>
		<td width="21%" class="tdLabel">PAN</td>
				<td width="30%">
				<?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));?>
				</td>
		</tr>
	<tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<th style="padding-left: 10px;" colspan="4"><?php echo __('Company assets issued to him');?>
		</th>
	</tr>	
	<tr>
		<td colspan="3">
			<table width="67%" border="0" cellspacing="0" cellpadding="0" align="center" class="formFull" id="bankDetailAsset">
				<tr>
					<th class="text" align="center"><?php echo __('Sr.No');?>
					</th>
					<th align="center"><?php echo __('Item issued');?>
					</th>
					<th align="center"><?php echo __('Date');?>
					</th>
					<th class="text"><?php echo __('Action');?>
					</th>
				</tr>
				<?php if($this->data['HrDetail']['company_assets']){?>
                                <?php $key = 0;?>
				<?php  foreach($this->data['HrDetail']['company_assets'] as $value){ ?> 
				<tr id="removeRow-<?php echo $key; ?>">
					<td class="text" ><?php echo $bankSrNo = $key+1;?>
					</td>
					<td><?php echo $this->Form->input("HrDetail.company_assets.$key.item_issued",array('type'=>'text','id'=>"item_issued-$key",'value'=>$value['item_issued'],'class'=>'textBoxExpnd'));?>
					</td>
					<td><?php echo $this->Form->input("HrDetail.company_assets.$key.date",array('type'=>'text','id'=>"date-$key",'value'=>$value['date'],'class'=>'date textBoxExpnd','readonly' => 'readonly'));?>
					</td>
					<?php if($key == 0) { ?>
					<td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addMoretr','style'=>'float:none;'));?>
					</td>
					<?php } else{ ?>
					<td class="text"><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	   			 					'alt'=> __('Remove', true),'class'=>'removeCompantAssest','style'=>'float:none;','id'=>$key));?>
				    </td> <?php }?>
				</tr> <?php $key++; } ?>
				<?php } else{ ?>
				<?php $key = 0;?>
				<tr>
					<td class="text" ><?php echo $bankSrNo = $key+1;?>
					</td>
					<td><?php echo $this->Form->input("HrDetail.company_assets.$key.item_issued",array('type'=>'text','id'=>"item_issued-$key",'value'=>$value['item_issued'],'class'=>'textBoxExpnd'));?>
					</td>
					<td><?php echo $this->Form->input("HrDetail.company_assets.$key.date",array('type'=>'text','id'=>"date-$key",'value'=>$value['date'],'class'=>'date textBoxExpnd','readonly' => 'readonly'));?>
					</td>
					<td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addMoretr','style'=>'float:none;'));?>
					</td>
					</tr>
					<?php } ?>
					
			</table>
		</td>
	</tr>
	</table>
<script>
var bankSrNo = isNaN(parseInt('<?php echo $bankSrNo;?>')) ? 1 : parseInt('<?php echo $bankSrNo;?>');

$(function(){
	$('#addMoretr').click(function () {
		
		$('#bankDetailAsset tbody:last')
			.append($('<tr>').attr('id','removeRow-'+bankSrNo)
				.append($('<td>').text(bankSrNo+1).attr('class','text'))
			 		.append($('<td>')
			 			.append($('<input>').attr({'name':'data[HrDetail][company_assets]['+bankSrNo+'][item_issued]','type':'text','class':'textBoxExpnd','id' : 'item_issued-'+bankSrNo})))
		 		 	.append($('<td>')
			 		 		.append($('<input>').attr({'name':'data[HrDetail][company_assets]['+bankSrNo+'][date]','type':'text','class':'date textBoxExpnd','readonly':'readonly', 'id' : 'date-'+bankSrNo})))
			 		.append($('<td class="text">').attr('id','Td-'+bankSrNo).append($('<span>').attr({'class':'removeCompantAssest','id' : bankSrNo})
		 		 		 	.append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	   			 					'alt'=> __('Remove', true),'style'=>'float:none;'));?>')))
		 );
		$('.removeCompantAssest').on('click' , function (){
			$("#removeRow-" + $(this).attr('id')).remove();
		});	
	
		$('#date-'+bankSrNo).datepicker({
                    changeMonth : true,
                    changeYear : true,
                    yearRange : '1950',
                    showOtherMonths: true,
                    dateFormat:'<?php echo $this->General->GeneralDate();?>',
                    showOn : 'both',
                    buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                    buttonImageOnly : true,
                    buttonText: "Calendar",
                    onSelect : function() {
                            $(this).focus();
                    }
                }); bankSrNo++;//in
	});
        $('.removeCompantAssest').on('click' , function (){
		$("#removeRow-" + $(this).attr('id')).remove();
	});
		$(".date").datepicker({
			changeMonth : true,
			changeYear : true,
			yearRange : '1950',
			showOtherMonths: true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			showOn : 'both',
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			buttonText: "Calendar",
			onSelect : function() {
				$(this).focus();
			}
		});	
});
	
		</script>