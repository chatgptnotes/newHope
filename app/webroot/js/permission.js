/* this method for get the list of action of particular controller and their permsiions*/
function getAllAction(modeulObj){	
var url= "/admin/acl/aros/module_permssion?controller_name="+modeulObj.value;
if(modeulObj.value!=""){
$("#action-permission-list").attr("src",url);
/* $("#action-permission-list").html('<img style="margin:50px" alt="" src="/img/indicator.gif">');
	$.ajax({
		  type: "get",
		  url: "module_permssion",
		  data: "controller_name="+modeulObj.value+""
		}).done(function( msg ) {
		 document.getElementById("action-permission-list").innerHTML = msg;
		});
	*/
	
	}else{
		alert("Please Select a Module.");
		return false;
		}
	}
	
	/* this method for get the list of action of particular controller and their permsiions*/
function getAllActionWithUserPermission(modeulObj,user_id,path){	
	if(modeulObj.value!=""){
	var url= "/admin/acl/aros/module_user_permssion/"+user_id+"/"+modeulObj.value;
	$("#action-permission-list").attr("src",url);
	 /*$("#action-permission-list").html('<img style="margin:50px" alt="" src="/img/indicator.gif">');
		$.ajax({
			  type: "get",
			  url: path+"/module_user_permssion/"+user_id,
			  data: "controller_name="+modeulObj.value+""
			}).done(function( msg ) {
			 document.getElementById("action-permission-list").innerHTML = msg;
			});
		*/
	}else{
		alert("Please Select a Module."); 
		return false;
		}
	}
	
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= "100%";
}
function setPermissionOnModule(obj,roleId){
	var moduleName='';
	
	var f = parent.document.getElementById('action-permission-list');


	$.ajax({
		  type: "get",
		  url: "/admin/acl/aros/permission_on_module",
		  data: "controller_name="+obj+"&role="+roleId
		}).done(function( msg ) {
			if(msg=="1"){
				alert("Permission on "+obj+" granted");
				f.contentWindow.location.reload();
			}else{
				alert("Something went wrong.");
				f.contentWindow.location.reload();
			}
		});
	}

/* Do not remove this comment
function addConsultantVisitElement()
{
	 var field = '';
	 var number_of_field = parseInt($("#no_of_fields").val())+1;
	 var amoutRow = $("#ampoutRow");
	 $("#ampoutRow").remove();
	 field +='<tr id="row'+number_of_field+'">';
	 field +=' <td valign="middle" width="260"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:117px;" class="validate[required,custom[mandatory-date]] textBoxExpnd ConsultantDate" id="ConsultantDate'+number_of_field+'" name="data[ConsultantBilling][date][]"> </td>';
	 field +=' <td valign="middle"> <select fieldno="'+number_of_field+'" style="width:152px;" id="category_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd category_id" name="data[ConsultantBilling][category_id][]" onchange="categoryChange(this)"> <option value="">Please select</option> <option value="0">External Consultant</option> <option value="1">Treating Consultant</option> </select> </td>';
	 field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" style="width:152px;" id="doctor_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd doctor_id" 	name="data[ConsultantBilling][doctor_id][]" onchange="doctor_id(this)"> <option value="">Please Select</option> <option value="0"></option> </select> </td>';
	 field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="textBoxExpnd service_category_id" style="width:167px;" id="service-group-id'+number_of_field+'" 	  name="data[ConsultantBilling][service_category_id][]" onchange="getListOfSubGroup(this);"> </select></td>';
	 field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id" style="width:150px;" name="data[ConsultantBilling][consultant_service_id][]" id="consultant_service_id'+number_of_field+'"   onchange="consultant_service_id(this)"><option value="">Please Select</option></select></td>';
	 field +=' <td valign="middle" style="text-align: center;"><select fieldno="'+number_of_field+'" style="width:130px;" id="hospital_cost'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd hospital_cost" name="data[ConsultantBilling][hospital_cost][]" ><option value="">Please Select</option><option value="private">Private</option><option value="cghs">CGHS</option><option value="other">Other</option></select></td>';
	 field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="amount'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd amount" name="data[ConsultantBilling][amount][]"></td>';
	 field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="description'+number_of_field+'" class="textBoxExpnd description" name="data[ConsultantBilling][description][]"></td>';
     field +=' <td valign="middle" style="text-align:center;"><a href="javascript:void(0);" id="delete row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="webroot/theme/Black/img/cross.png" ></a></td>  </tr>';
	 $("#no_of_fields").val(number_of_field);
	 $("#consulTantGrid").append(field);
	 $('#service-group-id'+(number_of_field-1)+' option').clone().appendTo('#service-group-id'+number_of_field);
	 $("#consulTantGrid").append(amoutRow);
	 $("#removeVisit").css("visibility","visible");
	 //add  calender 
	 addCalenderOnDynamicField();
	 return number_of_field;
}

*/


