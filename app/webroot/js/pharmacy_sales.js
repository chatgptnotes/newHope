 function checkIsItemRemoved(obj){
	var fieldno = $(obj).attr('fieldNo') ;
	if($.trim(obj.value.length)==0){

			$("#item_name"+fieldno).val("");
			$("#item_id"+fieldno).val("");
			$("#item_code"+fieldno).val("");
		 	$("#pack"+fieldno).val("");
            $("#manufacturer"+fieldno).val("");
			$("#mrp"+fieldno).val("");
			$("#rate"+fieldno).val("");
			$("#stockQty"+fieldno).val("");
			$("#stockWithLoose_"+fieldno).val("");
			$("#batch_number"+fieldno).val("");
		 	$("#expiry_date"+fieldno).val("");
			$("#qty"+fieldno).val("");

			$("#value"+fieldno).val("");
			$("#free"+fieldno).val("");
	}

}

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
				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                },
				"future":{
				 	"alertText": "Expiry Date should be future date."
				}
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

function addFields(){

		   var number_of_field = parseInt($("#no_of_fields").val())+1;

		 $(".formError").remove();
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		     field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_code"  tabindex="6" value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"  tabindex="6" value="" style="width:80%;"/></td>';
           field += '<td align="center" valign="middle"  width="185"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_name"  tabindex="6" value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/> <a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"></a></td>';
field += '<td align="center" valign="middle"><input name="manufacturer[]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  style="width:100%;" autocomplete="off" readonly="true"/></td>';
		   field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7" value=""  style="width:100%;" readonly="true"/></td>';

            field += '<td align="center" valign="middle"><input name="batch_no[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  tabindex="8" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"/></td>';
			  field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required,future[NOW]] expiry_date"  tabindex="8" value=""  style="width:80%;" autocomplete="off"/></td>';

		   field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required,number]"  tabindex="12" value="" id="mrp'+number_of_field+'" style="width:100%;" readonly="true"/></td>';
		   //field += '<td valign="middle" style="text-align:center;"><input name="tax[]" type="text" class="textBoxExpnd"  tabindex="10" value="" id="tax'+number_of_field+'" style="width:80%;" readonly="true"/></td>';
	   	//	field += '<td valign="middle" style="text-align:center;"><input name="vat[]" type="text" class="textBoxExpnd"  tabindex="10" value="" id="vat'+number_of_field+'" style="width:80%;" readonly="true"/></td>';

		 field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,number,funcCall[checkstock]]"  tabindex="10" value="" id="qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="0" id="stockQty'+number_of_field+'"></td>';
           field += '<td valign="middle" style="text-align:center;"><input name="rate[]" type="text" class="textBoxExpnd validate[required,number]"  tabindex="13" value="" id="rate'+number_of_field+'" style="width:100%;" readonly="true" /></td>';
           field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'"  tabindex="14" value=""  style="width:100%;"/></td> ';
		   field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><img title="delete row" alt="Remove Item" src="/DrmHope/img/icons/cross.png" ></a></td>';
		  field +='  </tr>    ';
      	$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);

			if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}

}
function removeRow(){
$(".formError").remove();
 	var number_of_field = parseInt($("#no_of_fields").val());
	$('.item_code'+number_of_field+"formError").remove();
	$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
	$('.expiry_date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();

	$('.rate'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
    $("#no_of_fields").val(number_of_field-1);
   $("#row"+number_of_field).remove();

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

	/* for auto populate the data */
function selectDoctor(li) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		$("#doctor_id").val(itemID);


}
	/* for auto populate the data */
function selectPatient(li,selectedId) {
	if( li == null ) return alert("No match!");

		/*$("#no_of_fields").val("1");
		var itemID = li.extra[0];
		$("#person_id").val(itemID);
		if(li.extra[1] == "lookup_name"){
			$("#party_code").val(li.extra[0]);

		}else{
			$("#party_name").val(li.extra[0]);
				}*/
		getPatientPrescription($("#party_code").val(),"","Note");

}


function deletRow(id){
	//$("#row"+id).find("input").remove();
	$("#row"+id).remove();
	$(".formError").remove();
	 var number_of_field = parseInt($("#no_of_fields").val());
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
					$('.item_name'+number_of_field+"formError").hide();
	$('.item_code'+id+"formError").remove();
	$('.item_name'+id+"formError").remove();
	$('.batch_number'+id+"formError").remove();
	$('.expiry_date'+id+"formError").remove();
	$('.qty'+id+"formError").remove();
	$('.value'+id+"formError").remove();

	$('.rate'+id+"formError").remove();
	$('.mrp'+id+"formError").remove();
					if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}
					$("#submitButton").removeAttr('disabled');
	//field = "<td align='center' colspan='12'> Row deleted</td>";
	//$("#row"+id).append(field);
		var $form = $('#InventoryPurchaseDetailInventorySalesBillForm'),
   				$summands = $form.find('.value');

					var sum = 0;
					$summands.each(function ()
					{
						var value = Number($(this).val());
						if (!isNaN(value)) sum += value;
					});

				$("#total_amount_field").val((sum.toFixed(2)));
				$("#total_amount").html((sum.toFixed(2)));

}

function selectItem(li,selectedId) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		var flag = false;
		var currentField = $("#"+selectedId);
		var fieldno = currentField.attr('fieldNo') ;
		var fields = $('input[name="item_id[]"]').serializeArray();
		//console.log(fields);
        jQuery.each(fields, function(i, field){
        	if(parseInt(field.value) == parseInt(itemID)){
				flag = true;
			}
    	});
		if(flag){
			/*alert("This Item already in list please select another.");
			$("#submitButton").attr('disabled','disabled');
			currentField.val("");
			$("#item_name"+fieldno).val("");
			$("#item_id"+fieldno).val("");
			$("#item_code"+fieldno).val("");
		 	$("#pack"+fieldno).val("");
            $("#manufacturer"+fieldno).val("");
			$("#mrp"+fieldno).val("");
			$("#rate"+fieldno).val("");
			$("#stockQty"+fieldno).val("");
			$("#batch_number"+fieldno).val("");
			$("#expiry_date"+fieldno).val("");
			$("#qty"+fieldno).val("");
			$("#value"+fieldno).val("");
			$("#free"+fieldno).val("");
			return false;*/
		}
		$("#submitButton").removeAttr('disabled');
		$("#viewDetail"+fieldno).attr('href','edit_item_rate/'+itemID+'?popup=true');
		$("#viewDetail"+fieldno).css("visibility","visible");
		$("#viewDetail"+fieldno).fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		loadDataFromRate(itemID,selectedId);

}


			$(".quantity").on('blur',function()
			  {
	           var price = 0.00;
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var qty = currentField.val();
				if(parseInt($("#stockQty"+fieldno).val()) ==0){
					/*alert("0 unit available in stock for "+$('#item_name'+fieldno).val());
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;*/
				}else if(parseInt($("#stockQty"+fieldno).val()) < parseInt(qty)){
					/*alert($("#stockQty"+fieldno).val()+" unit in stock, Quantity must be less than "+$("#stockQty"+fieldno).val());
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;*/
				}else{
					$("#submitButton").removeAttr('disabled');
				}
				if(isNaN(qty) || qty.indexOf(".")<0 == false || parseInt(qty)<0){
					alert("Invalid Quantity");
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;
				}else{
					qty = parseInt(qty);
					$("#submitButton").removeAttr('disabled');
				} 
				price = parseFloat($("#rate"+fieldno).val());
				 
				
                if(!isNaN(price)){ 
					if(price<=0){
						//alert(fieldno);
						price = parseFloat($("#mrp"+fieldno).val());
					}
					
					//alert(price) ;
					var	sub_total = qty*price;
					var totalWithTax = sub_total;
					$("#value"+fieldno).val(totalWithTax.toFixed(2));
					var $form = $('#InventoryPurchaseDetailInventorySalesBillForm'),
	   				$summands = $form.find('.value');
	
						var sum = 0;
						$summands.each(function ()
						{
							var value = Number($(this).val());
							if (!isNaN(value)) sum += value;
						});
	
					$("#total_amount_field").val((sum.toFixed(2)));
					$("#total_amount").html((sum.toFixed(2))); 
                }
             }
 });
$(".batch_number").on('blur',function()
			  {
                 var t = $(this);
			     var fieldno = t.attr('fieldNo') ;
                setTimeout(function() { $("#qty"+fieldno).focus(); }, 50);

              });
 $(".fancy").fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
$("#tax").on("blur",function(){

    var tax = parseFloat($("#tax").val());
    var amount = parseFloat($("#total_amount_field").val());
    if(isNaN(tax)){
        alert("Please enter the valid tax amount.");
        $("#tax").val("0");
        return false;
    }
        	var $form = $('#InventoryPurchaseDetailInventorySalesBillForm'),
   				$summands = $form.find('.value');

					var sum = 0;
					$summands.each(function ()
					{
						var value = Number($(this).val());
						if (!isNaN(value)) sum += value;
					});

        var taxAmount = ((sum*tax)/100);
        sum = sum+taxAmount;
        $("#total_amount_field").val((sum.toFixed(2)));
		$("#total_amount").html((sum.toFixed(2)));

});