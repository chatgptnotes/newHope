<td class="form_lables" align="right" valign="top"><?php echo __('Patients'); ?><font color="red">*</font></td>
<td>
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">
    	<tr>
    		<th>Name</th>
    		<th>Bed No.</th>
    		<th>Select</th>
    	</tr>
    	<?php 
    		$i=0;  
    		foreach($patientInRoom as $key=>$value){
    			$i++;
    			$checked = '' ;
    			$disable ='' ;
    			$patient_id = $value['Patient']['id'] ;
    	?>
    	<tr>
    		<td><?php echo $value['Patient']['lookup_name']; ?></td>
    		<td><?php echo $value[0]['bedno']; ?></td>
    		<td>
    			<?php  
    			 
	    			//checked
	    			foreach($patients as $k =>$v){
	    			//	if(isset($v['AllocatedPatient'][0])){
	    					foreach($v['AllocatedPatient'] as $allotKey => $allotedValue){
	    						 
	    						if(($allotedValue['patient_id'] == $patient_id) && ($v['TimeSlot']['id']!=$time_slot)){
	    							$checked = 'checked' ;
	    							$disable = 'disabled' ;
	    						}else if($allotedValue['patient_id'] == $patient_id){
	    							$checked = 'checked' ;
	    							$disable = '' ;
	    						}
	    					}	
	    			//	}
	    				 
		    		}
	    			echo $this->Form->input('',array('name'=>"data[AllocatedPatient][$i][patient_id]",'checked'=>$checked,'disabled'=>$disable,
	    				'type'=>'checkbox','id'=>$patient_id,'value'=>$patient_id,'div'=>false,'label'=>false,'error'=>false));
    			?>
    		</td>
    	</tr>
    	<?php } ?>
    </table>
</td>