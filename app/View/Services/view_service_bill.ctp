<div class="inner_title">
        <h3>  &nbsp; <?php echo __('View Service Bill'); ?></h3>
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
                       	  	<td>Date :
	                             <strong>                                   
		                         	 <?php
			                         	 $formattedDate = $this->DateFormat->formatDate2Local($this->data[0]['ServiceBill']['date'],Configure::read('date_format'));
			                         	 echo $formattedDate; 
		                         	 ?>
	                         	 </strong>
                         	 </td>
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
			                            		if($morning=='checked'){
			                            			echo $this->Html->image('icons/tick.png');
			                            		}else{
			                            			echo $this->Html->image('icons/cross.png');
			                            		}  
			                            		
			                            		?>
					 					</td>
			                            <td valign="top" style="text-align:center;">
			                            	<?php
			                            		if($evening=='checked'){
			                            			echo $this->Html->image('icons/tick.png');
			                            		}else{
			                            			echo $this->Html->image('icons/cross.png');
			                            		}
			                            	?>	
			                            </td>
			                            <td valign="top" style="text-align:center;">
			                            	<?php
			                            	   if($night=='checked'){
			                            			echo $this->Html->image('icons/tick.png');
			                            		}else{
			                            			echo $this->Html->image('icons/cross.png');
			                            		}
			                            	?>
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
					 		echo $this->Html->link(__('Print'),
					 			                       '#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'services','action'=>'print_service_bill',$this->data[0]['ServiceBill']['patient_id'],$this->data[0]['ServiceBill']['date']))."', '_blank',
									           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=400');  return false;")) ;
					?>	
                    </div>
   				<?php echo $this->Form->end();?>                  

	 	
                    