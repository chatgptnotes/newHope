<?php //echo $this->Html->css(array('media_style'));      
//echo $this->Html->script(array('jquery.tree'));?>
<?php echo $this->Html->script(array('inline_msg'));?>
<style>
.m91 {
    background: none repeat scroll 0 0 #f7f7f7;
    border: 1px solid #d1d1d1;
    overflow: hidden;
    width:515px;
}
.m91 span {
    background: none repeat scroll 0 0 #e9e9e9;
    border-right: 1px solid #d1d1d1;
    color: #555555;
    display: block;
    float: left;
    font-size: 13px;
    padding: 13px;
}
.m91 input {
    background: none repeat scroll 0 0 #f7f7f7;
    border: 0 none;
    float: left;
    padding: 10px;
    width: 306px;
}
.templateCls:hover {
  background: none repeat scroll 0 0 #eeeff2 ;
}

.daredevel-tree li span.daredevel-tree-anchor {
    cursor: pointer !important;   
}
.daredevel-tree li span.daredevel-tree-anchor:hover {
    color: #76D6FF ;
  background-color: #FFFF00 ;
    
}
.parentCls{
font-size: 15px !important;
font-weight: lighter;
color:#3185AC;

}
.parentCls:hover {
  color: black ;
  background-color: #FFFF00 ;
  font-weight: lighter;
}
.childCls{
font-size: 14px !important;
font-weight: lighter;
color:#000000;
}
.childCls:hover {
  color: #3185AC ;
  background-color: #FFFF00 ;
  font-weight: bold;
}
.subchildCls{
font-size: 13px !important;
font-weight: normal;
color:#000000;
}
.subchildCls:hover {
  color: black ;
  background-color: #FFFF00 ;
  font-weight: bold;
}

.child{

font-size: 14px !important;
}
.subchild{
cursor:pointer;
font-size: 13px !important;
}


body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif !important;
	font-size: 10px !important;
	/*color: #000000;*/
	/*background-color: #F0F0F0;*/
}
.ui-widget-content {
    background: url("../img/ui-bg_flat_75_ffffff_40x100.png") repeat-x scroll 50% 50% #ffffff;
    border: none;
    color: #fff;
}
input,textarea {
	border: 1px solid #999999;
	padding: none !important;
}

.ui-widget-content {
	color: #000 !important;
}

ul {
	padding-left: 20px !important;
}

.prntDiv1 {
	float: left;
	padding: 0 5px 0 0;
	width: 60%;
}

.prntDiv2 {
	float: left;
	padding: 0px 3px 0px 0px;
	width: 6%;
}

.prntDiv3 {
	float: left;
	padding: 0 0 0 4px;
	width: 5%;
}

.prntDiv4 {
	float: left;
	padding: 0 0 0 13px;
	width: 7%;
}

.prntDiv5 {
	float: left;
	width: 7%;
}

.prntDiv6 {
	float: left;
	padding: 0 0 0 6px;
	width: 8%;
}

.prntDiv7 {
	float: left;
	width: 8%;
}

.chldDiv1 {
	float: left;
	padding: 0 6px 0 0;
	width: 50%;
}

.chldDiv2 {
	float: left;
	width: 6%;
	padding: 0px 4px 0px 0px;
}

.chldDiv3 {
	float: left;
	padding: 0 5px 0 0;
	width: 5%;
}

.chldDiv4 {
	float: left;
	padding: 0 3px 0 0;
	width: 8%;
}

.chldDiv5 {
	float: left;
	padding: 0 0 0 2px;
	width: 7%;
}

.chldDiv6 {
	float: left;
	padding: 0 8px 0 0;
	width: 8%;
}

.chldDiv7 {
	float: left;
	width: 8%;
}
.subchldDiv1 {
	float: left;
	padding: 0 6px 0 0;
	width: 50%;
}

.leaf {
	clear: both;
}

.expanded {
	clear: both;
}

.collapsed {
	clear: both;
}

