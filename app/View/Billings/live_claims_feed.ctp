<?php 
echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4','inline_msg','jquery.blockUI'));

?>
<style>
.selectedRow {
	background-color: #24483C; /* #64F3C8*/
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Live Claims Feed'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Billing',array('controller'=>'Billings','action'=>'liveClaimsFeed','id'=>'liveClaimsFeed','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table style="border: 1px solid rgb(76, 94, 100); margin: 10px;"
	width="100%">
	<tr>
		<td style="padding-left: 35px"><strong><?php echo __('Provider'); ?> </strong>
		</td>
		<td width="23%"><?php echo $this->Form->input('doctor_name', array('class' => 'textBoxExpnd','id' => 'doctor_name')); 
		echo $this->Form->hidden('doctor_id', array('type'=>'text','id'=>'doctor_id'));
		?>
		</td>
		<!-- <td>
			<?php //echo $this->Form->input('suffix1', array('options'=>array(""=>__('Please Select Type'),"CSJ"=>__('C.S.J. Sisters of St. Joseph'),"DC"=>__('D.C. Doctor of Chiropractic'),'class' => 'textBoxExpnd','id' => 'suffix'))); ?>
		</td>
		<td>
			<?php //echo $this->Form->input('suffix1', array('options'=>array(""=>__('Please Select Type'),"CSJ"=>__('C.S.J. Sisters of St. Joseph'),"DC"=>__('D.C. Doctor of Chiropractic'),'class' => 'textBoxExpnd','id' => 'suffix'))); ?>
		</td>
		 -->
		<td><strong><?php echo __('Claim Status'); ?> </strong></td>
		<td width="20%" style="padding-right: 1%;"><?php echo $this->Form->input('claim_status', array('empty' => 'Please Select','options'=>Configure::read('claim_status'),'class'=>'textBoxExpnd ','style'=>"width:250px",'id' => 'suffix')); ?>
		</td>
	</tr>
	<tr>
		<td width="20%" style="padding-left: 35px"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td width="20%"><?php echo $this->Form->input('lookup_name', array('type'=>'text','id'=>'lookup_name','class'=>'textBoxExpnd ')); ?>
		</td>
		<td><strong><?php echo __('Insurance'); ?> </strong></td>
		<td width="20%" style="padding-right: 1%;"><?php echo $this->Form->input('tariff_standard_id', array('tariff_standard_id','options'=>$tariffStandards,'empty'=>'Please Select')); ?>
		</td>
	</tr>
	<tr>
		<td width="20%" style="padding-left: 35px"><strong><?php echo __('From Date'); ?>
		</strong></td>
		<td class="tddate"><?php echo $this->Form->input('from',array('type'=>'text','id'=>"from",'class'=>'textBoxExpnd dateCalender','autocomplete'=>'off','readonly'=>'readonly'));?>
		</td>
		<td width="20%"><strong><?php echo __('To Date'); ?> </strong></td>
		<td class="tddate"><?php echo $this->Form->input('to',array('type'=>'text','id'=>"to",'class'=>'textBoxExpnd dateCalender','autocomplete'=>'off','readonly'=>'readonly'));?>
		</td>

	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td align="right"><?php echo $this->Form->button('Clear',array('class'=>'blueBtn','id'=>'clear'));?>
		</td>
		<td align="left"><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'Submit'));?>
		</td>
	</tr>

