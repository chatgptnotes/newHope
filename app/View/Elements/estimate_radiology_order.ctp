<?php  
                   		echo $this->Form->create('Radiology', array('url' => array('controller' => 'estimates', 'action' => 'radiology_test_order',$patient_id)
																	,'id'=>'ordertestradfrm' ,
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
                            	echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'rad-search','autocomplete'=>'off'));
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
	                            					echo $this->Form->input('toTest',array('options'=>$rad_test_data,'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectRadLeft'));
	                            				?>
	                            			</td>
	                            			<td width="15%">
	                            			 <input id="MoveRadRight" type="button" value=" >> " />
					      					 <input id="MoveRadLeft" type="button" value=" << " />
	                            			</td>
	                            		</tr>	                            		                              	 
	                                </table>
                            <td valign="top">
                            	<?php 
	                            		echo $this->Form->input('RadiologyTestOrder.radiology_id',array('options'=>array(),'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectRadRight'));
	                            ?>
	                             
	                        </td>
                        </tr>
                   </table>
                   <!-- billing activity form end here -->
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                      		<tr>
                            	<td width="50%" align="left">
                            		<!--<input name="" type="button" value="Order More" class="blueBtn"/> -->
                            	</td>
                                <td width="50%" align="right">
                                	<?php 
                                		
                            			echo $this->Form->submit(__('Submit'), array('id'=>'add-more','title'=>'Submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                            	 
                                		//echo $this->Html->link(__('Cancel'), array('controller'=>'patients','action' => 'patient_information',$patient_id), array('escape' => false,'class' => 'grayBtn'));
                                		?>
                                </td>
                            </tr>
                      </table>     
                       
 <?php echo $this->Form->end() ;?>
    <script language="javascript" type="text/javascript">
       
     		
		$(document).ready(function(){			
			$("#rad-search").keyup(function () { 
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'radiologies', "action" => "ajax_sort_test", "admin" => false)); ?>",
					  data:{"searchParam":$("#rad-search").val(),"patient_id":<?php echo $patient_id ;?>},
					  context: document.body,
					  beforeSend:function(){
			    		//this is where we append a loading image
						$('#temp-busy-indicator').show('fast');
			  		  },				  		  
					  success: function(data){	
			  			    $('#temp-busy-indicator').hide('fast');				  			     				  
			  				data= $.parseJSON(data);
				  			$("#SelectRadLeft option").remove();
							$.each(data, function(val, text) {
							    $("#SelectRadLeft").append( "<option value='"+val+"'>"+text+"</option>" );
							});									 			
					  }
				});   					 			 
		 
			});

			$('#ordertestradfrm').submit(function(){
				$("#SelectRadRight option").attr("selected","selected");				
			});
		});

		
		 $(function() {
	            $("#MoveRadRight,#MoveRadLeft").click(function(event) {
	                var id = $(event.target).attr("id");
	                var selectFrom = id == "MoveRadRight" ? "#SelectRadLeft" : "#SelectRadRight";
	                var moveTo = id == "MoveRadRight" ? "#SelectRadRight" : "#SelectRadLeft";
	 
	                var selectedItems = $(selectFrom + " :selected").toArray();
	                $(moveTo).append(selectedItems);
	                selectedItems.remove;
	            });
	        });
	</script>