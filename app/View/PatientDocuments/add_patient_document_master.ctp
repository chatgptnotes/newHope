 	<div class="inner_title">
 	<h3><?php echo __('Add Patient Document Master', true); ?></h3>
 	</div>
 	<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#patientdocumentmasterfrm").validationEngine();
	});
	</script>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
    ?>
    </td>
   </tr>
  </table>
   <?php } ?>
   <form name="patientdocumentmasterfrm" id="patientdocumentmasterfrm" action="<?php echo $this->Html->url(array("action" => "add_patient_document_master")); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
     <tr>
	  <td class="table_cell" align="right"><?php echo __('Document Type',true); ?><font color="red">*</font>
						</td>
						<!--  <td><?php
						echo $this->Form->input('patientdocumentmaster.document_type_id',array('empty'=>'Please Select','style'=>'width:165px','readonly'=>'readonly',
											'options'=>$patient_document,'selected'=>$getDataPatientDocument['PatientDocument']['patient_document_id'],'id'=>'patient_document_id','div'=>false,'label'=>false));?>
						</td>--> 
						<td>
	   <?php echo $this->Form->input('PatientDocumentMaster.document_type',array('class' => 'validate[required,custom[name]]','id' => 'documenttype', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  	</td>
	  	</tr>
	 
 	 	<tr>
	  	<td class="form_lables" align="right">
        <?php echo __('Description',true); ?>
	   	<font color="red">*</font>
	   	</td>
	  	<td>
        <?php 
        echo $this->Form->textarea('PatientDocumentMaster.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	    </tr>
	
        <tr>
	  	<td colspan="2" align="center">
	  	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'patient_document_master'), array('escape' => false,'class'=>'grayBtn')); ?>
	  	<input type="submit" value="Submit" class="blueBtn">
	  	</td>
	  	</tr>
	  	</table>
     	</form>