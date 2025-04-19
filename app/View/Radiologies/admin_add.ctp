
<?php
	echo $this->Html->script('jquery.autocomplete');//'jquery.autocomplete.1.2.0'
	echo $this->Html->css('jquery.autocomplete.css'); 
?>
<div class="inner_title">
<h3>&nbsp; <?php
	if($this->data['Radiology']['id']){
		echo __('Edit Test', true);
	}else{
		echo __('Add Test', true);	
	}
 ?></h3>
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
		jQuery("#radiologyFrm").validationEngine();
	});
	
</script>
<!--BOF lab Forms -->
<div>&nbsp;</div>
<?php 
			echo $this->Form->create('Radiology', array('action'=>'add','id'=>'radiologyFrm',
												    	'inputDefaults' => array(
												        'label' => false,
												        'div' => false,'error'=>false
												    )
			));

?>
					<table width="36%" cellpadding="0" cellspacing="3" border="0" align="center">
                       <tr>
                      	 	<td width="" class="tdLabel2" align="right">Test Name<font color="red"> *</font></td>
                            <td width="">
                            <?php 
                            	echo $this->Form->input('name', array('id' => 'name','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd'));
                            	echo $this->Form->input('id', array());
                            ?>
                            </td>                         
                       </tr>
                   
                        <tr>
                       		<td width="" class="tdLabel2" align="right">Select Sub Specialty :</td>
                            <td width="">
                            	<?php
									echo $this->Form->input('test_group_id',
									 	 array('value'=>$this->data['Radiology']['test_group_id'],'options'=>$testGroup,'empty'=>__('Select Sub Specialty'),'escape'=>false,'id'=>'test_group_id',
									 	 'class' => ' textBoxExpnd','autocomplete'=>'off','style'=>''));
							 	 ?> 
                            </td>                         
                       </tr>
                       <?php if($this->data['Radiology']['id']){  ?>
                       		  <tr >
								<td    class="tdLabel2" align="right"  >Select Radiology or Similar Testing Method:<font color="red">*</font></td>
								<td  align="left"  > 
									<?php
										echo $this->Form->input('service_group_id',
											array('options'=>$radServiceGroup,'selected'=>$radId,'empty'=>__('Select Service Group'),
												'escape'=>false,'id'=>'service_group_id', 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off','style'=>'','value'=>$this->data['Radiology']['service_group_id']));
								 	
										

												 ?> 
								</td> 
							</tr>
							<tr>
								<td class="tdLabel2" align="right" > Map Test To Service:<font color="red">*</font></td>
								<td  align="left"  >
									<?php 
											echo $this->Form->input('',array('id'=>'rad_name','name'=>'rad_name','placeHolder'=>'Search Service','autocomplete'=>'off','type'=>'text','value'=>''));
											echo $this->Form->input('tariff_list_id', array('selected'=>$this->data['Radiology']['tariff_list_id'], 'options'=>$tariffList,'label'=>false,'style'=>'width:65%;', 
											'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tarifflist', 'empty' => __('Select Service')));
								    ?> 
								</td> 
							</tr>
							<?php if($this->data['Radiology']['id']){?>
							<tr>
								<td class="tdLabel2" align="right" > CPT:</td>
								<td  align="left"  >
									<?php 
											echo $this->Form->input('cpt_code', array('class' => '','id' => 'cpt_code'));
                            	echo $this->Form->input('id', array());
											
								    ?> 
								</td> 
							</tr>
							<?php }?>
                      <?php  }else{ ?>
	                        <tr >
								<td    class="tdLabel2" align="right"  >Select Radiology or Similar Testing Method:<font color="red">*</font></td>
								<td  align="left"  > 
									<?php
										echo $this->Form->input('service_group_id',
										 	 array('options'=>$radServiceGroup,'selected'=>$radId,'empty'=>__('Select Service Group'),'escape'=>false,'id'=>'service_group_id',
										 	 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off','style'=>''));
								 	 ?> 
								</td> 
							</tr>
							<tr>
								<td class="tdLabel2" align="right" > Map Test To Service:<font color="red">*</font></td>
								<td  align="left"  >
									<?php 
										echo $this->Form->input('',array('id'=>'rad_name','name'=>'rad_name','value'=>'Search Service','autocomplete'=>'off','type'=>'text','class'=>''));
											echo $this->Form->input('tariff_list_id', array('options'=>$tarifflist,'label'=>false,'style'=>'', 
											'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tarifflist', 'empty' => __('Select Service')));
								    ?> 
								</td> 
							</tr>
						<?php  } ?>
						
                       
                        <tr>
                       		<td width="" class="tdLabel2" align="right">Note :</td>
                            <td width="">
                            <?php 
                            	echo $this->Form->textarea('note', array('class' => 'textBoxExpnd', 'id' => 'note','rows'=>5));
                            ?>
                            </td>                         
                       </tr>
                        <tr>
                       		<td width="" class="tdLabel2" align="right">Use as default:</td>
                            <td width="">
                            <?php 
                            	echo $this->Form->checkbox('template_rad', array('class' => 'textBoxExpnd'));
                            ?>
                            </td>                         
                       </tr>
					
                    </table>  
                       
                      <p class="ht5"></p>
                      <table width="750" cellpadding="0" cellspacing="0" border="0" align="center">
                      	<tr>
                            
                                <td width="50%" align="right">
                                	 
                                	<?php
                                		 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		
                                		echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn'));
                                	?>
                                </td>
                            </tr>
                      </table>  
                      <?php echo $this->Form->end();?>   
                      
                      <div>
                      <?php 
	                      if($this->data['Radiology']['id']){
                      		echo $this->Html->link('View Tempaltes', array('action' => 'admin_templatelist', $this->data['Radiology']['id']));
                      	}
							?>
                      </div>                  
<!-- EOF lab Forms -->

 <script language = "javascript">
 var radioId = '<?php echo $this->data['Radiology']['id'];?>'; 
		$(document).ready(function(){
			if(radioId == '')
			getServiceGroup();
			$('#service_group_id').change(function (){ 
		 		getServiceGroup();
		 	});
			   //BOF pankaj
		 	function getServiceGroup()
		 	{
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
		 							
		 							$("#rad_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList",
			 					  			'id',"name","admin" => false,"plugin"=>false)); ?>"
				 							+"/service_category_id="+$('#service_group_id').val(), {
				 								width: 250,
				 								selectFirst: true,
				 								valueSelected:true,
				 								showNoId:true,
		 								loadId : 'rad_name,tarifflist',
		 								
		 							});
		 					  	}else{
		 							$('#lsit-content').hide('fast');
		 					  	}	
								
		 					  	
		 				  }
		 		});
		 	}
		 	
			$('#rad_name').focus(function() {
		        if (this.value === this.defaultValue) {
		            this.value = '';
		        }
			})
			.blur(function() {
		        if (this.value === '') {
		            this.value = this.defaultValue;
		        }
			});
		 	//EOF pankaj     
			$("#rad_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList",
			  			'id',"name","admin" => false,"plugin"=>false)); ?>"
						+"/service_category_id="+$('#service_group_id').val(), {
							width: 250,
							selectFirst: true,
							valueSelected:true,
							showNoId:true,
					loadId : 'rad_name,tarifflist',
					
				});
  });

</script>
  