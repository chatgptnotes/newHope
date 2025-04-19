<style>.row_action img{float:inherit;}</style>
<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');

?>
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
 <div class="inner_title">
    <h3> &nbsp; <?php echo __('Specialty Management - Edit Outward', true); ?></h3>
    <span><?php
   echo $this->Html->link(__('Back'), array('action' => 'outward_list'), array('escape' => false,'class'=>'blueBtn'));
   ?></span>
</div>
<input type="hidden" value="<?php echo count($data['InventoryOutwardDetail']);?>" id="no_of_fields"/>
 <?php echo $this->Form->create('InventoryOutward');?>
  <div class="clr ht5"></div>
<div class="clr ht5"></div>
                  	<div class="row_action">Date<font color="red">*</font>:&nbsp;<input type="text" id="date" name="date" class="validate[required]" value="<?php echo $this->DateFormat->formatDate2Local($data['InventoryOutward']['date'],Configure::read('date_format'));?>" >
	               </div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
  <div class="clr ht5"></div>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
                  	<tr>
               	  	  	  <th width="40" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="120" align="center" valign="top"  style="text-align:center;">Product Name</th>
                          <th width="112" align="center" valign="top"  style="text-align:center;">Product Code</th>
                          <th width="80" align="center" valign="top"  style="text-align:center;">Manufacturer</th>
                          <th width="20" align="center" valign="top"  style="text-align:center;">Pack</th>

                          <th width="60" valign="top" style="text-align:center;">Total Stock</th>
                          <th width="60" valign="top" style="text-align:center;">Outward</th>
                          <th width="1"></th>
                     	</tr>
            <?php
                $count=1;
                $pharmacyItem = Classregistry::init('PharmacyItem');
                foreach($data['InventoryOutwardDetail'] as $key=>$value){
                    	$item = $pharmacyItem->findById($value['item_id']);

            ?>
                        <tr id="row<?php echo $count;?>">
                          <td align="center" valign="middle" class="sr_number" width="20"><input name="outwarddetail[]" id="outwarddetail'+number_of_field+'" type="hidden"   value="<?php echo $value['id'];?>"/><?php echo $count;?></td>
                          <td align="center" valign="middle" width="200">
                                <input name="item_name[]" id="item_name1" type="text" class="textBoxExpnd validate[required] item_name"  value="<?php echo $item['PharmacyItem']['name'];?>" tabindex="6" value="" style="width:70%;"  fieldNo='<?php echo $count;?>' onkeyup="checkIsItemRemoved(this)"/>

						  </td>
                           <td align="center" valign="middle"><input name="item_code[]" type="text" class="textBoxExpnd validate[required] item_code" id="item_code<?php echo $count;?>" tabindex="1" value="<?php echo $item['PharmacyItem']['item_code'];?>" style="width:80%;" fieldNo="<?php echo $count;?>" onkeyup="checkIsItemRemoved(this)"/></td>
                          <td align="center" valign="middle" id="manufacturer<?php echo $count;?>" style="text-align:center;">&nbsp;<?php echo $item['PharmacyItem']['manufacturer'];?></td>
                          <td align="center" valign="middle" id="pack<?php echo $count;?>" style="text-align:center;">&nbsp;<?php echo $item['PharmacyItem']['pack'];?></td>
                          <td align="center" valign="middle" id="stock<?php echo $count;?>" style="text-align:center;">&nbsp;<?php echo $value['current_stock'];?></td>

                         <td width="60" colspan="2"><input name="preoutward[]" type="text" id="outward<?php echo $count;?>" class="textBoxExpnd validate[required,custom[number]]" tabindex="9" value="<?php echo $value['outward'];?>" style="width:33%;" /></td>
                            </td>

                          </tr>

            <?php
            $count++;
                }
            ?>

</table>

 <div class="clr ht5"></div>

				      <div align="right" >
				   <input name="" type="button" value="Add More" class="blueBtn" tabindex="36" onclick="addFields()"/><input name="" type="button" value="Remove" class="blueBtn" tabindex="36" id="remove-btn"  style="display:none" onclick="removeRow()"/>
				  	 </div>
            <div class="clr ht5"></div>
              <div class="btns">
                              <input name="submit" type="submit" value="Submit" class="blueBtn" tabindex="37" id="submitButton"/>
							   

                  </div>
 <?php echo $this->Form->end();?>
 <script>

