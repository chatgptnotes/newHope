<div class="inner_title">
                      <h3>Radiology Result</h3>
                  	</div>
                   <p class="ht5"></p>
                   
                   <!-- billing activity form start here -->
                   <?php 
                  		echo $this->element('patient_information');
                  ?>
                   <div class="clr ht5"></div>
                   <?php 
                   echo $this->Form->create('Radiology', array('url' => array('controller' => 'radiologies', 'action' => 'radiology_result',$patient_id)
																	,'id'=>'labResultfrm' , 
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
									));
								
									?>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0">
                   		<tr>
                       	  	<td width="300" class="tdLabel2">
                            </td>
                            <td>
                            </td>
                        </tr> 
                   </table>
                   <?php echo $this->Form->end();?>
                 
                   <div class="clr ht5"></div>
                   <?php 
                  		
                   		if(isset($this->data['Radiology']['radiology_id']) && !empty($this->data['Radiology']['radiology_id'])) {    
                   				echo $this->requestAction(array('action'=>'radiology_doctor_view',$patient_id,$this->data['Radiology']['radiology_id'],$rad_test_order_id,$smartPhraseFlag));
                   		 } //EOF test check
                   ?>
                     
 <script>
 		
 </script>