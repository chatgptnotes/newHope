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
		<?php echo __('Medical Requisition - Add', true); ?>
	</h3>
	<span><?php  echo $this->Html->link(__('Back'), array('action' => 'medical_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('MedicalRequisition');?>
<input type="hidden" value="1"
	id="no_of_fields" />
<table>
	<tr>
		<!--	<td>Replacement Slip No.: </td>
    <TD >
    	<input name="replacement_number" id="replacement_number" type="text" readonly="true" value="<?php echo $replacement_number;?>"/>
    </TD>-->
		<?php
		?>
		<td width="180" class="tdLabel"><?php echo __('Medical Requisition for:'); ?>
		</td>
		<td width="150"><input type="radio" value="Room"
			name="requisition_for" class="requisition_selector" checked='checked'>
			<?php echo __("Room");?></td>

		<td width="190">Or<input type="radio" value="OR"
			name="requisition_for" class="requisition_selector"> <?php echo __("OR");?>
		</td>
		<td width="190">Or<input type="radio" value="Exam Room"
			name="requisition_for" class="requisition_selector"> <?php echo __("Exam Room");?>
		</td>
		<td width="190">Or<input type="radio" value="other"
			name="requisition_for" class="requisition_selector"> <?php echo __("Other");?>
		</td>

	</tr>
	<tr>
		<td width="180" class="tdLabel">&nbsp;</td>
		<td width="180" class="tdLabel"><?php
		echo $this->Form->input('MedicalRequisition.ward',
                                array('id' => 'ward', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select Room','options'=>$wards,'div'=>false,'class'=>'requisition_option','style'=>"display:block;"));
               ?>
		</td>
		<td width="190"><?php
		echo $this->Form->input('MedicalRequisition.ot',
                                array('id' => 'ot', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select OR','options'=>$ot,'div'=>false,'class'=>'requisition_option'));
               ?>
		</td>
		<td width="190"><?php
		echo $this->Form->input('MedicalRequisition.chamber',
                                array( 'id' =>'chamber', 'label'=> false,
                                            'div' => false, 'error' => false,'empty'=>'Please Select Exam Room','options'=>$chambers,'div'=>false,'class'=>'requisition_option'));
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
<!--
<table id="subdepartment" style="display:none">
  <td width="180" class="tdLabel"><?php //echo __('Sub Specilty:'); ?></td>
			<td width="150">
				<?php
				//	 echo $this->Form->input('MedicalRequisition.sub_department_id', array( 'id' => 'sub_department_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select', 'div'=>false));?>
			</td>

			<td width="190"></td>

   </tr>
</table>-->
<table cellspacing="1" cellpadding="0" border="0" id="item-row"
	class="tabularForm">

	<tr class="row_title">

		<th align="center" style="text-align: center;"><?php echo __('Sr.', true); ?>
		</th>
		<th align="center" style="text-align: center;" width="16%"><?php echo   __('Item Category') ; ?><font
			color="red">*</font></th>
		<th align="center" style="text-align: center;" width="16%"><?php echo   __('Item Name') ; ?><font
			color="red">*</font></th>
		<th align="center" style="text-align: center;" width="29%"><?php echo  __('Date') ; ?><font
			color="red">*</font>
		</th>
		<th align="center" style="text-align: center;" width="2%"><?php echo  __('Quantity') ; ?><font
			color="red">*</font>
		</th>
		<th align="center" style="text-align: center;" width="5%"><?php echo  __('Received Date') ; ?>
		</th>
		<th align="center" style="text-align: center;" width="2%"><?php echo  __('Received Quantity') ; ?>
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

	<tr id="row1">
		<td align="center" class="sr_number">1</td>
		<td align="center"><input name="category[]" id="category1" type="text"
			class="textBoxExpnd validate[required,custom[name]] category"
			tabindex="6" value="" fieldNo='1' style="width: 60%" /> <input
			name="category_id[]" id="category_id1" type="hidden" value="" />
		</td>
		<td align="center"><input name="item_name[]" id="item_name1"
			type="text"
			class="textBoxExpnd validate[required,custom[name]] item_name"
			tabindex="6" value="" fieldNo='1' style="width: 60%" /> <input
			name="item_id[]" id="item_id1" type="hidden" value="" />
		</td>
		<td align="center"><input name="date[]" id="date1" type="text"
			class="textBoxExpnd validate[required,custom[mandatory-date]] date"
			tabindex="6" value="" fieldNo='1' style="width: 70%" />
		</td>
		<td align="center"><input name="qty[]" id="qty1" type="text"
			class="textBoxExpnd validate[required,custom[number]]" tabindex="6"
			value="" "  fieldNo='1' style="width: 60%" />
		</td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"><input name="used_quantity[]" id="used_quantity1"
			type="text" class="textBoxExpnd validate[custom[number]]"
			tabindex="6" value="" fieldNo='1' style="width: 60%" />
		</td>
		<td align="center"><input name="return_date[]" id="return_date1"
			type="text" class="textBoxExpnd date" tabindex="6" value=""
			fieldNo='1' style="width: 70%" />
		</td>
		<td align="center"><input name="return_quantity[]"
			id="return_quantity1" type="text"
			class="textBoxExpnd validate[custom[number]]" tabindex="6" value=""
			fieldNo='1' style="width: 60%" />
		</td>
		<td align="center"><a href="#this" id="delete row"
			onclick="deletRow(1);"><?php echo $this->Html->image('/img/cross.png');?>
		</a>
		</td>
	</tr>

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

           field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[name]] item_name"  tabindex="6" value=""  fieldNo="'+number_of_field+'"  style="width:70%"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"   value=""/> </td>';

		     field += '<td align="center" valign="middle"><input name="date[]" id="date'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[mandatory-date]]"  tabindex="8" value="" fieldNo="'+number_of_field+'" style="width:70%"/></td>';

		   field += '<td align="center" valign="middle"><input name="qty[]" id="qty'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[number]]"  tabindex="7" value="" style="width:60%"/></td>';

           field += '<td align="center" valign="middle"> </td>';

           field += '<td valign="middle" style="text-align:center;">   </td>';

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

function deletRow(id){
	 var number_of_field = parseInt($("#no_of_fields").val());
	 if(number_of_field ==1){
	 	alert("Sorry! single row can't Delete.");
		return;
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
/*  $('#patient_centric_department_id').live('change',function()
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
</script>
