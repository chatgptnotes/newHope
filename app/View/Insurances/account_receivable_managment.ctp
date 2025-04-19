<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg','jquery.blockUI'));
?>
<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable By Insurance');?> |
		<?php echo $this->Html->link('View By Patient',array('controller'=>'Insurances','action'=>'account_receivable_patient'));?> |
		<?php echo $this->Html->link('Summary',array('controller'=>'Accounting','action'=>'paymentRecieved'));?>
	</h3>
</div>
<?php echo $this->Form->create('Insurances',array('url'=>array('controller'=>'Insurances','action'=>'acc_recevable_managment_excel',$insurance_company_id,$month,$amount),'id'=>'accRecevableManagmentExcel','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));?>
<table cellspacing="1" cellpadding="0" border="0" width="100%" align="center" class="tabularForm" style="margin-top: 40px;">
	<tr class="row_title">
		<th><?php echo __('Payer Id #')?></th>
		<th><?php echo __('Insurance Company')?></th>
		<th><?php echo __('0-30 Days (in $)')?></th>
		<th><?php echo __('31-60 Days (in $)')?></th>
		<th><?php echo __('61-90 Days (in $)')?></th>
		<th><?php echo __('91-120 Days (in $)')?></th>
		<th><?php echo __('121+ Days (in $)')?></th>
		<th><?php echo __('Total (in $)')?></th>
	</tr>
	<tr>
		<td class="table_cell"><?php echo ($insData[0]['TariffStandard']['payer_id'])? $insData[0]['TariffStandard']['payer_id']:'';?></td>
		<td class="table_cell"><?php echo ($insData[0]['TariffStandard']['name'])? $insData[0]['TariffStandard']['name']:'';?></td>
		<td class="table_cell" align="right"><?php echo ($month=='1')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month=='2')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month=='3')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month=='4')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month>'4')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo  $this->Number->currency($amount);?></td>
	</tr>
</table>
<table style="margin: 10px" width="100%">
	<tr>
		
		<td align="left"><?php $cancelBtnUrl =  array('controller'=>'Insurances','action'=>'claim_balance_company');?>
	    <?php  echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
		<td align="right"><?php echo $this->Html->link(__('Print'),'',
						     		array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Insurances','action'=>'accRecevableManagment',$insurance_company_id,$month,$amount))."', '_blank',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>

		<?php echo $this->Form->submit('Export To File', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<table cellspacing="1" cellpadding="0" border="0" width="100%" align="center" class="tabularForm" style="margin-top: 40px;" id="claimTable">
	<tr class="row_title">
		<th><?php echo __('Patient')?></th>
		<th><?php echo __('Visit')?></th>
		<th><?php echo __('Date Of Birth')?></th>
		<th><?php echo __('Ins Id #')?></th>
		<th><?php echo __('Note')?></th>
		<th><?php echo __('Bill No.')?></th>
		<th><?php echo __('Billed (in $)')?></th>
		<!--<th><?php echo __('Allowed')?></th> -->
		<!--<th><?php echo __('Adjustment')?></th> -->
		<th><?php echo __('Ins Resp (in $)')?></th>
		<th><?php echo __('Ins 1 Paid (in $)')?></th>
		<th><?php echo __('Ins 2 Paid (in $)')?></th>
		<th><?php echo __('Pt Resp (in $)')?></th>
		<th><?php echo __('Pt Paid (in $)')?></th>
		<th><?php echo __('Ins Bal (in $)')?></th>
		<th><?php echo __('Pt Bal (in $)')?></th>
		<th><?php echo __('Status')?></th>
		<th><?php echo __('Details')?></th>
	</tr>
	<?php foreach($insData as $data){
	//$ptid=$data['Patient']['id'];
	?>
	<tr>
		<td class="table_cell"><?php echo $data['Patient']['lookup_name'];?></td>
		<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?></td>
		<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($data['Person']['dob'],Configure::read('date_format'),false);?></td>
		<td class="table_cell"><?php echo $data['NewInsurance']['insurance_number'];?></td>
		<td class="table_cell"><?php echo $data['DumpNote']['note'];?></td>
		<td class="table_cell"><?php echo $data['FinalBilling']['bill_number'];?></td>
		<td class="table_cell" align="right"><?php echo ($data['FinalBilling']['total_amount'])? $currency.($data['FinalBilling']['total_amount']):$currency.'0';?></td>
		<!-- <td class="table_cell"></td> -->
		<!-- <td class="table_cell"></td> -->
		<td class="table_cell" align="right"><?php echo $currency.($data['FinalBilling']['amount_pending_ins_company'] + $data['FinalBilling']['amount_pending_ins_2_company']);?></td>
		<td class="table_cell" align="right"><?php echo ($data['FinalBilling']['amount_collected_ins_company'])? $currency.$data['FinalBilling']['amount_collected_ins_company']:$currency.'0';?></td>
		<td class="table_cell" align="right"><?php echo ($data['FinalBilling']['amount_pending_ins_2_company'])? $currency.$data['FinalBilling']['amount_pending_ins_2_company']:$currency.'0';?></td>
		<td class="table_cell" align="right"><?php echo ($data['FinalBilling']['copay'])? $currency.( $data['FinalBilling']['copay']):$currency.'0';?></td>
		<td class="table_cell" align="right"><?php echo ($data['FinalBilling']['collected_copay'])? $currency.$data['FinalBilling']['collected_copay']:$currency.'0';?></td>
		<td class="table_cell" align="right"><?php echo $currency.(( $data['FinalBilling']['amount_pending_ins_company'] -  $data['FinalBilling']['amount_collected_ins_company']) + ($data['FinalBilling']['amount_pending_ins_2_company'] -  $data['FinalBilling']['amount_collected_ins_2_company']));?></td>
		<td class="table_cell" align="right"><?php echo $currency.( $data['FinalBilling']['copay'] - $data['FinalBilling']['collected_copay']);?></td>
		<td class="table_cell"><?php echo $data['FinalBilling']['claim_status'] ?></td>
		<td class="table_cell"><a href="javascript:ptdetails(<?php echo $data['Patient']['id']; ?>)"><?php echo $this->Html->image('icons/uerInfo.png',array('title'=>'Patient Details')) ?></a></td>
	</tr>
	<?php  }?>
</table>

<script>
var pager = new Pager('claimTable', 20); 
$(document).ready(function(){
	<?php if(!empty($patientData)) { ?>
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
	<?php } ?>
});

$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true
});
$("#doctor_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'doctor_name,doctor_id'
});

