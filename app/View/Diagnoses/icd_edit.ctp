<?php 
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css'); 
?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Panel', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error"><div  >
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#diagnosesFrm").validationEngine();
	});
	
</script>
<!--BOF lab Forms -->
<div>&nbsp;</div>
<?php 
			echo $this->Form->create('Diagnoses', array('controller'=>'diagnoses','action'=>'icd_edit','id'=>'diagnosesFrm',
												    	'inputDefaults' => array(
												        'label' => false,
												        'div' => false,'error'=>false
												    )
			));

?>
					<table width="100%" cellpadding="0" cellspacing="5" border="0" align="center">
                       <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Diagnoses Name<font color="red"> *</font></td>
                            <td width="300">
                            <?php 
                            
                            	if(isset($advanceData) && !empty($advanceData)){
                            		$read_only = 'readonly';                        		                           		
                            	}else{                            		
                            		$read_only = '';
                            		$advanceData = isset($this->data['SnomedMappingMaster']['sctName'])?$this->data['SnomedMappingMaster']['sctName']:'';
                            	}
                            	echo $this->Form->input('SnomedMappingMaster.name', array('class' => 'textBoxExpnd validate[required,ajax[ajaxTestNameCall],custom[mandatory-enter]]','value'=>$advanceData['SnomedMappingMaster']['sctName'],'id' => 'name1','readonly'=>$read_only));
                            	echo $this->Form->hidden('SnomedMappingMaster.id', array('id'=>'id','value'=>$advanceData['SnomedMappingMaster']['id'],));
                            	//echo $this->Form->input('Diagnoses.id', array('id'=>'id'));
                            ?>
						                            <?php 
								
								 ?>
                            </td>                         
                       </tr>
                       <!--   <tr>
							<td  class="tdLabel2" align="right"  >Select Sub Speciality:</td>
							<td  align="left"> 
								<?php 
								echo $this->Form->input('SnomedMappingMaster.test_group_id',
								 	 array('options'=>$testGroup,'empty'=>__('Select Sub Speciality'),'escape'=>false,'id'=>'test_group_id',
								 	 'class' => ' textBoxExpnd','autocomplete'=>'off','style'=>'width:94%;'));
									 	 ?> 
							</td> --> 
                       <tr>
						<td    class="tdLabel2" align="right"  >Select Service Category:<font color="red">*</font></td>
						<td  align="left"  > 
							<?php
								echo $this->Form->input('SnomedMappingMaster.service_group_id',
								 	 array('options'=>$serviceGroup,'empty'=>__('Select Service Group'),'escape'=>false,'id'=>'service_group_id',
								 	 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off','style'=>'width:94%;'));
								 	 ?> 
						</td> 
					</tr>
					<tr>
						<td class="tdLabel2" align="right" > Map Diagnosis To Service:<font color="red">*</font></td>
						<td  align="left"  >
							<?php 
									echo $this->Form->input('',array('id'=>'lab_name','name'=>'lab_name','value'=>'Search Service','autocomplete'=>'off','type'=>'text','class'=>''));
									echo $this->Form->input('SnomedMappingMaster.tariff_list_id', array('options'=>$tariffList,'label'=>false,'style'=>'width:64%;', 
									'class' => 'validate[required,custom[mandatory-select]] ','id' => 'tarifflist', 'empty' => __('Select Service')));
						    ?> 
						</td> 
					</tr>
                      
                      
                       
                     
                    </table>  
                       <p class="ht5"></p>
                      
                      <p class="ht5"></p>
                      <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                      	<tr>
                          
                                <td width="50%" align="right">
                                	 
                                	<?php
                                		echo $this->Form->hidden('whichAct',array('id'=>'whichAct')); 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		echo $this->Html->link(__('Cancel'), array('action' => 'admin_icd'), array('escape' => false,'class' => 'grayBtn'));
                                	?>
                                </td>
                            </tr>
                      </table>  
                      <?php echo $this->Form->end();?>                     
<!-- EOF lab Forms -->

  
<script language = "javascript"> 
		$(document).ready(function(){
			 var counter = 1; 
			 var radioId = 2;
		  		$('#add-more').click(function(){
		  			$('#whichAct').val($(this).attr('id'));
			  	});
			  	
			 	$('.attr-type').live('change',function(){
			 		currEleText = $(this).attr('id');						 
					currTextPos  = currEleText.split("_");					 
				 	if($(this).val()=='text'){
						$('#radioGroup_'+currTextPos[1]).fadeOut();	
						$('#gender-section_'+currTextPos[1]).fadeOut(400);
						$('#age-section_'+currTextPos[1]).fadeOut('fast');
						$('#parameter_text_'+currTextPos[1]).delay(400).fadeIn(400);					
					}else{
						$('#parameter_text_'+currTextPos[1]).fadeOut(400);						
						$('#gender-'+currTextPos[1]).attr('checked','checked');						
						$('#age-section_'+currTextPos[1]).fadeOut('fast');
						$('#gender-section_'+currTextPos[1]).delay(400).fadeIn(400);
						$('#radioGroup_'+currTextPos[1]).delay(400).fadeIn(400);							
					}
				});
				//show/hide age or gender wise
				 
					$('.sort-by').live('click',function()
					{ 	
						var currEle = $(this).attr('id');						 
						var currPos  = currEle.split("-");						 	
						if(currPos[0]=='gender'){
							$('#age-section_'+currPos[1]).fadeOut(400);
							$('#gender-section_'+currPos[1]).delay(400).fadeIn(400);
						}else if(currPos[0]=='age'){
							$('#gender-section_'+currPos[1]).fadeOut(400);
							$('#age-section_'+currPos[1]).delay(400).fadeIn(400);
						}					
					 
					});
				//EOF age/gender
	 
		   
		    $("#addButton").click(function () {		 
		    	var newCostDiv = $(document.createElement('tr'))
			     .attr("id", 'TestGroup' + counter);
				
		    	$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_add_block", "admin" => false)); ?>",
					  data:{"counter":counter,"radioId":radioId},
					  context: document.body,
					  beforeSend:function(){
			    		//this is where we append a loading image
		    			$('#temp-busy-indicator').show('fast');
			  		  },				  		  
					  success: function(data){	
			  			    $('#temp-busy-indicator').hide('fast');							  
			  			  	newCostDiv.append(data);		 
							newCostDiv.appendTo("#TestGroup");	
							
					  }
				});   					 			 
				counter++;
				radioId = radioId+2  ;
				if(counter > 1) $('#removeButton').show('slow');
			});
		 
		     $(".removeBtn").live('click',function () {
		    	 	if(confirm('Are You Sure?')){
		    			readyToRem = $(this).attr('id');						 
		    			readyToRemPos  = readyToRem.split("_");				 
			        	$("#TestGroup" + readyToRemPos[1]).remove();
		    	 	}					
			  });
		   //BOF pankaj
		 	$('#service_group_id').change(function (){ 
		 		$("#tarifflist option").remove();
		 		$.ajax({
		 				  url: "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "getServiceGroup", "admin" => false)); ?>"+"/"+$('#service_group_id').val(),
		 				  context: document.body,
		 				  beforeSend:function(){
		 				    // this is where we append a loading image
		 				    $('#busy-indicator').show('fast');
		 				  }, 				  		  
		 				  success: function(data){
		 						$('#busy-indicator').hide('slow');
		 					  	data= $.parseJSON(data);
		 					  	$("#tarifflist").append( "<option value=''>Select Service</option>" );
		 					  	if(data != ''){
		 					  		$('#list-content').show('slow'); 
		 							$.each(data, function(val, text) {
		 							    $("#tarifflist").append( "<option value='"+val+"'>"+text+"</option>" );
		 							});
		 							$('#tarifflist').attr('disabled', '');	
		 							$("#lab_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
		 				                    "name",'null','null','service_category_id', "admin" => false,"plugin"=>false)); ?>/service_category_id="+$('#service_group_id').val(), {
		 								width: 250,	 			  				 
		 								onItemSelect:function (data1) {  
		 									var itemID = data1.extra[0]; 
		 									$("#tarifflist").val(itemID);
		 								}
		 							});  
		 					  	}else{
		 							$('#lsit-content').hide('fast');
		 					  	}		
		 				  }
		 		});
		 	});
		 	//EOF pankaj
			$('#lab_name').focus(function() {
		        if (this.value === this.defaultValue) {
		            this.value = '';
		        }
			})
			.blur(function() {
		        if (this.value === '') {
		            this.value = this.defaultValue;
		        }
			});

			$("#name1").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","SnomedMappingMaster",'id',"sctName",'null',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				loadId : 'name1,id'
			});

			
	  });
	
 </script>
 