#ui-datepicker-div{
		width: 190px;
}
label{
	width : auto !important;
	margin-right : 0 !important;
	padding-top : 0 !important;
	float: none !important;
}

div.row_format:nth-child(even) {background: #c5f1f1 !important;}
div.row_format:nth-child(odd) {background: #ACDEF6 !important;}
label.row_format:nth-child(even) {background: #c5f1f1 !important;}
label.row_format:nth-child(odd) {background: #ACDEF6 !important;}

</style>
<div style="padding-bottom:10px;">
<div class="inner_title" >
	<h3>
		&nbsp;
		<?php echo __('HOPE2SMS', true); ?>
	</h3>
</div>
</div>
<!--<div class="dashboardDiv">-->
<?php echo $this->Form->create('Messages',array('type' => 'file','name'=>'message_container','id'=>'messagefrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-bottom:30px;border:1px solid #000000;height:400px;">
	<tr>	
		<td width="30%" valign="top" style="padding:10px;">
			<div style="height:25px;"><strong><?php echo $this->Html->link('Add Group', array('action' => 'groupIndex'), array('escape' => false,'style'=>'text-decoration: underline;','target'=>"_blank"));  ?><span style="text-align:center;">Template List</span></div>
			<div style="max-height: 545px; overflow: scroll; clear: both; float: left; width: 410px;" class="smsTxtCls">
			<div style="border-bottom: 1px solid #f2f2f2;cursor:pointer;font-size:13px;line-height:18px;padding:8px 15px;">
			</div>
			<?php if(!empty($templateSmsData)){
			foreach($templateSmsData as $key=>$templateSmsDatas){?>
			<div style="border-bottom: 1px solid #f2f2f2;cursor:pointer;font-size:13px;line-height:18px;padding:8px 15px;" id="<?php echo $key;?>" class="templateCls row_format"><?php echo $templateSmsDatas;?>
			</div>
			<?php }
			}else{?>
			<div style="border-bottom: 1px solid #f2f2f2;cursor:pointer;font-size:13px;line-height:300px;padding:8px 15px;font-weight:bold;" class="templateCls row_format">
			<?php echo "No Template Available...";?>
			</div>
			<?php }?>
			</div>
		</td>
		<td width="34%" valign="top" style="padding:10px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" >	
				<tr>
				 <td><div id="alertMsg" align="left" style="color:green;font-size:18px;float:left;" ></div>
				</td>
				</tr>
				<tr>
				<td>
				</td>
				</tr>
				<tr>
					<td valign="top"><strong>Mobile Number :</strong></td>
				</tr>
				<tr>
				<td><div class="m91">
			                            <span>+91</span>
			                            	  
			                            <input type="text" maxlength="10" placeholder="Mobile Number" class="validate[optional,custom[onlyNumber]]" name="mobile" id="mobile">

			                                                
			                        </div></td>
				</tr>
				<tr>
					<td valign="top"><strong>Message :</strong></td>
				</tr>
				<tr>
				<td valign="top"><?php echo $this->Form->textarea('sms',array('id'=>'msg_txtarea','placeholder'=>'Type your message here.','style'=>'width:500px;resize:none;','class'=>'validate[required,custom[mandatory-enter]]','rows'=>'10','cols'=>'38','maxlength'=>'250'));	
				echo $this->Form->hidden('hidd',array('id'=>'sms_id'));?>
				</td>
				</tr>
				<tr>
				<td>
				</td>
				</tr>
				<tr>
				<td>
				</td>
				</tr>
				<tr>
					<td><strong><?php echo "Left :"?></strong><span id="lftcnt" style="color:red;">250</span></td>
				</tr>
				</table>
	
		</td>
		<td width="34%" valign="top" style="padding:10px;">
	<table width="100%" cellpadding="0" cellspacing="0" border="0" >	
	<tr><td ><strong><?php echo __("Groups");?></strong><input type="button" class="blueBtn resetDoctorList" name="Reset Group" value="F1:Reset Group" id="reset" style="float: right;"></td>
	</tr>
	<tr><td>
	<div>
		<div>
				<?php 
					echo $this->Form->input('sub_location', array('empty'=>__('Select Sponsor'), 'id'=>'subLocationsDoctor','class'=>'subLocationsDoctor','style'=>'width:458px !important;height:100px !important;font-size: 12px !important;','options'=>$corporatesublocations,'multiple'=>true));
		
       			?><br/><font color="RED">Press ctrl to select multiple</font>
        		<div id="changeDoctorsList" val=''> </div>
        </div>
		<div id="treeMsg" style="max-height: 300px; overflow: scroll; clear: both; text-align: center; width:458px !important;padding-top:10px;display:none;">
			<font style="color:RED;">No Data Available.</font><!-- no doctors found load -->
		</div>
	</div>
	<div id="tree" style="max-height: 400px; overflow: scroll; clear: both; float: left; width: 458px;padding-top:10px;display:none;">
	</div><!-- All refferal doctors found load -->
		<!--<ul>
			
			<li>
			
		</li>
					
			  <div>
			 <?php foreach($getPatientData as $key=>$getPatientDatas){?>
				<li>
				<div class="parentCls">
					<div align="center" id="parentClsdiv" class="tdBorder parentClsdiv" style="float: left;" value="">
						<?php $getPatientId=$getPatientDatas['Patient']['id'];
       					echo $this->Form->input('Billing.surgery_charges',array('type'=>'checkbox','id'=>"chk_$getPatientId",'class'=>'chk_parent chkColor','label'=>false));?>
					</div>
					<div class="tdBorderRt prntDiv1 checkddiv">				
						<?php echo $getPatientDatas['Patient']['lookup_name'];?>
						<br>
					</div>
					<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>			
					
				</div> <br>
				
			</li>
			<?php }?>
			</div>
			<br>
			<br>
			<br>
			</ul>
			</div>
			</div>-->	
			</td>
			</tr>
			</table>
	</td>
	</tr>
</table>

<div style="padding-top:15px;" align="center">
<input type="button" class="blueBtn clrmessage" name="Clear" value="Clear" id="clr_message">
<input type="button" class="blueBtn svemessage" name="Save" value="Add as template" id="save_message">
<input type="button" class="blueBtn sendmessage" name="Send Message" value="Save & Send Message" id="send_message">
</div>
 <?php echo $this->Form->end(); ?>
 <!--</div>-->
<script>
//var scrolled=0;
var selections=[];
$(document).ready(function(){
	$('#reset').click(function(){
		//for resetting filtrs
 		$('#messagefrm').trigger('reset'); 	
 		$('#treeMsg').hide();	
 		$('#tree').hide();
		$("option:selected").removeAttr("selected");
	});
	
	$('#msg_txtarea').focus();
	 $('.selectall').attr('checked', true);
	 $('.chk_parent').attr('checked', true);
	/* $('#tree').tree({
       
    }); */

    	
	

   //If one item deselect then button CheckAll is UnCheck
 
	 $(document).on( 'click', '#selectall', function() {	
	            if(this.checked) { // check select status
            	   var chk1Array=[];
				   var tCount=0;
            	   var amtValArray=[];
                   $('.chk_parent').each(function() {//loop through each checkbox
				   this.checked = true;              	
					});             
                 }else{
                   $('.chk_parent').each(function() { //loop through each checkbox
                       this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                   });        
               }
           });


   /**BOF-Mahalaxmi For save template Message and Send that message****/
     $('.sendmessage').click(function(){	
		var chk1Array=[];var tCount=0; var flag=false;       	  
  	   $(".chk_parent:checked").each(function () {
    	   	   checkId=this.id;          	
    	   	   splitedId=checkId.split('_');    	   	   	   	   
    	   	   chk1Array.push(splitedId['1']); 
			   if($.isNumeric(splitedId['1'])){
				   flag=true;
			   }
    	}); 
		/*console.log(chk1Array);
		console.log(flag);
		 if(flag=='true'){		
			 $('#mobile').removeClass( "validate[optional,custom[onlyNumber]]" );
			 $('#mobile').addClass( "validate[required,custom[onlyNumber]]" );				 	
		 }else{
			 $('#mobile').removeClass( "validate[required,custom[onlyNumber]]" );
			 $('#mobile').addClass( "validate[optional,custom[onlyNumber]]" );		
			  console.log("else"+chk1Array);					
		 }*/
	  	var validatePerson = jQuery("#messagefrm").validationEngine('validate'); 
	  	 	if(!validatePerson){
	  		 	return false;
	  		}
	  	 

		$('.sendmessage').hide();
    	var mobile=$('#mobile').val()!=''?$('#mobile').val():'';   	 
       var smsId=$('#sms_id').val()!=''?$('#sms_id').val():'';
       var msgTxt=$('#msg_txtarea').val()!=''?$('#msg_txtarea').val():'';
		
  	 
     chk1Array = chk1Array!=''?chk1Array:'';
  	 var smsMsgId = $('#smsMsg').attr('id')!=''?$('#smsMsg').attr('id'):'';

  	 //console.log(chk1Array);
  	   $.ajax({
     			url : "<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "sendToSmsMultipleDoctor", "admin" => false));?>",
     			type: 'POST',
     			data: "chk1Array="+chk1Array+"&msgTxt="+msgTxt+"&smsId="+smsId+"&mobile="+mobile,
     			dataType: 'html',
     		  
     			beforeSend:function(data){
     			$('#busy-indicator').show();
     			},

     			success: function(data){        		
				var objSmsTextArr= jQuery.parseJSON(data);
				console.log(objSmsTextArr); 										
				addMessageText(objSmsTextArr);					
     			$('#busy-indicator').hide();
     			if(data!=""){
					$('.sendmessage').show();
					$('#mobile').val('');
					$('#msg_txtarea').val('');
					$('#lftcnt').html("250");
					var alertId = $('#alertMsg').attr('id') ; 
					$('.chk_parent').attr('checked', false);					
					inlineMsg(alertId,'Message Save & Sent Successfully.');	     				
     			}
     			}
     			});   
			
          });

     /**EOF-Mahalaxmi For save template Message and Send that message****/
     
     /**BOF-Mahalaxmi For save template Message Only****/
      $('#save_message').click(function(){
		/* $('#mobile').removeClass( "validate[required,custom[onlyNumber]]" );
		 $('#mobile').addClass( "validate[optional,custom[onlyNumber]]" );*/
		    var validatePerson = jQuery("#messagefrm").validationEngine('validate'); 
	  	 	if(!validatePerson){
	  		 	return false;
	  		}
	  	 $('#save_message').hide();
       var msgTxt=$('#msg_txtarea').val();  	 
  	 
  	   	$.ajax({
     			url : "<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "saveTemplateSms", "admin" => false));?>",
     			type: 'POST',
     			data: "msgTxt="+msgTxt,
     			dataType: 'html',
     		  
     			beforeSend:function(data){
     			$('#busy-indicator').show();
     			},
     			success: function(data){
					/*$('.smsTxtCls').each(function () {
						$(this).attr('data-top', $(this).position().top);
					});*/
				var objSmsTextArr= jQuery.parseJSON(data); 										
				addMessageText(objSmsTextArr);		
				$('#save_message').show();
				$('#mobile').val('');
				$('#msg_txtarea').val('');
				$('#lftcnt').html("250");
     			$('#busy-indicator').hide();
				$('.chk_parent').attr('checked', false);
				var alertId = $('#alertMsg').attr('id') ; 						
				inlineMsg(alertId,'Message Save Successfully.');
     			}
     			});   
			
          });
      /**EOF-Mahalaxmi For save template Message Only****/
     $('#msg_txtarea').keyup(function(){
    	 var mstText=$('#msg_txtarea').val();    	
    	 var mstTextlng=mstText.length; 	    	
    	 msglngcnt=250-mstTextlng;
    	 if(msglngcnt<0){        	
        	return false;
    	 }
    	 $('#lftcnt').html(msglngcnt);
     });
         
     $('#clr_message').click(function(){
    	 $('#msg_txtarea').val(' ');
    	 $('#lftcnt').html("250");
    	// $("#msg_txtarea").attr('placeholder','Type your message here.');    	
     });
      $(document).on( 'click', '.templateCls', function() {
     //$('.templateCls').click(function(){     	
    	 var templateId = $(this).attr('id') ;	    	
    	 $('#sms_id').val(templateId);    	 
    	var tempTxt=$(this).text();
    	 $('#msg_txtarea').val(tempTxt);    	
    	 var mstTextlng=tempTxt.length;         	
    	 msglngcnt=250-mstTextlng;
    	 if(msglngcnt<0){        	
        	return false;
    	 }
    	 $('#lftcnt').html(msglngcnt);
     });
     
     $('#mobile').keyup(function(){
     $('.chk_parent').each(function() { //loop through each checkbox
         this.checked = false; //deselect all checkboxes with class "chk_parent"                      
     });  
     $("#selectall").attr('checked', false);

     });   

     $('#subLocationsDoctor').change(function(){
    	//var locVal =  $("#subLocationsDoctor").val(); 
				$('#subLocationsDoctor :selected').each(function(i, selected){				
					 selections.push($(selected).val());					
				});

		$.ajax({
 			url : "<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "getDoctors", "admin" => false));?>"+'/'+selections,
 			type: 'POST',
 			data: "subLocationid="+selections,
 			dataType: 'html',
 		  
 			beforeSend:function(data){
 			$('#busy-indicator').show();
 			},
			success: function(data){ 				
				var parseData = JSON.parse(data); 				
	 	 		if(parseData != "none"){	
					$("#treeMsg").hide();
		 	 			$("#tree").html('');
		 	 			var output = '';
						output += '<label><input id="selectall" class="chk_parent selectall" type="checkbox"/>All</label><br/>';
		 	 		$(parseData).each(function(key,value){  
			 	 		output += '<div class="row_format" style="border-bottom: 1px solid #f2f2f2;cursor:pointer;font-size:13px;line-height:18px;padding:8px 15px;"><input class="chk_parent" type="checkbox" value="'+value.id+'" id="chk_'+value.id+'" />'+value.name+'</div>';
	 	 			});
					$("#tree").show();
		 	 		$("#tree").html(output);
	 	 		}else{
					$("#tree").hide();
					$("#treeMsg").show();
				}							
	 	 		$('#busy-indicator').hide();
 			}
 			});   
    	
     });
     
});


//BOF-For render when send and save sms 
		function addMessageText(smsTxtdata){		
			$('.smsTxtCls').html('');			
			$(".smsTxtCls")				
				.append($('<div style="border-bottom: 1px solid #f2f2f2;cursor:pointer;font-size:13px;font-weight:bold;line-height:18px;padding:8px 15px;">').append($('<label>').attr({}).text("Template List")))
			$.each(smsTxtdata, function (key, value) {						
	   			$(".smsTxtCls")				
				.append($('<div style="border-bottom: 1px solid #f2f2f2;cursor:pointer;font-size:13px;line-height:18px;padding:8px 15px;" id="'+key+'" class="templateCls row_format">').append($('<label>').attr({}).text(value)))
			});	 
		}
//EOF-For render when send and save sms 
//shortcut key 
$(document).bind('keydown', function(e) {	
	if (e.keyCode == "112"){
		//for resetting filtrs
 		$('#messagefrm').trigger('reset'); 	
 		$('#treeMsg').hide();	
 		$('#tree').hide();
		$("option:selected").removeAttr("selected");
	} 
});
</script>