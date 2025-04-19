<?php
echo $this->Html->script('jquery.autocomplete_pharmacy');
echo $this->Html->css('jquery.autocomplete.css');
?>
<style>
.requisition_option {
	display: none;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Medical Requisition - Edit', true); ?>
	</h3>
	<span><?php  echo $this->Html->link(__('Back'), array('action' => 'medical_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('MedicalRequisition');?>
<input
	type="hidden"
	value="<?php echo count($data['MedicalRequisitionDetail']);?>"
	id="no_of_fields" />
<table>
	<tr>
		<!--	<td width="180" class="tdLabel"><?php echo __('Patient Centric Specilty:'); ?><font color="red"> *</font></td>
			<td width="150">
			<?php
				 echo $this->Form->input('MedicalRequisition.patient_centric_department_id', array('class' => 'validate[required,custom[mandatory-select]]', 'id' => 'patient_centric_department_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$PatientCentricDepartment,'div'=>false ,"default"=>$data['MedicalRequisition']['patient_centric_department_id']));
				 ?>
			</td>-->
		<td width="180" class="tdLabel"><?php echo __('Medical Requisition for:'); ?>
		</td>


		<td width="190"><input type="radio" value="ward"
			name="requisition_for" class="requisition_selector"
			<?php if($data['MedicalRequisition']['requisition_for'] == "ward"){echo " checked=checked";}?>>Ward</td>
		<td width="190">Or<input type="radio" value="ot"
			name="requisition_for" class="requisition_selector"
			<?php if($data['MedicalRequisition']['requisition_for'] == "ot"){echo " checked=checked";}?>>
			OT
		</td>
		<td width="190">Or<input type="radio" value="chamber"
			name="requisition_for" class="requisition_selector"
			<?php if($data['MedicalRequisition']['requisition_for'] == "chamber"){echo " checked=checked";}?>>
			Chamber
		</td>
		<td width="190">Or<input type="radio" value="other"
			name="requisition_for" class="requisition_selector"
			<?php if($data['MedicalRequisition']['requisition_for'] == "other"){echo " checked=checked";}?>>
			Other
		</td>

	</tr>
	<tr>
		<td width="180" class="tdLabel">&nbsp;</td>
		<td width="180" class="tdLabel"><?php
		echo $this->Form->input('MedicalRequisition.ward',
                                array('id' => 'ward', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select ward','options'=>$wards,'div'=>false,'class'=>'requisition_option'));
               ?>
		</td>
		<td width="190"><?php
		echo $this->Form->input('MedicalRequisition.ot',
                                array('id' => 'ot', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select OT','options'=>$ot,'div'=>false,'class'=>'requisition_option'));
               ?>
		</td>
		<td width="190"><?php
		echo $this->Form->input('MedicalRequisition.chamber',
                                array( 'id' =>'chamber', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select chamber','options'=>$chambers,'div'=>false,'class'=>'requisition_option'));
               ?>
		</td>
		<td width="190"><?php
		echo $this->Form->input('MedicalRequisition.other',
                                array('id' => 'other', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$PatientCentricDepartment,'div'=>false,'class'=>'requisition_option'));
               ?>
		</td>
	</tr>
</table>

<!-- <table id="subdepartment">
  <td width="180" class="tdLabel"><?php //echo __('Sub Specilty:'); ?></td>
			<td width="150">
				<?php
					// echo $this->Form->input('MedicalRequisition.sub_department_id', array( 'id' => 'sub_department_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select', 'div'=>false,'options'=>$subdepartment,'default'=>$data['MedicalRequisition']['sub_department_id']));?>
			</td>

			<td width="190"></td>

   </tr>
</table>-->

<table cellspacing="1" cellpadding="0" border="0" id="item-row"
	class="tabularForm">

	<tr class="row_title">

		<th align="center" style="text-align: center;"><?php echo __('Sr.No.', true); ?>
		</th>
		<th align="center" style="text-align: center;" width="16%"><?php echo   __('Category Name') ; ?><font
			color="red">*</font></th>
		<th align="center" style="text-align: center;" width="16%"><?php echo   __('Item Name') ; ?><font
			color="red">*</font></th>
		<th align="center" style="text-align: center;" width="29%"><?php echo  __('Date') ; ?><font
			color="red">*</font>
		</th>
		<th align="center" style="text-align: center;" width="2%"><?php echo  __('Quantity') ; ?><font
			color="red">*</font>
		</th>
		<th align="center" style="text-align: center;" width="5%"><?php echo  __('Recieved Date') ; ?>
		</th>
		<th align="center" style="text-align: center;" width="2%"><?php echo  __('Recieved Quantity') ; ?>
		</th>
		<th align="center" style="text-align: center;" width="2%"><?php echo  __('Used Quantity') ; ?>
		</th>
		<th align="center" style="text-align: center;" width="29%"><?php echo  __('Return Date') ; ?>
		</th>
		<th align="center" style="text-align: center;" width="2%"><?php echo  __('Return Quantity') ;?>
		</th>
		<th align="center" style="text-align: center;"><?php echo  __('Action')  ;?>
		</th>
	</tr>
	<?php

	$cnt = 0;
	foreach($data['MedicalRequisitionDetail'] as $key=>$value){
	$cnt++;
	?>
	<tr id="row<?php echo $cnt;?>">
		<td align="center" class="sr_number"><?php echo $cnt;?></td>

		<td align="center"><input name="category[]" id="category1" type="text"
			class="textBoxExpnd validate[required,custom[name]]" tabindex="6"
			value="<?php echo $value['category']['name'] ; ?> " fieldNo='1'
			style="width: 60%" readonly="true" /> <input name="category_id[]"
			id="category_id1" type="hidden"
			value="<?php echo $value['category']['id'] ; ?>" />
		</td>
		<td align="center"><input name="MedicalRequisitionDetail[]"
			id="MedicalRequisitionDetail<?php echo $cnt;?>" type="hidden"
			value="<?php echo $value['id'] ; ?>" /> <input name="item_name[]"
			id="item_name1" type="text"
			class="textBoxExpnd validate[required,custom[name]]" tabindex="6"
			value="<?php echo $value['item']['name'] ; ?> " fieldNo='1'
			style="width: 60%" readonly="true" /> <input name="item_id[]"
			id="item_id<?php echo $cnt;?>" type="hidden"
			value="<?php echo $value['item']['id'] ; ?>" />
		</td>
		<td align="center"><input name="date[]" id="date<?php echo $cnt;?>"
			type="text"
			class="textBoxExpnd validate[required,custom[mandatory-date]] date"
			tabindex="6"
			value="<?php echo $this->DateFormat->formatDate2local($value['date'],Configure::read('date_format'),false); ?>"
			fieldNo='1' style="width: 70%" />
		</td>
		<td align="center"><input name="qty[]" id="qty<?php echo $cnt;?>"
			type="text" class="textBoxExpnd validate[required] custom[number]"
			tabindex="6" value="<?php echo $value['request_quantity']; ?>"
			fieldNo='<?php echo $cnt;?>' style="width: 60%" />
		</td>
		<td align="center"><?php echo $this->DateFormat->formatDate2local($value['recieved_date'],Configure::read('date_format'),false); ?>
		</td>
		<td align="center"><?php echo $value['recieved_quantity']; ?>
		</td>
		<td align="center"><input name="used_quantity[]"
			id="used_quantity<?php echo $cnt;?>" type="text"
			class="textBoxExpnd validate[custom[number]]" tabindex="6"
			value="<?php echo $value['used_quantity']; ?>"
			fieldNo='<?php echo $cnt;?>' style="width: 60%" />
		</td>
		<td align="center"><input name="return_date[]"
			id="return_date<?php echo $cnt;?>" type="text"
			class="textBoxExpnd date" tabindex="6"
			value="<?php echo $this->DateFormat->formatDate2local($value['return_date'],Configure::read('date_format'),false); ?>"
			fieldNo='<?php echo $cnt;?>' style="width: 70%" />
		</td>
		<td align="center"><input name="return_quantity[]"
			id="return_quantity<?php echo $cnt;?>" type="text"
			class="textBoxExpnd validate[custom[number]]" tabindex="6"
			value="<?php echo $value['return_quantity']; ?>"
			fieldNo='<?php echo $cnt;?>' style="width: 60%" />
		</td>
		<td align="center"><a href="#this" id="delete row"
			onclick="if(confirm('Are you Sure!')){deletRow(<?php echo $cnt;?>,<?php echo $value['id'];?>);}"><?php echo $this->Html->image('/img/cross.png');?>
		</a>
		</td>
	</tr>
	<?php
}
?>
</table>
<div class="btns">
	<input type="button" value="Add Row" class="blueBtn"
		onclick="addFields()" /> <input name="submit" type="submit"
		value="Submit" class="blueBtn" />

</div>

<?php echo $this->Form->end();?>



<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#MedicalRequisitionMedicalRequisitionForm").validationEngine();
	});


function addFields(){
  			var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		   	 field += '<td align="center" valign="middle"><input name="category[]" id="category'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[name]] category"  tabindex="6" value=""  fieldNo="'+number_of_field+'" style="width:60%"/> <input name="category_id[]" id="category_id'+number_of_field+'" type="hidden" fieldNo="'+number_of_field+'"  value=""/></td>';

           field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[name]] item_name"  tabindex="6" value=""  fieldNo="'+number_of_field+'"  style="width:60%"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"   value=""/> </td>';

		     field += '<td align="center" valign="middle"><input name="date[]" id="date'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[mandatory-date]]"  tabindex="8" value="" fieldNo="'+number_of_field+'" style="width:70%"/></td>';

		   field += '<td align="center" valign="middle"><input name="qty[]" id="qty'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[number]]"  tabindex="7" value="" style="width:60%"/></td>';

           field += '<td align="center" valign="middle"> </td>';

           field += '<td valign="middle" style="text-align:center;">    </td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="used_quantity[]" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="10" value="" id="used_quantity'+number_of_field+'" style="" fieldNo="'+number_of_field+'" style="width:60%"/> </td>';

		  field += '<td valign="middle" style="text-align:center;"><input name="return_date[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="return_date'+number_of_field+'" style="width:70%"/></td>';

		  	  field += '<td valign="middle" style="text-align:center;"><input name="return_quantity[]" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="11" value="" id="return_quantity'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:60%"/></td>';

		   if(number_of_field>1)
		     field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';

		  field +='  </tr>    ';
      	$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
		$("#recieved_date"+number_of_field).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			minDate: new Date(),

		});
		 	$("#date"+number_of_field).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',


		});
			$("#return_date"+number_of_field).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});

}

	$(".date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',


		});

