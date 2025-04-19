<?php echo $this->Html->css(array('jquery.tree'));      
echo $this->Html->script(array('jquery.tree'));?>
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

</style>
<div style="padding-bottom:30px;">
<div class="inner_title" >
	<h3>
		&nbsp;
		<?php echo __('Voice Call', true); ?>
	</h3>
</div>
</div>

<div style="padding-left:700px;background:#CBFFCC;display:none;text-align:center;font-size:13px;" id="smsMsg"><strong>asas</strong></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-bottom:30px;padding-top:30px;border:1px solid #000000;">
	<tr>	
	<td width="27%" valign="top" style="padding-left:10px;">
	
	</td>
	
	<td width="42%" valign="top">
	<table width="100%" cellpadding="0" cellspacing="0" border="0" >
	
	<tr>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	</td>
	</tr>
	<tr>
		<td valign="top" style="padding-left:10px;"><strong>Mobile Number :</strong></td>
	</tr>
	<tr>
	<td style="padding-left:10px;"><div class="m91">
                            <span>+91</span>
                            	  
                            <input type="text" maxlength="10" placeholder="Mobile Number" name="mobile" id="mobile">

                                                
                        </div></td>
	</tr>
	<tr>
		<td valign="top" style="padding-left:10px;"><strong>Audio Clip :</strong></td>
	</tr>

	<tr>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	</td>
	</tr>
	
	</table>
	</td>
	<td width="20%" valign="top">
	<div style="width:100%">
	<div id="tree" style="max-height: 300px; overflow: scroll; clear: both; float: left; width: 350px;">
		<div><strong>
			<?php echo 'Select All '.$this->Form->input('Billing.Select All',array('type'=>'checkbox','id'=>"selectall",'class'=>'select_all',"style"=>"float: left",'label'=>false));?>
		</strong></div>
		

		<ul>
			<!-- Start of Main UL -->			
			<div>
			 <?php 
foreach($detailsDoc as $key=>$getDetailsDoc){?>
				<li>
				<div class="parentCls">
					<div align="center" class="tdBorder" style="float: left;">
						<?php $getUserId=$getDetailsDoc['User']['id'];
						 echo $this->Form->input('Billing.surgery_charges',array('type'=>'checkbox','id'=>"chk_$getUserId",'class'=>'chk_parent chkColor','label'=>false));?>
					</div>
					<div class="tdBorderRt prntDiv1">				
						<?php echo $getDetailsDoc['User']['full_name'];?>
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
			</div>	
	</td>
	</tr>
</table>

<div style="padding-top:15px;" align="center">
<input type="button" class="blueBtn clrmessage" name="Clear" value="Clear" id="clr_message">
<input type="button" class="blueBtn svemessage" name="Save" value="Add as template" id="save_message">
<input type="button" class="blueBtn sendmessage" name="Send Message" value="Save & Send Message" id="send_message">
</div>
<script>
$(document).ready(function(){
	$('#msg_txtarea').focus();
	 $('.select_all').attr('checked', true);
	 $('.chk_parent').attr('checked', true);
	$('#tree').tree({
        /* specify here your options */
    }); 

    	
	 $('#selectall').click(function(event) {  //on click
         if(this.checked) { // check select status
      	   var chk1Array=[];var tCount=0;
      	   var amtValArray=[];
             $('.chk_parent').each(function() {//loop through each checkbox         
      	    this.checked = true;
          	   checkId=this.id;                	   	 
        	   	   splitedId=checkId.split('_');
        	   var patientIdnew=splitedId['1'];
        	   console.log(patientIdnew);
        	   var amtnew=$('#amount_to_pay_today_'+patientIdnew).val();  	             	  
        	   	var patientIdnew = patientIdnew.concat("_");       
        	   	var res = patientIdnew.concat(amtnew);   	   	   
        	   	 chk1Array.push(res);	 
             });
         
          
             //*********EOF-For Save Amt-Mahalaxmi	  
         }else{
             $('.chk_parent').each(function() { //loop through each checkbox
                 this.checked = false; //deselect all checkboxes with class "chk_parent"                      
             });        
         }
     });

   //If one item deselect then button CheckAll is UnCheck
     $(".chk_parent").click(function () {             
         if (!$(this).is(':checked')){                
             $("#selectall").attr('checked', false);
         }else{      
      	   	 var chkId = $(this).attr('id') ; 
      	   	 splittedId = chkId.split("_");
		     newId = splittedId[1];  					
         }
     });

   /**BOF-Mahalaxmi For save template Message and Send that message****/
     $('.sendmessage').click(function(){ 
    	var mobile=$('#mobile').val();   	 
       var smsId=$('#sms_id').val();
       var msgTxt=$('#msg_txtarea').val();
  	   var chk1Array=[];var tCount=0;        	  
  	   $(".chk_parent:checked").each(function () {
    	   	   checkId=this.id;          	   	 
    	   	   splitedId=checkId.split('_');    	   	   	   	   
    	   	   chk1Array.push(splitedId['1']);    	   	 
    	});
  	 var smsMsgId = $('#smsMsg').attr('id') ;
  	 
  	   //array of id of selected chkboxes to send message
  	 
  	   	$.ajax({
     			url : "<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "sendToSmsMultiplePatient", "admin" => false));?>",
     			type: 'POST',
     			data: "chk1Array="+chk1Array+"&msgTxt="+msgTxt+"&smsId="+smsId+"&mobile="+mobile,
     			dataType: 'html',
     		  
     			beforeSend:function(data){
     			$('#busy-indicator').show();
     			},

     			success: function(data){
         			
     			$('#busy-indicator').hide();
     			if(data!=""){
     			inlineMsg(smsMsgId,'SMS Sent successfully'); 
     			}
     			}
     			});   
			
          });
     /**EOF-Mahalaxmi For save template Message and Send that message****/
     
     /**BOF-Mahalaxmi For save template Message Only****/
      $('#save_message').click(function(){
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
     			$('#busy-indicator').hide();
     			}
     			});   
			
          });
      /**EOF-Mahalaxmi For save template Message Only****/
     $('#msg_txtarea').keyup(function(){
    	 var mstText=$('#msg_txtarea').val();    	
    	 var mstTextlng=mstText.length; 	    	
    	 msglngcnt=140-mstTextlng;
    	 if(msglngcnt<0){        	
        	return false;
    	 }
    	 $('#lftcnt').html(msglngcnt);
     });
         
     $('#clr_message').click(function(){
    	 $('#msg_txtarea').val(' ');
    	 $('#lftcnt').html("140");
    	// $("#msg_txtarea").attr('placeholder','Type your message here.');    	
     });
     $('.templateCls').click(function(){
    	 var templateId = $(this).attr('id') ;
    	 $('#sms_id').val(templateId);
    	 
    	var tempTxt=$(this).text();
    	 $('#msg_txtarea').val(tempTxt);    	
    	 var mstTextlng=tempTxt.length;         	
    	 msglngcnt=140-mstTextlng;
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
});

</script>