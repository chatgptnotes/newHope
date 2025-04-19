<style>
.blueBtn{
	color:#000000 ;
}
</style>
<?php //BOF lab order ?>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="right"><a class="tdLabel2" style="text-decoration:underline;" href="#" id="swap_investigation">Click To View Radiology</a></td>
		</tr>
	</table> 
	<div id="lab-investigation">
   				<table width="" cellpadding="0" cellspacing="0" border="0" align="left">
                    <tr>
                         <td width="60" class="tdLabel2"><strong>Search</strong></td>
                            <td width="300">
	                            <?php 
		                             echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'lab-search','autocomplete'=>'off','label'=>false,'div'=>false));
		                             echo $this->Form->hidden('LaboratoryTestOrder.patient_id', array('value'=>$patient_id));
		                             echo $this->Form->hidden('LaboratoryTestOrder.from_assessment', array('value'=>1));
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
                         <th width="50%">Lab Test Names</th>
                            <th width="50%">Lab Tests To Be Ordered</th>
                        </tr>
                        <tr>
                         	<td valign="top">
	                          	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	                               <tr>
	                                <td width="85%">
	                                 <?php 
	                                  echo $this->Form->input('LaboratoryTestOrder.toTest',array('options'=>$test_data,'escape'=>false,'multiple'=>true,
	                                  'style'=>'width:90%;min-height:100px;','id'=>'SelectLeft','label'=>false,'div'=>false));
	                                 ?>
	                                </td>
	                                <td width="15%">
	                                 <input id="MoveRight" type="button" value=" >> " />
	                 				 <input id="MoveLeft" type="button" value=" << " />
	                                </td>
	                               </tr>                              
	                            </table> </td>
                            <td valign="top">
                             <?php 
                               echo $this->Form->input('LaboratoryTestOrder.laboratory_id',array('options'=>array(),'escape'=>false,'multiple'=>true,
                               'style'=>'width:90%;min-height:100px;','id'=>'SelectRight','label'=>false,'div'=>false));
                             ?>
                              <!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
                              <?php
                               /*foreach($test_ordered as $ord_key =>$ord_data){
                                echo "<tr id=lab-".$ord_key.">";
                                        echo "<td>"."<a href='#'>".$test_data[$ord_key]['Laboratory']['name']."</a></td>";
                                      echo "</tr>"; 
                               } */ 
                              ?>                                  
                             </table> -->
                         </td>
                        </tr>
                   </table>
                   <!-- billing activity form end here -->
                   
                  
                       <!--BOF list -->
				<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php if(isset($test_ordered) && !empty($test_ordered)){  ?> 
						  <tr class="row_title">
							   <td class="table_cell"><strong><?php echo __('Lab Order id'); ?></strong></td>
							   <td class="table_cell"><strong><?php echo __('Order Time'); ?></strong></td>
							   <td class="table_cell"><strong><?php echo __('Test Name'); ?></strong></td> 
							   <td class="table_cell"><strong><?php echo __('Status'); ?></strong></td>
							   <td class="table_cell"><strong><?php echo __('Action'); ?></strong></td>
							   
						  </tr>
						  <?php 
							  $toggle =0;
							  $time = '';
							  if(count($test_ordered) > 0) {
									foreach($test_ordered as $labs){
										   /*$splitDateTime   = explode(" ",$labs['LaboratoryTestOrder']['create_time']) ;
							   			   $splitTime = explode(":",$splitDateTime[1]);
							   			   $currentTime =  $splitTime[0].":".$splitTime[1];
							   			   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
							   			   $currentTime = $labs['LaboratoryTestOrder']['batch_identifier'];
										   if($time != $currentTime ){
										   		if(!empty($test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='5' align='right' style='padding: 8px 5px;'>" ;
		                                 			echo $this->Html->link(__('Print Slip'),
													     '#',
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'laboratories','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='5'>&nbsp;</td></tr>" ;
		                                 		}
										   }
							   			   
							   			   $time  =  $currentTime;
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
									//status of the report
										   if($labs['LaboratoryResult']['confirm_result']==1){
										   		$status = 'Resulted';
										   		 
										   }else{
										   		$status = 'Pending';
										   		 
										   }
										  ?>								  
										   <td class="row_format"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?></td>
										   <td class="row_format"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
										   <td class="row_format"><?php echo ucfirst($labs['Laboratory']['name']); ?> </td>
										   <td class="row_format"><?php echo $status; ?> </td>						   
										   <td class="row_format">
										   	<?php 
										   		if($status == 'Pending'){
										   			echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));	
										   		}
										   		?>
										   </td>
										  </tr>
							  <?php } 	
										//set get variables to pagination url
										$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
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
		</div> 
		<?php
			//EOF lab order 
		 	//BOF radiology order
		 	?>
		<div id="radiology-investigation" style="display:none;">
			<table width="" cellpadding="0" cellspacing="0" border="0" align="left">
                   	<tr>
                         <td width="60" class="tdLabel2"><strong>Search</strong></td>
                            <td width="300">
                            <?php 
                            	echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'radiology-search','autocomplete'=>'off','label'=>false,'div'=>false));
                            	echo $this->Form->hidden('RadiologyTestOrder.patient_id', array('value'=>$patient_id));
                            	echo $this->Form->hidden('RadiologyTestOrder.from_assessment', array('value'=>1));
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
	                            					echo $this->Form->input('RadiologyTestOrder.toTest',array('options'=>$radiology_test_data,'escape'=>false,
	                            					'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'RadSelectLeft','label'=>false,'div'=>false));
	                            				?>
	                            			</td>
	                            			<td width="15%">
	                            			 <input id="RadMoveRight" type="button" value=" >> " />
					      					 <input id="RadMoveLeft" type="button" value=" << " />
	                            			</td>
	                            		</tr>	                            		                              	 
	                                </table><!--
                                </div>
                          --></td>
                            <td valign="top">
                            	<?php 
	                            		echo $this->Form->input('RadiologyTestOrder.radiology_id',array('options'=>array(),'escape'=>false,'multiple'=>true,
	                            		'style'=>'width:90%;min-height:100px;','id'=>'RadSelectRight','label'=>false,'div'=>false));
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
                 
                     
                       <!--BOF list -->
				<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php if(isset($radiology_test_ordered) && !empty($radiology_test_ordered)){ 

					
					
					?> 
						  <tr class="row_title">
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTestOrder.order_id', __('Radiology Order id', true)); ?></strong></td>
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTestOrder.create_time', __('Order Time', true)); ?></strong></td>
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Radiology.name', __('Test Name', true)); ?></strong></td> 
							   <td class="table_cell"><strong><?php echo  __('Status'); ?></strong></td>
							   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
							   
						  </tr>
						  <?php 
							  $toggle =0;
							  $time ='' ;
							  if(count($radiology_test_ordered) > 0) {
									foreach($radiology_test_ordered as $labs){
							   			   /*$splitDateTime   = explode(" ",$labs['RadiologyTestOrder']['create_time']) ;
							   			   $splitTime = explode(":",$splitDateTime[1]);
							   			   $currentTime =  $splitTime[0].":".$splitTime[1];
							   			   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
										   $currentTime = $labs['RadiologyTestOrder']['batch_identifier'];
										   if($time != $currentTime ){
										   		if(!empty($radiology_test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='5' align='right' style='padding: 8px 5px;'>" ;
		                                 			echo $this->Html->link(__('Print Slip'),
													     '#',
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'radiologies','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='5'>&nbsp;</td></tr>" ;
		                                 		}
										   }
							   			   
							   			   $time  =  $currentTime;
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
										
										//set get variables to pagination url
										$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
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
		
		</div>
		<?php //EOF radiology order ?>		
				
    <script language="javascript" type="text/javascript">
       
       
  $(document).ready(function(){

	  $('#swap_investigation').click(function(){
		 
		  if($('#lab-investigation').css('display')=='none'){
			  $('#radiology-investigation').fadeOut('fast');
			  $('#lab-investigation').fadeIn('slow');
			  $(this).text('Click to view Radiology') ;
		  }else{
			  $('#lab-investigation').fadeOut('fast');
			  $('#radiology-investigation').fadeIn('slow');
			  $(this).text('Click to view Laboratories') ;
		  }
		  return false ;
	  });
	  //BOF pankaj
	  $("#is-external").click(function(){
		  if($(this).attr('checked')==true){
			  $("#service-provider").show('slow');
		  }else{
			  $("#service-provider").hide('slow');
		  }
	  });
	  //EOF pankaj   
   	/*$("#lab-search").keyup(function () { 
	    $.ajax({
	       url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_sort_test", "admin" => false)); ?>",
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
   
   });*/

   $('#diagnosisfrm').submit(function(){
    $("#SelectRight option").attr("selected","selected");    
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

   //BOF radiology JS
   $(document).ready(function(){
   		/*$("#radiology-search").keyup(function () { 
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'radiologies', "action" => "ajax_sort_test", "admin" => false)); ?>",
					  data:{"searchParam":$("#radiology-search").val(),"patient_id":<?php echo $patient_id ;?>},
					  context: document.body,
					  beforeSend:function(){
			    		//this is where we append a loading image
						$('#temp-busy-indicator').show('fast');
			  		  },				  		  
					  success: function(data){	
			  			    $('#temp-busy-indicator').hide('fast');				  			     				  
			  				data= $.parseJSON(data);
				  			$("#RadSelectLeft option").remove();
							$.each(data, function(val, text) {
							    $("#RadSelectLeft").append( "<option value='"+val+"'>"+text+"</option>" );
							});									 			
					  }
				});   					 			 
		 
			});*/

			$('#diagnosisfrm').submit(function(){
				$("#RadSelectRight option").attr("selected","selected");				
			});
		});

		
		 $(function() {
	            $("#RadMoveRight,#RadMoveLeft").click(function(event) {
	                var id = $(event.target).attr("id");
	                var selectFrom = id == "RadMoveRight" ? "#RadSelectLeft" : "#RadSelectRight";
	                var moveTo = id == "RadMoveRight" ? "#RadSelectRight" : "#RadSelectLeft";
	 
	                var selectedItems = $(selectFrom + " :selected").toArray();
	                $(moveTo).append(selectedItems);
	                selectedItems.remove;
	            });
		 });
	        });

	        
   //EOF radiology JS
 </script> 