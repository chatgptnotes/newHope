<style>.row_action img{float:inherit;}</style>






<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Surgery Requisition Card', true); ?>
	</h3>
	
</div>
<div class="patient_info">
	
</div>
<?php echo $this->Form->create('Preferencecard',array('type' => 'file','id'=>'Preferencecardfrm','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false
	)
	));?>
<table  border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr>
		<td width="5%">
			<?php echo __('Surgery');?><font color="red">*</font>:
		</td>
	    <td>
	    	<?php 
	    		echo $this->Form->input('surgery_id', array('empty'=>'Please select','options'=>$procedure,'id' => 'surgery_id','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px')); 
	    	?>
	     	
	    </td>
	</tr>

</table>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr>
		<td colspan="8" align="right">
			<?php 
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr class="row_title">

		<td class="table_cell" align="left"><strong>Preference Card</strong></td>
		<td class="table_cell" align="left"><strong>Procedure Name</strong></td>
		<td class="table_cell" align="left"><strong>Primary care provider</strong>
		</td>
		<td class="table_cell" align="left"><strong>Action</strong></td>

	</tr>
	<?php 
	//debug($getData);
	$cnt=0;
	if(count($getData) > 0) {


       foreach($getData as $pref_data):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format" align="left"><?php echo ucwords($pref_data['Preferencecard']['card_title']); ?>
		</td>
		<td class="row_format" align="left"><?php echo $pref_data['Surgery']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php echo "DR. ".$pref_data['User']['first_name']." ".$pref_data['User']['last_name'] ?>
		</td>
		<td class="row_action" align="left">
		
		<?php 	$is_activechk = ($pref_data['Preferencecard']['is_checked'] == '1') ? true : false;
		 echo $this->Form->checkbox('', array('class'=>'preferanceChecked','id'=>'preferanceChecked_'.$pref_data['Preferencecard']['id'],
			'hiddenField'=>false,'value'=>$pref_data['Preferencecard']['id'],'name'=>'Preferencecard[is_checked_][]','checked'=>$is_activechk));
		
		
      /*  echo  $this->Html->link($this->Html->image('icons/view-icon.png'), array('controller'=>'preferences','action' => 'view_preference',$pref_data['Preferencecard']['id'],$pref_data['Preferencecard']['patient_id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
       echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preferencecard',$pref_data['Preferencecard']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
       echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'))), array('controller'=>'preferences','action' => 'delete', $pref_data['Preferencecard']['id']), array('escape' => false,'title'=>'Delete'),"Are you sure you wish to delete this Preference card?"); */



       ?>
		</td>
	</tr>
	
	<?php endforeach;  ?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php //echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php //echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php //echo $this->Paginator->counter(); ?>
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

<div class="btns">
	<table>
		<tr>
			<td><?php echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'procedure_perform_submit','class'=>'blueBtn','onclick'=>"javascript:updatePreferanceCard()")); ?>
			</td>
			<td><?php echo $this->Html->link(__('Cancel'),array('action' => 'surgeryRequisitionCard'),array('escape' => false,'class'=>'blueBtn')); ?></td>
		</tr>
	</table>
</div>
<?php echo $this->Form->end();?>
<script>
//$(document).ready(function(){
function updatePreferanceCard(){
	var validateProcedure = jQuery("#Preferencecardfrm").validationEngine('validate');
	if(validateProcedure){
	patientid="<?php echo $patientid;?>";
	
 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "OptAppointments", "action" => "savesurgeryRequisitionCard","admin" => false)); ?>";
 	var formData = $('#Preferencecardfrm').serialize();	  
   	$.ajax({
    	type: 'POST',
   		url: ajaxUrl+"/"+patientid,
    	data: formData,
    	dataType: 'html',
   		beforeSend : function() {
			$('#busy-indicator').show('fast');
		},
    	success: function(data){ 
    		$('#busy-indicator').hide('fast');
    	 	if(data !='Please Insert Data'){
    	 	document.getElementById("Preferencecardfrm").reset();
    	 	//alert("Procedure Sucessfully Saved");
    	 window.location.reload();
    	/*$("#procedure_name").val('');
	        $("#code_value").val('');
	        $("#code_type").val('');
	        $("#id").val('');*/
    	 }else{
             //-----don't comment it. its error message
            
         }
	       
          },	         
		error: function(message){
        alert("Internal Error Occured. Unable To Save Data.");
    }        
    });
}

return false;
}
///});
      
</script>
