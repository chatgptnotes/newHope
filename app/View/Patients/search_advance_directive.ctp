 <?php echo $this->Html->script(array('jquery.signaturepad.min'));
  	echo $this->Html->css(array('jquery.signaturepad'));?>
  	<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
  </script>
 <div class="inner_title">
 
	<h3>&nbsp; <?php echo __('Advance Directive', true); ?></h3>
	</div>
	<p class="ht5"></p>
	 <div class="btns">
  <?php #echo $this->Html->link(__('Print'), array('action' => 'print_advance_directive',$advanceData['AdvanceDirective']['patient_id']), array('escape' => false,'class'=>'grayBtn'));
	echo $this->Html->link('Print','#',
			 array('class'=>'grayBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'print_advance_directive',$advanceData['AdvanceDirective']['patient_id']))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400');  return false;"));
   			
	?>
 </div>  
 
 
 
 
 <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td width="100%" valign="top" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                              <tbody><tr>
                              	<th colspan="2"><strong><?php echo __('Patient Information'); ?></strong></th>
                              </tr>
                              <tr>
                                <td width="140" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?>:</td>
                                <td align="left">
								<?php echo $advanceData['AdvanceDirective']['patient_name']; ?>
								
								
								
								</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?>:</td>
                                <td align="left">
                                <?php echo $advanceData['AdvanceDirective']['patient_sex']; ?>
                                </td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?> :</td>
                                <td align="left">
	<?php echo $advanceData['AdvanceDirective']['patient_age']; ?>
	</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php //echo __('Years'); ?></td>
                                <td align="left">
<?php //echo $advanceData['AdvanceDirective']['patient_year']; ?>
</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Registration No.'); ?>:</td>
                                <td align="left">
<?php echo $advanceData['AdvanceDirective']['patient_id']; ?>
</td>
                              </tr>
                            
                            </tbody></table></td></tr></tbody></table>
                            
                            
                            
                            <?php // debug($advanceData);?>
                              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr>
			                  		<th colspan="2" font-size="16px"><strong><?php echo __('Part 1. My Durable Power of Attorney for Health Care'); ?></strong></th>
			                   </tr>
                             
                           
	                           <tr><td valign="middle" id="boxSpace" class="tdLabel" width="440px">
	                                I appoint this person to make decisions about my medical care if there ever comes a time when i cannot make those decision myself. 
					            	 I want the person i have appointed, my doctors, my fa and others to be guided by the decisions I have made in the parts of the form that follow.</td>
	                       		 </tr></tbody></table>
	                       		 
	                       		 
                        	 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                          <tr>
                            	
                       
                              
			                         <tr>
			                                <td valign="middle" id="boxSpace" class="tdLabel" width="100px"><?php echo __('Name'); ?></td>
			                                <td valign="middle" id="boxSpace" class="tdLabel">
			                                <?php echo $advanceData['AdvanceDirective']['person1_name']; ?>
												
											</td>
                             		 </tr>
                              
		                         	 <tr>
		                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Home telephone'); ?></td>
		                                <td valign="middle" id="boxSpace" class="tdLabel">
		                                <?php echo $advanceData['AdvanceDirective']['p1home_telephone']; ?>
											
										</td>
		                             </tr>
                              
		                               <tr>
			                               <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Work telephone'); ?></td>
					                         <td valign="middle" id="boxSpace" class="tdLabel">
					                           <?php echo $advanceData['AdvanceDirective']['p1work_telephone']; ?>
												
											</td>
		                              </tr>
                              
                              
                              
                               <tr>
	                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 1'); ?></td>
	                               <td valign="middle" id="boxSpace" class="tdLabel">
	                                <?php echo $advanceData['AdvanceDirective']['p1address1']; ?>
									
									</td>
                              </tr>
                              <tr>
	                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 2'); ?></td>
	                               <td valign="middle" id="boxSpace" class="tdLabel">
	                               <?php echo $advanceData['AdvanceDirective']['p1address2']; ?>
										
									</td>
                              </tr>  </table>    </td></tr></tbody></table>
                              
                              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr>  <td valign="middle" id="boxSpace" class="tdLabel">If the person above cannot or will not make decisions for me, I appoint this person:</td>
					           </tr>
            </tbody></table>
            
            		  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
           
       					    <tr>  <td valign="middle" id="boxSpace" class="tdLabel" width="100px"><?php echo __('Name'); ?>
                                 <td valign="middle" id="boxSpace" class="tdLabel">
                                <?php echo $advanceData['AdvanceDirective']['person2_name']; ?>
								
								</td>
                             </tr>
                              
                          <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Home telephone'); ?></td>
                               <td valign="middle" id="boxSpace" class="tdLabel">
                               <?php echo $advanceData['AdvanceDirective']['p2home_telephone']; ?>
								
								</td>
                          </tr>
                              
                               <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Work telephone'); ?></td>
                                <td valign="middle" id="boxSpace" class="tdLabel">
                                <?php echo $advanceData['AdvanceDirective']['p2work_telephone']; ?>
										
								</td>
                           </tr>
                              
                              
                              
                               <tr>
	                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 1 '); ?></td>
	                                <td valign="middle" id="boxSpace" class="tdLabel">
	                                <?php echo $advanceData['AdvanceDirective']['p2address1']; ?>
									
									</td>
                              </tr>
                               <tr>
	                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 2'); ?>
	                                <td valign="middle" id="boxSpace" class="tdLabel">
	                                <?php echo $advanceData['AdvanceDirective']['p2address2']; ?>
									
									</td>
                              </tr></tbody>
                              
                              </table></tr></tbody></table>
                              
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                               <tr>
                       			   <td valign="middle" id="boxSpace" class="tdLabel">I have not appointed anyone to make health care decisions for me in this or any other document.</td>
                          	</tr>
                               </tbody></table>
                      
                       
                       
                       
                      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                              <tbody>
                                <tr>
                  		<th colspan="2" font-size="16px"><strong><?php echo __(' Part 2. My Living Will'); ?></strong></th>
                    	</tr>
                             
                              
                      <tr>   <td valign="middle" id="boxSpace" class="tdLabel">
                              These are my wishes for my future medical care if there ever comes a times when i cant make these decisions myself.</td></tr>
                              
                              <tr>
                              	<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('A. These are my wishes if i have a terminal condition'); ?></td>
                              </tr>
                              
                              
                                 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                              
                              <tr>
                             <td valign="middle" id="boxSpace" class="tdLabel"><strong>Life-sustaining treatments</strong></td></tr>
                              
                                <tr>
                                <td width="140" valign="middle" id="boxSpace" class="tdLabel">  </td>
                              </tr>
                              
                             
                                   	    <tr><td valign="middle" id="boxSpace" class="tdLabel">
                                   	    <?php 
							if($advanceData['AdvanceDirective']['terminal_check1'] == 1){
							echo $this->Form->checkbox('terminal_check1', array('checked' => 'checked', 'disabled' => 'disabled'));
							}else{
								echo $this->Form->checkbox('terminal_check1');
							}
 	?>

    I do not want life-sustaining treatment(including CPR) started. If life-sustaining treatments are started, 
    I want them stopped </td></tr>

<tr><td valign="middle" id="boxSpace" class="tdLabel">
  <?php 
							if($advanceData['AdvanceDirective']['terminal_check2'] == 1){
							echo $this->Form->checkbox('terminal_check2', array('checked' => 'checked', 'disabled' => 'disabled'));
							}else{
								echo $this->Form->checkbox('terminal_check2');
							}
 	?>

                                   	    I want the life-sustaining treatments that my doctors think are best for me</td>
                                 </td>   </tr>
                                 
  <tr><td valign="middle" id="boxSpace" class="tdLabel">
   <?php 
							if($advanceData['advance_directive']['terminal_check3'] == 1){
							echo $this->Form->checkbox('terminal_check3', array('checked' => 'checked', 'disabled' => 'disabled'));
							}else{
								echo $this->Form->checkbox('terminal_check3');
							}
 	?>
 
                                   	   Other wishes</td>
                                 </td>   </tr>
                                 
                                 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                                 
                                 
                                  <td valign="middle" id="boxSpace" class="tdLabel"><strong>Artificial nutrition and hydration</strong></td></tr>
 <tr><td valign="middle" id="boxSpace" class="tdLabel">
 
 						<?php 
 								if($advanceData['AdvanceDirective']['terminal_check4'] == 1){
								echo $this->Form->checkbox('terminal_check4', array('checked' => 'checked', 'disabled' => 'disabled'));
								}else{
									echo $this->Form->checkbox('terminal_check4');
								}
 	?>

	    I do not want artificial nutrition and hydration started if they would be the main treatments keep me alive.
        If artificial nutrition and hydration are started, I want them stopped. </td></tr>

<tr><td valign="middle" id="boxSpace" class="tdLabel">
 <?php 
							if($advanceData['AdvanceDirective']['terminal_check5'] == 1){
							echo $this->Form->checkbox('terminal_check5', array('checked' => 'checked', 'disabled' => 'disabled'));
							}else{
								echo $this->Form->checkbox('terminal_check5');
							}
 	?>

	    I do not want artificial nutrition and hydration started if they are main treatments keeping me alive.</td></tr>
	</table>   



  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr>
                  		<th colspan="2" font-size="16px"><strong><?php echo __(' Part 3. Other Wishes'); ?></strong></th>
                    </tr>
                              <tbody>
	    
                              
                          <tr>
                              	<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('A. Organ donation'); ?></strong></td>
                              </tr>
                              
                               <tr><td valign="middle" id="boxSpace" class="tdLabel">
                               <?php 
 								if($advanceData['AdvanceDirective']['organ_donate1'] == 1){
								echo $this->Form->checkbox('organ_donate1', array('checked' => 'checked', 'disabled' => 'disabled'));
								}else{
									echo $this->Form->checkbox('organ_donate1');
								}
 								?>

	    I do not wish to donate any of my organs or tissues.</td></tr>
	    
	    
                               <tr><td valign="middle" id="boxSpace" class="tdLabel">
                                <?php 
 								if($advanceData['AdvanceDirective']['organ_donate2'] == 1){
								echo $this->Form->checkbox('organ_donate2', array('checked' => 'checked', 'disabled' => 'disabled'));
								}else{
									echo $this->Form->checkbox('organ_donate2');
								}
 								?>

	   I  want to donate all of my organs and tissue.</td></tr>
	    
	   <tr><td valign="middle" id="boxSpace" class="tdLabel">
	    I only want to donate these organs and tissue.</td></tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
	      <?php echo $advanceData['AdvanceDirective']['organ_name']; ?>

</td></tr>

<tr>	<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('B. Autopsy'); ?></strong></td>
                              </tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
<?php
if($advanceData['AdvanceDirective']['consent_for1'] == 1){
	echo $this->Form->checkbox('consent_for1', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('consent_for1');
}



//echo $this->Form->checkbox('consent_for1'); 
	?>
	    I do not want an autopsy.</td></tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
<?php 
if($advanceData['AdvanceDirective']['consent_for2'] == 1){
	echo $this->Form->checkbox('consent_for2', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('consent_for2');
}
	?>
	    I agree to an autopsy if my doctors wish it.</td></tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
<?php 
if($advanceData['AdvanceDirective']['consent_for3'] == 1){
	echo $this->Form->checkbox('consent_for3', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('consent_for3');
}
	?>
	    Other wishes.</td></tr>
	    
	    
	    
	    <tr><td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('C. Other statement about your medical care'); ?></strong></td>
                              </tr>
	     <tr> <td valign="middle" id="boxSpace" class="tdLabel">if you wish to say more about any of the choices you have made or if you have any other statements to make about your medical care, 
	     you may do so on a separate piece of paper. If you do so, put here the number of pages you adding:</td></tr>
	     </table>
                               
   	<table width="100%" cellspacing="0" cellpadding="0" border="0">
        
              <tbody>
             		<tr>
                  		<th colspan="2" font-size="16px"><strong><?php echo __(' Part 4. Signatures'); ?></strong></th>
                    </tr>
                               
                    <tr> <td valign="middle" id="boxSpace" class="tdLabel">You and two witnesses must sign this document before it will be legal.</td></tr>
                                
                     <tr><td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('A. Your Signature'); ?></strong></td>
                     </tr>  
                      <tr><td valign="middle" id="boxSpace" class="tdLabel">By my signature below, I show that I understnd the purpose and the effect of this document.</td></tr>
                      
                      
		    
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                          <tr>
                            <td width="30" valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Signature.'); ?></td>
                            <td align="left"> <?php 
                            	    if($advanceData['AdvanceDirective']['witness2_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$advanceData['AdvanceDirective']['patient_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }  else {
                            	?>
                        
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="200" height="150"></canvas>
                                 <?php echo $this->Form->input('AdvanceDirective.patient_output', array('type' =>'text', 'id' => 'output', 'class' => 'output validate[required,custom[mandatory-enter-only]]','style'=>'visibility:hidden')); ?>
                                 </div>
                               </div> <?php } ?>
                            	

							</td>
                          </tr>
                         
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
                            <?php echo $advanceData['AdvanceDirective']['patient_address1']; ?>
							</td>

                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"> &nbsp;</td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['patient_address2']; ?>
                           
                            </td>
                          </tr>
                         
                          
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Date'); ?></td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['patient_date']; ?>
								</td>

                          </tr>
                        </tbody></table>
   
   
   
   
   
                     <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
		   
		            <tr><td valign="middle" id="boxSpace" class="tdLabel">
		                        I believe the person who has signed this advance directive to be of sound mind, 
								that he/she signed or acknowledged this advance directive in my presence and that he/she appears not to be acting under pressure duress,
								fraud or undue influence. I am not related to the person making this advance directive by blood, marriage or adoption nor, to the best of my knowledge,
								 am i named in his/her will. I am not the person appointed in this advance directive. I am not a health care provider or an employee of a health care provider who is now,
								 or has been in the past, responsible for the care of the person making this advance directiv.</td>
					</tr> 
			</table></table>
			
			
			<table width="100%" cellspacing="0" cellpadding="0" border="2">
                      <tbody><tr>
                        <td width="50%"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness 1'); ?></th>
                          </tr>
                          <tr>
                            <td width="30" valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Signature.'); ?></td>
                            <td align="left"> <?php 
                            	    if($advanceData['AdvanceDirective']['witness1_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$advanceData['AdvanceDirective']['witness1_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }  else {
                            	?>
                         
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="200" height="150"></canvas>
                                 <?php echo $this->Form->input('AdvanceDirective.patient_output', array('type' =>'text', 'id' => 'output', 'class' => 'output validate[required,custom[mandatory-enter-only]]','style'=>'visibility:hidden')); ?>
                                 </div>
                               </div> <?php } ?>
                            	

							</td>
                          </tr>
                         
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
                            <?php echo $advanceData['AdvanceDirective']['witness1_address1']; ?>
							</td>

                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"> &nbsp;</td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['witness1_address2']; ?>
                           
                            </td>
                          </tr>
                         
                          
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Date'); ?></td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['witness1_date']; ?>
								</td>

                          </tr>
                        </tbody></table></td>

                        <td width="50%"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness 2'); ?></th>
                          </tr>
                          <tr>
                            <td width="30" valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Signature.'); ?></td>
                            <td align="left"> <?php 
                            	    if($advanceData['AdvanceDirective']['witness2_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$advanceData['AdvanceDirective']['witness2_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }  else {
                            	?>
                         
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="200" height="150"></canvas>
                                 <?php echo $this->Form->input('patient_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div> <?php } ?>
                            	

							</td>
                          </tr>
                         
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
                            <?php echo $advanceData['AdvanceDirective']['witness2_address1']; ?>
							</td>

                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"> &nbsp;</td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['witness2_address2']; ?>
                           
                            </td>
                          </tr>
                         
                          
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Date'); ?></td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['witness2_date']; ?>
								</td>

                          </tr>
                        </tbody></table></td>
			</table>
			</table>
                            
                            
                            
                            
                            
                          