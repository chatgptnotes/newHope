<div class="inner_title">
 <h3>
 <?php echo __('Edit Notes'); ?>
 </h3>
</div>
<div class="inner_left">    
 <?php echo $this->Form->create('PatientNote',array('id'=>'patientnotesfrm', 'default'=>false,'inputDefaults' => array('label' => false,'div' => false))); ?> 
 <table class="table_format"  id="schedule_form">
  <?php 
 		echo $this->Form->hidden('PatientNote.note_type', array('value'=>'patient_notes'));
        echo $this->Form->hidden('PatientNote.id');
  ?>
 <tr>
    <td><label><?php //echo __('Note Date');?> </label></td>
    <td>
      
     <?php
		echo $this->Form->input('patient_id', array( 'type' => 'hidden','value'=>$patientid, 'id' => 'patientid', 'label'=> false,'div' => false,'error' => false)); 
     	?>
    </td>
   </tr>
   <tr>
    <td><label><?php echo __('Note Title');?>:</label></td>
    <td>
    	<?php
    		
    		echo $this->Form->input('title', array('type'=>"text",'id' => 'note_title','class'=>'validate[required,custom[mandatory-enter]]', 'label'=> false,'div' => false,'error' => false)); 
    	?>
     	
    </td>
   </tr>
   <tr>
    <td><label><?php echo __('Note Type');?>:</label></td>
    <td>
    	<?php 
    		$noteType= array('OT'=>'OT Note','event'=>'Event Note','general'=>'General Note');
    		echo $this->Form->input('note_type', array('empty'=>'Please select','options'=>$noteType, 'id' => 'note_type','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'div' => false,'error' => false)); 
    	?>
     	<input type="hidden" name="authorname" value="<?php echo AuthComponent::user('first_name'); ?>"  readonly/>
    </td>
   </tr>
   <tr>
    <td><label><?php echo __('Note');?>:</label></td>
    <td>
     <?php echo $this->Form->textarea('note', array('class' => 'validate[required,custom[customnotes]]','id' => 'customnotes', 'label'=> false, 'div' => false,'error' => false ,'rows'=>'10','style'=>'width:500px')); ?> 
    </td>
   </tr>
   <tr>
   <td></td>
   <td>
    <?php 
	echo $this->Js->link(__('Cancel'), array('controller'=>'patients','action' => 'patient_notes', $patientid), array('escape' => false,'update'=>'#list_content','method'=>'post','class'=>'blueBtn'));	
        echo $this->Form->submit(__('Submit'), array('label'=> false,
			 					  	   'div' => false,'error' => false,'class'=>'blueBtn' ));
        echo $this->Js->writeBuffer(); 	
	        
    ?> 
    </td>					 
   </tr>
  </table>
 <?php echo $this->Form->end();?>
</div>
<script>
			jQuery(document).ready(function(){
				// binds form submission and fields to the validation engine
				  
					jQuery("#patientnotesfrm").submit(function(){
						var returnVal = jQuery("#patientnotesfrm").validationEngine('validate');						 
						if(returnVal){					 
					 		ajaxPost('patientnotesfrm','list_content');
					 	}
					});
				 
				function ajaxPost(formname,updateId){ 
						 
				        $.ajax({
				            data:$("#"+formname).closest("form").serialize(), 
				            dataType:"html",
				            beforeSend:function(){
							    // this is where we append a loading image
							    $('#busy-indicator').show('fast');
							},				            
				            success:function (data, textStatus) {
				             	$('#busy-indicator').hide('slow');
				                $("#"+updateId).html(data);
				               
				            }, 
				            type:"post", 
				            url:"<?php echo $this->Html->url((array('controller'=>'patients','action' => 'notes_edit')));?>"
				        }); 
				}
			});	
</script>