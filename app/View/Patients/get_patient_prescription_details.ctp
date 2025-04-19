<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.accordion.js'));
echo $this->Html->css(array('internal_style.css')); 
?>
<style>
.ui-accordion-content {
	height: auto !important;
}
</style>
<div style="margin: 12px">
	<div style="float: right">
		<?php 
		echo $this->Html->link(__('Back'), array('action' => 'get_patient_prescription'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</div>
	
	<script>
	$(function() {
		$( "#accordion" ).accordion();
	});
	</script>
	
	
	<?php echo $this->Form->create('GetPatientPrescription',array('type' => 'file','id'=>'GetPatientPrescriptionfrm','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false
	)
	));?>
	<h3 align="center">
			Prescription   of
			<?php echo $patient['PatientInitial']['name'].' '.$patient['Patient']['lookup_name'];?>
			(
				<?php echo $patient['Patient']['admission_id'];?>
			)
	</h3>
	
	<div id="normMed">
	
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="table_format">
			<tr ><td><h3 align="justify"> Normal Medications </h3></td></tr>
			<tr class="row_title">
				<td class="table_cell">Sr.</td>
				<td class="table_cell">Item Name</td>
				<td class="table_cell">Pack</td>
				<td class="table_cell">Item Code</td>
				<td class="table_cell">Dose</td>
				<td class="table_cell">Quantity</td>
<!-- 				<td><input type="button" class="blueBtn" value="Fetch" 
					onclick="parent.getPatientPrescriptionDetails('<?php echo $patient['Patient']['id'];?>');">-->
<!-- 				</td> -->
				<td class="table_cell" colspan="2">
				<?php 
					//debug($patient);
					echo $this->Form->button('Retrieve',array('type'=>'button','fetchData','class'=>'blueBtn','onclick'=>"prescriptionData(".$patient['Patient']['id'].",'medication')"));
					 echo $this->Html->image('icons/view-icon.png',
								array('title' => 'Prescribed Medication','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'template_format',$noteId,$getLabData['0']['LaboratoryTestOrder']['batch_identifier']))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,left=400,top=300,height=700');  return false;"));
				?>
				<?php if($patient['Patient']['admission_type'] == "IPD"){?>
					<span><?php echo $this->Form->button('OT Medication',array('type'=>'button','id'=>'otBtn','class'=>'blueBtn'));?></span>
					<?php } ?>
				</td>
				
			</tr>
			<?php //debug($datapost);
			 if(!empty($datapost)) { ?>
			<?php $cnt = 1; ?>
			<?php foreach($datapost as $data){?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
				<td class="row_format"><?php echo $cnt;?></td>
				<td class="row_format"><?php echo $data['PharmacyItem']['name'];
				?> 
				</td>
				<td class="row_format"><?php echo $data['PharmacyItem']['pack'];?>
				</td>
				<td class="row_format"><?php echo $data['PharmacyItem']['item_code'];?>
				</td>
				<td class="row_format"><?php echo $data['NewCropPrescription']['dose'];?></td>
				<td class="row_format"><?php echo $data['NewCropPrescription']['quantity'];?></td>
				<td class="row_format"><?php echo "&nbsp;"?></td>
				<td class="row_format"><?php echo "&nbsp;"?></td>
			</tr>
			
			<?php  $cnt++;
				} 
			  
			 ?>
 		</table>
		<?php }else{?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr>
				<TD colspan="10" align="center"><h4><?php echo __('No record found', true); ?></h4></TD>
			</tr>
		</table>
		<?php }?>
		</div>
		
		
	<div id="otMed" style="display: none;"> 
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="table_format">
			<tr ><td><h3 align="justify"> OT Medications </h3></td></tr>
			<tr class="row_title">
				<td class="table_cell">Sr.</td>
				<td class="table_cell">Item Name</td>
				<td class="table_cell">Pack</td>
				<td class="table_cell">Item Code</td> 
				<td class="table_cell">Quantity</td>
				<td>
				<?php 
					//echo $this->Html->link(__('fetch'), array('controller'=>'pharmacy','action' => 'inventory_sales_bill',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
				//echo $this->Html->link(__('fetch'), array('controller'=>'Pharmacy','action' => 'sales_bill','inventory'=>true,'Plugin'=>false,$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
				echo $this->Form->button('Retrieve',array('type'=>'button','fetchData','class'=>'blueBtn','?'=>array('print'=>'print','id'=>$get_last_insertID),'onclick'=>"prescriptionData(".$patient['Patient']['id'].",'ot')"));
				?>
				<span><?php echo $this->Form->button('Back',array('type'=>'button','id'=>'backToNormMed','class'=>'blueBtn')); ?></span>
				
				</td>
				
			</tr>
			
 		
 		<?php	$inc =1; 
 			$i = 0; $j = 0;
 			if(!empty($preferenceRequisition)) {
		  foreach($preferenceRequisition as $key => $data){ 
					/* $ser = $data['Preferencecard']['medications']; 
					$ser1 = $data['Preferencecard']['quantity']; 
					$unser = unserialize($data['Preferencecard']['medications']);
					$unser1 = unserialize($data['Preferencecard']['quantity']);  */
					
				
					
					/* foreach ($unser as $key => $item) {
						
						for($count=count($item); $count>=0; $count-- ) {
						foreach($unser1 as $key => $item1){
						for($count=count($item1); $count>=0; $count-- ) {
							for($j==0; $j<$count; $j++){	 */
							
							
				?>
				
			<tr <?php if($inc%2 == 0) echo "class='row_gray'"; ?>>
				<td class="row_format"><?php echo $inc; ?></td>
				<td class="row_format"><?php echo $data['PharmacyItem']['name']; ?></td>
				<td class="row_format"><?php echo $data['PharmacyItem']['pack']; ?></td>
				<td class="row_format"><?php echo $data['PharmacyItem']['item_code'];?></td> 
				<td class="row_format"><?php  echo $drugQty[$i];?></td>
				<td class="row_format">&nbsp;</td>
				
				<?php /* 	}
					}
				}  */  ?>
			</tr> 
				<?php //}
	    			//} 
				$inc++; $i++;}
				?>
		</table>
		<?php }else{?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr>
				<TD colspan="10" align="center"><h4><?php echo __('No record found', true); ?></h4></TD>
			</tr>
		</table>
		<?php }?>
		</div>
	<div id="viewTemplate" style="display: none;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="table_format">
			<tr>
				<td><?php echo $viewdata;?></td>
			</tr>
			</table>
			</div>
	
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr>
				<TD colspan="10" align="center">
					<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
					<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
					<!-- prints X of Y, where X is current page and Y is number of pages -->
					<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
				</span>
				</TD>
			</tr>

		</table>
	
	
	


<!-- </div> -->
<script>

	$("#otBtn").click(function(event){
	   	event.stopPropagation();
	   /* $('.refer').toggle();*/ 
	    $('#otMed').show();
	    $('#normMed').hide();
	    $('#viewTemplate').hide();
	});

	$("#backToNormMed").click(function(event){
	   	event.stopPropagation();
	   /* $('.refer').toggle();*/ 
	    $('#otMed').hide();
	    $('#normMed').show();
	    $('#viewTemplate').hide();
	});
	$("#viewTemplateButton").click(function(event){
	   	event.stopPropagation();
	   /* $('.refer').toggle();*/ 
	    $('#otMed').hide();
	    $('#normMed').hide();
	    $('#viewTemplate').show();
	});
	 
	function viewTemp(){
		
		window.open('<?php echo $this->Html->url(array("controller" => "Patient", "action" => "template_format","plugin"=>false)); ?>','width=500,height=150,location=0,scrollbars=no');
		}
				
	function prescriptionData(patientId,requisitionType){
			window.location.href = "<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'sales_bill','inventory'=>true))?>"+'/'+patientId+"/"+requisitionType;
		}
</script>
