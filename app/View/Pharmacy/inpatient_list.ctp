<?php echo $this->Html->script(array('inline_msg','permission','jquery.blockUI','jquery.fancybox'));
echo $this->Html->css(array('jquery.fancybox'));  
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');

if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php }
if($this->params->query['type']=='OPD'){
	$urlType= 'Ambulatory';
	$serachStr ='OPD';
	$searchStrArr = $this->params->query;
}else if($this->params->query['type']=='emergency'){
	$urlType= 'Emergency';
	$serachStr ='IPD&is_emergency=1';
	$searchStrArr = array('type'=>'IPD','is_emergency'=>1);
	}else if($this->params->query['type']=='IPD'){
		$urlType= 'Inpatient' ;
		$serachStr ='IPD&is_emergency=0' ;
		$searchStrArr = array('type'=>'IPD','is_emergency'=>0);
	}
	$queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;


	?>
<style>
label {
	width: 126px;
	padding: 0px;
}

.ui-datepicker-trigger {
	padding: 0px 0 0 0;
	clear: right;
}

.tddate img {
	float: inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Inpatient List', true);?>
	</h3> 
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Pharmacy',array('url'=>array('controller'=>'Pharmacy','action'=>'inpatientList'),'type'=>'get'));?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%" align="center">
	<tbody>
		<tr class="row_title">
			<!-- <td class="tdLabel" id="boxSpace" align="left"><?php //echo __('DOB') ?> :</td>
			<td class="tddate"><?php /*echo $this->Form->input('dob', array('id' => 'dob_search','label'=> false, 'type'=>'text',
					'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd','readonly'=>'readonly'));*/?> </td> -->
			<td class="tdLabel" id="boxSpace" align="right" width="12%"><?php echo __('Patient Name') ?>:</td>
			<td class=" " width="20%"><?php 
				echo $this->Form->hidden('type',array('value'=>$this->request->query['type']));
				echo $this->Form->hidden('patientstatus',array('value'=>$this->params->query['patientstatus']));
				echo $this->Form->hidden('listflag',array('value'=>$this->params->query['listflag']));
				echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td>
			<td class="tdLabel" id="boxSpace" align="right" width="12%"><?php echo __('Patient ID') ?>:</td>	
			<td><?php echo $this->Form->input('patient_id', array('id' => 'patient_id','label'=> false, 'type'=>'text',
					'div' => false, 'error' => false,'autocomplete'=>false));?> </td>
			<td class=" " align="center" width="10%"><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));?></td>
			<td class=" " align="center" width="10%"><?php 
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array('style'=>'height:20px;width:18px;')),array('controller'=>'Pharmacy','action'=>'inpatientList'),
					array('id'=>'refresh','class'=>'refresh','escape' => false,'title'=>'Refresh')); ?></td>
			<td></td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>
<div
	class="clr inner_title" style="text-align: right;"></div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<?php if(isset($data) && !empty($data)){
		//set get variables to pagination url
		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		?>
	<tr class="row_title">
		
		<td class="table_cell"><strong><?php echo __('Patient Name') ?></strong></td> 
		<td class="table_cell"><strong><?php echo __('Patient ID') ?></strong></td> 
		<td class="table_cell"><strong><?php echo __('Primary Care Provider') ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Patient Location') ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Department') ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Pharmacy Advance (Rs.)') ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Pharmacy Advance Payment') ?></strong></td>
	</tr>
	<?php //debug($data);
	$toggle =0;
	if(count($data) > 0) {
      		foreach($data as $patients){
			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
	<!-- <td class="row_format"><?php //echo substr($this->DateFormat->formatDate2Local($patients['Person']['dob'],Configure::read('date_format'),true),0,10); ?></td> --> 
	<td class="row_format"><?php echo $patients['Person']['first_name'].' '.$patients['Person']['last_name']; ?></td>
	<td class="row_format"><?php echo $patients['Patient']['admission_id']; ?></td>
	<td class="row_format"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?></td>
	<td class="row_format"><?php echo $patients['Ward']['name']."/".$patients['Ward']['ward_type']; ?></td>
	<td class="row_format"><?php echo $patients['Department']['name']; ?></td>
	<td class="row_format"><?php echo $patients[0]['advance']; ?></td>
	<td class="row_format"><?php echo $this->Html->link($this->Html->image('icons/rupee_symbol.png',array('style'=>'height:20px;width:18px;')),'javascript:void(0)',
			array('id'=>'pharmacyAdvancePayment_'.$patients['Patient']['id'],'class'=>'pharmacy_advance_payment','escape' => false,'title'=>'Pharmacy Advance Payment'));?></td>
	<?php }?>
	</tr>
	<?php } 
	$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
	<?php					  
	}else {?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php } ?>
</table>
<script>
	//script to include datepicker
$(function() {
	$("#dob_search").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>', 
});
});
$('#PatientSearchForm').submit(function(){
	var msg = false ; 
	$("form input:text").each(function(){
	       //access to form element via $(this)
	       if($(this).val() !=''){
	       		msg = true  ;
	       }
	    }
	);
	if(!msg){
		alert("Please fill atleast one field .");
		return false ;
	}		
});
 $(document).ready(function(){
    	 $("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type=IPD&is_discharge=0',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type=IPD&is_discharge=0',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});

		
		$("#dob_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","dob",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
 	});
 /* $('#patient_id').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","admission_id",'IPD',"null","null",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
		 },
		 messages: {noResults: '',results: function() {}
		 }
	});

 $('#lookup_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'IPD',"null","null",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
		 },
		 messages: {noResults: '',results: function() {}
		 }
	});*/
//for advance payment  --yashwant
 $(".pharmacy_advance_payment").click(function(){
	 var currentID=$(this).attr('id');
	 var splitedVar=currentID.split('_');
	 patientID=splitedVar[1];
	 $.fancybox({ 
		 	'width' : '50%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
			},
			'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"advanceBillingPayment","admin"=>false)); ?>"+'/'+patientID+'?category=pharmacy',
	 });
	// $(document).scrollTop(0);
 });

</script>