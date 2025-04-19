<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Vaccination', true); ?></h3>
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
		jQuery("#vaccinationFrm").validationEngine();
	});
	
</script>
<!--BOF lab Forms -->
<div>&nbsp;</div>
<?php echo $this->Form->create('',array('url'=>array('action'=>'vaccinationfuturesave',$patientId),'type' => 'post','id'=>'vaccinationFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
/*echo $this->Form->create('VaccinationRemainder', array('action'=>'vaccinationfuture','id'=>'vaccinationFrm',
												    	'inputDefaults' => array(
												        'label' => false,
												        'div' => false,'error'=>false
												    )));*/?>
				
                    <p class="ht5"></p>
                       <!-- BOF-For histopathology_data -->
                       <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm showForHistopathology" align="center" id="TestGroupVaccination" >
                       		<tr>
                            	<th width="5%">Sr. No.</th>
                                <th width="25%">Name of Vaccination</th>
                                <th width="50%">Date of Vaccination</th>        
                                <th width="10%">Action</th> 
                                <!--  <th width="5%">Action</th>   -->                   
                            </tr>
                             <?php //debug($vaccineDataArray);
					$count_vaccinationData  = 1 ;
                     $getVaccinationData=Configure::read('vaccination_data');						
                     foreach($vaccineDataArray as $key=>$getData){

							$getVar=key($getData['VaccinationRemainder']);
                       			//for($i=0;$i<$count_vaccinationData;){
									?>
                            <tr id="TestGroupVaccination_<?php echo $key ?>" class="getRow">
                            	<td valign="top" style="padding-top:10px;"><?php echo $key+1;?></td>
                                <td valign="top"> <?php   echo $this->Form->input('', array('name'=>"data[VaccinationRemainder][$key][vaccination_name]",
                                		 'class' => "validate[required,custom[mandatory-enter]] textBoxExpnd", 'label' => false,'div' => false,'error'=>false,'id'=>'','value'=>$getVar,'type'=>'text','style'=>'width:400px;')); 
										
							?></td>
                                <td style="padding-top:10px;" id="showDateTbl_<?php echo $key ?>">   
                           <?php if(isset($getData['VaccinationRemainder'][$getVar]) && !empty($getData['VaccinationRemainder'][$getVar])){
			               				$count  = count($getData['VaccinationRemainder'][$getVar]) ;			               				
			               			}else{
			               				$count  = 1 ;			               				
			               			}
								$innerCount=0;
								
								 for($i=0;$i<$count;){	
									$dateValue= isset($getData['VaccinationRemainder'][$getVar][$i])?$getData['VaccinationRemainder'][$getVar][$i]:'' ;
									
									$getDateExp=explode('_',$dateValue);
?>                           
                                <table width="100%" cellpadding="0" cellspacing="1" border="0" class="getTblId getRowInner" align="center" >
                               <tr id="TestGroupVaccinationInner_<?php echo $key;?>_<?php echo $i ?>"  class="block_<?php echo $key;?> uniqueRow_<?php echo $key;?>_<?php echo $i ?> "> 				
                                <td style="float:left" width="47%">
								<?php $dataAll=$this->DateFormat->formatDate2Local($getDateExp[0],Configure::read('date_format'));
								echo $this->Form->input('', array('name'=>"data[VaccinationRemainder][$key][date][$i]",'id' => 'vaccinationdate_'.$key.'_'.$i, 'label' => false,'div' => false,'error'=>false,'type'=>'text','class'=>"textBoxExpnd vaccinationdatecls1 vaccinationdatecls_$key_$i",'value'=>$dataAll));
								echo $this->Form->hidden('',array('id'=>'recordId_'.$key.'_'.$i,'value'=>$getDateExp[1],'name'=>"data[VaccinationRemainder][$key][id][$i]",'class'=>'recordId'));
								echo '</n>';				           
 								echo $this->Form->hidden('',array('id'=>'vaccinationId_'.$key.'_'.$i,'value'=>$key,'name'=>"data[VaccinationRemainder][$key][vaccination_id][$i]",'class'=>'vaccinationId')); 
							?>
							<span style="float:left" class="removeButtonVaccCls" id="removeButtonVaccLink_<?php echo $key.'_'.$i;?>">
							<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?>  
				            </span>
				                 </td> 
				                 <td  width="55%">
				                 </td>
				                 
				                  </tr>
				                 </table> 
				                  <?php $innerCount++; 
									 $i++;	
									$innerCountId[$key] = $i;	
															
									}?>                    
				              
				                                 
                                   </td>
                                     <td valign="top">  <?php  echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'class' => 'addButtonDatecls','id'=>'addButtonDate_'.$key));
                                     //echo $this->Form->Button(__('Add More'), array('type'=>'button','label' => false,'div' => false,'error'=>false,'escape' => false,'class' => 'blueBtn addButtonDatecls','id'=>'addButtonDate_'.$key));
							 		?>						 
				                 </td>  
                                  <!-- <td><?php echo $this->Html->link($this->Html->image('icons/close-icon.png'),
					 			                       '#',array('id'=>"removeButtonVaccination_$key",'escape' => false,'class'=>'removeBtnHistopathology','title'=>'Remove')) ;
					 			     
                          		  ?></td>  -->                                                         	 			
                          	</tr>   
                          	   <?php $counterInc=$key;
                          	   $count_vaccinationData++;
							}?>                           
                       </table> 
                      
                       <p class="ht5"></p>
                      
                      <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center"  class="showForHistopathology">
                      	<tr>
                            <td width="50%" align="left">
                            <?php 
									echo $this->Form->Button(__('Add More Attribute'), array('type'=>'button','label' => false,'div' => false,'error'=>false,'escape' => false,'class' => 'blueBtn','id'=>'addButtonVaccination'));
							 
									
							?>
							 
							<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
							</td>
                                <td width="50%" align="right">
                                	 
                                	<?php
                                		echo $this->Form->submit(__('Save'), array('id'=>'add-morevaccination','title'=>'Save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                	/*	echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn'));*/
                                	?>
                                </td>
                            </tr>
                      </table>  
                       <!-- EOF-For histopathology_data -->
                        <p class="ht5"></p>
            
                      <?php echo $this->Form->end();?>                     
