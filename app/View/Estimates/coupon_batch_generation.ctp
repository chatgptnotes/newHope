<style>
label {
	width: 31px;
	padding: 0px;
}

.ui-widget-header {
	color: white;
}

.tdLabel {
	color: #000;
	font-size: 13px;
	padding-left: 15px !important;
	padding-right: 0px !important;
	padding-top: 5px !important;
	text-align: left;
}
</style>

<div class="clr ht5"></div>
<div class="inner_title">
	<h3>
		<?php echo __('Coupon Generation ', true); ?>
	</h3>
	<span> <?php echo $this->Html->link(__('Add', true),"javascript:void(0);", array('escape' => false,'class'=>'blueBtn','id'=>'addcoupon')); 
	//echo $this->Html->link(__('Back', true),array('action' => 'couponNumberGenration'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
<div class="clr ht5"></div>
<div id='generatecoupen' style="display: none">
	<?php 
	echo $this->Form->create('Coupon',array('url'=>array('controller'=>'Estimates','action'=>'couponBatchGeneration'),'type'=>'post',
			'id'=>'couponGeneration','inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));
	echo $this->Form->hidden('id',array('id'=>'id'));
	if($action=='edit'){
		$display  = '' ; $displayList = 'none';
	}else $display = 'none';
	?>

	<table class="tdLabel formFull" width="100%" border="0" cellspacing="0" style="max-width: 1000px; display:<?php  //echo$display; ?>;"; ">
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Type'); ?><font color="red">*</font></td>
			<td width="30%"><?php echo $this->Form->radio('Coupon.type',array('Privilege Card'=>'Privilege Card','Coupon'=>'Coupon'),
					array('legend'=>false,'label'=>false,'class' => 'validate[required,custom[mandatory-select]] ','unchecked'=>true));?>
			</td>
			<td width="">&nbsp;</td>
		<tr>
			<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Branch'); ?><font
				color="red">*</font></td>
			<td width="30%"><?php echo $this->Form->input('Coupon.branch', array('empty'=> 'Please select','options'=>$branches,
					'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'branch')); ?>
			</td>
		</tr>
		<tr>
			<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Batch Name');?><font
				color="red">*</font></td>
			<td width="30%"><?php echo $this->Form->input('Coupon.batch_name', array('type'=>'text','maxlength'=>'10','readonly'=>'readonly','id' =>'batchName'));?>
			</td>
		</tr>
		<tr>
			<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('No. of Coupons');?><font
				color="red">*</font></td>
			<td width="30%"><?php echo $this->Form->input('Coupon.no_of_coupons', array('label'=>false,'type'=>'text',
					'class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','maxlength'=>'10','id' => 'couponNo','autocomplete'=>"off"));?>
			</td>
		</tr>
		<tr>
			<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Valid From');?><font
				color="red">*</font></td>
			<td colspan="2" width="30%"><?php 
					echo $this->Form->input('Coupon.valid_date_from', array('class'=>'validate[required,custom[mandatory-date]] fromDate','id'=>'fromDate',
						'type'=>'text','style'=>'float:left;width:140px;','autocomplete'=>"off")); ?>
			</td>
		</tr>
		<tr>
			<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Valid to')?><font
				color="red">*</font></td>
			<td colspan="2" width="30%"><?php echo $this->Form->input('Coupon.valid_date_to', array('class' =>'validate[required,custom[mandatory-date]]  fromDate',
												'id'=>'toDate','type'=>'text','style'=>'width:140px;float:left;','autocomplete'=>"off"));?></td>
		</tr><?php $sevices_available =$services ;?>
		<?php foreach($this->request->data['Coupon']['coupon_amount'] as $key=>$value){ ?>
		
		<?php  unset($sevices_available[$value['serviceId']]);
			} ?>
		<tr>
			<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Services Available');?><font
				color="red">*</font></td>
			<td width="30%" ><?php echo $this->Form->input('Coupon.sevices_available', array('empty'=>'Please Select','options'=>$sevices_available ,'multiple'=>true,
					 'style'=>'height:72px;width:200px','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'sevicesId')); ?></td>
					 
			<td width="30%"><?php echo $this->Form->button('Coupon Services', array('name'=>'Coupon Services','type'=>'button','class'=>'','id' => 'sevices')); ?></td>
		</tr>
		<tr><td colspan="2">
		<table>
		<?php foreach($this->request->data['Coupon']['coupon_amount'] as $key=>$value){?>
		<tr>
		<td width = "180px" style= "text-align: bold"><?php echo $services[$value['serviceId']];
		echo $this->Form->input("Coupon.coupon_amount.$key.serviceId", array('readonly' => false, 'legend' => false,'type'=>'hidden',
                'label' => false, 'div' => false, 'class' => '','value'=>$value['serviceId']));?>
		</td>
		<td width = "100px"><?php 
		
		$discount = array('Amount' => 'Amount', 'Percentage' => 'Percentage');
          		  echo $this->Form->input("Coupon.coupon_amount.$key.type", array('options' => $discount, 'readonly' => false, 'legend' => false,
                'label' => false, 'div' => false, 'style' => 'width:120px','value'=>$value['type']));
		?>
		</td>
		<td width = "178px"><?php echo $this->Form->input("Coupon.coupon_amount.$key.value", array('id' => $key."coupon_amount", 'autocomplete' => 'off','label'=>false,'div'=>false,
				'value'=>$value['value'])); ?>
		</td>
		</tr><?php }?>
		<tr id="rows">
		  <td ></td>
		</tr>
		</table>
		
		</td>
		</tr>

	
	
	</table>
	<table width="66%">
		<tr>
			<td class="row_title" align="right"><?php
			echo $this->Form->submit(__('Submit'),array('style'=>'margin: 0 10px 0 0;','class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'submit'));
			echo $this->Html->link(__('Cancel',true),array('action'=>'couponBatchGeneration'),array('escape' => false,'id'=>'add-cancel','class'=>'blueBtn'));
			?>
			</td>
		</tr>
	</table>
<?php echo $this->Form->end();?>
</div>
<div id='listing'>
	<table class="tabularForm " width="100%" border="1" cellspacing="0" cellpadding="0" style="display:<?php echo $displayList;?>"  >
		<tr>
		<thead>
			<th width="81px" valign="top" align="center"
				style="text-align: center;">Coupon Type</th>
			<th width="83px" valign="top" align="center"
				style="text-align: center;">Batch Name</th>
			<th width="81px" valign="top" align="center"
				style="text-align: center;">Valid From</th>
			<th width="81px" valign="top" align="center"
				style="text-align: center;">Valid To</th>
			<th width="81px" valign="top" align="center"
				style="text-align: center;">Action</th>
		</thead>
		</tr>
	<?php if(count($couponData) > 0) {
    foreach($couponData as $result){
    	$couponId = $result['Coupon']['id'];
    	?>
		<tr>
			<td width="81px" style="text-align: center;"><?php echo $result['Coupon']['type'];?>
			</td>
			<td width="83px" style="text-align: center;"><?php 
			echo $result['Coupon']['batch_name'];   ?>
			</td>
			<td width="81px" style="text-align: center;"><?php	
			echo $this->DateFormat->formatDate2Local($result['Coupon']['valid_date_from'],Configure::read('date_format'));
			?>
			</td>
			<td width="81px" style="text-align: center;"><?php echo $this->DateFormat->formatDate2Local($result['Coupon']['valid_date_to'],Configure::read('date_format'));?>
			</td>
			<td width="81px"><?php 
			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
						'alt'=> __('Edit', true))), array('controller'=>'Estimates','action' => 'couponBatchGeneration',$couponId), array('style'=>'','escape' => false ));
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
						'alt'=> __('View', true))), array('controller'=>'Estimates','action' => 'viewCoupon',$couponId), array('style'=>'','escape' => false ));
                       // echo $this->Html->link($this->Html->image('icons/print.png', array('title'=> __('Print', true),
						//'alt'=> __('Print', true))), array('controller'=>'Estimates','action' => 'printCoupon',$couponId), array('style'=>'','escape' => false ));
			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
					'alt'=> __('Delete', true))), array('controller'=>'Estimates','action' => 'deleteCoupon',$couponId), array('style'=>"align:center;",'escape' => false ),
					"Are you sure you wish to delete this Coupon?");
			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Coupon')),'#',
				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Estimates','action'=>'printCoupon',$couponId
				))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;")); ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<TD colspan="8" align="center"><?php 
			echo $this->Paginator->counter(array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true), array('complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    		'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links'));
			echo $this->Paginator->numbers();
			echo $this->Paginator->next(__('Next »', true), array('complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    		'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
			<span class="paginator_links"> </span>
			</TD>
		</tr>
		<?php } else { ?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found.', true); ?></TD>
		</tr>
		<?php } ?>
	</table>
</div>
<script>
jQuery(document).ready(function(){
	jQuery("#couponGeneration").validationEngine();	
 	var action = '<?php echo $action?>';	
 	if(action == 'edit'){ 
		$("#generatecoupen").show() ;
		$("#listing").hide();
 	}	
	$("#addcoupon").click(function(){
		$("#generatecoupen").show('slow');
		$("#listing").hide();
	}); 
	$("#sevices").click(function(){
		$("#couponAmt").show('slow');
		$('#sevicesId').val();
		var key = 0;
	var amtData ='<?php echo $this->request->data['Coupon']['coupon_amount']?>';	
		$('#sevicesId :selected').each(function(i, selected){ 
			//console.log($(this).val());
			  $('#rows').append($('<tr>')
			             .append($('<td>').text($(selected).text()).css('width','180px').attr({'id':'service-'+key})
								 	.append($('<input>').attr({'name':'data[Coupon][coupon_amount]['+$(selected).val()+'][serviceId]','type':'hidden','value':$(selected).val()})))
			             .append($('<td>').append($('<select>').css('width','100px')
				 		 			.append(new Option("Amount", "Amount"),new Option("Percentage", "Percentage")).css('width','131px').attr({'name':'data[Coupon][coupon_amount]['+$(selected).val()+'][type]','id' : 'type-'+key})))
			             .append($('<td>').append($('<input>').css({'width':'178px'})
					 				.attr({'name':'data[Coupon][coupon_amount]['+$(selected).val()+'][value]','id':'serviceamt-'+key}))));
				  key++;
			}); 
		$('#sevicesId :selected').remove();
	}); 

	
	
	$(".fromDate").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	
		onSelect : function() {
			$(this).focus();	
		}
	});	
	
	$( "#couponGeneration").click(function(){
		$('.fromDate').validationEngine('hide');
		   var fromdate = new Date($( '#fromDate' ).val());
	     var todate = new Date($( '#toDate' ).val());
	     if(fromdate.getTime() > todate.getTime()) {
	    $('.fromDate').validationEngine('showPrompt', 'Valid to date should be greater than valid from date');
	     return false;
	    }
	});	
	
	/*	$('#sevicesId').change(function (){
			if($(this).val() == 'Laboratory Services'){
				$('#couponAmt').val('50%');
				$('#couponAmt').attr('readonly',true);
				
			}else if($(this).val() == 'Radiology Services'){
				$('#couponAmt').val('1000');
				$('#couponAmt').attr('readonly',true);
			}else {
				$('#couponAmt').val(' ');
				$('#couponAmt').attr('readonly',false);
			}
		}); */
		
	 $("#couponAmt").focusout(function(){
			if($(this).val() > 100)
		        $('#couponAmt').validationEngine('showPrompt', 'Percentage can not be greater than 100');
		});
	 
		
});
</script>