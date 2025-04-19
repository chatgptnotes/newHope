<style>
.Tbody {
	width: 100%;  
	height: 500px;
	display: -moz-stack;
	overflow: auto;
}
.textBoxExpnd{
 height: 16px !important;
}
</style>

<?php 
  // echo $this->Html->script('jquery.autocomplete');
  //echo $this->Html->css('jquery.autocomplete.css');
  echo $this->Html->script('jquery.fancybox-1.3.4');
	echo $this->Html->css('jquery.fancybox-1.3.4.css');
  ?>
<?php echo $this->Form->create('',array('action'=>'add_prescription','type'=>'get','id'=>'saveChkValues'));?>

<div class="inner_title" >
<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
	<h3>Nurse Procurements</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'index','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div> 
<div id = "prescriptionStatusContainer">
</div> 
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" > 
		<tr class="row_title"> 
		
			<td class="row_format"><label><?php echo __('Patient Name/ID') ?> </label></td> <td class="row_format" style="font-weight: bold;">:</td>
			<td class="row_format">
		    	<?php
		    		 echo $this->Form->input('lookup_name', array('value'=>$this->request->query['lookup_name'],'name'=>'lookup_name','id' => 'patient_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>   
		  	<td class="row_format">
			<?php  echo $this->Form->input('date', 
					array('value'=>$this->request->query['date'],'placeholder'=>'Select Date','name'=>'date','id' => 'date','class'=>'date textBoxExpnd' ,'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?>
			</td>
			<!-- <td class="row_format"><label><?php echo __('MRN') ?> :</label></td>
			<td class="row_format"> 
		    	<?php
		    	echo  $this->Form->input('admission_id', array('value'=>$this->request->query['admission_id'],'name'=>'admission_id','type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>  -->
			<td class="row_format"></td>
			<td class="row_format"></td>
			 
			<td class="row_format"><?php 
				echo $this->Form->input('isPending', array('checked'=>($this->request->query['isPending']==1)?true:false,'hiddenField'=>false,'type'=>'checkbox','class'=>'checkedValuePending','div'=>false,'label' => 'Pending','legend' => false));?></td>
		  
			<td class="row_format"><?php echo $this->Form->input('isPartial', array('checked'=>($this->request->query['isPartial']==1)?true:false,'hiddenField'=>false,'type'=>'checkbox','class'=>'checkedValuePartial','div'=>false,'label' => 'Partial','legend' => false));?></td>
		 	 
			<td class="row_format"><?php echo $this->Form->input('isCompleted', array('checked'=>($this->request->query['isCompleted']==1)?true:false,'hiddenField'=>false,'type'=>'checkbox','class'=>'checkedValueCompleted','div'=>false,'label' => 'Completed','legend' => false));?>
			</td>
			<td class="row_format" >
				<?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn forChkValues','div'=>false,'label'=>false,'id'=>'forChkValues'));?>
			</td>
			<td class="row_format">
			<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Nursings','action'=>'add_prescription'),array('escape'=>false, 'title' => 'refresh'));?>
			</td>
		</tr> 
</table>
 <?php echo $this->Form->end();?>
 
 <?php // echo $this->Form->create('',array('id'=>'forChkBoxValue','action'=>'add_prescription')); ?>

 <?php // echo $this->Form->end();?>

<div style="margin:5px">

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
<tbody class ="Tbody">
 <tr class="row_title">
   <td class="table_cell" ><strong><?php echo __('Date', true);?></strong></td>
   <td class="table_cell"><strong><?php echo __('Prescribed By', true);?></strong></td>
   <td class="table_cell"><strong><?php echo  __('Patient ID', true) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Patient Name', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></strong></td>
   <!--  <td class="table_cell"><strong><?php echo __('Total Amout Due', true);?></td> -->
   <td class="table_cell"><strong><?php echo __('Status', true);?></strong></td>
    <td class="table_cell"><strong><?php echo __('Details', true);?></strong></td>
  </tr>
	<?php
    
      $cnt =0;
      if(count($pateintdat) > 0) { 
	
       foreach($pateintdat as $data){
 			$cnt++; 
			  ?>
			  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>> 
				 <?php   $billId = "null";?>
			  		<td class="row_format" ><?php echo $this->DateFormat->formatDate2Local($data['NewCropPrescription']['date_of_prescription'],Configure::read('date_format'),true); ?></td>
					<td class="row_format"><?php echo $data['User']['first_name'].' '.$data['User']['last_name']; ?></td>
			  		<td class="row_format"><?php echo $data['Patient']['patient_id']; ?> </td>
				  	<td class="row_format"><?php echo $data['PatientInitial']['name'].''.$data['Patient']['lookup_name']; ?> </td>    
					<td class="row_format"><?php 
					
						echo $statusData[$data['NewCropPrescription']['batch_identifier']];
						
					echo $patienStatus[$data['Patient']['id']];?></td> 
				    <td class="row_format">
			    	<?php
				    	$idPatient = $data['Patient']['id'];
				    	$batchId = $data['NewCropPrescription']['batch_identifier']; 
				    	echo $this->Html->link($this->Html->image('icons/view-icon.png',
									array('title'=>'view prescription','alt'=>'view prescription')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getViewPrescription($idPatient,$batchId)"));
						if($statusData[$data['NewCropPrescription']['batch_identifier']] != 'Completed'){
							echo $this->Html->link($this->Html->image('icons/arrow_curved_blue1.png',
								array('title'=>'Retrieve for Sale','alt'=>'Retrieve for Sale')), 'javascript:void(0)', array('escape' => false,'onclick'=>"parent.prescriptionDataByNurse($idPatient,'nurse',$billId,$batchId)"));		
						}  
				  	?>  
			  		</td> 
			  </tr> 
		  <?php  } ?>
  
 <tr>
    <TD colspan="10" align="center"> 
     <!-- Shows the page numbers -->
     <?php 
     		$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
     		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
     
     		echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php  echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php  echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
         } else {
  ?>
  <tr>
   <TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>

</tbody>
 </table>
</div>


     <script>

     function getViewPrescription(patientId,batchId){
   
 		$.fancybox({
			'width' : '70%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' :'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller"=>"Nursings", "action" => "get_add_prescription_detail","plugin"=>false)); ?>"+'/'+patientId+'/'+batchId,

		});
	}
 		
 	function prescriptionDataByNurse(patientId,requisitionType,billId,batchId){
 	 	
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'sales_bill','inventory'=>true))?>"+'/'+patientId+'/'+requisitionType+'/'+billId+'/'+batchId;
	}	
     
  $(document).ready(function(){

	  $("#patient_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){				
		  },
		 messages: {
	         noResults: '',
	         results: function() {},
	      },
	});

});

$( "#date" ).datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
});

  </script>