<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<div class="inner_title">
	<h3>
		<?php echo __('No. of Arrivals Patients', true); ?>
	</h3>
<span>
<?php
 //echo $this->Html->link(__('Back', true),array('controller' => 'corporates', 'action' => 'lifespring_reports', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#docfrm").validationEngine();
	});
	
</script>

<?php  echo $this->Form->create('',array('action'=>'no_of_arrival_patient','type' => 'get','id'=>'docfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="100%" align="center">
	<tr>
		<td width="7%" class="form_lables"><?php echo __('From',true); ?>
		</td>
		<td width="11%"><?php echo $this->Form->input('Patient.from_date', array('type'=>'text', 'id' => 'from_date', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));?>
		</td>
		<td width="5%" class="form_lables"><?php echo __('To',true); ?>
		</td>
		<td width="11%"><?php echo $this->Form->input('Patient.to_date', array('type'=>'text', 'id' => 'to_date', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));?>
		</td>
		<td width="7%" class="form_lables"><?php echo __('Patient Name',true); ?>
		</td>
		<td width="19%"><?php echo $this->Form->input('Patient.patient_name', array('type'=>'text','id' => 'patient_name', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false));
		//echo $this->Form->hidden('Patient.ref_doc_id', array( 'id' => 'ref_doc_id'));?>
		</td>
		<td width="7%" class="form_lables"><?php echo __('Doctor Name',true); ?>
		</td>
		<td width="21%"><?php echo $this->Form->input('Patient.doc_name', array('empty'=>__('Please Select'),'id' => 'doc_name', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'options'=>$doctors));
		//echo $this->Form->hidden('Patient.ref_doc_id', array( 'id' => 'ref_doc_id'));?>
		</td>
		<td width="11%"><div style="text-align:center;">	
		<?php    echo $this->Form->submit(__('Submit'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
        ?></div></td>
	</tr>
	</table>
<?php echo $this->Form->end(); ?>
<?php //if(!empty($data)){?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="content-list" style="margin:10px 10px 10px 10px;"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr>
	 <td colspan="8"><?php echo "Total No. of Arrivals Patients: <b>".$getDataCount."</b>";
								?>
	 </td></tr>
	<tr> 
		<th width="16%" align="center" valign="top" style="text-align: center;;">Patient Name</th>
		<th width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;">Gender</th> 
		<th width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;">Age</th> 	
		<th width="16%" align="center" valign="top" style="text-align: center;;">Arrived</th>
		<th width="16%" align="center" valign="top" style="text-align: center;;">Date of Appointment</th>
		<th width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;">Doctor Name</th> 	
	</tr> 
	<?php
   $toggle =0;
      if(count($data) > 0) {
       foreach($data as $personval): 
       $cnt++;
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
    <td class="row_format" align="center"><?php echo $personval['Patient']['lookup_name']; ?> </td>
      <td class="row_format" align="center"><?php echo ucfirst($personval['Person']['sex']); ?> </td>
  <td class="row_format" align="center"><?php echo $this->General->getCurrentAge($personval['Person']['dob']); ?> </td>
   <td class="row_format" align="center"><?php echo ucfirst($personval['Appointment']['status']); ?>  </td>
    <td class="row_format" align="center"><?php echo $this->DateFormat->formatDate2LocalForReport($personval['Appointment']['date'],
						Configure::read('date_format'),true); ?> </td>
    
   <td class="row_format" align="center"><?php $getDocName=ucfirst($personval['DoctorProfile']['doctor_name']);
					echo $getDocName; ?> </td>
  </tr> 
  <?php endforeach;  
   $queryStr = $this->General->removePaginatorSortArg($queryString);  //for sort column
   $queryStr['from_date'] = $this->DateFormat->formatDate2STDForReport($queryStr['from_date'],Configure::read('date_format'))." 00:00:00";
   $queryStr['to_date'] = $this->DateFormat->formatDate2STDForReport($queryStr['to_date'],Configure::read('date_format'))." 23:59:59";
   
  $this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
<tr>
		<TD colspan="18" align="center"><?php if($this->Paginator->params['paging']['prevPage'] !='')echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php if($this->Paginator->params['paging']['nextPage'] !='')echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
 	<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</TD>
	</tr>  
  
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
      
        
  ?>
</table>
<?php //} ?>

<script>
$(document).ready(function(){
	$("#to_date,#from_date")
	.datepicker(
			{
				showOn : "both",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange: '-100:' + new Date().getFullYear(),
				maxDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}
			});
	
	$(function() {
		$("#patient_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','no','null','lookup_name', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });		
	});	
});
</script>