<!-- EOF lab Forms -->

  
<script language = "javascript"> 
        
		$(document).ready(function(){	
		
		//-----------------------------------------------------------------------------------------------------------------------------------	
			
			
			$('#add-morevaccination').click(function(){
	  		//	$('#whichActVaccination').val($(this).attr('id'));
		  	});
			var counter = 1; 
			 $("#addButtonVaccination").click(function () {		 
				 var cureentId1=$(".getRow").last().attr('id');					
					 var getNo=cureentId1.split("_");					
					 var counter=parseInt(getNo['1']);				
					 counter++;
			    	var newCostDiv = $(document.createElement('tr'))
				    .attr("id", 'TestGroupVaccination_' + counter).attr('class','getRow');
					
			    	$.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => 'Imunization', "action" => "ajax_add_vaccination", "admin" => false)); ?>",
						  data:{"counter":counter},
						  context: document.body,
						  beforeSend:function(){
				    		//this is where we append a loading image
			    			$('#temp-busy-indicator').show('fast');
				  		  },				  		  
						  success: function(data){	
				  			    $('#temp-busy-indicator').hide('fast');							  
				  			  	newCostDiv.append(data);		 
								newCostDiv.appendTo("#TestGroupVaccination");	
								$(".vaccinationdatecls1").datepicker({
									showOn : "button",
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									changeMonth : true,
									changeYear : true,
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
									onSelect : function() {
										$(this).focus();										
									}				
								}); 
								
								
						  }
				  		
					}); 			    	
					counter++;				
				});
			/* $(".removeBtnHistopathology").on('click',function () {
		    	 	if(confirm('Are You Sure?')){
		    			readyToRem = $(this).attr('id');			 
		    			readyToRemPos  = readyToRem.split("_");						 
			        	$("#TestGroupVaccination_" + readyToRemPos[1]).remove();
			        	
		    	 	}					
			  });*/
			 
			 
			 var counter_spd = '<?php echo $i;?>';
			 $(document).on('click','.addButtonDatecls', function() {				
			 	counter_spd++;
				/*var cureentId=$(".getRowInner").last().attr('id');//this is inner for loop id of date TR
				var trOFinnerId=cureentId.split('_'); */
				
				var cId=$(this).attr('id'); 	
			 	var tableId=cId.split('_'); 	 
			 	var restId=tableId['1'];
			 	
			 	
			 	/*tempCategory=$('.block_'+restId).length;*/
			 	
			 	/*if(tempCategory>1){
			 		//counter_spd=tempCategory;
			 	}*/
			 	
					 	
		          var newNoteDiv_spd = $(document.createElement('tr'))
	                 .attr("id", 'TestGroupVaccinationInner_'+restId+'_'+counter_spd).attr("class", 'block_'+restId);
		          var vaccDate_row = '<td colspan="2"><input class="textBoxExpnd vaccinationdatecls1 vaccination_datecls_'+restId+'_'+counter_spd+' " type="text" id="vaccinationdate_'+restId+'_'+counter_spd+'" name="data[VaccinationRemainder]['+restId+'][date]['+counter_spd+']"><input type="hidden" id="vaccinationdate_'+ counter_spd +'" name="data[VaccinationRemainder]['+restId+'][vaccination_id]['+counter_spd+']" value='+restId+'><input type="hidden" id="vaccinationdate_'+ counter_spd +'" name="data[VaccinationRemainder]['+restId+'][id]['+counter_spd+']" ><span style="float:right" class="removeButtonVaccCls" id="removeButtonVaccLink_'+restId+'_'+counter_spd+'"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></span></td>';
					newNoteDiv_spd.append(vaccDate_row);		 
					newNoteDiv_spd.appendTo("#showDateTbl_"+restId);	
					
					
			$(".vaccinationdatecls1").datepicker({
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();				
				}					
			}); 			 
		
	     });
		 
		 
		$(".removeButtonVaccCls").on('click',function () {				
				var cId=$(this).attr('id');
			 	var trId=cId.split('_');
			 	
			 	//alert(trId[0]);alert(trId[1]);alert(trId[2]);
		 		if(confirm('Are You Sure?')){
	    			//readyToRem = $(this).attr('id');			 
	    			//readyToRemPos  = readyToRem.split("_");	
	    			var vaccRecordId=$('#recordId_'+trId[1]+'_'+trId[2]).val();
	    			
	    			//alert(vaccRecordId);
		        	$("#TestGroupVaccinationInner_"+trId[1]+'_'+trId[2]).remove();
		        	if(vaccRecordId)deleteVaccination('Vaccination',vaccRecordId);
				}else{
					return false;
				}	
			        	
		    	 	
			  });
	  });
		//*********************************************Ajax call to delete codes of all type***************************************
		function deleteVaccination(modelName,vaccRecordId){ 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Imunization", "action" => "deleteVaccination","admin" => false)); ?>"+"/"+modelName+"/"+vaccRecordId;
		$.ajax({	
			 beforeSend : function() {
				// this is where we append a loading image
				$('#busy-indicator').show('fast');
				},
				                           
		 type: 'POST',
		 url: ajaxUrl,
		 dataType: 'html',
		 success: function(data){
			  $('#busy-indicator').hide('fast');
		  		$("#resultorder").html(" ");  
		 },
			error: function(message){
				alert("Error in Retrieving data");
		 }        
		 });
		}
		 //**************************************************end of ajax calls****************************************************** 	
		
	  $(".vaccinationdatecls1").datepicker({
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				
			}					
		}); 	
 </script>
 