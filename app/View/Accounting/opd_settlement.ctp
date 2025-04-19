<?php 
echo $this->Html->css(array('internal_style'));
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
?>

<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
#msg{
    width: 180px;
    margin-left: 34%;
}
.hasDatepicker {
    width: 75px !important;
}

textarea {
    background: -moz-linear-gradient(center top , #f1f1f1, #ffffff) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    border: 1px solid #214a27;
    color: #e7eeef;
    font-size: 13px;
    height: 20px;
    outline: medium none;
    padding: 5px 7px;
    resize: both;
    width: 120px;
</style>

<div class="inner_title">
	<h3>
		<?php echo __('OPD Patient Settlement', true); ?>
		<div style="float:right;">
			<?php echo $this->Html->link(__('Back to List'), array('controller'=>'Accounting','action' => 'index'), array('escape' => false,'class'=>'blueBtn'));?>
		</div>
	</h3>
</div> 
<?php echo $this->Form->create('Patient',array('id'=>'patient','url'=>array('controller'=>'Accounting','action'=>'opdSettlement','admin'=>false)));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
	<table align="center" style="margin-top: 10px">
			<tr>
				<td><?php echo $this->Form->input('Patient.date', array('class'=>'textBoxExpnd date','style'=>'width:120px','id'=>'date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'date'));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				<?php echo $this->Form->end();?></td>
			</tr>
		</table>
	
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
				<thead>
					<tr> 
						<th width="20%" align="center" valign="top"><?php echo __('Patient Name') ?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Amount') ?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Paid') ?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Refund') ?></th>
						<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Discount') ?></th>
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Pending') ?></th>
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Date') ?></th>
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Refund') ?></th>
						<th width="10%" align="center" valign="top" style="text-align: center;" colspan="2"><?php echo __('Remark') ?></th>
						<th width="3%" align="center" valign="top" style="text-align: center;"><?php echo __('Action') ?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				$netAmount = 0;
				$totalAmount=0;
				$totalPaid=0;
				foreach($data as $key=> $userData){

					$totalAmountSum = $allData[$userData['Patient']['id']];
					$amountSum = array_sum (set::classicExtract($userData,"Billing.{n}.amount"));
					$refundSum = array_sum (set::classicExtract($userData,"Billing.{n}.paid_to_patient"));
					$discountSum = array_sum (set::classicExtract($userData,"Billing.{n}.discount"));
					?>
					<tr>
						<td align="left" valign="center" style= "text-align: left;">
							<?php echo $userData['Patient']['lookup_name'].' ('.$userData['Patient']['admission_id'].')'; ?>
							<?php echo $this->Form->hidden('lookup_name',array('name'=>'data[patientId]['.$userData['Patient']['id'].'][]','id'=>'pateintId_'.$key,
									'value'=>$userData['Patient']['id'],'div'=>false,'label'=>false));?>
							<?php echo $this->Form->hidden('finalBillingId',array('id'=>'finalBillingId_'.$key,
									'value'=>$userData['FinalBilling']['id'],'div'=>false,'label'=>false));?>
							<?php echo $this->Form->hidden('totalAmount',array('id'=>'totalAmount_'.$key,
									'value'=>$userData['FinalBilling']['total_amount'],'div'=>false,'label'=>false));?>
							<?php echo $this->Form->hidden('amountPaid',array('id'=>'amountPaid_'.$key,
									'value'=>$userData['FinalBilling']['amount_paid'],'div'=>false,'label'=>false));?>
							<?php echo $this->Form->hidden('previousDiscount',array('id'=>'previousDiscount_'.$key,
									'value'=>$userData['FinalBilling']['discount'],'div'=>false,'label'=>false));?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $totalAmountSum;
							$totalAmount +=  (int) $totalAmountSum;?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $amountSum;
							$totalPaid +=  (int) $amountSum;?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $refundSum;
							$totalRefund +=  (int) $refundSum;?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $discountSum;
							$totalDiscount +=  (int) $discountSum;?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php $pendingAmount = ($totalAmountSum - $amountSum + $refundSum - $discountSum);
								 echo $pendingAmount;
								$totalPendingAmount +=  (int) $pendingAmount?>
						</td>
						
						<td class="tdLabel"  style= "text-align: left;">
							<?php echo $this->Form->input('date',array('name'=>'data[date]['.$userData['Patient']['id'].'][]','id'=>'date_'.$key,
							'class'=>'textBoxExpnd date','div'=>false,'label'=>false,'value'=>date('d/m/Y')));?>
						</td>
						
						<td class="tdLabel" style= "text-align: center;">
							<?php echo $this->Form->input('refund', array('name'=>'data[refund]['.$userData['Patient']['id'].'][]','id'=>'refund_'.$key,
							'type' => 'text','label'=>false ,'div'=>false,'class'=>'validate[required,custom[onlyNumber]] refund'));?>
						</td>
					
						<td class="tdLabel" colspan="2">
							<?php echo $this->Form->input('description',array('type'=>'textArea',
							'name'=>'data[description]['.$userData['Patient']['id'].'][]','id'=>'description_'.$key,'label'=>false,'class'=>'description')); ?>
						</td>
						
						<td>
							<?php echo $this->Html->link($this->Html->image('icons/saveSmall.png'),'javascript:void(0);', array('class'=>'save','escape' => false,'title' => 'Save', 'alt'=>'Save','id'=>'save_'.$key)); ?>
				  		</td>
				  	</tr>
			  	<?php }?>
				</tbody>
			<tr>
						<td class="tdLabel" colspan="0" style="text-align: left;"><?php echo __('Grand Total :');?></td>
						<?php if(empty($totalAmount)){ ?>
								<td class="tdLabel"><?php echo " ";?></td><?php
							}else{ ?>
								<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalAmount)?></td>
						<?php }
						if(empty($totalPaid)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalPaid)?></td>
						<?php }
						if(empty($totalRefund)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalRefund)?></td>
						<?php } 
						if(empty($totalDiscount)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalDiscount)?></td>
						<?php }
						if(empty($totalPendingAmount)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalPendingAmount)?></td>
						<?php }?>
						<td class="tdLabel"><?php echo " ";?></td>
						<td class="tdLabel"><?php echo " ";?></td>
						<td class="tdLabel" colspan="2"><?php echo " ";?></td>
						<td class="tdLabel"><?php echo " ";?></td>
						
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>

