<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
  
?>
<div class="inner_title">
<h3> &nbsp; <?php echo __('OR Item Requisition - Add', true); ?></h3>
<span><?php  echo $this->Html->link(__('Back'), array('action' => 'ot_replace_list'), array('escape' => false,'class'=>"blueBtn"));?>                     </div></span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('OtReplace', array('onsubmit' => 'return checkFormValue();'));?>  
  <input type="hidden" value="1" id="no_of_fields"/>
 <table>
   <tr>
   <!--	<td>Replacement Slip No.: </td>
    <TD >
    	<input name="replacement_number" id="replacement_number" type="text" readonly="true" value="<?php echo $replacement_number;?>"/>
    </TD>-->
	<?php
 	?>
	<td width="100" class="tdLabel"><?php echo __('OR Room:'); ?><font color="red"> *</font></td>
			<td width="150">
				<?php 
					 echo $this->Form->input('OtReplace.opt_id', array('class' => 'validate[required,custom[mandatory-select]]', 'id' => 'opt_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$opts,'div'=>false));?>
			</td>
				<td width="100" class="tdLabel"><?php echo __('OR Table:'); ?></td>
			<td width="150" id="changeOptTableList">
				<?php 
					 echo $this->Form->input('OtReplace.opt_table_id', array('id' => 'opt_table_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));?>
			</td>
			<td width="100"  class="tdLabel">&nbsp;</td>
			<td width="190"></td>
	  
   </tr>
</table>
  
<table   cellspacing="1" cellpadding="0" border="0" id="item-row" class="tabularForm">

<tr class="row_title">
 
  <th align="center" style="text-align:center;"><?php echo __('Sr.', true); ?></th>
  <th align="center" style="text-align:center;" ><?php echo   __('Category') ; ?><font color="red">*</font></th>
   <th align="center" style="text-align:center;" ><?php echo   __('Item Name') ; ?><font color="red">*</font></th>
	<th align="center" style="text-align:center;" width="22%"> <?php echo  __('Date') ; ?><font color="red">*</font> </th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Quantity') ; ?><font color="red">*</font> </th>
	<!--<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Recieved Date') ; ?></th>
    <th align="center" style="text-align:center;" width="2%"> <?php echo  __('Recieved Quantity') ; ?></th>-->
 	 <!--<th align="center" style="text-align:center;" width="2%"> <?php //echo  __('Used Quantity') ; ?></th>  
	<th align="center" style="text-align:center;" width="22%"> <?php //echo  __('Return Date') ; ?></th>  
	<th align="center" style="text-align:center;" width="2%"> <?php //echo  __('Return Quantity') ;?></th>-->
	<th align="center" style="text-align:center;" width="10%"> <?php echo  __('Action')  ;?></th>
 </tr>
 
	<tr id="row1">
	 	<td align="center" class="sr_number">1</td>
		
	 	<td align="center">
			<input name="category[]" id="category1" type="text" class="textBoxExpnd validate[required] category"  tabindex="6" value=""  fieldNo='1' style="width:90%"/>
			 <input name="category_id[]" id="category_id1" type="hidden"   value=""/>
 		</td>
	 	<td align="center">
			<input name="item_name[]" id="item_name1" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value=""  fieldNo='1' style="width:90%"/>
			 <input name="item_id[]" id="item_id1" type="hidden"   value=""/>
 		</td>
	 	<td align="center">
			<input name="date[]" id="date1" type="text" class="textBoxExpnd validate[required] date"  tabindex="6" value=""  fieldNo='1' style="width:70%"/>
		</td>
		<td align="center">
			<input name="qty[]" id="qty1" type="text" class="textBoxExpnd validate[required,custom[number]]"  tabindex="6" value="" "  fieldNo='1' style="width:60%"/>
		</td>
		<!--  <td align="center">
			<input name="recieved_date[]" id="request_date1" type="text" class="textBoxExpnd date"  tabindex="6" value="" fieldNo='1' style="width:70%" readonly />
		</td>
		<td align="center">
			<input name="recieved_quantity[]" id="request_quantity1" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value="" fieldNo='1' style="width:60%" readonly />
		</td>-->
		<!--  <td align="center">
			<input name="used_quantity[]" id="used_quantity1" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value=""  fieldNo='1' style="width:60%"/>
		</td>
		<td align="center">
			<input name="return_date[]" id="return_date1" type="text" class="textBoxExpnd date"  tabindex="6" value=""  fieldNo='1' style="width:70%"/>
		</td>
		<td align="center">
			<input name="return_quantity[]" id="return_quantity1" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value="" fieldNo='1' style="width:60%"/>
		</td>-->
		<td align="center">
			 <!-- <a href="#this" id="delete row" onclick="deletRow(1);"><?php //echo $this->Html->image('/img/cross.png');?></a>-->
		</td>
	</tr>

</table>
  <div class="btns">
                           <input type="button" value="Add Row" class="blueBtn" onclick="addFields()"/> 
                           <input name="submit" type="submit" value="Submit" class="blueBtn"/>
						  
 
 
<?php echo $this->Form->end();?>  
                     
    
 
<script> 

function checkFormValue() {
	var itemcnt = 0;
	var itemval = "";
	var itemNameArray = document.getElementById("OtReplaceOtReplacementForm").elements["item_id[]"];
	$('input[name="item_id[]"]').each(function(i){ 
		for (var j = 0; j < itemNameArray.length; j++) {
			if(itemNameArray[j].value != "") {
			    if($(this).val() == itemNameArray[j].value) {
			    	itemcnt++;
			    }
			}
		}
		if(itemcnt > 1) {
			itemval = "repeat";
		}itemcnt=0;
	 });
     
     if(itemval == "repeat") {
		 alert("Your item is repeating");
		 return false;
	 }
	 
}
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#OtReplaceOtReplacementForm").validationEngine();
	});


    
function addFields(){
  			var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		   
		   	 field += '<td align="center"> <input name="category[]" id="category'+number_of_field+'" type="text" class="textBoxExpnd validate[required] category"  tabindex="6" value="" fieldNo="'+number_of_field+'"  style="width:60%"/> <input name="category_id[]" id="category_id'+number_of_field+'"" type="hidden"   value=""/> </td>';
			 
           field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value=""  fieldNo="'+number_of_field+'"  style="width:60%"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"   value=""/> </td>';
		   
		     field += '<td align="center" valign="middle"><input name="date[]" id="date'+number_of_field+'" type="text" class="textBoxExpnd validate[required]"  tabindex="8" value="" fieldNo="'+number_of_field+'" style="width:70%"/></td>';
			 
		   field += '<td align="center" valign="middle"><input name="qty[]" id="qty'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[number]]"  tabindex="7" value="" style="width:60%"/></td>';
		   
           //field += '<td align="center" valign="middle"><input name="recieved_date[]" id="recieved_date'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  fieldNo="'+number_of_field+'" style="width:70%" readonly /></td>';
		   
           //field += '<td valign="middle" style="text-align:center;">  <input name="recieved_quantity[]" type="text" id="recieved_quantity'+number_of_field+'" class="textBoxExpnd validate[custom[number]]" tabindex="9" value="" style="width:60%" readonly /> </td>';
		 
           // field += ' <td valign="middle" style="text-align:center;"><input name="used_quantity[]" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="10" value="" id="used_quantity'+number_of_field+'" style="" fieldNo="'+number_of_field+'" style="width:60%"/> </td>';
		   
		  // field += '<td valign="middle" style="text-align:center;"><input name="return_date[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="return_date'+number_of_field+'" style="width:70%"/></td>';
		  
		  //	  field += '<td valign="middle" style="text-align:center;"><input name="return_quantity[]" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="11" value="" id="return_quantity'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:60%"/></td>';
			   
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
	 //if(number_of_field ==1){
	 //	alert("Sorry! single row can't Delete.");
	 //	return;
	 //}
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
			extraParams: {category:$("#category_id"+fieldno).val()},
			onItemSelect:function (data1) {
				var selectedId = t.attr('id');
			    var itemID = data1.extra[0];			   
				var fieldno = $("#"+selectedId).attr('fieldNo') ; 
				$("#item_id"+fieldno).val(itemID); 
			  }  
		});
   });
   
  $("#opt_id").change(function() { 
          $('#busy-indicator1').show();
          var data = 'opt_id=' + $('#opt_id').val() ; 
          // for surgery category name field //
          $.ajax({url: "<?php echo $this->Html->url(array("controller"=>"OtItems","action" => "getOptTableList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) {  $('#changeOptTableList').show(); $('#changeOptTableList').html(html);  $('#busy-indicator1').hide();  } });

         }); 
		 
 $('.category').live('focus',function()
			  {  
		   var t = $(this);
		 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OtItemCategory","name", "admin" => false,"plugin"=>false)); ?>",
			{
			selectFirst: false,
			matchSubset:1,
			matchContains:1,
			autoFill:false, 
			onItemSelect:function (data1) {
				var selectedId = t.attr('id');
			    var itemID = data1.extra[0];			   
				var fieldno = $("#"+selectedId).attr('fieldNo') ; 
				$("#category_id"+fieldno).val(itemID); 
			  }  
		});
   });
</script>