</table>
<?php echo $this->Form->end(); ?>
<table style="margin: 10px;">
	<tr>
		<?php echo $this->Form->create('liveClaimReport',array('url'=>array('controller'=>'Billings','action'=>'liveClaimReport','pdf'),'id'=>'liveClaimsFeed'));
		 echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'report', 'value' =>serialize($patientData)));?>
		<td align="center"><?php echo $this->Form->submit(__('Export to PDF'),array('class'=>'blueBtn'));?>
		</td>
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create('liveClaimReport',array('url'=>array('controller'=>'Billings','action'=>'liveClaimReport','excel'),'id'=>'liveClaimsFeed'));
		 echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'report', 'value' =>serialize($patientData)));?>
		<td align="center"><?php echo $this->Form->submit(__('Export to Excel'),array('class'=>'blueBtn'));?>
		</td>
		<?php echo $this->Form->end(); ?>
		<td align="center"><?php echo $this->Html->link(__('Print HCFA'), array('#'), array('escape' => false,'class'=>'blueBtn'));?>
		</td>
		<td align="center"><?php echo $this->Html->link(__('Print Superbill'),'#',array('id'=>'printSuperBill','class'=>'blueBtn'));?>
		</td>
		<td align="center"><?php echo $this->Html->link(__('Custom Export'), array('#'), array('escape' => false,'class'=>'blueBtn'));?>
		</td>
		<td align="center"><?php echo $this->Html->link(__('Re-submit Claims'), array('#'), array('escape' => false,'class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
<table style="margin: 10px" width="100%" >
	<tr>
		<th style="width: 80px"><?php echo __(count($patientData).' Claims')?>
		</th>
		<td><div id="pageNavPosition"></div></td>
	</tr>
</table>
<table style="margin: 10px;" width="100%" id="claimTable" cellspacing="0">
	<tr class="row_title">
		<td><?php echo __('Patient')?></td>
		<td><?php echo __('Visit')?></td>
		<td><?php echo __('Facility')?></td>
		<td><?php echo __('Provider')?></td>
		<td><?php echo __('Billed')?></td>
		<td><?php echo __('Allowed')?></td>
		<td><?php echo __('Adjustment')?></td>
		<td><?php echo __('Ins 1 Paid')?></td>
		<td><?php echo __('Ins 2 Paid')?></td>
		<td><?php echo __('Pt Paid')?></td>
		<td><?php echo __('Ins Bal')?></td>
		<td><?php echo __('Pt Bal')?></td>
		<td><?php echo __('Ins 1')?></td>
		<td><?php echo __('Ins 1 Status')?></td>
		<td><?php echo __('Action')?></td>
	</tr>
	<?php foreach($patientData as $data){
		$action=$data['FinalBilling']['id'];
		?>
	<tr class = "<?php echo $data['Patient']['id'] ?> selectable">
		<td class="table_cell"><?php echo $data['Patient']['lookup_name'];?></td>
		<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?>
		</td>
		<td class="table_cell"><?php echo $this->Session->read('facility');?>
		</td>
		<td class="table_cell"><?php echo $data['User']['first_name']. ' ' .$data['User']['last_name'];?>
		</td>
		<td class="table_cell"><?php echo ($data['FinalBilling']['total_amount'])? $currency.$data['FinalBilling']['total_amount']:$currency.'0';?>
		</td>
		<td class="table_cell"></td>
		<td class="table_cell"></td>
		<td class="table_cell"><?php echo ($data['FinalBilling']['amount_collected_ins_company'])? $currency.$data['FinalBilling']['amount_collected_ins_company']:$currency.'0';?>
		</td>
		<td class="table_cell"></td>
		<td class="table_cell"><?php echo ($data['FinalBilling']['collected_copay'])? $currency.$data['FinalBilling']['collected_copay']:$currency.'0';?>
		</td>
		<td class="table_cell"><?php echo $currency.((int) $data['FinalBilling']['amount_pending_ins_company'] - (int) $data['FinalBilling']['amount_collected_ins_company']);?>
		</td>
		<td class="table_cell"><?php echo $currency.((int) $data['FinalBilling']['copay'] - (int) $data['FinalBilling']['collected_copay']);?>
		</td>
		<td class="table_cell"><?php echo $data['TariffStandard']['name'];?></td>
		<td class="table_cell <?php echo $action." ".'td_'.$action ;?>"
			style="display: blok;"><?php echo $data['FinalBilling']['claim_status'];?>
		</td>
		<td class="table_cell <?php echo $action ." ".'drop_'.$action ;?>"
			style="display: none;"><?php echo $this->Form->input('claim_status', array('empty' => 'Please Select','options'=>Configure::read('claim_status'),'class'=>'textBoxExpnd status_drops','style'=>"width:200px",'id' => 'statusDrop_'.$action )); ?>
		</td>
		<td class="table_cell"><?php echo $this->Html->image('icons/uerInfo.png',array('title'=>'Change Claim Status','id'=>$action,'class'=>'action')) ?>
		</td>
	</tr>
	<?php  }?>
</table>
<div id="pageNavPosition"></div>
<script>
var pager = new Pager('claimTable', 20); 
var selectedRowId = '';
$(document).ready(function(){
	<?php if(!empty($patientData)) { ?>
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
	<?php } ?>
	
	$( '.selectable' ).click(function (){
		selectedRowId = '';
		if($( '.'+$(this).attr('class').split(' ')[0] ).hasClass('selectedRow') === true){
			$( '.'+$(this).attr('class').split(' ')[0] ).removeClass('selectedRow');
		}else{
			$( '.'+$(this).attr('class').split(' ')[0] ).addClass('selectedRow');
			selectedRowId = $(this).attr('class').split(' ')[0] ;
			
		}
		if($( document ).find('.selectable').hasClass('selectedRow') === true){
			$( document ).find('.selectable').removeClass('selectedRow');
			$( '.'+$(this).attr('class').split(' ')[0] ).addClass('selectedRow');
			selectedRowId = $(this).attr('class').split(' ')[0] ;
		}
	});

$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','null',"admin" => false,"plugin"=>false)); ?>", {
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
$('#expFile').click(function (){
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
	if(selectedRowId == ''){
		alert('Please Select Claim');
		return false;
	}
			$.fancybox({
				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'href' : '<?php echo $this->Html->url(array("controller"=>"Billings","action"=>"printSuperBill"));?>'+"/"+selectedRowId,
	
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
});
</script>
