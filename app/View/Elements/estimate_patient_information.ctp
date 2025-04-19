<?php 
			$complete_name  = ucfirst($patientData['Initial']['name'])." ".ucfirst($patientData['EstimatePatient']['first_name'])." ".ucfirst($patientData['EstimatePatient']['last_name']) ;
			 
			
	?> 
<div class="patient_info">
	    		<table width="100%" cellpadding="0" cellspacing="0" border="0">
	    			<tr>
	    				<td valign="top">
	    					<table width="100%" cellpadding="0" cellspacing="0" border="0" class="patientHub">
                   		 
                        <tr>
                        	<td>
                   				<table width="100%" cellpadding="0" cellspacing="0" border="0">
								
                   					<tr>
									 <?php if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$photo) && !empty($photo)){ ?>
                                    	<td width="111" valign="top"><?php echo $this->Html->image("/uploads/patient_images/thumbnail/".$photo, array('alt' => $complete_name,'title'=>$complete_name,'width'=>'100','height'=>100)); ?></td>
										<?php }else {
											if($patientData['EstimatePatient']['sex'] == 'male'){ ?>
											<td width="111" valign="top"><?php echo $this->Html->image("/img/icons/male-thumb.gif", array('alt' => $complete_name,'title'=>$complete_name)); ?></td>
										<?php } else {  ?>
											<td width="111" valign="top"><?php echo $this->Html->image("/img/icons/female-thumb.gif", array('alt' => $complete_name,'title'=>$complete_name)); ?></td>
										<?php } } ?> 

                                      	<td width="15">&nbsp;</td>
                                        <td width="230" valign="top">
                                        	<p class="name"><?php echo $complete_name ;?></p>
                                        	<p class="name"></p>
                                            <p class="address"><?php echo $formatted_address ;?></p>
                                      	</td>
                                        <td width="20">&nbsp;</td>
                                        <td valign="middle">
                                        	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="patientInfo">
                   								<tr class="darkRow">
                                                	<td width="270" style="min-width:270px;">
                                                    	<div class="heading"><strong>Patient ID</strong></div>
                                                        <div class="content"><?php echo $patientData['EstimatePatient']['id'] ;?></div>
                                                    </td>
                                                    <td width="270" style="min-width:270px;">
														<div class="heading"><strong><?php echo __('Sex'); ?></strong></div>
                                                        <div class="content"><?php echo ucfirst($patientData['EstimatePatient']['sex']) ;?></div>                                                    	
                                                    </td>
                                                </tr>
                                                <tr class="lightRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Age'); ?></strong></div>
                                                        <div class="content"><?php echo $patientData['EstimatePatient']['age'] ;?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong><?php echo __('Tariff Standard'); ?></strong></div>
	                                                    <div class="content"><?php echo $patientData['TariffStandard']['name'] ;?></div>  
                                                    </td>
                                                </tr>
                                                 <tr class="darkRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Diagnosis'); ?></strong></div>  
                                                    </td>
                                                    <td><div  ><?php echo nl2br($patientData['EstimatePatient']['diagnosis']) ;?></div> </td>
                                                </tr>  
												 
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                   </table>
	    				</td>
	    				
					</tr>
				</table>
			</div>