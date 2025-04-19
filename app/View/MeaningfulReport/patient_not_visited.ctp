<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('Patient Not Visited From Last '.$this->params->query['duration'].' Days', true); ?></h3>
</div>
<?php echo $this->Form->create(null,array('type'=>'get','url' => array('action'=>'patient_not_visited'), 'id'=> 'automatedmeasurecalfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="600px" align="left">
           <tr>				 
			<td  align="right"><?php echo __('Provider') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'provider', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => $doctorlist, 'empty' => 'Select Provider', 'style' => 'width:300px;',  'id' => 'provider', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $provider));
		    	?>
		  	</td>
		 </tr>	
		  <tr>				 
			<td  align="right"><?php echo __('Duration') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'duration', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('30'=> '30 Days (1 Month)','60'=> '60 Days (2 Months)','90' => '90 Days (3 Months)','180' => '180 Days (6 Months)', '365'=>'365 Days (1 Year)'), 'empty' => 'Select Duration', 'style' => 'width:300px;',  'id' => 'duration', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $duration));
		    	?>
		  	</td>
		    </tr>
	        <tr>				 
			 <td   align="right" ><?php //echo __('Start Date') ?></td>										
			 <td class="row_format">											 
		    <?php 
		      //echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false,'value'=>$this->request->data['startdate'],'style'=>'float:left'));
            ?>
		  	</td>
		    </tr> 
		  <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:125px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false,'onclick'=>'$("#report-type").val("");'));	
					echo $this->Form->hidden('report_type',array('value'=>'','id'=>'report-type'));
					echo $this->Form->submit(__('Excel Report'),array('id'=>'excel-report','class'=>'blueBtn','div'=>false,'label'=>false,'style'=>'margin-left:10px'));	 
				?>
			</td> 
		 </tr>	
		
</table>	
<div>&nbsp;</div>
<div style="float:right;">
	<?php 	//echo $this->Form->submit(__('Excel Report'),array('id'=>'excel-report','class'=>'blueBtn','div'=>false,'label'=>false));	 ?>
</div>
 <?php echo $this->Form->end();?>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
     
     <?php 
     if(!empty($patientList)){
$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		 $this->Paginator->options(array('url' =>array("?"=>$queryStr)));
     ?>
     <table width="85%" align="center" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th style="text-align:center;"><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true)); ?></th>
	       <th style="text-align:center;"> <?php echo $this->Paginator->sort('Person.dob', __('Date Of Birth', true));?></th>
           <th style="text-align:center;"> <?php echo $this->Paginator->sort('Appointment.date', __('Last Visit Date', true));  ?></th>
           <th style="text-align:center;"> <?php echo $this->Paginator->sort('Patient.lookup_name', __('Reason For Review', true)); ?></th>
          </tr>
          <?php $toggle=0;
          foreach($patientList as $key=>$data){
		  if($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				}else{
					echo "<tr>";
					$toggle = 0;
				}?>
				<td class="table_cell" style="text-align: left"><?php 
				echo $data['Patient']['lookup_name'];				
				?></td>
				<td class="table_cell"  style="text-align: left"><?php 
				echo $this->DateFormat->formatDate2Local($data['Person']['dob'],
						Configure::read('date_format'),true);				
				?></td>
				<td class="table_cell"  style="text-align: left"><?php 
				echo $this->DateFormat->formatDate2Local($data['Appointment']['date'],
						Configure::read('date_format'),true);				
				?></td>
				<td class="table_cell" style="text-align: left"><?php 
				echo $data['Appointment']['purpose'];				
				?></td>
          <?php }?>
          <tr>
	<TD colspan="8" align="center">
			 <!-- Shows the page numbers -->
		 <?php 
		 
		 $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		 $this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		 echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
		 <!-- Shows the next and previous links -->
		 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 <!-- prints X of Y, where X is current page and Y is number of pages -->
		 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 
		    </TD>
		   </tr>
      </table>
    <?php  }?>
     
     
<script>
	$(function() {
		$("#startdate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'mm/dd/yy',			
		});	
	
	});
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#automatedmeasurecalfrm").validationEngine();

		$("#excel-report").click(function(){
			$('#report-type').val('excel') ;
		});
	});
	
</script>
