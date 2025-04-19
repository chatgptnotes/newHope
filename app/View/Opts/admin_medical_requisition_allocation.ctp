<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
 ?>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Medical Requisition - Allocation', true); ?></h3>
<span>
 <?php  echo $this->Html->link(__('Back'), array('action' => 'medical_requisition_list',"admin"=>true), array('escape' => false,'class'=>"blueBtn"));?>                     </div>
</span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('MedicalRequisition');?>
  <input type="hidden" value="<?php echo count($data['MedicalRequisitionDetail']);?>" id="no_of_fields"/>
 <table>
  <!-- <tr>
    	<td width="180" class="tdLabel"><?php echo __('Patient Centric Specilty:'); ?><font color="red"> *</font></td>
			<td width="150">
			<?php
				 echo $this->Form->input('MedicalRequisition.patient_centric_department_id', array('class' => 'validate[required,custom[mandatory-select]]', 'id' => 'patient_centric_department_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$PatientCentricDepartment,'div'=>false ,"default"=>$data['MedicalRequisition']['patient_centric_department_id']));
				 ?>
			</td>

   </tr>-->


<td>Requisition For:</td>
<td>
<?php
			echo ucfirst($data['MedicalRequisition']['for']);
		?>

           (<?php
			echo ucfirst($data['MedicalRequisition']['requisition_for']);
		?>)

</td>
</table>

<table   cellspacing="1" cellpadding="0" border="0" id="item-row" class="tabularForm">

<tr class="row_title">

  <th align="center" style="text-align:center;"><?php echo __('Sr.', true); ?></th>
  <th align="center" style="text-align:center;" width="16%"><?php echo   __('Category Name') ; ?><font color="red">*</font></th>
    <th align="center" style="text-align:center;" width="16%"><?php echo   __('Item Name') ; ?><font color="red">*</font></th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Date') ; ?><font color="red">*</font> </th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Quantity') ; ?><font color="red">*</font> </th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('In Stock') ; ?></th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Recieved Date') ; ?></th>
   <th align="center" style="text-align:center;" width="2%"> <?php echo  __('Recieved Quantity') ; ?></th>
 	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Used Quantity') ; ?></th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Return Date') ; ?></th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Return Quantity') ;?></th>
  </tr>
 <?php

 	$cnt = 0;
 	foreach($data['MedicalRequisitionDetail'] as $key=>$value){
	$cnt++;
 ?>
	<tr id="row<?php echo $cnt;?>">
	 	<td align="center" class="sr_number"><?php echo $cnt;?></td>

	 	<td align="center">
		  <?php echo $value['category']['name'] ; ?>
		  <input name="category_id[]" id="category_id1" type="hidden"   value="<?php echo $value['category']['id'] ; ?>"/>
		</td>
	 	<td align="center">
		 <input name="MedicalRequisitionDetail[]" id="MedicalRequisitionDetail<?php echo $cnt;?>" type="hidden"   value="<?php echo $value['id'] ; ?>"/>
		 <?php echo $value['item']['name'] ; ?>

			 <input name="item_id[]" id="item_id<?php echo $cnt;?>" type="hidden"   value="<?php echo $value['medical_item_id'] ; ?>"/>

 		</td>
	 	<td align="center">
			 <?php echo $this->DateFormat->formatDate2local($value['date'],Configure::read('date_format'),false); ?>
		</td>
		<td align="center">
			 <?php echo $value['request_quantity']; ?>
		</td>
		<td align="center">
				 <?php echo $value['instock']; ?>
				  <input name="instock[]" id="instock<?php echo $cnt;?>" type="hidden"   value="<?php echo $value['instock']  ; ?>"/>
		</td>
		<td align="center">
			 			<input name="recieved_date[]" id="request_date<?php echo $cnt;?>" type="text" class="textBoxExpnd date"  tabindex="6" value="<?php echo $this->DateFormat->formatDate2local($value['recieved_date'],Configure::read('date_format'),false); ?>" fieldNo='<?php echo $cnt;?>' style="width:70%"/>
		</td>
		<td align="center">
			 			<input name="recieved_quantity[]" id="request_quantity<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value="<?php echo $value['recieved_quantity']; ?>" fieldNo='<?php echo $cnt;?>' style="width:60%"/>
		</td>
		<td align="center">
			 <?php echo $value['used_quantity']; ?>
		<td align="center">
			 <?php echo $this->DateFormat->formatDate2local($value['return_date'],Configure::read('date_format'),false); ?>
		</td>
		<td align="center">
			 <?php echo $value['return_quantity']; ?>
		</td>

	</tr>
<?php
}
?>
</table>
  <div class="btns">

                           <input name="submit" type="submit" value="Submit" class="blueBtn"/>

<?php echo $this->Form->end();?>



<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#MedicalRequisitionMedicalRequisitionForm").validationEngine();
	});


	$(".date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});


</script>