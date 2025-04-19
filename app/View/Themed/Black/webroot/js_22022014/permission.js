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
	
function addConsultantVisitElement(){
	 
	 var field = '';
	 var number_of_field = parseInt($("#no_of_fields").val())+1;
	 var amoutRow = $("#ampoutRow");
	 $("#ampoutRow").remove();
	 field +='<tr id="row'+number_of_field+'">';
	 field +=' <td valign="middle" width="260"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:88px;" class="validate[required,custom[mandatory-date]] ConsultantDate" id="ConsultantDate'+number_of_field+'" name="data[ConsultantBilling][date][]"> </td>';
	
	
	field +=' <td valign="middle"> <select fieldno="'+number_of_field+'" style="width:100px;" id="category_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd category_id" name="data[ConsultantBilling][category_id][]" onchange="categoryChange(this)"> <option value="">Please select</option> <option value="0">External Consultant</option> <option value="1">Treating Consultant</option> </select> </td>';
	
	field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" style="width:100px;" id="doctor_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd doctor_id" 	name="data[ConsultantBilling][doctor_id][]" onchange="doctor_id(this)"> <option value="">Please Select</option> <option value="0"></option> </select> </td>';
	
	field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="textBoxExpnd service_category_id" style="width:100px;" id="service-group-id'+number_of_field+'" 	  name="data[ConsultantBilling][service_category_id][]" onchange="getListOfSubGroup(this);"> </select>';
	
	field +=' <br><select fieldno="'+number_of_field+'" style="width:100px;" name="data[ConsultantBilling][service_sub_category_id][]" id="service-sub-group'+number_of_field+'"   onchange="serviceSubGroup(this)"> </select></td>';
	
	/*
	field +=' <td valign="middle" style="text-align: left;"> <select fieldno="'+number_of_field+'" style="width:100px;" name="data[ConsultantBilling][service_sub_category_id][]" id="service-sub-group'+number_of_field+'"   onchange="serviceSubGroup(this)"> </select></td>';
	*/
    field +=' <td valign="middle" style="text-align: center;" fieldno="'+number_of_field+'"><select fieldno="'+number_of_field+'" style="width:100px;" id="consultant_service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id" name="data[ConsultantBilling][consultant_service_id][]" onchange="consultant_service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
	
	/* hospital cost */
	 field +=' <td valign="middle" style="text-align: center;"><select fieldno="'+number_of_field+'" style="width:100px;" id="hospital_cost'+number_of_field+'" class="textBoxExpnd" name="data[ConsultantBilling][hospital_cost][]"> <option value="">Please Select</option><option value="private">Private</option><option value="cghs">CGHS</option><option value="other">Other</option></select></td>';
	 
    field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="amount'+number_of_field+'" class="validate[required,custom[onlyNumber]] amount" name="data[ConsultantBilling][amount][]"></td>';
 
	field +=' <td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="/img/icons/cross.png" ></a></td>  </tr>';
	$("#no_of_fields").val(number_of_field);
	$("#consulTantGrid").append(field);
	$('#service-group-id'+(number_of_field-1)+' option').clone().appendTo('#service-group-id'+number_of_field);
	$("#consulTantGrid").append(amoutRow);
	$("#removeVisit").css("visibility","visible");
	return number_of_field;
	}
function removeConsultantVisitElement(){
 
	 var number_of_field = parseInt($("#no_of_fields").val());
	
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#removeVisit").css("visibility","hidden");
	}
	
	
	
 }	
 function deleteVisitRow(rowID){
	  var number_of_field = parseInt($("#no_of_fields").val());
	
	if(number_of_field > 1){
		$("#row"+rowID).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#removeVisit").css("visibility","hidden");
	}
	
	 }