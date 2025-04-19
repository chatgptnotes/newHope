<?php echo $this->Html->script(array('pager')); ?>
<form id="subData">
<?php 
if($toshowFields=='hpi'){
	$displayhpi='block';
	$displayros='none';
}else if($toshowFields=='ros'){
	$displayhpi='none';
	$displayros='block';
}$toshowFields==''?>
<table width="100%">
	<tr>
		<td width="1%" valign="top">
		<table width="100%" id="hpi" style="display:<?php echo $displayhpi?>">
		<tr><td>
			                      			<?php echo $this->Form->input('Hpi',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;','value'=>$getDataFormNote['Note']['subject']
			                      					,'label'=>false,'id'=>'hpiTextNew','class'=>'resize-input','div'=>false,'placeholder'=>'History of presenting illness','value'=>$putSubData['Note']['subject']));?>
         </td></tr>
         </table>                                           
		</td>
		<td  width="4%" valign="top">
		<table width="100%" id="hpi" style="display:<?php echo $displayhpi?>">
		<tr><td>
			                      			<?php echo $this->Html->link('Save','javascript:void(0)',array('onclick'=>"updateNote('subject')",'class'=>'blueBtn'));?>
		</td></tr>
         </table>  	                      			
		</td>
		<!--  <td width="4%" valign="top">
		<table id="hpi" style="display:<?php echo $displayhpi?>">
		<tr><td>
			                      			<?php   echo $this->Html->link($this->Html->image('icons/plus_6.png'),array("controller" => "PatientForms", "action" => "hpiCall",$patientId,$noteId,'apptId'=>$appointmentId),array('escape'=>false,'target'=>'_blank'));?>
		</td></tr>
		</table>
		<td> -->
		<td width="30%" >
		<table width="100%" id="subjectiveDisplay" style="display:<?php echo $displayhpi?>">
		<tr><td>
		
		 </td></tr>
         </table> 
		</td>
	</tr>
	<tr>
	<td width="1%">
		<table id="ros" style="display:<?php echo $displayros; ?>;">
		<tr><td>
		                      			<?php echo $this->Form->input('Ros',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;',
		                      					'value'=>$getDataFormNote['Note']['ros'],'label'=>false,'placeholder'=>'Review of System','id'=>'rosTextNew','class'=>'resize-input','div'=>false,'value'=>$putSubData['Note']['ros']));?>
          
          </td></tr></table>                                     
		</td>
		<td  width="4%" >
		<table style="display:<?php echo $displayros; ?>;">
		<tr><td>
		                      		<?php echo $this->Html->link('Save','javascript:void(0)',array('onclick'=>"updateNote('ros')",'class'=>'blueBtn'));?>
	</td></tr></table>
		</td>
		<!-- <td  width="4%" >
		<table id="hpi" style="display:<?php echo $displayros?>">
		<tr><td>
			                      			<?php   echo $this->Html->link($this->Html->image('icons/plus_6.png'),array("controller" => "Notes", "action" => "reviewOfSystem",$patientId,$noteId,'apptId'=>$appointmentId),array('escape'=>false,'target'=>'_blank'));?>
		</td></tr>
		</table>
		</td> -->
		<td width="30%" >
		<table id="rosDisplay" style="display:<?php echo $displayros; ?>;"><tr><td></td></tr></table>
		</td>
		<input type="hidden" name="patientId" value='<?php echo $patientId?>'/>
	                      		<input type="hidden" name="noteId" value='<?php echo $noteId?>'/>
	                      		<input type="hidden" name="appointmentId" value='<?php echo $appointmentId?>'/>
	 </tr>
 </table>
 </form>
 <script>
//--------------------------------------Update Complaints --------------------------------------------//
function updateNote(fields){
	var formData = $('#subData').serialize();
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadSubjective",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	$.ajax({
		beforeSend : function() {
			$('#busy-indicator').show('fast');
		},
		type: 'POST',
		url: ajaxUrl+'/?type='+fields,
		data:formData,//"id="+complaints+"&id2="+patientId,
		dataType: 'html',
		success: function(data){
			getSubData();
			$('#busy-indicator').hide('fast');
			// $('#middle').html('Data Saved');
			 if(fields=='subject'){
				 $('#alertMsg').show();
				 $('#alertMsg').html('HPI Saved Successfully.');
				 $('#alertMsg').fadeOut( 1000 );
			 }else{
				 $('#alertMsg').show();
				 $('#alertMsg').html('Review of System Saved Successfully.');
			//	 $('#alertMsg').fadeout(1000);
				 $('#alertMsg').fadeOut(5000);
			 }
			
			
	},
	});
 }
function hpi(){
	window.location.href="<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "hpiCall",$patientId,$noteId)); ?>";
	}
function ros(){
	window.location.href="<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem",$patientId,$noteId)); ?>";
	}
	</script>