function deletRow(id,dID){
	 var number_of_field = parseInt($("#no_of_fields").val());
	  if(dID){
	  	deleteReplaceDetail(dID);
	  }
	$("#row"+id).remove();
	$('.item_name'+number_of_field+"formError").remove();
	$('.date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.recieved_quantity'+number_of_field+"formError").remove();
	$('.used_quantity'+number_of_field+"formError").remove();
	$('.return_quantity'+number_of_field+"formError").remove();
	 var table = $('#item-row');
		summands = table.find('tr');

			var sr_no = 1;
			summands.each(function ()
			{
					var cell = $(this).find('.sr_number');
					cell.each(function ()
					{
						$(this).html(sr_no);
						sr_no = sr_no+1;
					});

			});
	  $("#no_of_fields").val(number_of_field-1);

}
$('.item_name').live('focus',function()
			  {
		   	var t = $(this);
		   	var selectedId = t.attr('id');
			var fieldno = $("#"+selectedId).attr('fieldNo') ;
		 $(this).autocomplete(
				"<?php echo $this->Html->url(array("controller" => "opts", "action" => "autoSearchItem", "admin" => false,"plugin"=>false)); ?>",
			{
			selectFirst: false,
			matchSubset:1,
			matchContains:1,
			autoFill:false,
			extraParams: {category:$("#category_id"+fieldno).val(),model:"MedicalItem"},
			onItemSelect:function (data1) {
				var selectedId = t.attr('id');
			    var itemID = data1.extra[0];
				var fieldno = $("#"+selectedId).attr('fieldNo') ;
				$("#item_id"+fieldno).val(itemID);
			  }
		});
   });

 $('.category').live('focus',function()
			  {
		   	var t = $(this);
		   	var selectedId = t.attr('id');
			var fieldno = $("#"+selectedId).attr('fieldNo') ;
		 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OtItemCategory","name", "admin" => false,"plugin"=>false)); ?>",
			{
			selectFirst: false,
			matchSubset:1,
			matchContains:1,
			autoFill:false,

			onItemSelect:function (data1) {
				var fieldno = $("#"+selectedId).attr('fieldNo') ;
				$("#category_id"+fieldno).val(data1.extra[0]);
			  }
		});
   });
   function deleteReplaceDetail(dID){
   	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "opts", "action" => "delete_medical_requisition_detail","plugin"=>false)); ?>",
		  data: "id="+dID,
		}).done(function( msg ) {
		 	 alert(msg);
	});
  }
    /* $('#patient_centric_department_id').live('change',function()
			  {
			  $("#sub_department_id > option").remove();
			   $("#sub_department_id").append("<option value=''>Please Select</option>");
			  if($(this).val()!=""){
					$.ajax({
			  				url: "<?php echo $this->Html->url(array("controller" => "opts", "action" => "get_sub_department","plugin"=>false)); ?>/"+$(this).val(),
					}).done(function ( data ) {
						$("#subdepartment").show();
			  			 $("#sub_department_id").append(data);
					});
				}
   });*/

  $(".requisition_selector").click(function(){
        $(".requisition_option").css("display","none");
        var position = $(this).position();
        switch($(this).val())
            {
                case 'ward':
                 $("#ward").css("display","block");

                break;
                case 'ot':
                 $("#ot").css("display","block");

                break;
                case 'chamber':

                    $("#chamber").css("display","block");

                break;
                case 'other':
                      $("#other").css("display","block");

                break;
                default:


                break;

            }

    });
    <?php if($data['MedicalRequisition']['requisition_for'] == "ward"){?>
        $("#ward").css("display","block");
        $("#ward").val('<?php echo $data['MedicalRequisition']['requister_id'];?>');
    <?php } ?>
     <?php if($data['MedicalRequisition']['requisition_for'] == "ot"){?>
        $("#ot").css("display","block");
        $("#ot").val('<?php echo $data['MedicalRequisition']['requister_id'];?>');
    <?php } ?>
     <?php if($data['MedicalRequisition']['requisition_for'] == "other"){?>
        $("#other").css("display","block");
        $("#other").val('<?php echo $data['MedicalRequisition']['requister_id'];?>');
    <?php } ?>
     <?php if($data['MedicalRequisition']['requisition_for'] == "chamber"){?>
        $("#chamber").css("display","block");
        $("#chamber").val('<?php echo $data['MedicalRequisition']['requister_id'];?>');
    <?php } ?>
</script>
