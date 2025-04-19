<?php 
 
	 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
	 echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css'));
	 echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','internal_style.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4','jquery.ui.widget.js'));  
	 echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','ui.datetimepicker.3.js'));
  	 echo $this->Html->css('jquery.autocomplete.css'); 
  	 
  	 
?>
    
<div class="inner_title">
 <h3>
 <?php echo __('Add Notes'); ?>
 </h3>
</div>
	<?php 
			echo $this->Form->create('Note',array('id'=>'patientnotesfrm' ,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
		 	echo $this->Form->hidden('Note.id');
		 	$note_type  = $this->data['Note']['note_type'] ;
		 	$toBeBilled = 'none' ; 
		 	if($note_type=='general'){		  
		 		$toBeBilled ='block';
		 	} 
		 		
		  
	?>
	
	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format"  id="schedule_form">				    			    
			   <tr>
			    <td><label><?php echo __('S/B Registrar');?><font color="red">*</font>:</label></td>
			    <td>
			    	 <input type="hidden" name="patientid" value="<?php echo $patientid; ?>" > 
				     <?php
						echo $this->Form->input('patient_id', array( 'type' => 'hidden','value'=>$patientid, 'id' => 'patientid' )); 
				     //echo $this->Form->input('create_time', array( 'type' => 'hidden', 'id' => 'note_date' , 'value' => date('d/m/Y'))); 
				     ?>	
			    	<?php
			    		
			    		echo $this->Form->input('sb_consultant', array('options'=>$consultant,'empty'=>'Please select','id' => 'sb_consultant','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' )); 
			    	?>
			     	
			    </td>
			   </tr>				   
			   <tr>
			    <td><label><?php echo __('S/B  Consultant');?><font color="red">*</font>:</label></td>
			    <td>
			    	<?php
			    		
			    		echo $this->Form->input('sb_registrar', array('options'=>$registrar,'empty'=>'Please select','id' => 'sb_registrar','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' )); 
			    	?>
			     	
			    </td>
			   </tr>
			    <tr>
			    <td><label><?php echo __('Date');?><font color="red">*</font>:</label></td>
			    <td>
			    	<?php
			    		 
			    		echo $this->Form->input('note_date', array('type'=>'text','id' => 'note_date','class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:82%;' )); 
			    	?>
			     	
			    </td>
			   </tr>
			   <tr>
			    <td><label><?php echo __('Note Type');?><font color="red">*</font>:</label></td>
			    <td>
			    	<?php 
					 
			    		$noteType= array('general'=>'General','pre-operative'=>'Pre Operative','OT'=>'OT','post-operative'=>'Post Operative','event'=>'Event');
			    		echo $this->Form->input('note_type', array('empty'=>'Please select','options'=>$noteType, 'id' => 'note_type','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' )); 
			    	?>
			     	<input type="hidden" name="authorname" value="<?php echo AuthComponent::user('first_name'); ?>"  readonly/>
			    </td>
			   </tr> 
			    
			   <tr id="to_be_billed_section" style="display:<?php echo $toBeBilled ;?>">
			    <td><label><?php echo __('To be Billed');?>:</label></td>
			    <td>
			    	<?php 
					 
			    		    echo $this->Form->checkbox('to_be_billed', array('class'=>'servicesClick','id' => 'to_be_billed'));
			    	 
			    	?>
			     	<input type="hidden" name="authorname" value="<?php echo AuthComponent::user('first_name'); ?>"  readonly/>
			    </td>
			   </tr> </table>	  
		 
		 <?php
		 	 // set variable for edit form
		 	 if(isset($this->data['Note']['note_type'])){
		 	 	 $note_type  = $this->data['Note']['note_type'] ;
		 	 	 	$gen_display  = 'none';
		 	 	 	$pre_display  = 'none';
		 	 	 	$other_display ='none';
		 	 	 	$ot_display  = 'none';
		 	 	 	$post_display  = 'none';
		 	 	 	
		 	 	 if($note_type=='general'){
		 	 	 	$gen_display  = 'block';		 	 	 	 
		 	 	 }else if($note_type=='pre-operative'){		 	 	  
		 	 	 	$pre_display  = 'block';		 	 	  
		 	 	 }else if($note_type=='post-operative'){		 	 	 	 
		 	 	 	$post_display  = 'block';
		 	 	 }else if($note_type=='OT'){		 	 	 	 
		 	 	 	$ot_display  = 'block';		 	 	 	 
		 	 	 }else{		 	 	 	 
		 	 	 	$other_display ='block';		 	 	  
		 	 	 }
		 	 }else{
		 	 		$gen_display  = 'none';
		 	 	 	$pre_display  = 'none';
		 	 	 	$other_display ='none';
		 	 	 	$ot_display  = 'none';
		 	 	 	$post_display  = 'none';
		 	 } 
		 ?>
		 <div id="accordionCust">
		 <!-- BOF General Note type option -->
		 <h3 style="display:<?php echo $gen_display;?>;" id="present-cond-link"><a href="#">Present Condition</a></h3>
		 <div class="section" id="present-cond">
			 <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
	    	    		<td width="27%" align="left" valign="top">
	    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
	    	    			<div id="templateArea-present-cond">
	    	    				    	    			 	 
	    	    			</div>	    	    		 
	    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
    	    							<?php echo $this->Form->textarea('present_condition', array('id' => 'present-cond_desc'  ,'rows'=>'18','style'=>'width:90%')); ?>
        						</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table>
		 </div><!-- EOF section div -->
		 <h3 style="display:<?php echo $gen_display;?>;" id="investigation-link"><a href="#">Investigation</a></h3>
		 <div class="section" id="investigation">
			 <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
	    	    		<td width="27%" align="left" valign="top">
	    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
	    	    			<div id="templateArea-investigation">
	    	    				    	    			 	 
	    	    			</div>	    	    		 
	    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
    	    							<?php echo $this->Form->textarea('investigation', array('id' => 'investigation_desc'  ,'rows'=>'18','style'=>'width:90%')); ?>
        						</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table>
		 </div><!-- EOF section div -->  
		 <h3 style="display:<?php echo $gen_display;?>;" id="treatment-link"><a href="#">Treatment Adviced</a></h3>
		 <div class="section" id="treatment">
			 <!--BOF medicine  -->
		 	<table class="tdLabel" style="text-align:left;" width="100%">		 			
		 		<tr>		 		   
		       	  <td width="100%" valign="top" align="left" style="padding:8px;" colspan="4">
		              <table width="100%" border="0" cellspacing="0" cellpadding="0">		                
		                <!-- row 1 -->                
		               <tr>
		               	<td width="100%" valign="top" align="left" colspan="6">
		               		<table width="100%" border="0" cellspacing="0" cellpadding="0" id='DrugGroup' class="tdLabel">
								<tr>
								  <td width="20%" height="20" align="left" valign="top">Name of Medication</td>	
								   <td width="18%" height="20" align="left" valign="top">Unit</td>								  
								  <td width="6%" align="left" valign="top">Route</td>								  
								  <td width="6%" align="left" valign="top">Dose</td>								 
								  <td width="8%" align="left" valign="top">Quantity</td>
								  <td width="6%" align="left" valign="top">No. of Days</td>
								  <td width="54%" align="center" valign="top">Timing</td>
								</tr>
								<tr>
								  <td width="20%" height="20" align="left" valign="top">&nbsp;</td>								  
								  <td width="6%" align="left" valign="top">&nbsp;</td>								  
								  <td width="6%" align="left" valign="top">&nbsp;</td>								 
								  <td width="8%" align="left" valign="top">&nbsp;</td>
								  <td width="6%" align="left" valign="top">&nbsp;</td>
								  <td width="6%" valign="top" align="left">&nbsp;</td>
								  <td width="54%" align="center" valign="top">
									  	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
									  		<tr>
											  <td width="25%" height="20" align="center" valign="top">I</td>								  
											  <td width="25%" align="center" valign="top">II</td>								  
											  <td width="25%" align="center" valign="top">III</td>								 
											  <td width="25%" align="center" valign="top">IV</td>										  
										  </tr>
									  	</table>
								  </td>
								</tr>
			               		<?php  
			               			if(isset($this->data['drug']) && !empty($this->data['drug'])){
			               				$count  = count($this->data['drug']) ;
			               			}else{
			               				$count  = 3 ;
			               			}	               			
			               			for($i=0;$i<$count;){
			               				$drugValue= isset($this->data['drug'][$i])?$this->data['drug'][$i]:'' ;
			               				$pack= isset($this->data['drug'][$i])?$this->data['pack'][$i]:'' ;
			               				$routeValue= isset($this->data['route'][$i])?$this->data['route'][$i]:'' ;
			               				$doseValue= isset($this->data['dose'][$i])?$this->data['dose'][$i]:'' ;
			               				$frequency = isset($this->data['frequency'][$i])?$this->data['frequency'][$i]:'' ;
			               				$quantity = isset($this->data['quantity'][$i])?$this->data['quantity'][$i]:'' ;
			               				
										$firstValue= isset($this->data['first'][$i])?$this->data['first'][$i]:'' ;
			               				$secondValue= isset($this->data['second'][$i])?$this->data['second'][$i]:'' ;
			               				$thirdValue = isset($this->data['third'][$i])?$this->data['third'][$i]:'' ;
			               				$forthValue = isset($this->data['forth'][$i])?$this->data['forth'][$i]:'' ;
			               				
			               				
			               				$first  ='disabled';
			               				$second ='disabled';
			               				$third  = 'disabled';
			               				$forth  ='disabled';
			               				$hourDiff =0;
			               				//set timer
			               				switch($frequency){
			               					case "OD":
			               						$first ='enabled';			               									               									               						
			               						break;
			               					case "BD":
			               						$hourDiff =  12;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						break;
			               					case "TDS":
			               						$hourDiff = 6 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						break;
			               					case "QID":
			               						$hourDiff = 4 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						$forth = 'enabled';
			               						break;
			               					case "HS":
			               						$first ='enabled';			               						
			               						break;
			               					case "Twice a week":
			               						$first ='enabled';			               						
			               						break;
			               					case "Once a week":
			               						$first ='enabled';			               						
			               						break;
			               					case "Once fort nightly":
			               						$first ='enabled';			               						
			               						break;
			               					case "Once a month":
			               						$first ='enabled';			               						
			               						break;
			               					case "A/D":
			               						$first ='enabled';			               						
			               						break;
			               				}
			               				//EOF timer
			               			?>
				               			<tr id="DrugGroup<?php echo $i;?>">
						                  <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText' ,'id'=>"drug$i",'name'=> 'drug[]','value'=>$drugValue,'autocomplete'=>'off','counter'=>$i)); ?>                        	 
						                  </td> 
						                  <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('type'=>'text','size'=>16,'class' => 'drugPack','id'=>"Pack$i",'name'=> 'Pack[]','value'=>$pack ,'counter'=>$i)); ?>                        	 
						                  </td> 						                 
										  <td   align="left" valign="top">
						                  		<?php 
											$routes_options = array('IV'=>'IV','IM'=>'IM','S/C'=>'S/C','P.O'=>'P.O','P.R'=>'P.R','P/V'=>'P/V','R.T'=>'R.T','LA'=>'LA');  
										  
										  echo $this->Form->input('', array( 'options'=>$routes_options,'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"route$i",'name' => 'route[]','value'=>$routeValue)); ?>
						                  </td>
						                  <td   align="left" valign="top">
						                  		<?php
											  	$fre_options = array('SOS'=>'SOS','OD'=>'OD','BD'=>'BD','TDS'=>'TDS','QID'=>'QID','HS'=>'HS','Twice a week' => 'Twice a week', 'Once a week'=>'Once a week', 'Once fort nightly'=>'Once fort nightly', 'Once a month'=>'Once a month', 'A/D'=>'A/D');
										  		echo $this->Form->input('', array( 'options'=> $fre_options,'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"frequency_$i",'class'=>'frequency','name' => 'frequency[]','value'=>$frequency)); ?>
						                  </td>
						                  <td  align="left" valign="top">
						                  		<?php											  	
										  		echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'name' => 'quantity[]','value'=>$quantity)); ?>
						                  </td>
						                   <td   align="left" valign="top">
						                  		<?php echo $this->Form->input('', array( 'type'=>'text','class' => '','size'=>'2','id'=>"dose$i",'name' => 'dose[]','value'=>$doseValue)); ?>
						                  </td>
						                  <td  align="center" valign="top">
						                 	 <?php
													  $timeArr = array('1'=>'1am','2'=>'2am','3'=>'3am','4'=>'4am','5'=>'5am','6'=>'6am','7'=>'7am','8'=>'8am','9'=>'9am','10'=>'10am','11'=>'11am','12'=>'12am',
			               							 				   '13'=>'1pm','14'=>'2pm','15'=>'3pm','16'=>'4pm','17'=>'5pm','18'=>'6pm','19'=>'7pm','20'=>'8pm','21'=>'9pm','22'=>'10pm','23'=>'11pm','24'=>'12pm' );
			               							  $disabled = 'disabled'; 
						                  		?>
						                  		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
											  		<tr>
													  <td width="25%" height="20" align="center" valign="top"><?php
													  	echo $this->Form->input('first_time', array($first,'id'=>"first_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'','class' => 'first' , 'label'=> false,
							 					  	   'div' => false,'error' => false,'value'=>$firstValue));  
													  ?></td>								  
													  <td width="25%" align="center" valign="top"><?php
													  	 echo $this->Form->input('second_time', array($second,'id'=>"second_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'' , 'label'=> false,
							 					  	   'div' => false,'error' => false ,'class'=>'second','value'=>$secondValue));  
													  ?></td>								  
													  <td width="25%" align="center" valign="top"><?php
													  	echo $this->Form->input('third_time', array($third,'id'=>"third_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'','class' => 'third' , 'label'=> false,
							 					  	   'div' => false,'error' => false,'value'=>$thirdValue)); 
													  ?></td>								 
													  <td width="25%" align="center" valign="top"><?php
													  	echo $this->Form->input('forth_time', array($forth,'id'=>"forth_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'' , 'label'=> false,
							 					  	   'div' => false,'error' => false ,'class'=>'forth','value'=>$forthValue)); 
													  ?></td>										  
												  </tr>
											  	</table>						                  		
							 			  </td> 
						           		</tr>	
			               			<?php
			               				$i++ ;
			               			}
			               			?> 		
			               		                       	              
		                </table>
		              </td>
		            </tr>                
		                <!-- row 3 end -->
		            <tr>                	
						<td align="right" colspan="5">
							<input type="button" id="addButton" value="Add more"> 
							<?php if($count > 0){?>
						 		<input type="button" id="removeButton" value="remove">
						 	<?php }else{ ?>
						 		<input type="button" id="removeButton" value="remove" style="display:none;">
						 	<?php } ?>
						 </td>
					</tr>
		            </table>
		          </td>
		        </tr>
		      </table>
		 	<!--EOF medicine -->
		 </div><!-- EOF section div --> 
		 
		 <!-- EOF General Note type option -->		 
		 <!-- BOF pre-operative Note type option -->
		 <h3 style="display:<?php echo $ot_display;?>;" id="surgery-link"><a href="#">Description of Surgery</a></h3>
		 <div class="section" id="surgery">
		 	 <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
	    	    		<td width="27%" align="left" valign="top">
	    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
	    	    			<div id="templateArea-surgery">
	    	    				    	    			 	 
	    	    			</div>	    	    		 
	    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
    	    							 <?php echo $this->Form->textarea('surgery', array('id' => 'surgery_desc'  ,'rows'=>'18','style'=>'width:90%')); ?> 
        						</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table>			 
		 </div><!-- EOF section div -->  
		 <h3 style="display:<?php echo $ot_display;?>;" id="implants-link"><a href="#">Implants</a></h3>
		 <div class="section" id="implants">
		 	 <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
	    	    		<td width="27%" align="left" valign="top">
	    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
	    	    			<div id="templateArea-implants">
	    	    				    	    			 	 
	    	    			</div>	    	    		 
	    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
    	    							 <?php echo $this->Form->textarea('implants', array('id' => 'implants_desc'  ,'rows'=>'18','style'=>'width:90%')); ?>  
        						</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table> 
		 </div><!-- EOF section div -->
		 <h3 style="display:<?php echo $ot_display;?>;" id="event-note-link"><a href="#">Event Note</a></h3>
		 <div class="section" id="event-note">
		 	 <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
    	    		<td width="27%" align="left" valign="top">
    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
							&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>	
    	    			<div id="templateArea-event-note">
    	    				    	    			 	 
    	    			</div>	    	    		 
    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
	        							  <?php echo $this->Form->textarea('event_note', array('id' => 'event_note_desc'  ,'rows'=>'18','style'=>'width:90%')); ?>  
	        					</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table> 			 
		 </div><!-- EOF section div -->
		 <h3 style="display:<?php echo $post_display;?>;" id="post-opt-link"><a href="#">Post Operative Note</a></h3>
		 <div class="section" id="post-opt">
		 		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
    	    		<td width="27%" align="left" valign="top">
    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
							&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>	
    	    			<div id="templateArea-post-opt">
    	    				    	    			 	 
    	    			</div>	    	    		 
    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
	        							 <?php echo $this->Form->textarea('post_opt', array('id' => 'post-opt_desc','rows'=>'18','style'=>'width:90%')); ?>   
	        					</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table> 					 
		 </div><!-- EOF section div -->
		  <!-- EOF post-oprative Note type option -->
		  <h3 style="display:<?php echo $pre_display;?>;" id="pre-opt-link"><a href="#">Pre Operative Note</a></h3>
		 <div class="section" id="pre-opt">
		 		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
    	    		<td width="27%" align="left" valign="top">
    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
							&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>	
    	    			<div id="templateArea-pre-opt"> 
    	    			</div>	    	    		 
    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
	        							 <?php echo $this->Form->textarea('pre_opt', array('id' => 'pre-opt_desc','rows'=>'18','style'=>'width:90%')); ?>   
	        					</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table> 					 
		 </div><!-- EOF section div -->
		
		 <!-- EOF pre-oprative Note type option -->
		 
		 <!-- BOF Other Note type option -->
		 <h3 style="display:<?php echo $other_display;?>;" id="notes-link"><a href="#">Note</a></h3>
		 <div class="section" id="notes">			  
			  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
    	    		<td width="27%" align="left" valign="top">
    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
							&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>	
    	    			<div id="templateArea-notes">
    	    				    	    			 	 
    	    			</div>	    	    		 
    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
	        							<?php echo $this->Form->textarea('note', array('id' => 'notes_desc' ,'rows'=>'18','style'=>'width:90%')); ?>    
	        					</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table> 	
		 </div><!-- EOF section div -->
		 <!-- EOF Other Note type option -->
		 
		 
	</div><!-- EOF accordion -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
	   	  	<td >
	   	  		<div class="btns">
	   	  				 <?php 
					        echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
					        echo $this->Js->writeBuffer();
					     ?>     
				</div>   	  		
	   	  	</td>
	   	 </tr>
   </table>
	<!-- EOF new HTML -->
<?php echo $this->Form->end(); ?>
<?php $splitDate = explode(' ',$admissionDate);?>
<script>
	// To sate min date not more than the admission date 
		var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
	
			jQuery(document).ready(function(){  
				
					
				$( "#note_date" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate : new Date(explode[0],explode[1] - 1,explode[2]),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
					onSelect: function ()
				    {			      
				    	 $(this).focus();
				    }	
				});

				
				$("#note_type").change(function(){
			    	 
			    	 if($("#note_type").val() == 'general'){
			    		 //alert('here'+$("#note_type").val());
			    		 $("#to_be_billed_section").show()	
			    	 }else{
			    		 $("#to_be_billed_section").hide();
			    	 }
			     });
				
				 $('.drugText').live('focus',function()
			  {   
			  		var counter = $(this).attr("counter");
			  		if($(this).val()==""){
			  			$("#Pack"+counter).val("");
			  		}
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 
				  	});	 
				    
					  
			});//EOF autocomplete
			
			 $('.drugPack').live('focus',function()
			  {   
			  		var counter = $(this).attr("counter");
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPack","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 extraParams: {drug:$("#drug"+counter).val() },
				  	});	 
				    
					  
			});//EOF autocomplete	  
				//add n remove drud inputs
				 var counter = <?php echo $count?>;
			 
			    $("#addButton").click(function () {		 				 
					/*if(counter>10){
				            alert("Only 10 textboxes allow");
				            return false;
					}  */
					//$("#patientnotesfrm").validationEngine('detach'); 
					var newCostDiv = $(document.createElement('tr'))
					     .attr("id", 'DrugGroup' + counter);
					var route_option = '<select style="width:80px;" id="route'+counter+'" class="" name="route[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
					var fre_option = '<select style="width:80px;" id="frequency_'+counter+'" class="frequency" name="frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
					var quality_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
					var options = '<option value=""></option>';
					for(i=1;i<25;i++){
						if(i<13){
							str = i+'am';
						}
						else {
							str = (i-12)+'pm';
						}						
						options += '<option value="'+i+'"'+'>'+str+'</option>';
					}
					  
					timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';								  
					timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
					timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
					timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
					timer = timerHtml1+timerHtml2+timerHtml3+timerHtml4+'</tr></table></td>';
					
					
					var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '"  class=" drugText validate[optional,custom[onlyLetterNumber]] ac_input" name="drug[]" autocomplete="off" counter='+counter+'></td><td><input  type="text" value="" id="Pack' + counter + '"  class=" drugPack validate[optional,custom[onlyLetterNumber]] ac_input" name="Pack[]" autocomplete="off" counter='+counter+'></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt+'<td><input size="2" type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td>'+timer;
					           		 			
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");		
					//$("#patientnotesfrm").validationEngine('attach'); 			 			 
					counter++;
					if(counter > 0) $('#removeButton').show('slow');
			     });
			 
			     $("#removeButton").click(function () {
						/*if(counter==3){
				          alert("No more textbox to remove");
				          return false;
				        }  */ 			 
						counter--;			 
				 
				        $("#DrugGroup" + counter).remove();
				 		if(counter == 0) $('#removeButton').hide('slow');
				  });
				  //EOF add n remove drug inputs
				
			 
				 
				function remove_icd(val){				
					var ids= $('#icd_ids').val();
					//alert(ids+'|'+val);
					tt = ids.replace(val+'|','');
					//alert(tt);
					$('#icd_ids').val(tt);
					$('#icd_'+val).remove();				
				}

				//EOF add/remove medicine textboxes
				
					$('#note_type').change(function(data){
						var selOpt = $(this).val();//current type selection
						if(selOpt=='general'){							
							$('#notes-link').hide('fast');							
							$('#surgery-link').hide('fast');//display one by one 
							$('#implants-link').hide('fast');
							$('#event-note-link').hide('fast');
							$('#post-opt-link').hide('fast');
							$('#pre-opt-link').hide('fast');
							$('#notes').hide('fast');							
							$('#surgery').hide('fast');//display one by one 
							$('#implants').hide('fast');
							$('#event-note').hide('fast');
							$('#post-opt').hide('fast'); 
							$('#pre-opt').hide('fast');
							$('#investigation-link').fadeIn('fast');							
							$('#treatment-link').fadeIn('slow');
							$('#present-cond-link').fadeIn('slow');
						}else if(selOpt=='OT'){
							$('#investigation-link').hide('fast');
							$('#treatment-link').hide('fast');
							$('#notes-link').hide('slow');	
							$('#investigation').hide('fast');
							$('#treatment').hide('fast');
							$('#notes').hide('fast');
							$('#present-cond-link').hide('fast');	
							$('#present-cond').hide('fast');
							$('#post-opt-link').hide('fast');
							$('#pre-opt-link').hide('fast');							
							$('#surgery-link').fadeIn('500');//display one by one 
							$('#implants-link').fadeIn('1000');
							$('#event-note-link').fadeIn('1500');  
						}else if(selOpt=='pre-operative'){
							$('#investigation-link').hide('fast');
							$('#treatment-link').hide('fast');
							$('#notes-link').hide('slow');	
							$('#investigation').hide('fast');
							$('#treatment').hide('fast');
							$('#notes').hide('fast');
							$('#present-cond-link').hide('fast');	
							$('#present-cond').hide('fast'); 
							$('#surgery-link').hide('500');//display one by one 
							$('#implants-link').hide('1000');
							$('#event-note-link').hide('1500');
							$('#post-opt-link').hide('1500'); 
							$('#post-opt').hide('1500');
							$('#pre-opt-link').fadeIn('2000'); 
						}else if(selOpt=='post-operative'){
							$('#investigation-link').hide('fast');
							$('#treatment-link').hide('fast');
							$('#notes-link').hide('slow');	
							$('#investigation').hide('fast');
							$('#treatment').hide('fast');
							$('#notes').hide('fast');
							$('#present-cond-link').hide('fast');	
							$('#present-cond').hide('fast'); 
							$('#surgery-link').hide('500');//display one by one 
							$('#implants-link').hide('1000');
							$('#event-note-link').hide('1500');
							$('#event-note').hide('1500');
							$('#pre-opt-link').hide('fast');
							$('#pre-opt').hide('fast');						 
							$('#post-opt-link').fadeIn('2000'); 
							 
						}else{
							$('#surgery-link').hide('fast');//display one by one 
							$('#implants-link').hide('fast');
							$('#event-note-link').hide('fast');
							$('#post-opt-link').hide('fast');
							$('#pre-opt-link').hide('fast');
							$('#pre-opt').hide('fast');
							$('#investigation-link').hide('fast');
							$('#treatment-link').hide('fast');							
							$('#present-cond-link').hide('fast');	
							$('#present-cond').hide('fast'); 
							$('#surgery').hide('fast');//display one by one 
							$('#implants').hide('fast');
							$('#event-note').hide('fast');
							$('#post-opt').hide('fast');
							$('#investigation').hide('fast');
							$('#treatment').hide('fast'); 
							$('#pre-opt-link').hide('fast');	
							$('#notes-link').fadeIn('slow');	
						} 
					});
					//BOF accordion
							$( "#accordionCust" ).accordion({
									active :false,
									collapsible: true,
									autoHeight: true,				
									navigation: true,
									change:function(event,ui){
											 				 
											//BOF template call
										 	var currentEleID = $(ui.newContent).attr("id") ;									 	 
										 	var replacedID  = "templateArea-"+currentEleID; 	
										 	
										 	if(currentEleID=='implants' || currentEleID=='event-note' || currentEleID=='treatment' ||currentEleID=='notes' || currentEleID=='post-opt' || currentEleID=='surgery' || currentEleID=='investigation' || currentEleID=='present-cond' || currentEleID=='pre-opt'){
									 			$("#"+replacedID).html($('#temp-busy-indicator').html());					 		 
										 	 
										 		$("#templateArea-implants").html('');
												$("#templateArea-event-note").html('');
												$("#templateArea-treatment").html('');
												$("#templateArea-notes").html('');
												$("#templateArea-post-opt").html('');
												$("#templateArea-pre-opt").html('');
												$("#templateArea-investigation").html('');
												$("#templateArea-surgery").html('');
												$("#templateArea-present-cond").html(''); 											 	
										 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "add","admin" => false)); ?>";
										 		$("#"+currentEleID).css('height','auto');	 							 
										 		$.ajax({  
										 			  type: "POST",						 		  	  	    		
													  url: ajaxUrl+"/"+currentEleID,
													  data: "updateID="+replacedID,
													  context: document.body,								   					  		  
													  success: function(data){											 									 					 				 								  		
													   	 	$("#"+replacedID).html(data);								   		
													   	 	$("#"+replacedID).fadeIn();
													  }
													});
										 	}else{					 			
										 		$("#templateArea-implants").html('');
												$("#templateArea-event-note").html('');
												$("#templateArea-treatment").html('');
												$("#templateArea-notes").html('');
												$("#templateArea-post-opt").html('');
												$("#templateArea-pre-opt").html('');
												$("#templateArea-investigation").html('');
												$("#templateArea-surgery").html('');
												$("#templateArea-present-cond").html('');
											}					 		 		
										 	//EOF template call
									    }
															
								  });
					//EOF accordion
					//binds form submission and fields to the validation engine
				   $(".drugText").addClass("validate[optional,custom[onlyLetterNumber]]");
				   jQuery("#patientnotesfrm").validationEngine();				 
				  
				   jQuery("#patientnotesfrm").submit(function(){
					    
						var returnVal = jQuery("#patientnotesfrm").validationEngine('validate');	
					//	var singleCheck = jQuery('#drug0')..validationEngine('validate');	
						 			 
						/*if(returnVal){					 
					 		ajaxPost('patientnotesfrm','list_content');
					 	}*/
					});
				 
				function ajaxPost(formname,updateId){ 
						  
				        $.ajax({
				            data:$("#"+formname).closest("form").serialize(), 
				            dataType:"html",
				            beforeSend:function(){
							    // this is where we append a loading image
							    $('#busy-indicator').show('fast');
							},				            
				            success:function (data, textStatus) {
				             	$('#busy-indicator').hide('slow');
				                $("#"+updateId).html(data);
				               
				            }, 
				            type:"post", 
				            url:"<?php echo $this->Html->url((array('controller'=>'billings','action' => 'notesadd',$patientid)));?>"
				        }); 
				}

				  
				//BOF timer
				$('.frequency').live('change',function(){
					
					id 			 	= $(this).attr('id');
					currentCount 	= id.split("_");
					currentFrequency= $(this).val();
					$('#first_'+currentCount[1]).val('');
					$('#second_'+currentCount[1]).val('');
					$('#third_'+currentCount[1]).val('');
					$('#forth_'+currentCount[1]).val('');
					//set timer
       				switch(currentFrequency){       					
       					case "BD":       						
       						$('#first_'+currentCount[1]).removeAttr('disabled');
       						$('#second_'+currentCount[1]).removeAttr('disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');       					 
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
       						break;
       					case "TDS":
       						$('#first_'+currentCount[1]).removeAttr('disabled');
       						$('#second_'+currentCount[1]).removeAttr('disabled');
       						$('#third_'+currentCount[1]).removeAttr('disabled');       						  						
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
       						break;
       					case "QID":
       						$('#first_'+currentCount[1]).removeAttr('disabled');
       						$('#second_'+currentCount[1]).removeAttr('disabled');
       						$('#third_'+currentCount[1]).removeAttr('disabled');
       						$('#forth_'+currentCount[1]).removeAttr('disabled');       						
       						break;
       					case "OD":
       					case "HS":
       						$('#first_'+currentCount[1]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[1]).attr('disabled','disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
           					break;
           				case "Once fort nightly":
       						$('#first_'+currentCount[1]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[1]).attr('disabled','disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
           					break;
           				case "Twice a week":
       						$('#first_'+currentCount[1]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[1]).attr('disabled','disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
           					break;
           				case "Once a week":
       						$('#first_'+currentCount[1]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[1]).attr('disabled','disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
           					break;
           				case "Once a month":
       						$('#first_'+currentCount[1]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[1]).attr('disabled','disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
           					break ;  
           				case "A/D":
       						$('#first_'+currentCount[1]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[1]).attr('disabled','disabled');
       						$('#third_'+currentCount[1]).attr('disabled','disabled');
       						$('#forth_'+currentCount[1]).attr('disabled','disabled');
           					break ;     					
       				}
					
				});	
				
				$('.first').live('change',function(){	
					currentValue 	= Number($(this).val()) ;
					id 			 	= $(this).attr('id');
					currentCount 	= id.split("_");
					currentFrequency= $('#frequency_'+currentCount[1]).val();
					hourDiff		= 0 ;					 
					//set timer
       				switch(currentFrequency){       					
       					case "BD":
       						hourDiff = 12 ;
       						break;
       					case "TDS":
       						hourDiff = 6 ;
       						break;
       					case "QID":
       						hourDiff = 4 ;
       						break;       					
       				}			
					
					switch(hourDiff){
						case 12:						 
							$('#second_'+currentCount[1]).val(currentValue+12);
							break;
						case 6:						 
							$('#second_'+currentCount[1]).val(currentValue+6);
							$('#third_'+currentCount[1]).val(currentValue+12);
							break;
						case 4:
							 		 
							$('#second_'+currentCount[1]).val(currentValue+4);
							$('#third_'+currentCount[1]).val(currentValue+8);
							$('#forth_'+currentCount[1]).val(currentValue+12);
							break;
						}
				});
				//EOF timer 
			});	
</script>