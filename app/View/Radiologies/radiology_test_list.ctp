<style>
.row_action img{float:inherit;}

.patientHub .patientInfo .heading {
    float: left;
    width: 174px !important;
}
</style>
<?php $role=$this->Session->read("role");
      $website=$this->Session->read("website.instance");
?>
<div class="inner_title">
                      <h3>Radiology Test List</h3>
                      <span><?php 
                            	 	$returnController = $this->Session->read('radResultReturn'); 
                            	 	$redirectAction ='patient_information' ; 
                            		if($returnController == 'nursings'){
                            			$btnText = 'Back to Nursing';
                            		}else if($returnController == 'radiologies'){
                            			$btnText = 'Back to Radiology Manager';
                            			$redirectAction ='radiology_manager' ; 
                            		}else{
                            			$btnText = 'Back to Patient Info';
                            		} 
                            	      if($this->params->query['nurseFlag']=='nurse'){
                            	      	echo $this->Html->link('Back',array('controller' => 'Billings','action'=>'addNurseServices',$patient_id),array('escape'=>false,'class'=>'blueBtn'));
                            	      }else{
                            	 	/* echo $this->Html->link($btnText,array('controller'=>!empty($returnController)?$returnController:'patients',
                            	 	'action'=>$redirectAction,$patient_id),array('escape'=>false,'class'=>'blueBtn'));  */	
                            		echo $this->Html->link('Back',array('action'=>'radDashBoard'),array('escape'=>false,'class'=>'blueBtn'));
                            	      }
                            	?></span>
                  	</div>
                   <p class="ht5"></p>
                   
                   <!-- billing activity form start here -->
                   <?php 
                  		echo $this->element('patient_information');
                  ?>
                   <div class="clr ht5"></div>
                   <?php 
                   echo $this->Form->create('Radiology', array('url' => array('controller' => 'radiologies', 'action' => 'radiology_result',$patient_id)
																	,'id'=>'labResultfrm', 
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
									));
									?>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0">
                   		<tr>
              
                            <td width="300" class="tdLabel2">
                            	
                            </td>
							
                        </tr> 
                   </table>
					<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php
				 	//debug($testOrdered);
						if(isset($testOrdered) && !empty($testOrdered)){  ?> 
						  <tr class="row_title">
							   <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('RadioManager.order_id', __('Radiology Order id', true)); ?></strong></td>
							     <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('RadioManager.radiology_order_date', __('Order Time', true)); ?></strong></td>
							   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Radiology.name', __('Test Name', true)); ?></strong></td> 
							   <td class="table_cell" align="left"><strong><?php echo  __('Test Status'); ?></strong></td>
							   <?php if( strtolower($role)==strtolower(Configure::read('nurseLabel'))){
							             $display='none';
							   }else { 
                                        	$display='';
                                     }?>
							   <td class="table_cell"  align="left" width="12%" style="display: <?php echo $display;?>"><strong><?php echo  __('Action'); ?></strong></td> 
						  </tr>
						  <?php 
							  $toggle =0;
							  if(count($testOrdered) > 0) {
									foreach($testOrdered as $labs){
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   
										   //status of the report
										   if($labs['RadiologyResult']['confirm_result']==1){
										   		$status = 'Result Published';
										   		 
										   }else{
										   		$status = 'Pending';
										   		 
										   }
										   
										  ?>								  
										   <td class="row_format" align="left"><?php echo $labs['RadioManager']['order_id']; ?></td>
										     <td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['RadioManager']['radiology_order_date'],Configure::read('date_format'),true); ?> </td>
										   <td class="row_format" align="left"><?php echo ucfirst($labs['Radiology']['name']); ?> </td>
										   <td class="row_format" align="left"><?php echo $status; ?> </td>	
										   <td class="row_action" align="left" style="display: <?php echo $display;?>">
										    <?php	
										   	//print result
										      	$publishTime = strtotime($labs['RadiologyResult']['result_publish_date']) ;
										     	$currentTime = time();
										     	$diffHours = date("H",$currentTime - $publishTime) ;
										     	//$dateDiff = $this->DateFormat->dateDiff($publishTime,$currentTime);
										     	   if($labs['RadiologyResult']['confirm_result'] ==1 &&  ($diffHours < 25)){ 
													echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'View/Edit Published Result')), 
													array('controller'=>'radiologies','action' => 'incharge_radiology_result',
													$labs['RadioManager']['patient_id'],$labs['Radiology']['id'],$labs['RadioManager']['id']), array('escape'=>false));
										     	   }
										     	   
												if($labs['RadiologyResult']['confirm_result'] !=1){
													echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Add/Edit Result')), 
													array('controller'=>'radiologies','action' => 'radiology_result',
													$labs['RadioManager']['patient_id'],$labs['Radiology']['id'],$labs['RadioManager']['id']), array('escape'=>false));
												}
										     	
												if($labs['RadiologyResult']['confirm_result'] == 1){
													echo $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View Result')),
													 array('controller'=>'radiologies','action' => 'add_comment',$labs['RadioManager']['patient_id'],
													 $labs['Radiology']['id'],$labs['RadioManager']['id']), array('escape'=>false));
													 
													 echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,'title'=>'Print without Header',
														  'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$labs['RadioManager']['patient_id'],
													 		$labs['Radiology']['id'],$labs['RadioManager']['id'])).
													 		"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
                                                  
                                                      if($website=='kanpur' || $website=='hope'){
													   echo $this->Html->link($this->Html->image('icons/printer_mono.png'),'#',array('escape' => false,'title'=>'Print with Header',
																'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$labs['RadioManager']['patient_id'],
																		$labs['Radiology']['id'],$labs['RadioManager']['id'],'?'=>'flag=print_with_header')).
																"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
                                                       }
												}
										   //  } 
											?>
											</td>
							</tr>
							  <?php } 
										
									//set get variables to pagination url
									//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
							   ?>
							   <tr>
								<TD colspan="8" align="center">
								<!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
								</TD>
							   </tr>
					<?php } ?> <?php					  
						  } else {
					 ?>
					  <tr>
					   <TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patient', true); ?>.</TD>
					  </tr>
					  <?php
						  }
						  
						  
					  ?>
		</table>

				   

                   <?php echo $this->Form->end();	 ?>
                   