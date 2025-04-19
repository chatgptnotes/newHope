<style>
 .red{
 	color: red;
 }
 
 </style> 
<div id="listContainer">
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('New Insurance Authorizations', true); ?>
	</h3>
	<span></span>
</div>
<?php echo $this->Form->create('Insurances',array('action'=>'newInsuranceAuthorization','id'=>'newInsuranceAuthorizationForm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
//debug($activeAuthorizations);debug($expiredAuthorizations);
echo $this->Form->hidden("InsuranceAuthorization.id", array('value'=>$data[InsuranceAuthorization][id]));
?>
<table style="margin: 10px;" width="80%" cellspacing="0" align="center">
	<tr>
		<td>
			<table style="margin: 10px;" width="100%" cellspacing="0" align="center">
				<tr>
					<td class="tdLabel"><?php echo __('Authorization Number')?><font color="red">*</font></td>
					<td><?php echo $this->Form->input('InsuranceAuthorization.authorization_number', array('class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'authorization_number','label'=>false,'value'=>$data[InsuranceAuthorization][authorization_number]));?></td>
				</tr>
				<tr>
					<td class="tdLabel"><?php echo __('Start Date')?><font color="red">*</font></td>
					<td><?php $start_date=$this->DateFormat->formatDate2Local($data[InsuranceAuthorization][start_date],Configure::read('date_format'),true);
					echo $this->Form->input('InsuranceAuthorization.start_date', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-date]]','readonly'=>'readonly','id' => 'start_date','label'=>false,'value'=>$start_date));?></td>
				</tr>
				<tr>
					<td class="tdLabel"><?php echo __('End Date')?></td>
					<td><?php $end_date=$this->DateFormat->formatDate2Local($data[InsuranceAuthorization][end_date],Configure::read('date_format'),true);
					echo $this->Form->input('InsuranceAuthorization.end_date', array('type'=>'text','class' => 'textBoxExpnd','readonly'=>'readonly','id' => 'end_date','label'=>false,'value'=>$end_date));?></td>
				</tr>
			</table>
		</td>
	
		<td>
			<table style="margin: 10px;" width="100%" cellspacing="0" align="center">
				<tr>
					<td class="tdLabel"><?php echo __('Number of visits')?><font color="red">*</font></td>
					<td><?php echo $this->Form->input('InsuranceAuthorization.visit_approved', array('class' => 'textBoxExpnd validate[required,custom[onlyNumber]]','id' => 'visits_approved','label'=>false,'value'=>$data[InsuranceAuthorization][visit_approved]));?></td>
				</tr>
				<tr>
					<td class="tdLabel"><?php echo __('Notes')?></td>
					<td><?php echo $this->Form->input('InsuranceAuthorization.notes', array('class' => 'textBoxExpnd','id' => 'notes','label'=>false,'value'=>$data[InsuranceAuthorization][notes]));?></td>
				</tr>
				<tr>
					<td class="tdLabel"><?php echo __('Procedure Codes')?></td>
					<td><?php echo $this->Form->input('InsuranceAuthorization.procedure_code', array('type'=>'text','class' => 'textBoxExpnd','id' => 'procedure_code','label'=>false,'value'=>$data[TariffList][name]));?>
					<?php echo $this->Form->hidden("InsuranceAuthorization.cbt", array('id'=>"cbt",'value'=>$data[InsuranceAuthorization][procedure_code])); ?>
					</td>
				</tr>	
			</table>
		</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td style="padding-right:33px;padding-top:10px"><?php 
		 echo $this->Form->button('Save', array('class'=>'blueBtn','style'=>'float:right;','type' => 'button','id'=>'saveNewInsurance'));
		?></td>
	</tr>
</table>
<?php //echo $this->element('alert'); ?>
<?php echo $this->Form->end(); ?>

<div class="inner_title" >
	<table style="margin: 10px;" width="100%" cellspacing="0">
	<tr>
		<td><h3>&nbsp;<?php echo __('Insurance Authorizations', true); ?></h3></td>
		<td><?php //echo $this->Form->button('Add New Authorization', array('class'=>'blueBtn','style'=>'float:right','type' => 'button','id'=>'addNewInsuranceAuthorization'));?></td>
	</tr>
	</table>
</div>
<div id="updatedList">
	<table style="margin: 10px;" width="100%" class="table_format" cellspacing="0">
		<tr class="row_title">
			<td class="table_cell"><?php echo __('Authorization Number')?></td>
			<td class="table_cell"><?php echo __('Procedure')?></td>
			<td class="table_cell"><?php echo __('Start Date')?></td>
			<td class="table_cell"><?php echo __('End Date')?></td>
			<td class="table_cell"><?php echo __('Visits Approved')?></td>
			<td class="table_cell"><?php echo __('Visits Remaining')?></td>
			<td class="table_cell"><?php echo __('Notes')?></td>
			<td class="table_cell"><?php echo __('Actions')?></td>
		</tr>
		<?php foreach($activeAuthorizations as $activeAuthorizations){ ?>
		<tr>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['authorization_number'];?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['TariffList']['name'];?></td>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2LocalForReport($activeAuthorizations['InsuranceAuthorization']['start_date'],Configure::read('date_format'),false);?></td>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2LocalForReport($activeAuthorizations['InsuranceAuthorization']['end_date'],Configure::read('date_format'),false);?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['visit_approved'];?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['visit_remaining'];?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['notes'];?></td>
			<td class="tdLabel">
			<?php echo $this->Html->image('icons/edit-icon.png',array('alt'=>'Edit','title'=>'Edit Insurance Authorization','class'=>'edit','id'=>'edit_'.$activeAuthorizations['InsuranceAuthorization']['id']));?>
			<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'Delete Insurance Authorization','class'=>'delete','id'=>'delete_'.$activeAuthorizations['InsuranceAuthorization']['id']));?>
			</td>
		</tr>
	<?php }?>
</table>


<div class="inner_title">
	<td><h3>
		&nbsp;<?php echo __('Expired Authorizations', true); ?>
	</h3></td>
	<span></span>
</div>
<table style="margin: 10px;" width="100%" class="table_format" cellspacing="0">
	<tr class="row_title">
		<td class="table_cell"><?php echo __('Authorization Number')?></td>
		<td class="table_cell"><?php echo __('Procedure')?></td>
		<td class="table_cell"><?php echo __('Start Date')?></td>
		<td class="table_cell"><?php echo __('End Date')?></td>
		<td class="table_cell"><?php echo __('Visits Approved')?></td>
		<td class="table_cell"><?php echo __('Visits Remaining')?></td>
		<td class="table_cell"><?php echo __('Notes')?></td>
		<td class="table_cell"><?php echo __('Actions')?></td>
	</tr>
	<?php foreach($expiredAuthorizations as $expiredAuthorization){?>
	<tr>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['authorization_number'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['TariffList']['name'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['start_date'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['end_date'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['visit_approved'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['visit_remaining'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['notes'];?></td>
		<td class="tdLabel">
			<?php echo $this->Html->image('icons/edit-icon.png',array('alt'=>'Edit','title'=>'Edit Insurance Authorization','class'=>'edit','id'=>'edit_'.$expiredAuthorization['InsuranceAuthorization']['id']));?>
			<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'Delete Insurance Authorization','class'=>'delete','id'=>'delete_'.$expiredAuthorization['InsuranceAuthorization']['id']));?>
			</td>
	</tr>
<?php }?>
</table>
</div>
</div>

<script>
		
$(document).ready(function(){
	/*$("#procedure_code").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList","cbt","name",'service_category_id=36',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'name,cbt'
	});*/

	$( "#procedure_code" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","TariffList","cbt&name",'service_category_id=36',"no",'no',"admin" => false,"plugin"=>false)); ?>" ,
		 minLength: 1, 
		 select: function( event, ui ) {
			 $('#cbt').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	
		
var httpRequestNewInsuranceURL = '';
var newInsuranceURL = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "newInsuranceAuthorization",$patientId,"admin" => false)); ?>" ; 
 

$("#saveNewInsurance").click(function() {
	var validateMandatory = jQuery("#newInsuranceAuthorizationForm").validationEngine('validate');
	if(validateMandatory == false){
		return false;
	}
	
	if(httpRequestNewInsuranceURL) httpRequestFileCashBookSet.abort();
	var formData = $("#newInsuranceAuthorizationForm").serialize();
	var httpRequestNewInsuranceURL = $.ajax({
		  beforeSend: function(){
			  //loading(); // loading screen
		  },
	      url: newInsuranceURL,
	      context: document.body,
	      data : formData, 
	      type: "POST",
	      success: function(data){ 
	    	 location.reload(true);
		     // parent.$.fancybox.close();
 		  },
		  error:function(){
			  BootstrapDialog.alert('Please try again');
		  }
	});
});

$( "#start_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
});

$( "#end_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
});

$(document).on('click','.edit',function (){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");
	recordId = splittedVar[1];
	var flag="edit";
	//var editInsuranceAuthorizationURL = "<?php //echo $this->Html->url(array("controller" => 'Insurances', "action" => "newInsuranceAuthorization","admin" => false)); ?>"+"/"+recordId+"/"+flag ;
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "newInsuranceAuthorization",$patientId,"admin" => false)); ?>"+"/"+recordId,
		  context: document.body,	
		  //data : formData, 	  		  
		  success: function(data){
			 // parent.location.reload(true);
			 $("#listContainer").html(data);
		  }
	});	
});


$(document).on('click','.delete',function (){
	if(confirm("Do you really want to delete this record?")){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");
	recordId = splittedVar[1];
 	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "deleteInsuranceAuthorization", "admin" => false)); ?>"+"/"+recordId+"/"+"<?php echo $patientId ;?>",
		  context: document.body,	
		  //data : formData, 	  		  
		  success: function(data){
 			 // parent.location.reload(true);
			  $("#updatedList").html(data);
		  }
	});	
	}else{
        return false;
    }	 
});

});
</script>