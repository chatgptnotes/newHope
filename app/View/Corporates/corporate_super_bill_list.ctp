<?php echo $this->Html->css(array( 'jquery.fancybox'));  
 	  echo $this->Html->script(array('jquery.fancybox','inline_msg')); 
 	 ?> 
<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } ?>

<div class="inner_title">
	<h3><?php echo __('Corporate Super Bills'); ?></h3>
	<span>
		<?php
			echo $this->Html->link(__('Generate Super Bill'),array('controller'=>'Corporates','action'=>'generate_super_bill'), array('escape' => false,'class'=>'blueBtn')); 
		?>
	</span>
	<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('type'=>'GET'));?>
<table width="" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>Bill No : </td>
		<td><?php echo $this->Form->input('super_bill_no',array('type'=>'text','div'=>false,'label'=>false,'class'=>'textBoxExpnd super_bill_no','value'=>''));?></td>
		<td>Patient Name : </td>
		<td><?php echo $this->Form->input('lookup_name',array('type'=>'text','div'=>false,'label'=>false,'class'=>'textBoxExpnd lookup_name','value'=>'')); 
				  echo $this->Form->hidden('person_id',array('id'=>'person_id','value'=>$_GET['person_id']));?></td>
		<td><?php echo $this->Form->submit(__('Submit'),array('type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'submit'));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'corporate_super_bill_list'),array('escape'=>false));?></td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>

<?php if(!empty($results)) { ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" style="margin-top:10px;">
	<thead>
		<tr>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Sr.No');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Patient Name');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Super Bill No');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Patient Type');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Total Amount');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Approved Amount');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Total Received');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Created');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Date Of Settlement');?></th>
			<th align="center" valign="middle" style="text-align: center;"><?php echo __('Action');?></th> 
		</tr>
	</thead>
	
	<tbody>
		<?php if(count($results)>0){  $count = 1;
			foreach ($results as $key => $val) { ?>
				<tr>
					<td align="center" valign="middle" style="text-align: center;"><?php echo $count++; ?></td>
					<td align="center" valign="middle" style="text-align: center;"><?php echo $val[0]['lookup_name'];?></td>
					<td align="center" valign="middle" style="text-align: center;"><?php echo $val['CorporateSuperBill']['super_bill_no'];?></td>
					<td align="center" valign="middle" style="text-align: center;">
						<?php $options=array('General'=>'General','Semi-Private'=>'Semi-Private','Private'=>'Private');
						echo $this->Form->input('patient_type',array('div'=>false,'label'=>false,'class'=>'validate[required,mandatory-select]',
								'value'=>$val['CorporateSuperBill']['patient_type'],'superBill'=>$val['CorporateSuperBill']['id'],
								'prev_selected'=>$val['CorporateSuperBill']['patient_type'],
								'autocomplete'=>"off",'name'=>"data[Patient][patient_type]",'id'=>'patient_type','options'=>$options));
						?>
					</td>
					<td align="center" valign="middle" style="text-align: center;"><?php echo $val['CorporateSuperBill']['total_amount'];?></td>
					<td align="center" valign="middle" style="text-align: center;"><?php 
					//if(!$val['CorporateSuperBill']['bill_settled_date']){
						echo $this->Form->input('approved_amount',array('type'=>'text','id'=>'approved',
												'value'=>$val['CorporateSuperBill']['approved_amount'],'class'=>'validate[required,onlyNumbers]',
												'superBill'=>$val['CorporateSuperBill']['id'],'label'=>false));
					//}else{
						//echo $val['CorporateSuperBill']['approved_amount'];
					//}
					?></td>
					<td align="center" valign="middle" style="text-align: center;">
					<?php $recAmt=$val[0]['total_received']+$cardAdvance['Account']['card_balance'];
					if($recAmt>$val['CorporateSuperBill']['total_amount']){
						$excessAmt=$recAmt-$val['CorporateSuperBill']['total_amount'];
						echo $recAmt.'&nbsp '.$this->Html->link($this->Html->image('icons/exlpoint.jpeg', array('alt' => __('Excess Amount'),'title' => __('Add Extra service'),'onclick'=>"addEstraService(".$val['CorporateSuperBill']['id'].",".$excessAmt.")")),'javascript:void(0)', array('style'=>'float:right','escape' => false,'id'=>'excess'));
					}else{
						echo $recAmt;
					}
					?></td>
					<td align="center" valign="middle" style="text-align: center;"><?php echo $this->DateFormat->formatDate2Local($val['CorporateSuperBill']['created_time'],Configure::read('date_format'),true);?></td>
					<td align="center" valign="middle" style="text-align: center;"><?php echo $this->DateFormat->formatDate2Local($val['CorporateSuperBill']['bill_settled_date'],Configure::read('date_format'),true);?></td>
					<td align="center" valign="middle" style="text-align: center;">
					
					<?php  	
					
					if(!$val['CorporateSuperBill']['bill_settled_date'])
						echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit'),'title' => __('Edit'),'onclick'=>"editPayment(".$val['CorporateSuperBill']['id'].")")),'javascript:void(0);', array('escape' => false));
					
					if($recAmt >0 && $recAmt<=$val['CorporateSuperBill']['total_amount'] && !$val['CorporateSuperBill']['bill_settled_date'])						
						echo $this->Html->link($this->Html->image('icons/money.png', array('alt' => __('Bill Settlement'),'title' => __('Bill Settlement'))),array('controller'=>'Billings','action'=>'superBillServices',$val['CorporateSuperBill']['id']), array('escape' => false));

						echo $this->Html->link($this->Html->image('icons/upload-excel.png',array('title'=>'GenerateExcel')),array("controller" =>'Corporates',"action" => "getExcel",$val['CorporateSuperBill']['id'],/*$val['TariffStandard']['name'],*/"admin" => false),array('id'=>'corpExcel','escape' => false));
					
					if(!$val['CorporateSuperBill']['bill_settled_date'])
						echo $this->Html->link($this->Html->image('icons/delete-icon.png'),array('action' => 'corporateSuperBillDelete',$val['CorporateSuperBill']['id']), 
		        					array('escape' => false,'class'=>'deleteAdvanceEntry','id'=>'deleteAdvanceEntry_'.$val['CorporateSuperBill']['id']),__('Are you sure?', true));
						?></td> 
				</tr>
		<?php }//end of foreach
			 } else { ?>
			<tr>
				<td colspan="6"><b>No result found..!!</b></td>
			</tr>
		<?php }?>	
	</tbody>
