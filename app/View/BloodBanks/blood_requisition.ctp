				   <div class="inner_title">
                     <h3>Requisition for Blood &amp; Blood Components</h3>
                     <span>
                     	<?php 
                     		echo $this->Html->link('Back',array('action'=>'index',$patient['Patient']['id']),array('escape'=>false,'class'=>'blueBtn'));
                     	?>
                     </span>
                  </div>
                  <?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error"> 
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?> 
  </td>
 </tr>
</table>
<?php } ?>
                  <?php 
                  	echo $this->Form->create('BloodOrder',array('type' => 'file','id'=>'bloodfrm',
                  						'inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)
						));
                  ?>
                   <p class="ht5"></p> 
                   <?php echo $this->element('patient_information');?>
                   <table width="" cellpadding="0" cellspacing="0" border="0" align="right">
                   <tr>
                     <td class="tdLabel">Date<font color="red">*</font></td>
                        <td><?php 
                        		if(!empty($this->data['BloodOrder']['order_date']) && (empty($errors))){
                        			$convertedOrderDate = $this->DateFormat->formatDate2Local($this->data['BloodOrder']['order_date'],Configure::read('date_format'),true) ;
                        		}else{
                        			$convertedOrderDate='';
                        		} 
                        		echo $this->Form->input('order_date',array('value'=>$convertedOrderDate,'type'=>'text','id'=>'order_date','readonly'=>'readonly','class'=>'blood_transfusion validate[required,custom[mandatory-date]] textBoxExpnd'));
                        		echo $this->Form->hidden('patient_id',array('value'=>$patient['Patient']['id']));
                        		echo $this->Form->hidden('id') ; 
                        	?></td>
                    </tr>
                   </table>
                   <div class="clr"></div>
                   <!-- two column table start here -->
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                        <td width="50%" align="left" valign="top" style="padding-top:7px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                                <td width="20%" height="25" class="tdLabel" id="boxSpace1">Patient Name </td>
                                <td width="42%" >
                                	<?php 
                                		echo  $patient[0]['lookup_name'] ;
                                	?>
                                </td>
                              </tr>
                              <tr>
                                <td width="20%" class="tdLabel">Address</td>
                                <td><?php echo $address ;?></td>
                              </tr>
                              <tr>
                                <td height="35" class="tdLabel" id="boxSpace2">Age </td>
                          <td ><?php echo $age;?></td>
                              </tr>
                              <tr>
                                <td height="35" class="tdLabel" id="boxSpace2">Gender </td>
                          		<td ><?php echo ucfirst($patient['Person']['sex']); ?></td>
                              </tr>
                       </table>                        </td>
                        	<td width="50%" align="left" valign="top" style="padding-top:7px;">
	                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
	                                <tr>
	                                    <td width="">
	                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
	                                              <tr>
	                                                <td width="20%" height="25" class="tdLabel" id="boxSpace1">Type of Request<font color="red">*</font></td>
	                                                <td width="32%">
	                                                	<?php 
	                                                		$requestTypes =array('Planned'=>'Planned','Urgent'=>'Urgent','Rush'=>'Rush');
	                                                		echo $this->Form->input('type_of_request',array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'type_of_request','options'=>$requestTypes,'empty'=>__('Please Select')));
	                                                	?>
	                                                </td>
	                                              </tr>
	                                              <tr>
	                                                <td height="25" class="tdLabel" id="boxSpace1">Blood Group (If Known)</td>
	                                                <td align="left" valign="top"><?php echo $blood_group ;?></td>
	                                              </tr>
	                                              <tr>
	                                                <td height="25" class="tdLabel" class="tdLabel1" id="boxSpace1"><?php echo __("Room / Bed No.");?></td>
	                                                <td align="left" valign="top"><?php echo $ward[$patient['Patient']['ward_id']]." / ".$room[$patient['Patient']['room_id']]?></td>
	                                              </tr>
	                                              <tr>
	                                                <td height="25" valign="middle" class="tdLabel" id="boxSpace1"><?php echo __("Patient MRN");?></td>
	                                                <td><?php echo $patient['Patient']['admission_id'];?></td>
	                                              </tr>
	                                      </table>
	                                    </td>
	                                  </tr>
                                </table>
                           </td>
                      </tr>
                    </table>
