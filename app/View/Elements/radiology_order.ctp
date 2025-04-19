<?php  
                   		echo $this->Form->create('Radiology', array('url' => array('controller' => 'radiologies', 'action' => 'radiology_test_order',$patient_id)
																	,'id'=>'ordertestfrm' ,
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
						));		
						
						//echo $this->Form->hidden('RadiologyTestOrder.id');
?>	
			<table width="" cellpadding="0" cellspacing="0" border="0" align="left">
                   	<tr>
                         <td width="60" class="tdLabel2"><strong>Search</strong></td>
                            <td width="300">
                            <?php 
                            	echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'lab-search','autocomplete'=>'off'));
                            	echo $this->Form->hidden('RadiologyTestOrder.patient_id', array('value'=>$patient_id));
                            ?> 
                            </td>
                            <td>
                            <div align="center" id = 'temp-busy-indicator' style="display:none;">	
									&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						 	</div>
						 </td>                            
                        </tr>
                   </table>
                   <div class="clr ht5"></div>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th width="50%"><?php echo __('Radiology Test Names'); ?></th>
                            <th width="50%"><?php echo __('Radiology Tests To Be Ordered'); ?></th>
                        </tr>
                        <tr>
                   	  	  <td valign="top">
                   	  	  		<!--<div id="test-data" style="display:block;">
	                            	--><table width="100%" cellpadding="0" cellspacing="0" border="0">
	                            		<tr>
	                            			<td width="85%">
	                            				<?php 
	                            					echo $this->Form->input('toTest',array('options'=>$test_data,'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectLeft'));
	                            				?>
	                            			</td>
	                            			<td width="15%">
	                            			 <input id="MoveRight" type="button" value=" >> " />
					      					 <input id="MoveLeft" type="button" value=" << " />
	                            			</td>
	                            		</tr>	                            		                              	 
	                                </table><!--
                                </div>
                          --></td>
                            <td valign="top">
                            	<?php 
	                            		echo $this->Form->input('RadiologyTestOrder.radiology_id',array('options'=>array(),'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectRight'));
	                            ?>
	                             <!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            		<?php
                            			/*foreach($test_ordered as $ord_key =>$ord_data){
                            				echo "<tr id=lab-".$ord_key.">";
                                   	  		echo "<td>"."<a href='#'>".$test_data[$ord_key]['Radiology']['name']."</a></td>";
                                    		echo "</tr>"; 
                            			} */	
                            		?>                                	 
	                            </table> -->
	                        </td>
                        </tr>
                   </table>
                   <!-- billing activity form end here -->
                    <div>&nbsp;</div>
                      <table cellpadding="0" cellspacing="0" border="0">
                   		<tr>
                   			<td>
                   				<strong>External Requisition :</strong>
                   			</td>
                   			<td>
                   				<?php
                   				 	echo $this->Form->input('RadiologyTestOrder.is_external',array('type'=>'checkbox','id'=>'is-external','autocomplete'=>'off'));
                   				?>
                   			</td>
                   			<td id="service-provider" style="display:none;">	
                   					<?php 
                   						echo $this->Form->input('RadiologyTestOrder.service_provider_id',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('Please Select'))); 
                   					?>
                   			</td>
                   		</tr>
                   </table>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                      		<tr>
                            	<td width="50%" align="left">
                            		<!--<input name="" type="button" value="Order More" class="blueBtn"/> -->
                            	</td>
                                <td width="50%" align="right">
                                	<?php 
                                	 
                            			echo $this->Form->submit(__('Submit'), array('id'=>'add-more','title'=>'Submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                            	 
                                		echo $this->Html->link(__('Cancel'), array('controller'=>'patients','action' => 'patient_information',$patient_id), array('escape' => false,'class' => 'grayBtn'));
                                		?>
                                </td>
                            </tr>
                      </table>     
                       <!--BOF list -->
				<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php if(isset($test_ordered) && !empty($test_ordered)){ 

					//set get variables to pagination url
					  $queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;
					?>  
						  <tr class="row_title">
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTestOrder.order_id', __('Radiology Order id'),array('url' =>array("?"=>$queryStr))); ?></strong></td>
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTestOrder.create_time', __('Order Time'),array('url' =>array("?"=>$queryStr))); ?></strong></td>
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Radiology.name', __('Test Name'),array('url' =>array("?"=>$queryStr))); ?></strong></td> 
							   <td class="table_cell"><strong><?php echo  __('Status'); ?></strong></td>
							   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
							   
						  </tr>
						  <?php 
						       
							  $toggle =0;
							  $time = '' ;
							  if(count($test_ordered) > 0) {
									foreach($test_ordered as $labs){
							   			  /* $splitDateTime   = explode(" ",$labs['RadiologyTestOrder']['create_time']) ;
							   			   $splitTime = explode(":",$splitDateTime[1]);
							   			   $currentTime =  $splitTime[0].":".$splitTime[1];
							   			   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
							   			   $currentTime = $labs['RadiologyTestOrder']['batch_identifier'];
										   if($time != $currentTime ){
										   		if(!empty($test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='5' align='right' style='padding: 8px 5px;'>" ;
		                                 			echo $this->Html->link(__('Print Slip'),
													     '#',
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'radiologies','action'=>'investigation_print',$patient['Patient']['id'],$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='5'>&nbsp;</td></tr>" ;
		                                 		}
										   }
							   			   $time  =  $labs['RadiologyTestOrder']['batch_identifier'];
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   if($labs['RadiologyResult']['confirm_result']==1){
										   		$status = 'Resulted';
										   		 
										   }else{
										   		$status = 'Pending';
										   		 
										   }
										  ?>								  
										   <td class="row_format"><?php echo $labs['RadiologyTestOrder']['order_id']; ?></td>
										   <td class="row_format"><?php echo $this->DateFormat->formatDate2Local($labs['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
										   <td class="row_format"><?php echo ucfirst($labs['Radiology']['name']); ?> </td>
										   <td class="row_format"><?php echo $status; ?> </td>						   
										   <td class="row_format">
										   		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'radiologies','action' => 'deleteRadTest', $labs['RadiologyTestOrder']['id'],$currentTime), array('escape' => false),__('Are you sure?', true));?>
										   </td>
										  </tr>
							  <?php } 
										
										
							   ?>
							   <tr>
								<TD colspan="8" align="center">
								<!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
							 </span>	</TD>
							   </tr>
					<?php } ?> <?php					  
						  } else {
					 ?>
					  <tr>
					   <TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.</TD>
					  </tr>
					  <?php
						  }
						  
						  echo $this->Js->writeBuffer();
					  ?>
		</table> 
				<!--EOF list -->
 <?php echo $this->Form->end() ;?>
    <script language="javascript" type="text/javascript">
       
     		
		$(document).ready(function(){
			//BOF pankaj
			  $("#is-external").click(function(){
				  if($(this).attr('checked')==true){
					  $("#service-provider").show('slow');
				  }else{
					  $("#service-provider").hide('slow');
				  }
			  });
			  //EOF pankaj   
			  			
			$("#lab-search").keyup(function () { 
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'radiologies', "action" => "ajax_sort_test", "admin" => false)); ?>",
					  data:{"searchParam":$("#lab-search").val(),"patient_id":<?php echo $patient_id ;?>},
					  context: document.body,
					  beforeSend:function(){
			    		//this is where we append a loading image
						$('#temp-busy-indicator').show('fast');
			  		  },				  		  
					  success: function(data){	
			  			    $('#temp-busy-indicator').hide('fast');				  			     				  
			  				data= $.parseJSON(data);
				  			$("#SelectLeft option").remove();
							$.each(data, function(val, text) {
							    $("#SelectLeft").append( "<option value='"+val+"'>"+text+"</option>" );
							});									 			
					  }
				});   					 			 
		 
			});

			$('#ordertestfrm').submit(function(){
				$("#SelectRight option").attr("selected","selected");				
			});
		});

		
		 $(function() {
	            $("#MoveRight,#MoveLeft").click(function(event) {
	                var id = $(event.target).attr("id");
	                var selectFrom = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";
	                var moveTo = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";
	 
	                var selectedItems = $(selectFrom + " :selected").toArray();
	                $(moveTo).append(selectedItems);
	                selectedItems.remove;
	            });
	        });
	</script>