<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
 <?php echo __("Hospital Management System Advance Directive"); ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
<style>
.print_form{
	background:none;
	font-color:black;
	color:#000000;
}
.formFull td{
	color:#000000;
}
</style>
<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
  </script>
</head>
<body onload="javascript:window.print();" class="print_form">

   <div class="inner_title">
	<h3 style="color:black;text-align:center;">&nbsp; <?php echo __('Advance Directive', true); ?></h3>
	</div>
	
	<p class="ht5"></p>
<!-- two column table start here -->
                 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td width="49%" valign="top" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                              <tbody><tr>
                              	<th colspan="2"><?php echo __('Patient Information'); ?></th>
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
                            
                            </tbody></table>
                            
                            
                            
                            
                              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr>
			                  		<th colspan="2" font-size="16px"><strong><?php echo __('Part 1. My Durable Power of Attorney for Health Care'); ?></strong></th>
			                   </tr>
                             
                           
	                           <tr><td valign="middle" id="boxSpace" class="tdLabel" width="440px">
	                                I appoint this person to make decisions about my medical care if there ever comes a time when i cannot make those decision myself. 
					            	 I want the person i have appointed, my doctors, my fa and others to be guided by the decisions I have made in the parts of the form that follow.</td>
	                       		 </tr>
	                       		 
	                       		 
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
                              </tr>
                              
                              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr>  <td valign="middle" id="boxSpace" class="tdLabel">If the person above cannot or will not make decisions for me, I appoint this person:</td>
					           </tr>
           
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
                              </tr>
                              
                              <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                               <tr>
                       			   <td valign="middle" id="boxSpace" class="tdLabel">I have not appointed anyone to make health care decisions for me in this or any other document.</td>
                          	</tr>
                              
                      
                       
                       
                       
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr><tr>
                  		<th colspan="2" font-size="16px"><strong><?php echo __(' Part 2. My Living Will'); ?></strong></th>
                    </tr>
                             
                              
                               
                      <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                            <tr>  <td valign="middle" id="boxSpace" class="tdLabel" width="100px">
                              These are my wishes for my future medical care if there ever comes a times when i cant make these decisions myself.</td></tr>
                              
                              <tr>
                              	<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('A. These are my wishes if i have a terminal condition'); ?></td>
                              </tr>
                              
                              
                                 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
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
	    
                              
                          
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
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

 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>



<tr>	<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('B. Autopsy'); ?></strong></td>
                              </tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
<?php echo $this->Form->checkbox('consent_for1'); 	?>
	    I do not want an autopsy.</td></tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
<?php echo $this->Form->checkbox('consent_for1'); 	?>
	    I agree to an autopsy if my doctors wish it.</td></tr>
	     <tr><td valign="middle" id="boxSpace" class="tdLabel">
<?php echo $this->Form->checkbox('consent_for1'); 	?>
	    Other wishes.</td></tr>
	    
	    
	     <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
	    <tr>	<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('C. Other statement about your medical care'); ?></strong></td>
                              </tr>
	     <tr> <td valign="middle" id="boxSpace" class="tdLabel">if you wish to say more about any of the choices you have made or if you have any other statements to make about your medical care, 
	     you may do so on a separate piece of paper. If you do so, put here the number of pages you adding:</td></tr>
	     </table>
                               
   
   
   
                    
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
              <tbody>
             		<tr>
                  		<th colspan="2" font-size="16px"><strong><?php echo __(' Part 4. Signatures'); ?></strong></th>
                    </tr>
                       <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>        
                    <tr> <td valign="middle" id="boxSpace" class="tdLabel">You and two witnesses must sign this document before it will be legal.</td></tr>
                                
                     <tr><td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('A. Your Signature'); ?></strong></td>
                     </tr>  
                      <tr><td valign="middle" id="boxSpace" class="tdLabel">By my signature below, I show that I understnd the purpose and the effect of this document.</td></tr>
                      
                      
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody>
                          <tr>
                            <td width="90" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Signature.'); ?></td>
                          <td align="left">
                           <?php 
                            	    if($advanceData['AdvanceDirective']['patient_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$advanceData['AdvanceDirective']['patient_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }  
                            	?>
							
</td>
                          </tr>
                         
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
                               <?php echo $advanceData['AdvanceDirective']['patient_address1']; ?>

</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel">&nbsp; </td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['patient_address2']; ?>

</td>
                          </tr>
                          
     
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?> </td>
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
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness 1'); ?></th>
                          </tr>
                          <tr>
                            <td width="90" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Signature.'); ?></td>
                            <td align="left">
								 <?php if($advanceData['AdvanceDirective']['witness1_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$advanceData['AdvanceDirective']['witness1_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } ?>
</td>
                          </tr>
                         
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
                             <?php echo $advanceData['AdvanceDirective']['witness1_address1']; ?>

</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel">&nbsp; </td>
                            <td align="left">
                            <?php echo $advanceData['AdvanceDirective']['witness1_address2']; ?>

</td>
                          </tr>
                          
     
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?> </td>
                            <td align="left">
                            	<?php echo $advanceData['AdvanceDirective']['witness1_date']; ?>
							</td>
                          </tr>
                          
                        
                        
                       
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            		<th colspan="2"><?php echo __('Witness 2'); ?></th>
                          		</tr>
                        		  <tr>
                            			<td width="90" valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Signature.'); ?></td>
                           				 <td align="left">
                           				 <?php 
                            	    if($advanceData['AdvanceDirective']['witness2_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$advanceData['AdvanceDirective']['witness2_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }  
                            	?>
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
                        </tbody></table>
			
			
			
			
			
			
			
			 		
			</table>
			
			
			
			
			
			
			 		
			</table>
             </body>
             </html>               
                            
                            
                            
                            
                          