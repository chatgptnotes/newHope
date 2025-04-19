<table border="0" class=""  cellpadding="0" cellspacing="0" width="100%" align="center">
	<tbody>				    			 				    
			
							
	<?php  echo $this->Form->hidden('patient_id',array('value'=>$id,'id'=>'patientId'));
				  	  $toggle =0;
				      if(count($listCat) > 0) {?>
				    
				      	<?php 	foreach($listCat as $docList){
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
								  ?>								  
								  <td class="row_format" align="left"><?php  echo $this->Html->image('/img/icons/patient.png',
					 array('alt' => 'Doctor')).'recipient:'.$this->Form->checkbox('',array('name'=>'DocName_1','id'=>'docId1','class'=>'reciptients','value'=>$docList['User']['id']));?>
			</td>
								   <td class="row_format" align="left"><?php echo $docList['DoctorProfile']['doctor_name'].'('. $docList['DoctorProfile']['specility_keyword'].')';?></td>
								   <td class="row_format" align="left"><?php echo $docList['User']['email'];?> </td>
								  </tr>
					  <?php }}
					  else{				  
			       ?>
		  <tr class='row_gray'><td class="row_format" align="center" colspan='3'><?php echo __('No Record Found');}?> </td>
		  </tr>
		  <tr>
			<td class="row_format" align="right" colspan='3'><?php echo $this->Form->input('Add to recipient list',array('type'=>'button','label'=>false,'id'=>'addToList1'));?></td>
	</tr>
		 </table>
		 <script>
		 $('#addToList1').click(function(){
			 var patientId=$("#patientId").val();
				var icd_code='';
		 		$("input:checked").each(function(index) { 
		 		
		 			 if($(this).attr('name') != 'undefined'){
		 				 icd_code  += $(this).val()+"|";
				    }
		 			
				});
		 		window.top.location = '<?php echo $this->Html->url("/recipients/referral_preview_action/null"); ?>'+"/"+'<?php echo $id;?>'+"/"+icd_code;  	
		 		
		 	});</script>