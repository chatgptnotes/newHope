<style>
.main_wrap {
	width: 100%;
	float: left;
	margin: 0px;
	padding: 0px;
}

.btns {
	float: left !important;
	margin: 0 0 0 15px;
}

.tabularForm {
	float: left;
	margin: 10px 0 0 20px;
	width: 92% !important;
}

.inner_title {
	width: 97% !important;
}
</style>
<style>
.requisition_option {
	display: none;
}
</style>




<div class="main_wrap">
	<div class="inner_title">
	<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
		<h3>Issue for Consumption</h3>
		<span><?php  echo $this->Html->link(__('Back'), array('action' => 'department_store'), array('escape' => false,'class'=>"blueBtn"));?>
		</span>
	</div>
	<div class="first_table"><?php echo $this->Form->create();?>
		<table style="float: left; width: 100%;">
			<!--<tr> 
				<td valign="top" class="tdLabel"><span width="30%" style="float: left; padding-top: 10px">Issue Product For:  </span>
						<?php if($this->request->data['Department']['type_for']=='department' || empty($this->request->data['Department']['type_for'])){
						$checked="checked='checked'";
						$display="display: block;";
						$displayP="display: none;";
						}
						if($this->request->data['Department']['type_for']=='patient'){
						$checkedP="checked='checked'";
						$display="display: none;";
						$displayP="display: block;";
						}
					?>
					<label>Department<input type="radio" value="department" name="Department[type_for]" class="party_selector" <?php echo $checked;?>></label>
					<label>Patient<input type="radio" value="patient" name="Department[type_for]" class="party_selector" <?php echo $checkedP;?>></label>
						<?php echo $this->Form->input('is_patient',array('type'=>'hidden','value'=>'0','id'=>'is_patient','label'=>false,'div'=>false))?>
						</td>
			</tr>
			--><tr>
				<td>
					<table width="50%" style="margin-bottom: 50px;">					
						<!--<tr id='departID'>
							<td width="20%" valign="top" class="tdLabel" ><?php echo __('Department Name');?><font
								color="red">*</font></td>
							<td>
							
							<td><?php 
							
							echo $this->Form->input('issued_to', array('options'=>$department,'empty'=>'Please Select','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'department_name','style'=>'width: 40%; '.$display,'label'=>false,'div'=>false)); ?>
							</td>
						</tr>
						<tr id='patientID' style="display: none;">
							<td width="20%" valign="top" class="tdLabel" ><?php echo __('Patient Name');?><font
								color="red">*</font></td>
							<td>
							
							<td><?php echo $this->Form->input('patient_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'patient_name','style'=>'width: 40%; '.$displayP,'label'=>false,'div'=>false));
									  echo $this->Form->input('patient_id',array('type'=>'hidden','id'=>'patient_id','label'=>false,'div'=>false)); ?>
							</td>
						</tr>-->
						<tr id='locationID'>
							<td width="20%" valign="top" class="tdLabel" ><?php echo __('Store Location');?><font
								color="red">*</font></td>
							<td>
							
							<td><?php 
							echo $this->Form->input('issued_from', array('options'=>$location,'autocomplete'=>'off','empty'=>'Please Select','class' => 'requisition_selector validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'location_name','style'=>'width: 40%','label'=>false,'div'=>false)); ?>
							</td>
						</tr>
						<tr class='requisition_tr' style="display: none;">
						<td valign="top" class="tdLabel" ><?php echo __('Store Sub Location');?><font
								color="red">*</font></td>
							<td>
							<td ><?php
							echo $this->Form->input('StoreRequisition.ward',
                                	array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select ward',
                                	'options'=>$wards,'div'=>false,'class'=>'requisition_option validate[required]'));
			               		 
			               			echo $this->Form->input('StoreRequisition.ot',
			                                array('id' => 'ot', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select OT',
			                                'options'=>$ot,'div'=>false,'class'=>'requisition_option  validate[required]'));
			               		 
			               			echo $this->Form->input('StoreRequisition.chamber',
			                          array( 'id' =>'chamber', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select chamber',
			                           'options'=>$chambers,'div'=>false,'class'=>'requisition_option  validate[required]'));
			               		 
			               			echo $this->Form->input('StoreRequisition.other',
			                            array('id' => 'other', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select Other Location',
			                              'options'=>$department,'div'=>false,'class'=>'requisition_option  validate[required]'));
				               ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php $cnt=0;?>
			<input type="hidden" value="0" id="no_of_fields" />
			<tr>
				<td width="100%">
					<table width="100%" id="productArea">
						<tr id=<?php echo 'row-'.$cnt?>>
							<td class="tdLabel">
								<?php echo __('Item Desc.');?><font style="color: red">*</font><br />
							 	<?php echo $this->Form->input('product.'.$cnt, array('class' => 'validate[required,custom[name]] textBoxExpnd product product','fieldno'=>$cnt,'id' => 'product-'.$cnt,'label'=>false,'div'=>false));
											echo $this->Form->input('product_id.'.$cnt,array('type'=>'hidden','id'=>'product_id-'.$cnt,'fieldno'=>$cnt,'class'=>'product_id','label'=>false,'div'=>false)); ?>
											
							</td>
							<!--<td width="22%!important;" valign="" class="tdLabel"><?php echo __('Batch No');?><br />
								<?php echo $this->Form->input('batch_no.'.$cnt, array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd batch_no','id' => 'batch_no-'.$cnt,'label'=>false,'div'=>false,'readOnly'=>true)); ?>
							</td>-->
							<td  valign="" class="tdLabel"><?php echo __('Quantity');?><font
								color="red">*</font><br />
								<?php echo $this->Form->input('issue_qty.'.$cnt, array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd qty_issue','id' => 'qty_issue-'.$cnt,'autocomplete'=>'off','label'=>false,'div'=>false)); ?>
							</td>
							<td  valign="" class="tdLabel" id=""><?php echo __('Current Stock');?><br />
								<?php echo $this->Form->input('current_stock.'.$cnt, array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd current','id' => 'current-'.$cnt,'label'=>false,'div'=>false,'readOnly'=>true)); ?>
							</td>
							<!--<td width="22%!important;" valign="" class="tdLabel" id=""><?php echo __('Exp.Date');?><br />
								<?php echo $this->Form->input('expiry.'.$cnt, array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd expiry','id' => 'expiry-'.$cnt,'label'=>false,'div'=>false,'readOnly'=>true)); ?>
							</td>-->
						</tr>
						
					</table>
				</td>
			</tr>
			<tr> 
				<td width="20%!important;" style="padding: 10px 0px 0px 0px">
					<input name="" type="button" value="Add More" class="blueBtn Add_more" id="add_more" />
					<input name="" type="button" value="Remove" id="remove-btn" class="blueBtn" onclick="removeRow()" style="display: none" />
				</td>
			</tr>
			<tr>
				<td style="padding: 10px 0px 0px 0px">
					<?php echo $this->Form->input('Submit',array('type'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false))?>
				</td>
			</tr>
		</table><?php echo $this->Form->end();?>
		
		
		<div id="consumption_list">
			
		</div>
		
		
		
		<!--<table style="float: left; margin-top: 30px; width:100%">
			<tr>
				<td class="tdLabel"><a
					href="#" class="blueBtn">Add New</a> <a href="#" class="blueBtn">Issue
						Drugs & Report</a>
				</td>
			</tr>
		</table>
	--></div>
</div>

<script>
var departmentList = <?php echo json_encode($location); ?>;
var subDepartment = <?php echo json_encode($wards); ?>;
$(document).on('change','#location_name',function(){
	var departmentId = $("#location_name").val();
	if(departmentId!=''){
		$('#location_nameformError').remove();
		$.ajax({
		  type : "POST", 
		  url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "getConsumptionProducts", "admin" => false)); ?>"+"/"+departmentId,
		  context: document.body,
		  success: function(data){   
		  	  $("#consumption_list").html(data);
		  	  $("#consumption_list").fadeIn(500);	  				  
		  	  $("#busy-indicator").hide();
		  },
		  beforeSend:function(){
			  $("#busy-indicator").show();
		  },		  
		});
	}else{
		$("#consumption_list").fadeOut(100);	
	}
});


$(document).on('change','#ward',function(){
	var departmentId = $("#location_name").val();
	var ward = $("#ward").val();

	if(ward != ''){
		var url = "<?php echo $this->Html->url(array("controller" => "Store", "action" => "getConsumptionProducts", "admin" => false)); ?>"+"/"+departmentId+"/"+ward;
	}else{
		var url = "<?php echo $this->Html->url(array("controller" => "Store", "action" => "getConsumptionProducts", "admin" => false)); ?>"+"/"+departmentId;
	}

	$.ajax({
	  type : "POST", 
	  url: url,
	  context: document.body,
	  success: function(data){   
	  	  $("#consumption_list").html(data);
	  	  $("#consumption_list").fadeIn(500);	  				  
	  	  $("#busy-indicator").hide();
	  },
	  beforeSend:function(){
		  $("#busy-indicator").show();
	  },		  
	});
	
});



$(document).ready(function(){
	$("#location_name").val('');
	$('.product').val('');
    $('.product_id').val('');
	$('.batch_no').val('');
	$('.expiry').val(''); 
	$('.current').val(''); 
	$('.qty_issue').val('');
	jQuery("#DepartmentProductConsumptionForm").validationEngine();
	

	$('.party_selector').click(function(){
		var value=$(this).val();
		if(value=='department'){
			$('#departID').show();
			$('#patientID').hide();
			$('#is_patient').val('0');
		}
		if(value=='patient'){
			$('#departID').hide();
			$('#patientID').show();
			$('#is_patient').val('1');
			
		}
	});
	
	$("#patient_name").focus(function()
	{
		$(this).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>",
				 minLength: 1,
				 select: function( event, ui ) {
					$('#patient_id').val(ui.item.id); 					
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
		});

	});

	$(document).on('focus',".qty_issue, .current" , function() {
		var rowid = $(this).attr('id').split('-')[1];
		var storeLocation=$('#location_name').val();
		var subLocation='';
		if(storeLocation==''){
			alert('Please Select Store Location');
			$(".product-0formError").remove();
			$(".qty_issue-0formError").remove();
			$(".current-0formError").remove();
			return false;
		}
	});

	
	$(document).on('focus',".product" , function() {
	
		var rowid=$(this).attr('id').split('-')[1];
			var storeLocation=$('#location_name').val();
			var subLocation='';
			
			if(storeLocation==''){
				alert('Please Select Store Location');
				$(".product-0formError").remove();
				$(".qty_issue-0formError").remove();
				$(".current-0formError").remove();  
				return false;
			}else{
				switch($('.requisition_selector option:selected').text())
		        {
		            case 'Ward':
		            	subLocation=$('#ward').val();
		            	if(subLocation=='')
		            		alert('Please Select Store Sub Location');
		            break;
		            case 'OT':
		            	subLocation=$('#ot').val();
		            	if(subLocation=='')
		            		alert('Please Select Store Sub Location');

		            break;
		            case 'Chamber':
		            	subLocation=$('#chamber').val();
		            	if(subLocation=='')
		            		alert('Please Select Store Sub Location');

		            break;
		            case 'Other':
		            	subLocation=$('#other').val();
		            	if(subLocation=='')
		            		alert('Please Select Store Sub Location');

		            break;
		            default:
		            	subLocation='';
		            break;

		        }
			$(this).autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "consumption_stock", "admin" => false,"plugin"=>false)); ?>"+"/"+storeLocation+"/"+subLocation,
					 minLength: 1,
					 select: function( event, ui ) {
						console.log(ui.item);
						var curField = $(this).attr('fieldno');
						$('#product_id-'+rowid).val(ui.item.id);
						$('#batch_no-'+rowid).val(ui.item.batch_no);
						var splitDate=ui.item.expiry.split('-'); 
						$('#expiry-'+rowid).val(splitDate[2]+'/'+splitDate[1]+'/'+splitDate[0]); 
						$('#current-'+rowid).val(ui.item.stock); 

						var productId = ui.item.id; 
						var exist = false; 
						var thisField = '';
			            $(".product_id").each(function(){
			    			thisField = $(this).attr('fieldno');
			    			if(this.value == productId && curField != thisField){
			    				exist = true;
			    				return false;
			    				//return false;
			    			}
			    		});

						if(exist == true){
							alert("This product is already selected");
							return false;
						}					
					 },
					 messages: {
					        noResults: '',
					        results: function() {}
					 }
			});
			}

		});

});

$(".requisition_selector").change(function(){
    $(".requisition_option").css("display","none").val('');
    var position = $(this).position();
    var txt=$('.requisition_selector option:selected').text()
    switch($('.requisition_selector option:selected').text())
        {
            case 'Ward':
             $('.requisition_tr').show();
             $("#ward").css("display","block");
                $('.product').val('');
	            $('.product_id').val('');
				$('.batch_no').val('');
				$('.expiry').val(''); 
				$('.current').val(''); 

            break;
            case 'OT':
             $('.requisition_tr').show();
             $("#ot").css("display","block");
                $('.product').val('');
                $('.product_id').val('');
				$('.batch_no').val('');
				$('.expiry').val(''); 
				$('.current').val(''); 

            break;
            case 'Chamber':
            	$('.requisition_tr').show();
                $("#chamber").css("display","block");
                $('.product').val('');
                $('.product_id').val('');
				$('.batch_no').val('');
				$('.expiry').val(''); 
				$('.current').val('');

            break;
            case 'Other':
            	 $('.requisition_tr').show();
                  $("#other").css("display","block");
                  $('.product').val('');
                  $('.product_id').val('');
  				  $('.batch_no').val('');
  				  $('.expiry').val(''); 
  				  $('.current').val(''); 

            break;
            default:
            	$('.requisition_tr').hide();
                $('.product').val('');
                $('.product_id').val('');
				$('.batch_no').val('');
				$('.expiry').val(''); 
				$('.current').val('');
            break;

        }

});

var counter=1;
$(document).on('click','#add_more', function() {
	var newCounter=counter-1;
 	if($('#product-'+newCounter).val()==''){
		alert('Please Enter Data In First Row');
		$('#product_id-'+newCounter).val('');
		$('#batch_no-'+newCounter).val('');

		$('#qty_issue-'+newCounter).val('');
		$('#current-'+newCounter).val('');
		$('#expiry-'+newCounter).val('');
		return false;
	}else{ 
		addMoreProductHtml()
	}
});

function addMoreProductHtml(){ 
	 
	$("#productArea")
		.append($('<tr id="row'+counter+'">').attr({'id':'orderRowNew_'+counter,'class':'labAddMoreRows'})
			.append($('<td class="tdLabel ">').append($('<input>').attr({'style':'text-align:left','id':'product-'+counter,'class':'textBoxExpnd validate[required,custom[mandatory-enter]] product','type':'text','fieldno':counter,'name':'data[product]['+counter+']'})))
			.append($('<input>').attr({'id':'product_id-'+counter,'class':'textBoxExpnd product_id','type':'hidden','fieldno':counter,'name':'data[product_id]['+counter+']'}))
			//.append($('<span>').attr({'class':'orderText','id':'orderText_'+counter,'style':'float:right; cursor: pointer;','title':'Order Detail'}).append($('<strong>...</strong>')))
			//.append($('<td class="tdLabel ">').append($('<input>').attr({'style':'text-align:left','id':'batch_no-'+counter,'class':'textBoxExpnd validate[required,custom[mandatory-enter]] batch_no','type':'text','name':'data[batch_no]['+counter+']'})))
			.append($('<td class="tdLabel ">').append($('<input>').attr({'style':'text-align:left','id':'qty_issue-'+counter,'autocomplete':'off','class':'textBoxExpnd validate[required,custom[mandatory-enter]] qty_issue','type':'text','name':'data[issue_qty]['+counter+']'})))
			.append($('<td class="tdLabel ">').append($('<input>').attr({'style':'text-align:left','id':'current-'+counter,'class':'textBoxExpnd validate[required,custom[mandatory-enter]] current','type':'text','readonly':'readonly','name':'data[current_stock]['+counter+']'})))
			//.append($('<td class="tdLabel ">').append($('<input>').attr({'style':'text-align:left','id':'expiry-'+counter,'class':'textBoxExpnd validate[required,custom[mandatory-enter]] expiry','type':'text','name':'data[expiry]['+counter+']'})))
    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
					.attr({'class':'removeButton','id':'removeButton_'+counter,'field':counter,'title':'Remove current row'}).css('float','right')))
			)	 	
	 counter++;
 }

$(document).on('click','.removeButton',function(){
	var fieldno = $(this).attr('field');
	$("#orderRowNew_"+fieldno).remove(); 
});

$(document).on('keyup','.qty_issue',function(){
	var id = $(this).attr('id');
	var splittedId = id.split("-");
	var curStock = parseInt($("#current-"+splittedId[1]).val());
	var quantity = parseInt($(this).val());
	if(quantity > curStock){
		alert("Entered quantity exceeding Current Stock");
		$(this).val('');
		$(this).focus(); 
	}
});

$(document).on('input','.qty_issue',function(){
	if (/[^0-9]/g.test(this.value))
	{
		 this.value = this.value.replace(/[^0-9]/g,'');
	}
});
</script>