$(".dateCalender")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange : '-73:+0',
			//maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});
$('#expFile').click(function(){
	var ajaxUrl = '<?php echo $this->Html->url(array("controller" => "Billings", "action" => "liveClaimReport","admin" => false)); ?>';
	 
	   var dataToSend = {'patientData' : <?php echo json_encode($patientData); ?> } ;
	    $.ajax({
         type: 'POST',
         url: ajaxUrl,
         data: dataToSend,        
         error: function(message){
             alert("Internal Error Occured. Unable To Generate Report.");
             return false ;
         },        
         });
});
$('#printSuperBill').click(function(){
			$.fancybox({
				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
			//	 'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "ward_overview")); ?>" 
				'href' : "<?php echo $this->Html->url(array("controller"=>"Billings","action"=>"printSuperBill"));?>"+"/"+"<?php echo $Patients_id?>"
	
			});
});

$('.action').click(function (){
	var recordId = $(this).attr('id');
	$('.'+recordId).toggle();
});

$(".status_drops").change(function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	recordId = splittedVar[1];
	value = $(this).val();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "liveClaimsFeed",$patient_id, "admin" => false)); ?>"+"/"+recordId,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){					  
			  //$('#busy-indicator').hide('fast');
			  inlineMsg(currentId,'Updated');
			  ids = currentId.split("_");
			  $('.'+ids[1]).toggle();
			  $('.td_'+ids[1]).html(value);
			  onCompleteRequest();
		  }
	});		 
});

function loading(){
	 $('#claimTable').block({ 
        message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please Wait...</h1>', 
        css: {            
            padding: '5px 0px 5px 18px',
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px',               
            color: '#fff',
            'text-align':'left' 
        },
        overlayCSS: { backgroundColor: '#cccccc' } 
    }); 
}

function onCompleteRequest(){
	$('#claimTable').unblock(); 
}

function ptdetails(patient_id) {  
	if (patient_id == '') {
		alert("Something went wrong");
		return false;
	} 
	$("#Patientsid").val(patient_id);
	$.fancybox({ 
				'width' : '60%',
				'height' : '70%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe', 
				'href' : "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "detailClaim")); ?>" + '/' + patient_id,
	});
}
</script>