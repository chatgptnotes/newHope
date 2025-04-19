<?php 
/* echo $this->Html->script(array('jquery-1.5.1.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js'));
echo $this->Html->css(array('internal_style.css'));  */
?>
<style>
.ui-accordion-content {
	height: auto !important;
}
</style>
<div style="margin: 12px">
	<div style="float: right">
		<?php 
		//echo $this->Html->link(__('Back'), array('controller'=>'Nursings','action' => 'add_prescription'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</div>
	
	
	<?php echo $this->Form->create('GetNursePrescription',array('type' => 'file','id'=>'GetNursePrescriptionfrm','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false
	)
	));
	?>
	<h3 align="center">
			Prescription details of
			<?php echo $patient[0]['PatientInitial']['name'].' '.$patient[0]['Patient']['lookup_name'];?>
			(
				<?php echo $patient[0]['Patient']['admission_id'];?>
			)
	</h3>
	
	<div id="normMed">
		
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="table_format">
			<tr ><td><h3 align="justify"> Prescriptions </h3></td></tr>
			<tr class="row_title">
				<td class="table_cell">Sr.</td>
				<td class="table_cell">Item Name</td>
				<td class="table_cell">Pack</td>
				<td class="table_cell">Item Code</td>
				<td class="table_cell">Dose</td>
				<td class="table_cell">Quantity</td>
				<td class="table_cell">Recieved Quantity</td>
				
<!-- 				<td><input type="button" class="blueBtn" value="Fetch" 
					onclick="parent.getPatientPrescriptionDetails('<?php echo $patient['Patient']['id'];?>');">-->
<!-- 				</td> -->
				<td class="table_cell" colspan="2">
				<?php 
				//echo $this->Html->link(__('Retrieve'), array('controller'=>'pharmacy','action' => 'sales_bill','inventory'=>true,$patient[0]['Patient']['id'],'Nurse'), array('escape' => false,'class'=>'blueBtn'));
					//echo $this->Form->button('Retrieve',array('type'=>'button','fetchData','class'=>'blueBtn','onclick'=>"parent.prescriptionData(".$patient['Patient']['id'].",'medication')"));
				//echo $this->Form->button('Retrieve',array('type'=>'button','fetchData','class'=>'blueBtn','onclick'=>"prescriptionDataByNurse(".$patient[0]['Patient']['id'].",'nurse')"));
				
				?>
					
				</td>
				
			</tr>
			<?php 
			 if(!empty($patient)) { ?>
			<?php $cnt = 1; ?>
			<?php foreach($patient as $data){?>
			
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
				<?php if(!empty($data['NewCropPrescription']['recieved_quantity'])){ ?>
				<td class="row_format"><?php echo $data['NewCropPrescription']['recieved_quantity'];?></td>
				<?php }else{?>
				<td class="table_cell"><?php echo "0";?></td>
				<?php }?>
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
		<!--  <table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr>
				<TD colspan="10" align="center">
					<!-- Shows the page numbers --> <?php //echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					<!-- Shows the next and previous links --> <?php //echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
					<?php //echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
					<!-- prints X of Y, where X is current page and Y is number of pages -->
				<!--	<span class="paginator_links"><?php //echo $this->Paginator->counter(); ?>
				</span>
				</TD>
			</tr>

		</table>-->
	
	
	


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
				

</script>
