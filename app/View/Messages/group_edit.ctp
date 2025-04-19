<div class="inner_title">
 <h3>	
 <?php echo __('Edit Group'); ?></h3>
 <span>
<?php
echo $this->Html->link(__('Back', true),array('controller' => 'Messages', 'action' => 'groupIndex','admin'=>false), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
 </div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#GroupSmsFrm").validationEngine();
	});
	
</script>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
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
<form name="GroupSmsFrm" id="GroupSmsFrm" action="<?php echo $this->Html->url(array("action" => "groupEdit")); ?>" method="post" onSubmit="return Validate(this);" >       
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" style="width:80% !important" align="left">    
        <tr>
	<td class="form_lables">
	<?php echo __('Group Name',true); ?><font color="red">*</font>
	</td>
	<td><?php 
	echo $this->Form->input('GroupSms.group_name', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'group_name', 'label'=> false, 'div' => false, 'error' => false,'value'=>$this->data['GroupSms']['name']));
   echo $this->Form->hidden('GroupSms.id'); 
   
	   ?></td>
	</tr>
   <tr>
	<td class="form_lables">
	<?php echo __('Manager Name',true); ?><font color="red">*</font>
	</td>
	<td><?php echo $this->Form->input('GroupSms.manager_name', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'manager_name', 'label'=> false, 'div' => false, 'error' => false));
	   ?></td>
	</tr>

	  <tr>
	<td class="form_lables">
	<?php echo __('Manager Mobile No.',true); ?><font color="red">*</font>
	</td>
	<td><?php echo $this->Form->input('GroupSms.manager_mobile_no', array('class' => 'validate[required,custom[phone,minSize[10],onlyNumber]]','id' => 'manager_mobile_no', 'label'=> false, 'div' => false, 'error' => false,'maxlength'=>'10'));
	   ?></td>
	</tr>
         <tr>
	  <td class="form_lables">
	   <?php echo __('Is Active',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->checkbox('GroupSms.is_active', array('checked'=>'checked','id' => 'is_active', 'label'=> false, 'div' => false, 'error' => false,'checked'=>$this->data['GroupSms']['is_active']));
	   ?>
	  </td>
	 </tr>
	<tr>
	<td colspan="2" style="padding-top:10px;">
<table class="" border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">	
	<tr id="PackageBreakup">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				align="" class="formFull" id="packageData">
				<tr>
					<th align="center"><?php echo __('Initial');?><font color="red">*</font>
					</th>
					<th align="center"><?php echo __('Contact Name');?><font color="red">*</font>
					</th>
					<th align="center"><?php echo __('Mobile');?><font color="red">*</font>
					</th>		
					<th align="center"><?php echo __('Corporate');?>
					</th>	
					<th align="center"><?php echo __('Location');?>
					</th>	
					<th align="center"><?php echo __('Other Information');?>
					</th>								
					<th class="text"><?php echo __('Action');?>
					</th>
				</tr>

		<?php if($dataContact){	?>
				<?php $key = 0;?>
				<?php  foreach($dataContact as $keyM=>$value){?>
			<tr id="removePackageData-<?php echo $key;?>">	
					<td style="padding-left:10px;"><?php $radiologySrNo = $key+1;
					echo $this->Form->input("vbv",array('id'=>"initial_id-$key",'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd ','name'=> 'data[initial_id]['.$key.']','label'=>false,'div'=>false,'options'=>$initials,'value'=>$value['ContactSms']['initial_id']));
							?>
					<td  style="padding-left:10px;"><?php 
					echo $this->Form->input("fddfg",array('type'=>'text','id'=>"childId-$key",'name'=> 'data[contact_name]['.$key.']','value'=>$value['ContactSms']['name'],'class' => 'docName validate[required,custom[mandatory-enter]] textBoxExpnd','label'=>false,'div'=>false,'style'=>'width:150px;'));
					
					echo $this->Form->hidden("dddd",array('type'=>'text','id'=>"docId-$key",'class' => 'rate textBoxExpnd calculateCost','name'=> 'data[contact_id]['.$key.']','autocomplete'=> 'off','label'=>false,'div'=>false,'value'=>$value['ContactSms']['id'],'style'=>'width:150px;')); ?>
					</td>
					<td valign="top"><?php echo $this->Form->input("bbb",array('type'=>'text','id'=>"childImages-$key",'name'=> 'data[mobile]['.$key.']','value'=>$value['ContactSms']['mobile'],'class' => 'validate[required,custom[phone,minSize[10],onlyNumber]] textBoxExpnd calculateCost','autocomplete'=> 'off','label'=>false,'div'=>false,'maxlength'=>'10','style'=>'width:150px;'));				
					?>
					</td>
					<td style="padding-left:10px;"><?php echo $this->Form->input("vbv",array('id'=>"corporate_id-$key",'class' => 'corporateCls textBoxExpnd ','name'=> 'data[corporate_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$tariffStandardData,'value'=>$value['ContactSms']['corporate_id'],'style'=>'width:150px;'));
						?>
					</td>
					<td style="padding-left:10px;">
					 <div id="SubLocSection"><?php //debug($value['ContactSms']['sublocation_id']);
					 // echo $this->Form->input("vbv",array('id'=>"sublocation_id-$key",'class' => 'textBoxExpnd subLocCls','name'=> 'data[sublocation_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$corporateSublocationData,'value'=>$value['ContactSms']['sublocation_id'],'setValue'=>$value['ContactSms']['sublocation_id'],'style'=>'width:150px;'));
					   echo $this->Form->input("vbv",array('id'=>"sublocation_id-$key",'class' => 'textBoxExpnd subLocCls','name'=> 'data[sublocation_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$corporateSublocationData,'style'=>'width:150px;','value'=>$value['ContactSms']['sublocation_id'],'setValue'=>$value['ContactSms']['sublocation_id']));
							?>
							</div>
							<?php 	if(!empty($value['ContactSms']['city_id'])){
										$displayCity="";
									}else{
										$displayCity="none";
									}?>									

							 <div id="citySection-<?php echo $key?>" style="display:<?php echo $displayCity;?>"><?php echo $this->Form->input("vbv",array('type'=>'select','id'=>"city_id-$key",'class' => 'textBoxExpnd ','name'=> 'data[city_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$dataCity[$value['ContactSms']['sublocation_id']],'style'=>'width:150px;','value'=>$value['ContactSms']['city_id'],'setValue'=>$value['ContactSms']['city_id']));							
							?>
							</div><?php
					
						?>
					</td>
					<td style="padding-left:10px;"><?php echo $this->Form->input("vbv",array('type'=>'text','id'=>"other_info-$key",'class' => 'textBoxExpnd ','name'=> 'data[other_info]['.$key.']','label'=>false,'div'=>false,'style'=>'width:250px;','value'=>$value['ContactSms']['other_info']));
						?>
					</td>					
					<?php $display = 'none'; ?>
					<?php if($key == count($dataContact)- 1 ){?>
					<?php $display = '';}?>	
					<td class="text"><span><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'id'=>"Add-$key",'alt'=> __('Add', true),'class'=>'addMoretr','style'=>"float:none;display:$display",'onClick'=>"addMoretr();$(this).hide();$('#Remove-$key').show()"));?>
					</span> <span><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),'alt'=> __('Remove',true),'class'=>'removePackageData','style'=>'float:none;','id'=>"Remove-$key"));?></span>
					</td>
				</tr>
				<?php $key++; 
                                } ?>
				<?php } else{ ?>
				<?php $key = 0;?>
				<tr id="first">
							<td style="padding-left:10px;"><?php echo $this->Form->input("vbv",array('id'=>"initial_id-$key",'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd ','name'=> 'data[initial_id]['.$key.']','label'=>false,'div'=>false,'options'=>$initials,'default'=>'4'));
							?>
							</td>
							<td style="padding-left:10px;"><?php echo $this->Form->input("vbv",array('type'=>'text','id'=>"childId-$key",'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd ','name'=> 'data[contact_name]['.$key.']','label'=>false,'div'=>false,'style'=>'width:150px;'));
							?>
							</td>
							<td><?php echo $this->Form->input("bbb",array('type'=>'text','id'=>"childImages-$key",'class' => 'validate[required,custom[phone,minSize[10],onlyNumber]] textBoxExpnd calculateCost','autocomplete'=> 'off','name'=> 'data[mobile]['.$key.']','label'=>false,'div'=>false,'maxlength'=>'10','style'=>'width:150px;'));?>
							</td>	
							<td style="padding-left:10px;">
							<?php echo $this->Form->input("vbv",array('id'=>"corporate_id-$key",'class' => 'corporateCls textBoxExpnd ','name'=> 'data[corporate_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$tariffStandardData,'style'=>'width:150px;'));
							?>
							</td>
							<td style="padding-left:10px;">
							 <div id="SubLocSection"><?php echo $this->Form->input("vbv",array('id'=>"sublocation_id-$key",'class' => 'textBoxExpnd subLocCls','name'=> 'data[sublocation_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$corporateSublocationData,'style'=>'width:150px;'));
							?>
							</div>
							 <div id="citySection-<?php echo $key?>" style="display:none;"><?php //echo $this->Form->select("vbv",array('id'=>"city_id-$key",'class' => 'textBoxExpnd ','name'=> 'data[city_id]['.$key.']','label'=>false,'div'=>false,'empty'=>'Please Select','options'=>$corporateSublocationData,'style'=>'width:150px;'));
							?>
							</div>
							</td>
							<td style="padding-left:10px;"><?php echo $this->Form->input("vbv",array('type'=>'text','id'=>"other_info-$key",'class' => 'textBoxExpnd ','name'=> 'data[other_info]['.$key.']','label'=>false,'div'=>false,'style'=>'width:250px;'));
							?>
							</td>
							<td class="text"><span><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'id'=>"Add-$key",
									'alt'=> __('Add', true),'class'=>'addMoretr','style'=>'float:none;','onClick'=>"addMoretr();$(this).hide();$('#Remove-$key').show()"));?>
							</span> <span><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
									'alt'=> __('Remove', true),'class'=>'removePackageData','style'=>'float:none;display:none;','id'=>"Remove-$key"));?></span>
							</td>
						</tr>
				<?php }  ?>
			</table>
	</td>
	</tr>	
	 <tr>
	<td colspan="2" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'groupIndex'), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>



<script>

 //For Sort array in ascending Order
		function sortData(data) {
			var sorted = [];
			Object.keys(data).sort(function(a,b){				
				return data[a] < data[b] ? -1 : 1
			}).forEach(function(key){ 
				sorted.push({name: key, val: data[key]});
			});			 
			return sorted;
		}

		function addSublocationDropdown(IdSubLoc,corporateId){			
			$("#sublocation_id-"+IdSubLoc+" option").remove();
			$.ajax({
			  url:"<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "ajaxFetchSublocation", "admin" => false)); ?>"+"/"+corporateId,
			  context: document.body,
			  beforeSend:function(){
			    // this is where we append a loading image
			    $('#busy-indicator').show('fast');
				}, 				  		  
			  	success: function(data){
					$('#busy-indicator').hide('slow');		  		
			  		
				  	if(data == 'empty'){
				  			alert('No Location available for selected Corporate.'); 
				  	}else{
				  		data= $.parseJSON(data);
				  		$('#SubLocSection').show('slow');
					  	$("#sublocation_id-"+IdSubLoc).append( "<option value=''>Please Select</option>" );
						$.each(data,function(val, text) {
							//if(val==bedId)				   
							  // 	$("#"+IdSubLoc).append( "<option value='"+val+"' selected=selected>"+text+"</option>" );
							//else
						    	$("#sublocation_id-"+IdSubLoc).append( "<option value='"+val+"'>"+text+"</option>" );
						});
						//$("#"+Id).attr('disabled', disabledBed);
						//$('#bed_id').attr('disabled', '');	
				  	}/*else{	  		 
						$('#SubLocSection').hide('fast');
						if($('#corporate_id-'+IdSubLoc).val()!=''){
							alert('No Location available for selected Corporate'); 
						}
				  	}	*/    		
			   	}
			});
		}
		function addCityDropdown(IdSubLoc,subLocId){			
			$("#city_id-"+IdSubLoc+" option").remove();
			$.ajax({
			  url:"<?php echo $this->Html->url(array("controller" => 'Cities', "action" => "getCities", "admin" => false)); ?>"+"/"+subLocId,
			  context: document.body,
			  beforeSend:function(){
			    // this is where we append a loading image
			    $('#busy-indicator').show('fast');
				}, 				  		  
			  	success: function(data){
					$('#busy-indicator').hide('slow');				  	
			  		data= $.parseJSON(data);
			  		$('#citySection-'+IdSubLoc).show('slow');			  	
				  	$("#city_id-"+IdSubLoc).append( "<option value=''>Select City</option>" );
					$.each(data,function(val, text) {					
					    $("#city_id-"+IdSubLoc).append( "<option  value='"+val+"'>"+text+"</option>" );
					});			
					 		
			   	}
			});
		}
		
		function addSublocationDropdownStatic(IdSubLoc,selectedValue){
		 	$('#busy-indicator').show('fast');	  		
			var select = $("#sublocation_id-"+IdSubLoc);

			var newOptions = {
                				'Maharashtra' : 'Maharashtra',
                				'Madya Pradesh' : 'Madya Pradesh',
                				'Uttar Pradesh' : 'Uttar Pradesh'
           					 };
			$('option', select).remove();
			$(select).append( "<option value=''>Please Select</option>" );
			$.each(newOptions, function(text, key) {
				if(selectedValue==text)				   
					$(select).append( "<option value='"+text+"' selected=selected>"+key+"</option>" );
				else
					$(select).append( "<option  value='"+text+"'>"+key+"</option>" );
    			//var option = new Option(key, text);
    		//	console.log(option);
    		//	select.append($(option));
			});	
			$('#busy-indicator').hide('slow');			  	
		}
$(document).ready(function(){
	var privateTariff="<?php echo $getPrivateTariffID;?>";
 	$('.corporateCls').each(function() {//loop through each dropdown        
        checkId=this.id;                	   	 
        splitedId=checkId.split('-'); 
       // console.log($(this).val()+"+++++++"+privateTariff);    
      //  console.log(splitedId); 
        var value=$('#sublocation_id-'+splitedId[1]).attr('setvalue');     
        if(privateTariff==$(this).val()){        
        	addSublocationDropdownStatic(splitedId[1],value);
		}              	
    });

	//$("#sublocation_id-0 option").remove();
//BOF-click on city to fetch Branch
			$(document).on('change', '.corporateCls', function() {
			//$('.corporateCls').change(function (){
				var IdSubLoc=$(this).attr('id');
				var IdSubLocSplit=IdSubLoc.split("-");			
				var corporateId=$('#corporate_id-'+IdSubLocSplit[1]).val();
				var privateTariff="<?php echo $getPrivateTariffID;?>";
				if(privateTariff!=corporateId){
					addSublocationDropdown(IdSubLocSplit[1],corporateId);//changes done by mahalaxmi
					$("#sublocation_id-"+IdSubLocSplit[1]+" option").remove();
					$("#city_id-"+IdSubLocSplit[1]+" option").remove();
					$("#city_id-"+IdSubLocSplit[1]).hide();
				}else{
					if(privateTariff==corporateId){
						addSublocationDropdownStatic(IdSubLocSplit[1]);//changes done by mahalaxmi
						$("#city_id-"+IdSubLocSplit[1]).show();
					//$("#sublocation_id-"+IdSubLocSplit[1]).attr('disabled', 'disabled');
					}
				}
				
			});
			$(document).on('change', '.subLocCls', function() {
			//$('.corporateCls').change(function (){
				var IdSubLoc=$(this).attr('id');
				var IdSubLocSplit=IdSubLoc.split("-");			
				var subLocVal=$(this).val();	
				
				if(subLocVal=='Maharashtra' || subLocVal=='Madya Pradesh' || subLocVal=='Uttar Pradesh'){	
					addCityDropdown(IdSubLocSplit[1],subLocVal);
				}else{
					$("#city_id-"+IdSubLocSplit[1]+" option").remove();
				}

			});
});
var radiologySrNo = isNaN(parseInt('<?php echo $radiologySrNo;?>')) ? 1 : parseInt('<?php echo $radiologySrNo;?>'); 
var key =radiologySrNo;
function addMoretr() {
    var wardOrderNo = 1;
    var appendOption= "<option value=''>Please Select</option>";
	 $('#packageData')
     .append($('<tr>').attr('id','removeRow-'+radiologySrNo)  
     				 .append($('<td style="padding-left:10px;">').append($('<select>').attr({'id':'initial_id-'+radiologySrNo,'class':'textBoxExpnd ','type':'select','name':'data[initial_id]['+radiologySrNo+']'})))			          
                     .append($('<td  style="padding-left:10px;">')
                             .append($('<input>').attr({'name':'data[contact_name]['+radiologySrNo+']','type':'text','class': 'docName validate[required,custom[mandatory-enter]] textBoxExpnd','autocomplete': 'off','id' : 'childId-'+radiologySrNo,'style':'width:150px;'})))
                     .append($('<td>')
                                     .append($('<input>').attr({'name':'data[mobile]['+radiologySrNo+']','type':'text','class' :'rate calculateCost textBoxExpnd validate[required,custom[phone,minSize[10],onlyNumber]]','autocomplete': 'off', 'id' : 'childImages-'+radiologySrNo,'maxlength':'10','style':'width:150px;'})))  
                     .append($('<td  style="padding-left:10px;">')
                             .append($('<select>').attr({'name':'data[corporate_id]['+radiologySrNo+']','type':'text','class': 'corporateCls textBoxExpnd','autocomplete': 'off','id' : 'corporate_id-'+radiologySrNo,'style':'width:150px;'}).append(appendOption)))        
                     .append($('<td  style="padding-left:10px;">')                     	
                             .append($('<select>').attr({'name':'data[sublocation_id]['+radiologySrNo+']','type':'text','class': 'subLocCls textBoxExpnd','autocomplete': 'off','id' : 'sublocation_id-'+radiologySrNo,'style':'width:150px;'}).append(appendOption))
                             .append($('<div>').attr({'id':'citySection-'+radiologySrNo,'style':'display:none;'})  
                             .append($('<select>').attr({'name':'data[city_id]['+radiologySrNo+']','type':'text','class': 'textBoxExpnd','autocomplete': 'off','id' : 'city_id-'+radiologySrNo,'style':'width:150px;'}).append(appendOption))))              
                     .append($('<td  style="padding-left:10px;">')
                             .append($('<input>').attr({'name':'data[other_info]['+radiologySrNo+']','type':'text','class': 'docName textBoxExpnd','style':'width:250px;','autocomplete': 'off','id' : 'other_info-'+radiologySrNo})))                        
					 .append($('<td class="text">').attr('id','Td-'+radiologySrNo).append($('<span>').attr({'id' : 'Add-'+radiologySrNo})
                     .append('<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'alt'=> __('Add',true),'style'=>'float:none;','class'=>'addMoretr','onClick'=>'addMoretr();$(this).parent().hide()'));?>'))
                      .append($('<span>').attr({'class':'removePackageData','id' : 'Remove-'+radiologySrNo/*,'onclick' : "$('#Add-"+packageSrNo-1+").show()"*/})
                      .append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
                                                            'alt'=> __('Remove', true),'style'=>'float:none;'));?>')))
    
     );
     var selectInitials = <?php echo json_encode($initials);?>;
	   		$.each(selectInitials, function (key, value) {
	   			$('#initial_id-'+radiologySrNo).append( new Option(value, key) );
			});
			 var selecttariffStandardData = <?php echo json_encode($tariffStandardData);?>;
	   		$.each(selecttariffStandardData, function (key, value) {
	   			$('#corporate_id-'+radiologySrNo).append( new Option(value, key) );
			});
			 var selectCorporateSublocationData = <?php echo json_encode($corporateSublocationData);?>;
	   		$.each(selectCorporateSublocationData, function (key, value) {
	   			$('#sublocation_id-'+radiologySrNo).append( new Option(value, key) );
			});
     key++;
	    $('.removePackageData').on('click' , function (){
	        var thisElementId = $(this).attr('id'); 
	        var thisKey = thisElementId.split('-');
	        $("#removeRow-" + thisKey[1]).remove();
	        var trId = $('#packageData tr:last').attr('id'); 
	        var lastTrKey = trId.split('-');
	        if($('#packageData tr:last').attr('id') == 'firstn' || lastTrKey[1] == 0){
	            $('#Add-0').show();
	            $('img#Remove-0').hide();
	        }else{
	            var tdId = $('#packageData tr:last').attr('id')
	             var lastKey = tdId.split('-');
	             $('#Add-'+lastKey[1]).show(); 
	        }
	        $('.calculateCost').trigger('keyup');
	    });	
		
	   
	     radiologySrNo++;//in
	}
	$('.removePackageData').on('click' , function (){
	    var thisElementId = $(this).attr('id');
	        var thisKey = thisElementId.split('-');
	        $("#removePackageData-" + thisKey[1]).remove();
	        var trId = $('#packageData tr:last').attr('id');
	        var lastTrKey = trId.split('-');
	        if($('#packageData tr:last').attr('id') == 'first' || lastTrKey[1] == 0){
	            $('#Add-0').show();
	            $('img#Remove-0').hide();
	        }else{
	            var tdId = $('#packageData tr:last:last').attr('id')
	             var lastKey = tdId.split('-');
	             $('#Add-'+lastKey[1]).show();
	        }
	        $('.calculateCost').trigger('keyup');
	    });
	    

 </script>