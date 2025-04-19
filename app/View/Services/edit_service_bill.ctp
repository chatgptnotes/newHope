<?php 
	echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));

?>
<div class="inner_title">
        <h3>
        	<?php
        		echo $this->Html->image('icons/patient-owner-icon.png');
        		echo __("Edit Billing Activity");
        	?>        	
        </h3>
</div>
                   <p class="ht5"></p>
                   <?php       echo $this->Form->create('ServiceBill',array('type' => 'file','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
								echo $this->Form->hidden('id');																								    
								echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
 								echo $this->Form->hidden('patient_id', array('id'=>'patient_id','value'=>$this->data[0]['ServiceBill']['patient_id'])); 
 								
                    ?>
                     <table width="" align="left" cellpadding="0" cellspacing="0" border="0">
                   		<tr>	
                   			<td>                            	 
									 <?php echo __('Patient Name'); ?> :
					                            	 
                     			<strong>
									<?php echo ucfirst($this->data[0]['Patient']['lookup_name']);?>
								</strong> 
							</td>							
                        </tr>
                   </table>
                   <table width="" align="right" cellpadding="0" cellspacing="0" border="0">
                   		<tr>	
                       	  <td class="tdLabel">Date</td>
                            <td>                                           
                         <?php
                         	 $formattedDate = $this->DateFormat->formatDate2Local($this->data[0]['ServiceBill']['date'],Configure::read('date_format'));
                         	 echo $this->Form->input('date', array('value'=>$formattedDate,'type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;')); ?>
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
                         
                         $data = $this->data ; 
                         
                         foreach($service as $services){  	 
                           
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
						                     	 foreach($data  as $key=>$value) {	
						                     	 						                      
						                     	 	if($value['ServiceBill']['sub_service_id']== $sub_service_id && 
						                     	 	$value['ServiceBill']['service_id']== $service_id && $value['ServiceBill']['morning']==1){						                     	 	 
						                     	 			$morning = 'checked';
						                     	 	}
						                     	 	if($value['ServiceBill']['sub_service_id']== $sub_service_id && 
						                     	 	$value['ServiceBill']['service_id']== $service_id && $value['ServiceBill']['evening']==1){						                     	 	 
						                     	 			$evening = 'checked';
						                     	 	}
						                     	 	if($value['ServiceBill']['sub_service_id']== $sub_service_id && 
						                     	 	$value['ServiceBill']['service_id']== $service_id && $value['ServiceBill']['night']==1){						                     	 	 
						                     	 			$night = 'checked';
						                     	 	}
						                     	 }  
			                            		  
			                            		echo $this->Form->checkbox('', array('name'=>"data[ServiceBill][$service_id][$sub_service_id][morning]",'id' => 'morning','checked'=>$morning)); ?>
					 					</td>
			                            <td valign="top" style="text-align:center;">
			                            	<?php echo $this->Form->checkbox('', array('name'=>"data[ServiceBill][$service_id][$sub_service_id][evening]",'id' => 'evening','checked'=>$evening)); ?>
			                            </td>
			                            <td valign="top" style="text-align:center;">
			                            	<?php echo $this->Form->checkbox('', array('name'=>"data[ServiceBill][$service_id][$sub_service_id][night]",'id' => 'night','checked'=>$night)); ?>
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
		}	
                     </script>