/* Do not remove comment of this function.
 * this function is now moved to multiple_payment_mode_ipd
function addServiceVisitElement()
{	 var today = new Date(); 
	 var tadayDate=today.format('d/m/Y h:i:s');
	 var field = '';
	 var number_of_field = parseInt($("#no_of_fields").val())+1;
	 var amoutRow = $("#ampoutRow");
	 $("#ampoutRow").remove();
	 field +='<tr id="row'+number_of_field+'" class="serviceAddMoreRows">';
	 field +=' <td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:120px;" class="validate[required,custom[mandatory-date]] textBoxExpnd ServiceDate" id="ServiceDate'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+tadayDate+'"> </td>';
	// field +=' <td align="center" width="150"><select fieldno="'+number_of_field+'" class="textBoxExpnd add-service-group-id" style="width:150px;" id="add-service-group-id'+number_of_field+'" 	  name="data[ServiceBill]['+number_of_field+'][service_id]" onchange="getListOfSubGroupServices(this);"> </select></td>';
	// field +=' <td align="center"width="150"><select fieldno="'+number_of_field+'" style="width:150px;" class="textBoxExpnd add-service-sub-group" name="data[ServiceBill]['+number_of_field+'][sub_service_id]" id="add-service-sub-group'+number_of_field+'"   onchange="serviceSubGroups(this)"> </select></td>';
	 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'"  id="add-service-sub-group'+number_of_field+'" class="service-sub-group textBoxExpnd " name=" " > <input type="hidden" fieldno="'+number_of_field+'"  id="addServiceSubGroupId_'+number_of_field+'" class="addServiceSubGroupId" name="data[ServiceBill]['+number_of_field+'][sub_service_id]" ></td>';
	 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd service_id" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyServiceId_'+number_of_field+'" class="onlyServiceId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
	 //field +=' <td align="center" width="150"><select fieldno="'+number_of_field+'" style="width:150px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd service_id" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" onchange="service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
	 //field +='<td align="center" width="100"><select fieldno="'+number_of_field+'" style="width:100px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd " name="data[ServiceBill]['+number_of_field+'][hospital_cost]" onchange="service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
	 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="service_amount'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd service_amount" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
	 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="no_of_times'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
     field +='<td id="amount_'+number_of_field+'" class="amount" align="center" width="100"></td>';
     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="description'+number_of_field+'" class=" textBoxExpnd description" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
	 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove"  ></a></td>  </tr>';
	 $("#no_of_fields").val(number_of_field);
	  
	 $("#serviceGrid").append(field);
	 $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
	 $("#consulTantGrid").append(amoutRow);
	 $("#removeVisit").css("visibility","visible");
	 
	 //add  calender 
	 addCalenderOnDynamicField();
	 return number_of_field;
}
*/


function removeConsultantVisitElement()
{
	var number_of_field = parseInt($("#no_of_fields").val());
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();
		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#removeVisit").css("visibility","hidden");
	}
}	

/*do not remove comment
 function deleteVisitRow(rowID){
	  var number_of_field = parseInt($("#no_of_fields").val());
	
	if(number_of_field > 1){
		$("#row"+rowID).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#removeVisit").show();
	}
	
}
*/ 
 


 function removeMriLabOrderElement()
 {
	var number_of_field = parseInt($("#no_of_fields").val());
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();
		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#removeVisit").css("visibility","hidden");
	}
}
 
 

 