$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "/img/js_calendar/calendar.gif",
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
      if(number_of_field==1){
	 	alert("Single row can't delete.");
	 	return false;
		}

	$("#row"+id).remove();
 $("#no_of_fields").val(number_of_field-1);
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
					if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}

}
function addFields(){
		   var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number" width="20">'+number_of_field+'</td>';
           field += '<td align="center" valign="middle" width="200"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"   value=""/>  </td>';
           field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_code"  tabindex="6" value="" style="width:80%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/></td>';

           field += '<td align="center" valign="middle" id="manufacturer'+number_of_field+'" style="text-align:center;">&nbsp;</td>';
           field += '<td align="center" valign="middle" id="pack'+number_of_field+'" style="text-align:center;">&nbsp;</td>';
           field += '<td align="center" valign="middle" id="stock'+number_of_field+'" style="text-align:center;">&nbsp;</td>';
           field += '<td width="60"><input name="outward[]" type="text" id="outward'+number_of_field+'" class="textBoxExpnd validate[required,custom[number]]" tabindex="9" value="" style="width:65%;" /></td>';
           if(number_of_field>1)
		     field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><img title="delete row" alt="Remove Item" src="/img/cross.png" ></a></td>';

		  field +='  </tr>    ';
	    $("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
}


 $('.item_name').live('focus',function()
			  {

			  	  var t = $(this);
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>",
		{
			selectFirst: false,
			matchSubset:1,
			matchContains:1,
			autoFill:false,
			extraParams: {supplierID:$("#party_id").val() },
			onItemSelect:function (data1) {
			    selectedId = t.attr('id');
			    var itemID = data1.extra[0];
                var fieldno = $("#"+selectedId).attr('fieldNo') ;
                if(!repeatItem(itemID)){
                    alert("This Item is already in list.");
                    	$("#item_name"+fieldno).val("");
            			$("#item_id"+fieldno).val("");
            			$("#item_code"+fieldno).val("");
                        $("#manufacturer"+fieldno).html("");
            		 	$("#pack"+fieldno).html("");
                    return false;
                }

				$("#item_id"+fieldno).val(itemID);
    		 	var currentField = $(this);
				$.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item","inventory" => true,"plugin"=>false)); ?>",
				  data: "item_id="+itemID,
				}).done(function( msg ) {
					var ItemDetail = jQuery.parseJSON(msg);
                	$("#pack"+fieldno).html(ItemDetail.PharmacyItem.pack);
                    $("#manufacturer"+fieldno).html(ItemDetail.PharmacyItem.manufacturer);
                    $("#stock"+fieldno).html(ItemDetail.PharmacyItem.stock);
                    $("#item_code"+fieldno).val(ItemDetail.PharmacyItem.item_code);
			});

			},
		}
	);
			  });


 $('.item_code').live('focus',function()
			  {
			  if($("#party_id").val()==""){
			  	alert("Please select Supplier.");
				setTimeout(function() { $("#party_name").focus(); }, 10);
				return false;
			  }
			  	  var t = $(this);
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "autocomplete_item","item_code","inventory" => true,"plugin"=>false)); ?>",
		{
			selectFirst: false,
			matchSubset:1,
			matchContains:1,
			autoFill:false,
			extraParams: {supplierID:$("#party_id").val() },
			onItemSelect:function (data1) {
			    selectedId = t.attr('id');
			    var itemID = data1.extra[0];
				var fieldno = $("#"+selectedId).attr('fieldNo') ;
                if(!repeatItem(itemID)){
                    alert("This Item is already in list.");
                    	$("#item_name"+fieldno).val("");
            			$("#item_id"+fieldno).val("");
            			$("#item_code"+fieldno).val("");
                        $("#manufacturer"+fieldno).html("");
            		 	$("#pack"+fieldno).html("");
                    return false;
                }
				$("#item_id"+fieldno).val(itemID);

    		 	var currentField = $(this);
				$.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item","inventory" => true,"plugin"=>false)); ?>",
				  data: "item_id="+itemID,
				}).done(function( msg ) {
					var ItemDetail = jQuery.parseJSON(msg);
                	$("#pack"+fieldno).html(ItemDetail.PharmacyItem.pack);
                    $("#manufacturer"+fieldno).html(ItemDetail.PharmacyItem.manufacturer);
                    $("#stock"+fieldno).html(ItemDetail.PharmacyItem.stock);
                     $("#item_name"+fieldno).val(ItemDetail.PharmacyItem.name);
			});

			},
		}
	);
			  });


function checkIsItemRemoved(obj){
	var fieldno = $(obj).attr('fieldNo') ;
	if($.trim(obj.value.length)==0){
			$("#item_name"+fieldno).val("");
			$("#item_id"+fieldno).val("");
			$("#item_code"+fieldno).val("");
            $("#manufacturer"+fieldno).html("");
		 	$("#pack"+fieldno).html("");
    }

	}

function repeatItem(id){
        var flag = false;
		var fields = $('input[name="item_id[]"]').serializeArray();
        jQuery.each(fields, function(i, field){
        	if(parseInt(field.value) == parseInt(id)){
				flag = true;
			}
    	});
		if(flag){
            return false;
        }else{
            return true;
        }
  }
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryOutwardInventoryOutwardEditForm").validationEngine();
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

				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                },

            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);
 </script>