$(document).ready(function(){
	
	$(".save").hide();

	$( ".date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '-50:+50',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',
	});

	$(".save").click(function()
	{
		/*jQuery.each( $('.remaining_amount'), function( i, val ) {
			if($('#remaining_amount_'+i).val() !=''){
				console.log(i+'hello'+$('#remaining_amount_'+i).val());
			}
		});*/
		//var form_value = $("#update_corporate_amount").serialize();
		//alert(form_value);return false;
		var id = $(this).attr('id');
		id = id.split('save_');
		var refundAmount = $('#refund_'+id[1]).val(); 
		var date = $('#date_'+id[1]).val(); 
		var patientId = $('#pateintId_'+id[1]).val(); 
		var totalAmount = $('#totalAmount_'+id[1]).val(); 
		var description = $('#description_'+id[1]).val();
		var previousDiscount = $('#previousDiscount_'+id[1]).val();
		
		$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'updateCorporateAmount'));?>',
		data: {totalAmount : totalAmount,previousDiscount : previousDiscount,amountPaid : amountPaid,remainingAmount : remainingAmount,discountAmount : discountAmount,date : date,patientId : patientId,finalBillingId : finalBillingId,description : description},
		type: "POST",
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){
			$('#msg').html(data);
			$('#msg').fadeOut( 5000 );
			$('#busy-indicator').hide();
			if (data == 1) {
	            window.location = "<?php echo $this->Html->url(array('controller' => 'Accounting', 'action' => 'corporate_patient_details',$corporateName['TariffStandard']['id'])); ?>";
	            return false;
	        }
			//$('#msg').show();
		}
		});
	});
});

$(".refund").keyup(function(){
	if (/[^0-9\.]/g.test(this.value))
   	{
     this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	var id = $(this).attr('id');
	splttedArr = id.split("_");
	field = splttedArr[1];
	 var numbers = $("#refund_"+field).val();
	if(numbers >0)
	{	
		$("#save_"+field).show();
	}else
	{
		$("#save_"+field).hide();
	}
});

</script>
	