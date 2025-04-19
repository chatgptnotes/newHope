<?php 
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>
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
.subHead{
	display:none;
}
.headRow{
	cursor:pointer;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Trial Balance', true); ?>
	</h3>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'trialBalanceNew','admin'=>false)));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">
		<?php if(!empty($locations)){?>
			<td>
				<?php echo $this->Form->input('Voucher.location_id', array('type'=>'select','empty'=>'All Location',
					'options'=>array($locations),'class'=>'textBoxExpnd','style'=>'width:110px','id'=>'location',
					'label'=> false,'div'=>false,'error'=>false,'autocomplete'=>'off','value'=>$locationId));?>
			</td>
		<?php }else{
			echo $this->Form->hidden('Voucher.location_id',array('value'=>$this->Session->read('locationid'),'id'=>'locationId'));
		}?>
			<td>
				<?php echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 
					'div' => false, 'error' => false,'readonly'=>'readonly','placeholder'=>'From','value'=>$from));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 
					'div' => false, 'error' => false,'readonly'=>'readonly','placeholder'=>'To','value'=>$to));?>
			</td>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?>
			</td>
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'trialBalanceNew'),array('escape'=>false));?>	
			</td>
		</tr>
	</tbody>
</table>
<?php  echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<tr> 
		<td rowspan ="3" style="padding-left:50px;" width="80%">
			<strong><?php echo __("Particulars");?></strong>
		</td>
		<td width="20%" align="center">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<tr>
					<td align="center" colspan="2">
					<?php if($locationId == 'All' || $this->Session->read('location_created_by') != '0'){?>
						<strong><?php echo $this->Session->read(location_name);?></strong><br>
						<?php }else{ ?>
						<strong><?php echo $locations[$locationId];?></strong><br>
					<?php }?>
						<?php
			  				$getFrm=explode(" ",$from);
							$getFrmFinal = str_replace("/", "-",$getFrm[0]);				
							$getFrmFinal=date('jS-M-Y', strtotime($getFrmFinal));					
							$getTo=explode(" ",$to);
							$getToFinal = str_replace("/", "-",$getTo[0]);
							$getToFinal=date('jS-M-Y', strtotime($getToFinal));
						echo $getFrmFinal." To ".$getToFinal;
						?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<strong><?php echo __("Closing Balance");?></strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<?php echo __("Debit");?>
					</td>
					<td align="center">
						<?php echo __("Credit");?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
<?php foreach ($groupData as $key=> $data){
if($data['debit'] == '0' && $data['credit'] == '0') continue;?>
 <tbody id="s_<?php echo $key; ?>">
	<tr id="head_<?php echo $key; ?>" class="headRow">
		<td style="padding-left:20px;" width="80%">
			<strong><?php echo $data['name'];?></strong>
		</td>
		<td width="10%" align="center">
			<?php echo $this->Number->getPriceFormat((double) $data['debit']);
			$totalDebitAmount +=  (double) $data['debit'];?>
		</td>
		<td width="10%" align="center">
			<?php echo $this->Number->getPriceFormat((double) $data['credit']);
			$totalCreditAmount +=  (double) abs($data['credit']);?>
		</td>
	</tr>
	<tr id="subHead_<?php echo $key; ?>" class="subHead">
		<td colspan="3">
			<div id="subHeadLedger_<?php echo $key; ?>" class="subHeadLedger"></div>
		</td>
	<tr>
</tbody>
<?php }?>
<?php
 if($totalDebitAmount != ($totalCreditAmount)){?>
	<tr>
		<td style="padding-left:20px;" width="80%">
			<div style="font-style:italic;"><?php echo __("Diff. in Opening Balances");?></div>
		</td>
		
		<?php if($totalDebitAmount < $totalCreditAmount){?>
		<td width="10%" align="center">
			<?php 
			$totalDebitDiff = abs($totalDebitAmount-$totalCreditAmount);
				echo $this->Number->getPriceFormat($totalDebitDiff);
			?>
		</td>
		<td width="10%" align="center">
			<?php echo "";?>
		</td>
		<?php }elseif($totalDebitAmount > $totalCreditAmount){ ?>
		<td width="10%" align="center">
			<?php echo "";?>
		</td>
		<td width="10%" align="center">
			<?php 
			if($totalCreditAmount < 0){
				$totalCreditAmount = -($totalCreditAmount);
			}
			$totalCreditDiff = ($totalDebitAmount-$totalCreditAmount);
				echo $this->Number->getPriceFormat($totalCreditDiff);
			?>
		</td>
		<?php }?>
	</tr>
<?php }?>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<tr>
		<td style="padding-left:20px;" width="80%">
			<strong><?php echo __("Grand Total");?></strong>
		</td>
		<td width="10%" align="center">
			<b><?php echo $this->Number->getPriceFormat($totalDebitAmount+$totalDebitDiff);?></b>
		</td>
		<td width="10%" align="center">
			<b>
				<?php 
					if($totalCreditAmount < 0){
						$totalCreditAmount = -($totalCreditAmount);
					}
					echo $this->Number->getPriceFormat($totalCreditAmount+$totalCreditDiff);
				?>
			</b>
		</td>
	</tr>
</table>
</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
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
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	
	$( "#search" ).click(function(){ 
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 $("#to").validationEngine("hideAll");
		 if(!result){ 
			 $('#to').validationEngine('showPrompt', 'To date should be greater than from date', 'text', 'topLeft', true);
		 }
		 return result ;
	});

	 jQuery("#voucher").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
		});	
});
	$('.headRow').on('click',function(){
		var id = $(this).attr('id').split("_")[1]; 
		var location_id = "<?php echo $locationId;?>";
		if(location_id == ''){
			var location_id = $("#locationId").val();
		}
		if($.trim($("#subHeadLedger_"+id).html()) == ''){
		$.ajax({
			method : 'Post',
			url : "<?php echo $this->Html->url(array("controller"=>'Accounting',"action"=>"getLedgerGroupWise","admin"=>false));?>",
			data:"GroupId="+id+"&locationId="+location_id+"&from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>",
			context: document.body,
			 beforeSend:function(data){
             	$('#busy-indicator').show();
			 },
 		success: function(data){
 	 		$('.subHead').hide();
 	 		$("#subHead_"+id).toggle('show');
 				$("#subHeadLedger_"+id).html(data).fadeIn('slow');
				$('#busy-indicator').hide();
	   		}
		});
		}else{
			//$('.subHead').hide();
 	 		$("#subHead_"+id).toggle('show');
			$("#subHeadLedger_"+id).fadeIn('slow');
		}
		
	});
</script>