<!-- two column table end here -->
                    <div>&nbsp;</div>
                    <div class="clr ht5"></div>
                    <div class="tdLabel2" style="padding-bottom:10px; font-size:12px; font-weight:bold;">(KINDLY IDENTIFY THE PATIENT PROPERLY. TAKE BLOOD SAMPLE &amp; LABEL PROPERLY.)</div>
                    <div class="tdLabel2" style="padding-bottom:10px; font-size:12px; font-weight:bold;">(MOST OF THE SERIOUS HAZARDS OF TRANSFUSION (SHOT) OR FATAL REACTIONS ARE DUE TO SAMPLING/ LABELLING ERRORS)</div>
                    <div class="clr ht5"></div>
                    
                    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                    	<tr>
                        	<td>
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                  <tr>
                                    <td width="10%" class="tdLabel">Diagnosis</td>
                                    <td width="40%"><?php 
                                    	$dia = !empty($this->data['BloodOrder']['diagnosis'])?$this->data['BloodOrder']['diagnosis']:$diagnosis ;
                                    	echo $this->Form->input('diagnosis',array('class'=>'textBoxExpnd','value'=>$dia));
                                    ?></td>
                                    <td width="14%" class="tdLabel">Transfusion Indication</td>
                                    <td width="32%">
                                    	<?php 
                                    		echo $this->Form->input('trans_indication',array('class'=>'textBoxExpnd'));
                                    	?>
                                    </td>
                                    <td width="21%" class="tdLabel">HB%</td>
                                    <td width="20%">
                                    	<?php 
                                    		echo $this->Form->input('hb',array('style'=>'width:101px;;','class'=>'textBoxExpnd'));
                                    	?>
                                     </td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
                                <p class="ht5"></p>
                              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                  <tr>
                                    <td width="17%" class="tdLabel">History of Previous Transfusion</td>
                                    <td width="26%">
                                    	<?php 
                                    		$transfusionOptions= array('Yes'=>'Yes','No'=>'No');
                                    		echo $this->Form->input('previous_transfusion_history',array('options'=>$transfusionOptions, 'class'=> 'textBoxExpnd','empty'=>__('Please Select')));
                                    	?>
                                    </td>
                                    
                                    <td width="17%" class="tdLabel">Any adverse reaction reported?</td>
                                    <td width="29%">
                                    	<?php 
                                    		echo $this->Form->input('adverse_reaction',array('class'=>'textBoxExpnd'));
                                    	?>
                                    </td>                                    
                                    <td>&nbsp;</td>
                                  </tr>
                              </table>
                                <p class="ht5"></p>
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                  <tr>
                                    <td class="tdLabel" width="35%" >History of Pregnancy / Abortion / Previous Children HDN (if Applicable)</td>                                    
                                    <td width="57%">
                                    	<?php 
                                    		echo $this->Form->input('history_children_hdn',array('class'=>'textBoxExpnd'));
                                    	?>
                                    </td>                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                   <div class="clr">&nbsp;</div>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="TestGroup">
                   		<tr>
                        	<th width="20%" class="tdLabel">REQUIREMENT &nbsp;&nbsp;&nbsp;
                        		<?php 
                        			echo $this->Form->input('service_group_id',array('autocomplete'=>'off','id'=>'service_group_id','options'=>$serviceGroup,'empty'=>__('Please Select Service Group')))
                        		?>
                        	</th>
                            <th width="50" style="text-align:center;">UNITS</th>
                            <th width="220" style="text-align:center;">ON DATE AND TIME</th>
                            <th width="20" style="text-align:center;"></th>
                        </tr>
                        <?php  
                         $count =  !empty($this->data['BloodOrderOption'])?count($this->data['BloodOrderOption']):3 ;
                         for($op = 0;$op<$count;$op++){ ?>
	                        <tr id="TestGroup<?php echo $op;?>">
	                        	<td width="20%"><?php   
	                        		echo $this->Form->input('',array('options'=>$tariffListGroup,
	                        		'value'=>$this->data['BloodOrderOption'][$op]['tariff_list_id'],
	                        		'type'=>'select','empty'=>__('Please Select'),'id'=>'tariff_list_id-'.$op,'class'=>'textboxExpnd','style'=>'width:432px;',
	                        		'name'=>"data[BloodOrderOption][$op][tariff_list_id]")); ?></td>
	                            <td width="38%"><?php 
	                            	$units = !empty($this->data['BloodOrderOption'][$op]['units'])?$this->data['BloodOrderOption'][$op]['units']:'';
	                            	echo $this->Form->input('',array('value'=>$units,'type'=>'text','id'=>'units-'.$op,'class'=>'textBoxExpnd', 'style'=>"width:440px; " ,'name'=>"data[BloodOrderOption][$op][units]")); ?></td>
	                   	        <td width="19%" ><?php 
	                   	        	if(!empty($this->data['BloodOrderOption'][$op]['blood_transfusion_date'])){
	                   	        		$convertedTransfusion = $this->DateFormat->formatDate2Local($this->data['BloodOrderOption'][$op]['blood_transfusion_date'],Configure::read('date_format'),true ) ;
	                   	        	}else{
	                   	        		$convertedTransfusion ='';
	                   	        	}
	                   	        	echo $this->Form->input('',array(
	                        		'value'=>$convertedTransfusion,
	                        		'type'=>'text','id'=>'blood_transfusion_date-'.$op
	                   	        ,'class'=>'blood_transfusion textBoxExpnd', 'readonly'=>'readonly','name'=>"data[BloodOrderOption][$op][blood_transfusion_date]")); ?></td>	
	                   	        <td align="center"> 
	                   	        	<?php 
	                   	        		 
	                   	        			echo $this->Html->link($this->Html->image('/img/icons/cross.png',
	                   	        				array("align"=>"right","title"=>"Remove","style"=>"cursor: pointer;","alt"=>"Remove","class"=>"icd_eraser")),
	                   	        				'#',array('escape'=>false,'id'=>"removeBtn_$op",'class'=>"removeBtn"));
	                   	        	?>
	                   	        </td>                    
	                     	</tr>
                     	<?php } ?>
                   </table> <div class="clr">&nbsp;</div>
                   <table width="100%">
                   	<tr>
                   		<td align="right">
                   			<?php echo $this->Html->link('Add More','#',array("type"=>'button','alt'=>"Add More",'class'=>'blueBtn','id'=>'addButton')) ;?>
                   		</td>
                   	</tr>
                   </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2">
                   		<tr>
                       	  <td width="13%" >Name of Phlebotomist who has taken patient's blood sample</td>
                            <td width="30%"><?php 
                                    echo $this->Form->input('phlebotomist',array('class'=>'textBoxExpnd'));
                               ?>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2" style="padding-top:5px;">
                            	Please Send <strong>PROPERLY LABELED</strong> Patient's Blood in EDTA (1ml) &amp; Plain Bulb (5ml). In case of neonate, please send mother's blood sample also. I have read the instructions / rules overleaf &amp; will abide by it.
                            </td>
                        </tr>             
                   </table> 
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2">
                   		<tr>
                        	<td width="300" valign="top">
                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                   	  <td colspan="2"><strong>Hospital Name</strong></td>                                     	
                                    </tr>
                                    <tr>
                                    	<td colspan="2"> 
                                    		<?php 
			                                    echo $this->Form->input('hospital',array('value'=>$this->Session->read('facility'),'class'=>'textBoxExpnd','style'=>'width:86%; margin-top:5px;'));
			                               ?> 
			                            </td>                                     	
                                    </tr>
                                    <tr>
                                   	  <td width="20%" class="tdLabel" valign="middle">Ph. No.</td>
                                        <td>
                                        <?php
                                        	//use session value 
                                    		echo $this->Form->input('hospital_phone',array('style'=>"width:84%; margin-top:5px;",'class'=>'textBoxExpnd','value'=>$this->Session->read('location_phone')));
                               			?> 
                               			</td>
                                    </tr>
                                </table>                          </td>
                          <td width="300" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td colspan="2"><strong>Consultant Name</strong></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                              	 <?php  
                                    echo $this->Form->input('treating_consultant',array('style'=>"width:83%; margin-top:5px;",'class'=>'textBoxExpnd','value'=>$treating_consultant[0]['fullname'],'readonly'=>'readonly'));
                               	?> 
                              </td>
                            </tr>
                            <tr>
                              <td width="55" valign="middle">Cell No.</td>
                              <td><?php  
                                    echo $this->Form->input('treating_consultant_phone',array('style'=>"width:80%; margin-top:5px;",'class'=>'textBoxExpnd','value'=>$treating_consultant['User']['mobile']));
                               	?></td>
                            </tr>
                          </table></td>
                          <td width="300" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                <td colspan="2"><strong>RMO Name</strong></td>
                              </tr>
                              <tr>
                                <td colspan="2"><?php  
                                    echo $this->Form->input('registrar',array('id'=>'regsitrar','style'=>"width:85%; margin-top:5px;",'class'=>'textBoxExpnd','options'=>$registrar,'empty'=>__('Please Select')));
                               	?></td>
                              </tr>
                              <tr>
                                <td width="55" valign="middle">Cell No.</td>
                                <td><?php  
                                    echo $this->Form->input('registrar_phone',array('id'=>'registrar_phone','style'=>"width:79%; margin-top:5px;",'class'=>'textBoxExpnd','value'=>$treating_consultant['User']['mobile']));
                               	?></td>
                              </tr>
                          </table></td>
                   		</tr>
                    </table>
                   	<div>&nbsp;</div>
               		<div class="btns"> 
                          <?php echo $this->Html->link(__('Cancel'),array('action' => 'index',$patient['Patient']['id']), array('escape' => false,'class'=>'grayBtn'));
	?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
                    </div>
                    <div class="clr ht5"></div>
                    <!-- Right Part Template ends here -->
