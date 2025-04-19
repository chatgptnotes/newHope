<div class="inner_title">
	<h3>Radiology Result</h3>
</div>
<?php //echo $this->element('patient_information');?>
<?php echo $this->Form->create('Radiology', array('url' => array('controller' => 'radiologies', 'action' => 'radiology_result',$patient_id)
																	,'id'=>'labResultfrm' , 
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
									));
									 
									?>
<?php echo $this->Form->end();	 ?>
<?php if(isset($this->data['Radiology']['radiology_id']) && !empty($this->data['Radiology']['radiology_id'])) {   
                   			echo $this->requestAction(array('action'=>'ajax_radiology_manager_test_order',$patient_id,$this->data['Radiology']['radiology_id'],$rad_test_order_id));
 } //EOF test check
 ?>
                     
 