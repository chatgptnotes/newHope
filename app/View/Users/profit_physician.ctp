<div class="inner_title">
	<h3>
		<?php echo __('Physician-wise Profit Sharing Collection Report', true); ?>
	</h3>

</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#physicianReceiptfrm").validationEngine();
	});
	
</script>
<?php  echo $this->Form->create('',array('action'=>'profitPhysician','type' => 'get','id'=>'physicianReceiptfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="70%" align="center">
	<tr>
		<td width="14%" class="form_lables"><?php echo __('Period',true); ?><font
			color="red">*</font>
		</td>
		<td width="14%"><?php 
		
			echo $this->Form->input('Patient.from_date', array('type'=>'text', 'id' => 'from_date', 'class' => ' validate[required,custom[mandatory-date]] textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));?>
		</td>
		<td width="14%" class="form_lables"><?php echo __('To',true); ?><font
			color="red">*</font>
		</td>
		<td width="14%"><?php
		echo $this->Form->input('Patient.to_date', array('type'=>'text', 'id' => 'to_date', 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));?>
		</td>
		<td width="14%"><div style="text-align:center;">	
		<?php    echo $this->Form->submit(__('Submit'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
        ?></div></td>
	</tr>
	</table>
<?php echo $this->Form->end();
if(!empty($data)) { ?>
<table width="50%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="content-list"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
		<th width="25%" align="center" valign="top" style="text-align: center;;">Physician Name</th>
		<th width="25%" align="center" valign="top" style="text-align: center; min-width: 150px;">Profit Amount</th> 	
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
    <td class="row_format"><?php echo $personval['DoctorProfile']['doctor_name']; ?> </td>
  <td class="row_format"><?php if(!empty($personval[0]['ctotal'])){
   echo $personval[0]['ctotal'].'/-';
  }else{
		echo '0';
		} ?> </td>
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
   <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
      
        
  ?>
</table>
<?php }?>
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
});
</script>