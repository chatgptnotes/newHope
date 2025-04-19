<div class="inner_title">
        <h3 >
        	<?php
        		echo $this->Html->image('icons/patient-owner-icon.png');
        		echo __("Add Billing Activity");
        	?>        	
        </h3>
</div>
                   <p class="ht5"></p>
                   <?php       echo $this->Form->create('ServiceBill',array('type' => 'file','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
								echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
 								echo $this->Form->hidden('patient_id', array('id'=>'patient_id'));
 								echo $this->Form->hidden('person_id', array('id'=>'person_id'));
 								if(isset($corporateId) && $corporateId != '')
 									echo $this->Form->hidden('corporate_id', array('value'=>$corporateId));
 								else
 									echo $this->Form->hidden('corporate_id', array('value'=>''));
                    ?>
                     <table width="" align="left" cellpadding="0" cellspacing="0" border="0">
                   		<tr>	
                   			<td class="tdLabel">                            	 
									<?php echo __('Patient Name'); ?> <font color="red">*</font>
							</td>
                     		<td>                            	 
									<?php echo $this->Form->input('patient_name', array('type'=>'text','class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'patient_name', 'label'=> false,
																  'div' => false, 'error' => false,'readonly'=>'readonly','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'patient_search'))."', '_blank',
									           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=400');  return false;")); ?>
							</td>
							<td width="35" style="padding-right:10px;">
									<?php 
										echo $this->Html->link($this->Html->image('icons/patient-name.png',array('alt'=>__('Pick Up Patient'),'title'=>__('Pick Up Patient'))),'#',
											   array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'patient_search'))."', '_blank',
									           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=200');  return false;"));
									           
										echo  $this->Html->image('icons/eraser.png',array('alt'=>__('Reset Patient'),'title'=>__('Reset Patient'),'onclick'=>'clearLookup();')) ;
									?>                           	 
                            </td>
                            <td>Corporate:&nbsp;</td>
                            <td><?php echo $corporate;?></td>
                        </tr>
                   </table>
                   <table width="" align="right" cellpadding="0" cellspacing="0" border="0">
                   		<tr>	
                       	  <td class="tdLabel">Date <font color="red">*</font></td>
                            <td >
                            
                            
                         <?php echo $this->Form->input('date', array('type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;','readonly'=>'readonly')); ?>
                        </tr>
                   </table>
                   <!-- date section end here -->
                   <div class="clr ht5"></div>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th width="150">PARTICULAR</th>
                            <th>&nbsp;</th>
                            <th width="85" style="text-align:right;">UNIT PRICE</th>
                            <th width="70" style="text-align:center;">MORNING</th>
                            <th width="70" style="text-align:center;">EVENING</th>
                            <th width="70" style="text-align:center;">NIGHT</th>
                        </tr>
                        <?php                      
                        	 
                         foreach($service as $services){ ?>                       	
                     
                         <?php  
                         		$count  = count($services['SubService']);
                         ?>
	                        <tr>
	                        	<td valign="top"rowspan="<?php echo $count ;?>" ><?php echo $services['Service']['name'] ;?></td>
	                        	<?php for($i=0;$i<$count;){?>	                        		   
				                          <td  valign="top"><?php echo $services['SubService'][$i]['service'] ; ?></td>				                          
				                          <td valign="top" style="text-align:right;"><?php echo $services['SubService'][$i]['cost'] ; ?></td>
				                          <td valign="top" style="text-align:center;">
			                            	<?php 
			                            		  $sub_service_id = $services['SubService'][$i]['id'] ;
			                            		  $service_id = $services['Service']['id'] ;
			                            		  $morning='';
									              $evening='';
									              $night= '';  
									                  if(isset($this->data['ServiceBill'])){			                            		  	             	
								                     		foreach($this->data['ServiceBill']  as $key=>$value) {                        		        
										                     	 	if(is_array($value)){  										                     	 	
										                     	 		foreach($value as $k=>$v){											                     	 		 								                     	 		 
										                     	 			if( ($k== $sub_service_id) && ($service_id== $key) && ($v['morning']==1)){						                     	 	 
												                     	 			$morning = 'checked';
												                     	    }
												                     	    if( ($k== $sub_service_id) && ($service_id== $key) && ($v['evening']==1)){						                     	 	 
												                     	 			$evening = 'checked';
												                     	    }
												                     	    if( ($k== $sub_service_id) && ($service_id== $key) && ($v['night']==1)){						                     	 	 
												                     	 			$night = 'checked';
												                     	    }										                     	 											                     	 	 
										                     	 	}     							                     	 	
											                    }
									                     	} 
							                     	  } 
			                            		echo $this->Form->checkbox('', array('name'=>"data[ServiceBill][$service_id][$sub_service_id][morning]",'id' => 'morning','value'=>1,'checked'=>$morning)); ?>
					 					</td>
			                            <td valign="top" style="text-align:center;">
			                            	<?php echo $this->Form->checkbox('', array('name'=>"data[ServiceBill][$service_id][$sub_service_id][evening]",'id' => 'evening','value'=>1,'checked'=>$evening)); ?>
			                            </td>
			                            <td valign="top" style="text-align:center;">
			                            	<?php echo $this->Form->checkbox('', array('name'=>"data[ServiceBill][$service_id][$sub_service_id][night]",'id' => 'night','value'=>1,'checked'=>$night)); ?>
			                            </td>
				                        </tr>
	                        	<?php $i++ ;} ?>                 
	                           
	                        </tr>
	                       <?php } ?>                        
                   </table>
                   <!-- billing activity form end here -->
                    <div>&nbsp;</div>
                    
               		<div class="btns">
               		<?php 
                           	echo $this->Html->link(__('Cancel'),
					 			                       '/services/service_bill_list',array('escape' => false,'class'=>'grayBtn')) ;
					 		echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		
					 		
					 		?>		
                    </div>
   				<?php echo $this->Form->end();?>                  
   <script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#servicefrm").validationEngine();	
		});
		         	//script to include datepicker
		$(function() {
			$("#billDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat:'<?php echo $this->General->GeneralDate();?>',		
				onSelect: function ()
			    {			        // The "this" keyword refers to the input (in this case: #someinput)
			        this.focus();
			    }	
			}); 
		});
		
		function clearLookup(){
			 
			$('#patient_id').val('');
                        $('#patient_name').val('');
		}	
                     </script>