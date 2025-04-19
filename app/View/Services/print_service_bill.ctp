<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
			<style>
				body {
					background:none;
				    color: #000;
				    margin: 50px;
				}
				.tabularForm td{
					background: none repeat scroll 0 0 #FFFFFF;
					  color: #000;
				}
			</style>
</head>
<body onload="window.print();window.close();"> 
         
                     <table width="" align="left" cellpadding="0" cellspacing="0" border="0">
                   		<tr>	
                   			<td>                            	 
									 <?php echo __('Patient Name'); ?> :
					                            	 
                     			<strong>
									<?php echo ucfirst($this->data[0]['Patient']['full_name']);?>
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
                    
               		 
   				       
</body>
</html>
	 	
                    