<?php }?>


<script type="text/javascript">
$(document).ready(function(){
	$(".lookup_name").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no",'is_discharge=1&tariff_standard_id!='.$pvtTariffId,"admin" => false,"plugin"=>false)); ?>", 
		select: function(event,ui){ 
			console.log(ui.item);
				$("#person_id").val(ui.item.person_id);
		},
		messages: {
	         noResults: '',
	         results: function() {},
	  	}
	});
});

	$(document).ready(function(){
		$(".super_bill_no").autocomplete({
		    source: "<?php echo $this->Html->url(array("controller" => "Corporates", "action" => "getSuperBillNoAuto","admin" => false,"plugin"=>false)); ?>", 
			select: function(event,ui){ 
					//$("#person_id").val(ui.item.person_id);
			},
			messages: {
		         noResults: '',
		         results: function() {},
		  	}
		});
	});

	function editPayment(superBillId){ 
	
		$.fancybox({
			'autoDimensions':false,
	    	'width'    : '85%',
		    'height'   : '90%',
		    'autoScale': true,
		  	'transitionIn': 'fade',
		    'transitionOut': 'fade', 
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200,				    
		    'type': 'iframe', 
		     'afterClose': function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose" 
		    	 parent.location.reload(true);
	         },
		    'helpers'   : { 
		    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
		    	  },
		    'href' : "<?php echo $this->Html->url(array("controller" =>"Corporates","action" =>"receiveCorporateAmount","admin"=>false)); ?>/"+superBillId ,
		});
	}

	function addEstraService(superBillId,excessAmt){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addExtraService", "admin" => false)); ?>"+"/"+superBillId+"/"+excessAmt,
			  context: document.body,
			  success: function(data){ 
				  parent.location.reload();
				  $("#busy-indicator").hide();			  
			  },
			  beforeSend:function(){$("#busy-indicator").show();
			  },		  
			});
		
	}

	$('#patient_type').change(function(){
		var prev=$(this).attr('prev_selected');
		var selected=$(this).val();
		currentId=$(this).attr('id');
		var superBillId=$(this).attr('superbill');
		var msg="Changing Patient type to "+selected+". Do you want to change patient type ?";
		ret=confirm(msg);
		if(ret){
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Html->url(array("controller"=>"Corporates","action"=>'updatePatientType','admin'=>false));?>",
			data:"superBillId="+superBillId+"&patient_type="+selected,
			dataType:"text",
			 context: document.body,
			 beforeSend:function(){
				 $("#busy-indicator").show();
				 inlineMsg(currentId,'Updating Patient Type...',false);
			 },
			 success: function(data){ 
				 if(data){
				  //parent.location.reload();
				  $("#busy-indicator").hide();
				  inlineMsg(currentId,'Patient Type Updated',false);	
				  $(this).attr('prev_selected',prev);
				 }			  
			  },
			});
		}else{
			parent.location.reload();			
		}
		
	});

	$('#approved').blur(function(){
		var valid = jQuery("#superBill").validationEngine('validate'); 
		if(!valid){ 
			return false;
		}
	});

	$('#approved').blur(function(){
		var approveAmt=$(this).val();
		currentId=$(this).attr('id');
		var superBillId=$(this).attr('superbill');
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Html->url(array("controller"=>"Corporates","action"=>'updateApprovedAmt','admin'=>false));?>",
			data:"superBillId="+superBillId+"&approved_amount="+approveAmt,
			dataType:"text",
			 context: document.body,
			 beforeSend:function(){
				 $("#busy-indicator").show();
				 inlineMsg(currentId,'Updating Approved Amount...',false);
			 },
			 success: function(data){ 
				  if(data){
					  //parent.location.reload();
					  $("#busy-indicator").hide();
					  inlineMsg(currentId,'Approved Amount Updated',false);	
				  }			  
			  },
			});

	});
</script>