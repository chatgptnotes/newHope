<div class="inner_title">
<?php //echo $this->element('store_menu');?>
	<h3>
		<?php echo __('Add Contract', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action'=>'department_store'), array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>
	<div class="clr ht5"></div>
</div>
<?php //debug($contracts);?>
<div class="clr ht5"></div>

<?php if(!empty($contracts)) { ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td>
	<table>
		<td class="tdLabel2"><font style="font-weight:bold;">Contract Name: </font> 
			<?php //echo $this->Form->input('name',array('type'=>'text','value'=>$contracts['Contract']['name'],'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'disabled'=>'disabled')); 
				echo $contracts['Contract']['name'];
			?>
		</td>
	
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Contract Type: </font>
			<?php //echo $cont_type;?>
			<?php $cont_type = array('1'=>'Enterprise ('.$this->Session->read('facility').")",'2'=>'Company','3'=>'Facility','4'=>'Department');
			 if(array_key_exists($contracts['Contract']['contract_type'], $cont_type))
			 {
				echo $cont_type[$contracts['Contract']['contract_type']]; 
			 }
			?>
			
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier: </font>
			<?php //echo $this->Form->input('supplier',array('type'=>'text','class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'id'=>'supplier_name','autocomplete'=>'off','value'=>$contracts['InventorySupplier']['name'],'disabled'=>'disabled'));
					//echo $this->Form->hidden('supplier_id',array('id'=>'supplier_id'));
					echo $contracts['InventorySupplier']['name'];
			?> 
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Contract Description: </font>
			<?php //echo $this->Form->input('contract_description',array('type'=>'text','rows'=>'1','div'=>false,'label'=>false,'value'=>$contracts['Contract']['descriptions'],'disabled'=>'disabled'));
				echo $contracts['Contract']['descriptions']; ?>
		</td>
	</table>
	</td>	
	</tr>
	
	
	<tr>
	<td>
	<table>
		<td class="tdLabel2"><font style="font-weight:bold;">Duration: </font>
			<?php //echo $this->Form->input('start_date',array('type'=>'text','id'=>'start_date', 'class'=>"textBoxExpnd",'div'=>false,'label'=>false,'value'=>$contracts['Contract']['start_date'],'disabled'=>'disabled'));
				echo $contracts['Contract']['start_date']." to ".$contracts['Contract']['end_date']; ?>
		</td>
		
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" colspan="3"><font style="font-weight:bold;">PO Amount in Between: </font>
			<?php //echo $this->Form->input('min_po_amount',array('type'=>'text','div'=>false,'label'=>false,'value'=>$contracts['Contract']['min_po_amount'],'disabled'=>'disabled'));
				echo $this->Number->currency( $contracts['Contract']['min_po_amount'])." to ".$this->Number->currency( $contracts['Contract']['max_po_amount']);
			
			//echo $contracts['Contract']['min_po_amount']." Rs. to ".$contracts['Contract']['max_po_amount']." Rs."; ?>
		</td>
	</table>	
	</td>		
	</tr>
</table>
<?php } else { ?>

<?php echo $this->Form->create('',array('id'=>'Add-Contract'));?>
<table cellpadding="0" cellspacing="3" border="0" width="100%">
	<tr>
		<td class="tdLabel2" width="10%">Contract Name: <font color="red">*</font>&nbsp; </td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('name',array('type'=>'text','value'=>$contracts['Contract']['name'],'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'style'=>"width:100%")); ?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" width="10%">Contract Type: <font color="red">*</font>&nbsp; </td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php $cont_type = array('1'=>'Enterprise','2'=>'Company','3'=>'Facility');
			 echo $this->Form->input('contract_type',array('type'=>'select','options'=>array('empty'=>'Please Select',$cont_type),'div'=>false,'label'=>false,'class'=>'validate[required]','style'=>"width:100%",'id'=>'ContractType'));?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td colspan="5">
			<table>
				<tr>
					<td id="EnterpriseId" style="display:none">
						Eneterprise:&nbsp; <?php echo $this->Session->read('facility');?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					
					<td id="CompanyId" style="display:none">
					Company:&nbsp; <?php echo $this->Form->input('company_id',array('type'=>'select','options'=>array('empty'=>'Select',$company),'class'=>'validate[required]','div'=>false,'label'=>false,'id'=>'company_id'));?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					
					<td id="FaciltyId" style="display:none">
					Facilty: <?php echo $this->Form->input('facility_id',array('type'=>'select','options'=>array('empty'=>'Select'),'div'=>false,'class'=>'validate[required]','label'=>false,'id'=>'facility_id'));?>
					</td>

				</tr>	
			</table>
		</td>
	</tr>
	
	<tr>
		<td class="tdLabel2" width="10%">Supplier: <font color="red">*</font>&nbsp;</td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('supplier',array('type'=>'text','class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'id'=>'supplier_name','autocomplete'=>'off','style'=>"width:100%"	));
					echo $this->Form->hidden('supplier_id',array('id'=>'supplier_id'));
			?> 
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" width="10%">Contract Description: &nbsp;</td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('descriptions',array('type'=>'text','rows'=>'1','div'=>false,'label'=>false));?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" width="10%">Start Date: <font color="red">*</font>&nbsp;</td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('start_date',array('type'=>'text','id'=>'start_date', 'class'=>"textBoxExpnd validate[required]",'div'=>false,'label'=>false));?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" width="10%">End Date: <font color="red">*</font>&nbsp;</td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('end_date',array('type'=>'text','id'=>'end_date', 'class'=>"textBoxExpnd validate[required]",'div'=>false,'label'=>false));?>
		</td>
	</tr>
	
	<tr>
		
	</tr>
	
	<tr>
		<td class="tdLabel2" width="10%">Min PO Amount: <font color="red">*</font>&nbsp;</td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('min_po_amount',array('type'=>'text','div'=>false,'label'=>false,'class'=>"textBoxExpnd validate[required]"));?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" width="10%">Max PO Amount: <font color="red">*</font>&nbsp;</td>
		<td class="tdLabel2" valign="middle" align="center">
			<?php echo $this->Form->input('max_po_amount',array('type'=>'text','div'=>false,'label'=>false,'class'=>"textBoxExpnd validate[required]"));?>
		</td>	
		
		<td colspan="6">
		
		</td>
	</tr>
</table>

<div class="clr ht5"></div>
<div class="btns">
	<?php echo $this->Form->submit(__("Submit"),array('class'=>'blueBtn','div'=>false,'label'=>false,'onclick'=>"return getValidate()"));?>
	<?php echo $this->Form->end();?>
</div>

<?php } ?>

<div class="inner_title">
	<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>
<div id="replace_container">



</div>

<script>



$(document).ready(function(){

	var contract_id = "<?php echo $this->request->params['pass'][0]; ?>";
	if(contract_id != "")
	{
		//alert(contract_id);
		$.ajax({
		  url: "<?php echo $this->Html->url(array("controller" => 'Contracts', "action" => "getProducts", "admin" => false)); ?>"+"/"+contract_id,
		  context: document.body,
		  beforeSend:function(data){
			$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				$("#replace_container").html(data).fadeIn('slow');
			}
		});	
	}
	

	
	$("#start_date").datepicker({
		showOn: "button",
		buttonImage: "/getnabh/img/js_calendar/calendar.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$("#end_date").datepicker({
		showOn: "button",
		buttonImage: "/getnabh/img/js_calendar/calendar.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#supplier_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
});



function getValidate(){  

	var valid = jQuery("#Add-Contract").validationEngine('validate');

	if(valid){
		var StartDate = document.getElementById('start_date').value;
		var EndDate = document.getElementById('end_date').value;
		
		if (StartDate == '' || EndDate == '') 
		{
			alert("Plesae enter both the dates!");
			return false;
		} 
		else 
		if((StartDate) > (EndDate))
		{
			alert("End Date should be greater than the Start Date.");
			return false;
		} 
	}
	else
	{
		return false;
	}
	
}


	

$("#ContractType").change(function()
{
	var contract_type = $(this).val(); 
	selectContract(contract_type);
	
});

function selectContract(contractType)
{
	ResetAll();
	switch(contractType)
	{
		case '1':	$("#EnterpriseId").show();	break; 
		case '2':	$("#CompanyId").show();		break;
		case '3':	$("#CompanyId").show();		break;
		default :	break;
	}
}

function ResetAll()
{
	$("#EnterpriseId").hide();
	$("#CompanyId").hide();
	$("#FaciltyId").hide();
}

$("#CompanyId").change(function(){
	company_id = $("#company_id").val();
	contract_id = parseInt($("#ContractType").val());
	if(contract_id == 3)
	{
		$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'Locations', "action" => "getLocations", "admin" => false)); ?>"+"/"+company_id,
			  context: document.body,
			  beforeSend:function(data){
				$('#busy-indicator').show();
				},
				success: function(data){
					data= $.parseJSON(data);
					$("#FaciltyId").show();	
				  	$("#facility_id option").remove();
				  	$("#facility_id").append( "<option value=''>Select</option>" );
					$.each(data, function(val, text) {
					    $("#facility_id").append( "<option value='"+val+"'>"+text+"</option>" );
					});		
					$('#busy-indicator').hide();
					
				}
			});
	}	
});


(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                },
             	"email": {
                    // Simplified, was not working in the Iphone browser
                    "regex": /^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/,
                    "alertText": "* Invalid email address"
                },
				 "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid phone number"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Numbers Only"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);



</script>