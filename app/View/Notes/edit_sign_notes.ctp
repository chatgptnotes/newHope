<?php echo $this->Form->create('Note',array('id'=>'patientnotesfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
		class="table_format ">
		<tr class="row_title">
	
			<td colspan="2" width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("This is a signed document. Give reason for editing it.");?></td>
			</tr>
			<tr>
				<td style="text-align: right; width:240px"><font color="red">* </font></td>
				<td width="" style="text-align: left;" valign="top" class="table_cell">
				<?php echo $this->Form->input('Note.reason_to_unsign',array('type'=>'textarea','class' => 'validate[required,custom[mandatory-enter]]','cols'=>'3','rows'=>'5'));?></td>
			</tr>
			<?php echo $this->Form->input('Note.id',array('type'=>'hidden','value'=>$noteId));?>
			<tr>
				<td colspan="2" width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Form->submit('Submit',array('id'=>'submit_edit','type'=>'button','onclick'=>'editNotes('.$noteId.','.$patientId.')','name'=>'submit','class'=>'Bluebtn'));?></td>
			</tr>
			</table>			
<?php echo $this->Form->end(); ?>
<script>

$(document).ready(function(){
	jQuery("#patientnotesfrm").validationEngine();

});
function editNotes(noteId,patientId){

	var validatePerson = jQuery("#patientnotesfrm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson==false){
		return false;
	}else{
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "editSignNotes","admin" => false)); ?>";
	   var formData = $('#patientnotesfrm').serialize();
       $.ajax({	
      	 beforeSend : function() {
      		// this is where we append a loading image
      		$('#busy-indicator').show('fast');
      		},
      		                           
        type: 'POST',
       url: ajaxUrl+"/"+noteId+"/"+patientId,
        data: formData,
        dataType: 'html',
        success: function(data){
      	  $('#busy-indicator').hide('fast');	
      		window.top.location.href = '<?php echo $this->Html->url("/notes/soapNote"); ?>'+"/"+patientId+"/"+noteId;
      		parent.$.fancybox.close();
	        	
	        
	        
        },
			error: function(message){
				alert("Error in Retrieving data");
        }        });
  
  		return false; 
	}
}
</script>
