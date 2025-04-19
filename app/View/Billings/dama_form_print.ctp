
 <div style="float:right;" id="printButton"><?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?></div>
 <div  align="center">
                     <h3>DAMA CONSENT</h3>
                  </div>
                   <p class="ht5"></p> 
                   <?php echo $this->element('print_patient_header'); ?>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:30px;line-height:2">
                        <tr>
	                        <td   class="" height="30" >
	                        	We have been informed on the status of our patient  
	                        	<?php echo $patient['Initial']['name'].ucfirst($patient[0]['lookup_name']); ?> by the doctor.
	                        </td>
                        </tr>  
                         <tr> 
                            <td width=""  >
                            	The patient is suffering from
	                        	<?php   echo nl2br($this->data['DamaConsentForm']['condition']);  ?>.
	                        	
	                        	<?php
                            	/*if(!$this->data['DamaConsentForm']['suffering_from'])
									$form_received_on = $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),true);
								else
									$form_received_on = $this->DateFormat->formatDate2Local($this->data['DamaConsentForm']['suffering_from'],Configure::read('date_format'),true);
									
                            	echo $this->Form->input('suffering_from',array('type'=>'text','id'=>'suffering_from','class'=>'','value'=> $form_received_on));*/  
                            	?></td><!--
                            <td width="20">&nbsp;</td>
                            <td width="400"><?php   //echo $this->Form->input('condition',array('type'=>'text','id'=>'condition','size'=>50));  ?></td>
                            <td width="20">&nbsp;</td>
                            <td width="90" class="tdLabel2">is very critical.</td>
                            <td>&nbsp;</td>
                        --></tr>    
                        <tr>
	                        <td  height="30" class="">We have been informed that the condition of the patient  is serious.<br/>

								We are moving the patient from <?php echo ucfirst($this->Session->read('facility'))?> at our own risk and take full responsibility for this.<br/>

								We take full responsibility for the death of the patient.<br/>

								No doctor or staff of <?php echo ucfirst($this->Session->read('facility'))?> will be held responsible for the death of the patient.</td>
	                    </tr> 
	                    <tr><td>&nbsp;</td></tr>
	                    <tr><td>&nbsp;</td></tr>
	                    <tr><td>&nbsp;</td></tr>
                        <tr>
                        	<td width="100%">
	                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	                        		<tr>
	                        			 <td   height="35" class="">Date :
					                           <?php  
						                           	if($this->data['DamaConsentForm']['date']){
						                           		$damaDate = $this->DateFormat->formatDate2Local($this->data['DamaConsentForm']['date'],Configure::read('date_format'),true);
						                           	}else{
						                           		$damaDate='';
						                           	}
						                           echo $damaDate; 
						                       ?>
				                           
				                            </td> 
				                            <td>Signature _______________________</td>
				                            <td  class="" align="right" >Relationship with patient :<?php 
				                            echo ucfirst($this->data['DamaConsentForm']['relation']);
				                            ?>
				                          </td>  
	                        		</tr>
	                        	</table>
                           </td>
                        </tr>   
                              
                    </table>  
                    <div class="clr ht5"></div>
 