<script>
jQuery(document).ready(function(){
	 
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#bloodfrm").validationEngine();
	});
	 

	//BOF pankaj
	//counter for services
	var counter = <?php echo !$count?1:$count ;?>;
	var serviceData ='';
	$('#service_group_id').change(function (){ 
		for(var g=0;g<counter;g++){ 
		  	var nameEle =  "#tariff_list_id-"+ g ;
	  		$(nameEle).empty();
	  		$(nameEle).append( "<option value=''>Please Select</option>" );
		}
		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "getServiceGroup", "admin" => false)); ?>"+"/"+$('#service_group_id').val(),
				  context: document.body,
				  beforeSend:function(){
				    // this is where we append a loading image
				    $('#busy-indicator').show('fast');
				  }, 				  		  
				  success: function(options){
						$('#busy-indicator').hide('slow');
						if(options != ''){ 
						  	serviceData= $.parseJSON(options);
						  	for(var k=0;k<counter;k++){ 
							  	var nameEle =  "#tariff_list_id-"+ k ;
						  		$(nameEle).empty();
						  		$(nameEle).append( "<option value=''>Please Select</option>" );
								$.each(serviceData, function(val, text) {
								    $(nameEle).append( "<option value='"+val+"'>"+text+"</option>" );
								}); 
						  	} 
					  	}		
				  }  
		});
	}); 
 
	//Add New 
	$("#addButton").click(function () {
		 
			if($('#service_group_id').val()=='') {
				alert('Please select service group');
				$('#service_group_id').focus();
				return false ;
			}		 
	    	var newCostDiv = $(document.createElement('tr'))
		     .attr("id", 'TestGroup' + counter);
		    var testList = '<td width="20%"><select class="textboxExpnd" id="tariff_list_id-'+counter+'" name="data[BloodOrderOption]['+counter+'][tariff_list_id]" style="width:432px;"></select></td>';
		    var unit = '<td width="38%"><input type="text" class="textboxExpnd" id="units-'+counter+'" name="data[BloodOrderOption]['+counter+'][units]" style="width:440px;"></td>';
		    var bloodDate = '<td><input type="text" class="blood_transfusion textBoxExpnd" readonly="readonly" name ="data[BloodOrderOption]['+counter+'][blood_transfusion_date]" id="blood_transfusion_date-'+counter+'"></td>';
		    var delLink = '<td width="19%"><a href="#" id="removeBtn_'+counter+'" class="removeBtn">'+'<?php echo $this->Html->image('/img/icons/cross.png',array("title"=>"Remove","style"=>"float:left;","alt"=>"Remove","class"=>"icd_eraser textboxExpnd")) ;?>'+"</a></td>";

		    data = testList+unit+bloodDate+delLink ;    				  
  		  	newCostDiv.append(data);		 
			newCostDiv.appendTo("#TestGroup");
		    //adding service group options to dropdown
		   /* $("#	 option").each(function(val){
		    	$('#tariff_list_id-'+counter).append( "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>" );
		       
		    });  */
		    $('#tariff_list_id-'+counter).append( "<option value=''>Please Select</option>" );
		    $.each(serviceData, function(val, text) {
			    //$(nameEle).append( "<option value='"+val+"'>"+text+"</option>" );
			    $('#tariff_list_id-'+counter).append( "<option value='"+val+"'>"+text+"</option>" );
			});
		    	  
			counter++; 
			if(counter > 1) $('#removeButton').show('slow');

			 $( ".blood_transfusion" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		            maxDate: new Date(),
				}); 
			return false ;
		});
		 
	    $(".removeBtn").live('click',function () {
	    	 	if(confirm('Are You Sure?')){
	    			readyToRem = $(this).attr('id') ;
	    			readyToRemPos  = readyToRem.split("_");				 
		        	$("#TestGroup" + readyToRemPos[1]).remove();
	    	 	}					
	    	 	return false ;
		  });
		  
	    $( ".blood_transfusion" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
            onSelect:function(){
					$(this).focus();
	            }
		});
		
		
	//EOF add New
	//BOF registrar fon
	$('#regsitrar').change(function (){  
		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'blood_banks', "action" => "getDoctorByID", "admin" => false)); ?>"+"/"+$(this).val(),
				  context: document.body,
				  beforeSend:function(){
				    // this is where we append a loading image
				    $('#busy-indicator').show('fast');
				  }, 				  		  
				  success: function(data){
						$('#busy-indicator').hide('slow');
						$('#registrar_phone').val(data) 	;
				  }  
		});
	}); 
	//EOF registrar fon
	//EOF pankaj
}); //EOF ready
</script>