<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
 ?>
<div class="inner_title">
<h3> &nbsp; <?php echo __('OR Item Requisition - Edit', true); ?></h3>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('OtReplace', array('onsubmit' => 'return checkFormValue();'));?>  
  <input type="hidden" value="<?php echo count($data['OtReplaceDetail']);?>" id="no_of_fields"/>
 <table>
   <tr> 
    	<td width="100" class="tdLabel"><?php echo __('OR Room:'); ?><font color="red"> *</font></td>
			<td width="150">
				<?php 
					 echo $this->Form->input('OtReplace.opt_id', array('class' => 'validate[required,custom[mandatory-select]]', 'id' => 'opt_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$opts,'div'=>false,'default'=>$data['Opt']['id']));?>
			</td>
				<td width="100" class="tdLabel"><?php echo __('OR Table:'); ?></td>
			<td width="150" id="changeOptTableList">
				<?php 
					 echo $this->Form->input('OtReplace.opt_table_id', array('id' => 'opt_table_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$OptTable,'default'=>$data['OptTable']['id']));
		 ?>
			</td>
   </tr>
</table>
  
<table   cellspacing="1" cellpadding="0" border="0" id="item-row" class="tabularForm">

<tr class="row_title">
 
  <th align="center" style="text-align:center;"><?php echo __('Sr.', true); ?></th>
  <th align="center" style="text-align:center;" width="16%"><?php echo   __('Category') ; ?><font color="red">*</font></th>
   <th align="center" style="text-align:center;" width="16%"><?php echo   __('Item Name') ; ?><font color="red">*</font></th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Date') ; ?><font color="red">*</font> </th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Quantity') ; ?><font color="red">*</font> </th>
	<th align="center" style="text-align:center;" width="18%"> <?php echo  __('Recieved Date') ; ?></th>
   <th align="center" style="text-align:center;" width="2%"> <?php echo  __('Recieved Quantity') ; ?></th>
 	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Used Quantity') ; ?></th>  
 	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Instock Quantity') ; ?></th> 
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Return Date') ; ?></th>  
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Return Quantity') ;?></th>
	<th align="center" style="text-align:center;"> <?php echo  __('Action')  ;?></th>
 </tr>
 <?php
 
 	$cnt = 0;
 	foreach($data['OtReplaceDetail'] as $key=>$value){
	$cnt++;
 ?>
	<tr id="row<?php echo $cnt;?>">
	 	<td align="center" class="sr_number"><?php echo $cnt;?></td>
		<td align="center">
			<input name="category[]" id="category<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[required]"  tabindex="6" value="<?php echo $value['category']['name'] ; ?>"  fieldNo='<?php echo $cnt;?>' style="width:60%" readonly="true"/>
			 <input name="category_id[]" id="category_id<?php echo $cnt;?>" type="hidden"   value="<?php echo $value['category']['id'] ; ?>"/>
 		</td>
	 	<td align="center">
		 <input name="OtReplaceDetail[]" id="OtReplaceDetail<?php echo $cnt;?>" type="hidden"   value="<?php echo $value['id'] ; ?>"/>
		 <input name="item_name[]" id="item_name1" type="text" class="textBoxExpnd validate[required]"  tabindex="6" value="<?php echo $value['item']['name'] ; ?> "  fieldNo='1' style="width:60%" readonly="true"/>
		 
			 <input name="item_id[]" id="item_id<?php echo $cnt;?>" type="hidden"   value="<?php echo $value['item']['id'] ; ?>"/>
 		</td>
	 	<td align="center">
			<input name="date[]" id="date<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[required] date"  tabindex="6" value="<?php echo $this->DateFormat->formatDate2local($value['date'],Configure::read('date_format'),false); ?>"  fieldNo='1' style="width:70%"/>
		</td>
		<td align="center">
			<input name="qty[]" id="qty<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[required] custom[number]"  tabindex="6" value="<?php echo $value['request_quantity']; ?>"  fieldNo='<?php echo $cnt;?>' style="width:60%"/>
		</td>
		<td align="center">
			<input name="recieved_date[]" id="request_date<?php echo $cnt;?>" type="text" class="textBoxExpnd date"  tabindex="6" value="<?php echo $this->DateFormat->formatDate2local($value['recieved_date'],Configure::read('date_format'),false); ?>" fieldNo='<?php echo $cnt;?>' style="width:70%" readonly />
		</td>
		<td align="center">
			<input name="recieved_quantity[]" id="request_quantity<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value="<?php echo $value['recieved_quantity']; ?>" fieldNo='<?php echo $cnt;?>' style="width:60%" readonly />
		</td>
		<td align="center">
			<input name="used_quantity[]" id="used_quantity<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value="<?php echo $value['used_quantity']; ?>"  fieldNo='<?php echo $cnt;?>' style="width:60%"/>
		</td>
		<td align="center id="instock<?php echo $cnt;?>">
			<?php print(($value['recieved_quantity']-$value['used_quantity'])); ?>
		</td>
		<td align="center">
			<input name="return_date[]" id="return_date<?php echo $cnt;?>" type="text" class="textBoxExpnd date"  tabindex="6" value="<?php echo $this->DateFormat->formatDate2local($value['return_date'],Configure::read('date_format'),false); ?>"  fieldNo='<?php echo $cnt;?>' style="width:70%"/>
		</td>
		<td align="center">
			<input name="return_quantity[]" id="return_quantity<?php echo $cnt;?>" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="6" value="<?php echo $value['return_quantity']; ?>" fieldNo='<?php echo $cnt;?>' style="width:60%"/>
		</td>
		<td align="center">
			 <a href="#this" id="delete row" onclick="if(confirm('Are you Sure!')){deletRow(<?php echo $cnt;?>,<?php echo $value['id'];?>);}"><?php echo $this->Html->image('/img/cross.png');?></a>
		</td>
	</tr>
<?php
}
?>
</table>
  <div class="btns">
                           <input type="button" value="Add Row" class="blueBtn" onclick="addFields()"/> 
                           <input name="submit" type="submit" value="Submit" class="blueBtn"/>
						  
 <?php  echo $this->Html->link(__('Back'), array('action' => 'ot_replace_list'), array('escape' => false,'class'=>"blueBtn"));?>                     </div>
 
<?php echo $this->Form->end();?>  
                     
    
 
<script> 
function checkFormValue() {
	var itemcnt = 0;
	var itemval = "";
	var usedquant = "";
	var returnquant = "";
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
		// validation for used quantity and return quantity //
		var getUsedQuantity = $("#used_quantity"+eval(i+1)).val()?$("#used_quantity"+eval(i+1)).val():0;
		var getRecievedQuantity = $("#request_quantity"+eval(i+1)).val()?$("#request_quantity"+eval(i+1)).val():0;

		var getInstockQuantity = $("#instock"+eval(i+1)).text()?$("#instock"+eval(i+1)).text():0;
		var getReturnQuantity = $("#return_quantity"+eval(i+1)).val()?$("#return_quantity"+eval(i+1)).val():0;
		
		if(getUsedQuantity > getRecievedQuantity) {
			usedquant = "fail";
		}
		if(getReturnQuantity > getInstockQuantity) {
			returnquant = "fail";
		}
	 });
     
     if(itemval == "repeat") {
		 alert("Your item is repeating");
		 return false;
	 }
     if(usedquant == "fail") {
		 alert("Your used quantity is wrong.");
		 return false;
	 }
     if(returnquant == "fail") {
		 alert("Your return quantity is wrong.");
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
		   
           field += '<td align="center" valign="middle"><input name="recieved_date[]" id="recieved_date'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  fieldNo="'+number_of_field+'" style="width:70%" readonly /></td>';
		   
           field += '<td valign="middle" style="text-align:center;">  <input name="recieved_quantity[]" type="text" id="recieved_quantity'+number_of_field+'" class="textBoxExpnd validate[custom[number]]" tabindex="9" value="" style="width:60%" readonly /> </td>';
		 
           field += ' <td valign="middle" style="text-align:center;"><input name="used_quantity[]" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="10" value="" id="used_quantity'+number_of_field+'"  fieldNo="'+number_of_field+'" style="width:60%"/> </td>';
           
           field += ' <td valign="middle" style="text-align:center;"> </td>';
		   
		  field += '<td valign="middle" style="text-align:center;"><input name="return_date[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="return_date'+number_of_field+'" style="width:70%"/></td>';
		  
		  	  field += '<td valign="middle" style="text-align:center;"><input name="return_quantity[]" type="text" class="textBoxExpnd validate[custom[number]]"  tabindex="11" value="" id="return_quantity'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:60%"/></td>';
			   
		   //if(number_of_field>1)
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
		
function deletRow(id,dID) { 
	 var number_of_field = parseInt($("#no_of_fields").val()); 
	  if(dID != null){
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
			extraParams: {category:$("#category_id"+fieldno).val()},
			onItemSelect:function (data1) {
				var selectedId = t.attr('id');
			    var itemID = data1.extra[0];			   
				var fieldno = $("#"+selectedId).attr('fieldNo') ; 
				$("#item_id"+fieldno).val(itemID);
			  }  
		});
   });
   function deleteReplaceDetail(dID){
   	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "opts", "action" => "delete_medical_replace_detail","plugin"=>false)); ?>",
		  data: "id="+dID,
		}).done(function( msg ) {
		 	 alert(msg); 
	});
  }
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