<p class="ht5"></p>
<table width="100%" cellpadding="5" cellspacing="1" border="0" class="tabularForm" align="center">
	<tr>                    	 
    <th colspan="2"><?php echo __('Uploaded Reports');?>
                                <strong>
	<?php echo " - ".$radiologyTestName; ?>
	</strong></th>
                            </tr>
                            <tr>
                            	 
                                      			<td valign="top" width="100%">
		                                        	<?php
		                                        		$labID = $this->data['Radiology']['radiology_id'] ; 
		                                        		
		                                        	?>
		                                          	<div class="ht5"></div>
		                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
		                                            	<tr>
		                                               	  <td style="padding:0 10px 0 0;"><?php echo __('Uploaded file/record ')?></td>
		                                                    <td width="50%" style="padding:0;">
		                                                    	 
													              	  		 													              	  			
													              	  			<?php               	  			 
													              	  				foreach($data as $temData){
													              	  					if($temData['RadiologyReport']['file_name']){
													              	  						$id = $temData['RadiologyReport']['id'];
													              	  						echo "<p id="."icd_".$id." >";
													              	  						$replacedText =$temData['RadiologyReport']['file_name'] ;
													              	  					 	echo $this->Html->link($replacedText,'/uploads/radiology/'.$temData['RadiologyReport']['file_name'],array('escape'=>false,'target'=>'__blank','style'=>'text-decoration:underline;'));
														              	  			        echo "</p>"; 
													              	  					}
													              	  				}
													              	  				 
													              	  			?>            
													              	  		 
													              	                                                       	                                               	 
		                                                    </td>
		                                                   
		                                                </tr>
		                                              
		                                                <tr>
		                                               	  <td style="padding:0 10px 0 0;"><?php echo __('Note')?></td>
		                                                    <td width="50%" style="padding:0;">
		                                                    <?php
		                                                    
		                                                    	$note = isset($data[0]['RadiologyResult']['note'])?$data[0]['RadiologyResult']['note']:'' ;
		                                                    	echo nl2br($note); 
		                                                    ?>
		                                                  </td>
		                                                </tr>
		                                                <tr><td>&nbsp;</td></tr>
		                                                 <tr>
		                                               	  <td style="padding:0 10px 0 0;"><?php echo __('No of Slices')?></td>
		                                                    <td width="50%" style="padding:0;">
		                                                    <?php
		                                                    	$split = isset($data[0]['RadiologyResult']['split'])?$data[0]['RadiologyResult']['split']:'' ;
		                                                    	echo $split ; 
		                                                    ?>
		                                                  </td>
		                                                </tr>
		                                                
		                                          	</table>     
		                                         </td>
                                      	 
                                        
                                      </tr>
                                    </table> 
                      <p class="ht5"></p>
                       <p class="ht5"></p>
                       <div align="right">
                       		<?php  
                            echo $this->Html->link(__('Cancel'), array('action'=>'radiology_test_list',$patient_id), array('escape' => false,'class' => 'grayBtn','id'=>'cancel-order-form'));
                            ?>
                       </div> 
 
        