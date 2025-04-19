<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#ward").validationEngine();
	});
	
</script>
<!-- Right Part Template -->
<?php echo $this->Form->create('Ward',array('controller'=>'wards','action'=>'addWard','id'=>'ward','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
?>

<div class="inner_title">
<h3 style="float:left;">Add Ward</h3>
<div style="float:right;">
<?php echo $this->Html->link(__('Back'),array('controller'=>'wards','action' => 'index','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
</div>
<p class="clr"></p>
</div>
<p class="ht5"></p>
<!-- two column table start here -->
<table id="wardList" width="100%" border="0" cellspacing="1"
	cellpadding="0" class="tabularForm">
	<tr>
		<td width="30%" align="left" valign="middle" style="padding-top: 7px;">
		<table width="350" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="35" valign="middle" class="tdLabel1" id="boxSpace2">Ward Type :</td>
				<td align="left" valign="middle"><?php 
					echo $this->Form->input('ward_type',array('options'=> array('Non-ICU' => 'Non-ICU','ICU' => 'ICU'),'legend'=>false,'label'=>false,'id' => 'ward_type'));
				?></td>
			</tr>
			<tr>
				<td height="35" valign="middle" class="tdLabel1">Ward Name:<font color="red">*</font></td>
				<td align="left" valign="middle"><?php echo $this->Form->input('Ward.name',array('class' => 'validate[required,custom[Wardname]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'name_1','onChange'=>'get_ward_id(this.value);','onBlur'=>'get_ward_id(this.value);')); ?></td>
			<?php 
				echo $this->Form->hidden('wardid',array('id' => 'wardid')); 
				?></tr>
			<tr>
				<td height="35" valign="middle" class="tdLabel1" id="boxSpace2">Ward ID:<font color="red">*</font></td>
				<td align="left" valign="middle" id="wards">
				</td>
			</tr>
		</table>
		</td>
		<td width="70%" align="left" valign="top" style="padding-top: 7px;">
		<table width="480" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" id="wardSubService">
					<tr>
						<td width="50%" height="35" valign="middle" class="tdLabel1"
							id="boxSpace1">No. of Rooms:<font color="red">*</font></td>
						<td width="50%" align="left" valign="middle"><?php echo $this->Form->input('Ward.no_of_rooms',array('class' => 'validate[required,custom[no_of_rooms]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'no_of_rooms_1')); ?></td>
						 
					</tr> 
					<tr>
						<td height="35" valign="middle" class="tdLabel1"
							id="boxSpace1">Select Bed Charges, Accomodation or similar category:<font color="red">*</font></td>
						<td  align="left" valign="middle">
							
							<?php
								echo $this->Form->input('Ward.service_group_id',
								 	 array('options'=>$serviceGroup,'empty'=>__('Select Service Group'),'escape'=>false,'id'=>'service_group_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off'));
								 	 ?> 
						</td> 
					</tr>
					<tr>
						<td height="35" valign="middle" class="tdLabel1"
							id="boxSpace1"> Map Ward To Service:<font color="red">*</font></td>
						<td  align="left" valign="middle">
							<?php 
									echo $this->Form->input('Ward.tariff_list_id', array('options'=>'','label'=>false, 
									'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tarifflist', 'empty' => __('Select Service')));
						    ?> 
						</td> 
					</tr>
					<tr>
						<td height="35" valign="middle" class="tdLabel1"
							id="boxSpace1">Sort Order</td>
						<td  align="left" valign="middle">
							<?php 
									echo $this->Form->input('Ward.sort_order', array('label'=>false, 
									'class' => 'textBoxExpnd','id' => 'sort_order'));
						    ?> 
						</td> 
					</tr>
				</table>
				</td>

			</tr>
		</table>
		</td>
	</tr>
</table>

<div class="btns"><!--<input name="addMore" id="addMore" type="button"
	value="Add More" class="blueBtn" tabindex="8" />
	--><input class="blueBtn" type="submit" value="Save" id="save">
	</div>

                    <div class="clr ht5"></div>
                    
           
                   <!-- Right Part Template ends here -->
<div class="btns">
<!-- <input name="addMore" id="addMoreServices" type="button" value="Add More" class="blueBtn" tabindex="8" /></div> 
  -->
 <div class="btns">

</div></div>      
<?php echo $this->Js->writeBuffer();?>             
<?php echo $this->Form->end(); ?>


<script>
	var basePath = '<?php echo $this->webroot;?>';


jQuery(document).ready(function(){

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
					  	}else{
							$('#lsit-content').hide('fast');
					  	}		
				  }
		});
	});
	//EOF pankaj
	var subServicecounter = 2;
	jQuery("#ward").validationEngine();
	$("#addMore").click(function () {	//alert('here'); 
		var newWardDiv = $(document.createElement('tr'))
	    .attr("id", 'wardSubService' + subServicecounter);
		var addTRHtml = '<td valign="middle" height="35" id="boxSpace1" class="tdLabel1">Sub-service/Cost:<font color="red">*</font></td><td valign="middle" align="left"><div class="input text"><input type="text", "class= validate[required,custom[mandatory-enter-only]]", id="sub_service_1" name="data[Ward][sub_service][]"></div></td><td>&nbsp;</td><td>&nbsp;</td><td><div class="input text"><font color="red">*</font><input type="text", "class= validate[required,custom[mandatory-enter-only]]", id="sub_service_cost_1" style="width: 80px;" name="data[Ward][sub_service_cost][]"></div></td>';
	    
	    newWardDiv.append(addTRHtml);		 
	    newWardDiv.appendTo("#wardSubService");		
	});

});


// Funtion to ge the Ward it dynamically

function get_ward_id(value){
	if(value=='') return false;
   jQuery.ajax({       
   type: "GET",  
   data: value,   
   url: basePath+'wards/genrate_ward_id/'+value,     
   success: function(html){	  
	 var showlabl=$('#ward_id_1').val(html);
		$("#wards").html(html);
		$("#wardid").val(html);
	
},
async: false 
});
}
</script>
