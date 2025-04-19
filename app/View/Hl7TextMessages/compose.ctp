<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
<script>
var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";
//var encrypted = CryptoJS.AES.encrypt("Pawan", hashKey);//alert(encrypted);

    //alert(encrypted); // {"ct":"tZ4MsEnfbcDOwqau68aOrQ==","iv":"8a8c8fd8fe33743d3638737ea4a00698","s":"ba06373c8f57179c"}

    //var decrypted = CryptoJS.AES.decrypt(encrypted, "Secret Passphrase");

    //alert(decrypted.toString(CryptoJS.enc.Utf8)); // Message
</script>
<script>

jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#composefrm").validationEngine();
	});
</script>
<style>
.mover{width:20px;}
.movel{width:20px;}
.select{width:150px;}
.tbl{border: 1px solid #3E474A;
    padding-bottom: 5px;}
.t1 label{color: #E7EEEF;
   
    font-size: 13px;
    margin-right: 10px;
    padding-top: 7px;
    text-align: right;
    width: 97px;	}
.radio{margin-right:-300px;}
.lblcls{float:inherit;}
.btn{margin-right:30px;}</style>
<?php
//echo $this->Html->script('jquery.autocomplete');
//echo $this->Html->css('jquery.autocomplete.css');

?>
<?php  echo $this->Html->script('fckeditor/fckeditor');  ?>
<?php echo $this->Form->create('Compose',array('type' => 'file','id'=>'composefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
?>
<div class="inner_title" style="margin-bottom:25px;">
	<h3><?php echo __('Compose') ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"Laboratories","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" class="t1">
		<!-- <tr><td>
			<h3>
		
		<?php echo __(' Compose', true); ?>
		
	</h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"Laboratories","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
	</td>
		</tr>-->
		
		<tr></tr>
		<!-- 
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Type') ?><font color="red">*</font> </td>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
			<?php
                        	 $To = array('Normal'=>'Normal','Urgent'=>'Urgent','Provider'=>'Provider');
                         echo $this->Form->input('type', array('style'=>'width:150px; float:left;','options'=>$To,'empty'=>__('Please select'), 'id'=>'type','class' => 'validate[required,custom[name],custom[mandatory-select]] textBoxExpnd')); ?>
 </td>
		</tr>
		 -->
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace" width="150px"><?php echo __('Send To') ?><font color="red">*</font> </td>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
			<?php
                        	 $To = array('Registry'=>'Registry','ELR'=>'ELR','Ambulatory'=>'Ambulatory');
                         echo $this->Form->input('message_to', array('style'=>'width:150px; float:left;','options'=>$To,'empty'=>__('Please select'), 'id'=>'message_to','class' => 'validate[required,custom[name],custom[mandatory-select]] textBoxExpnd')); ?>
 </td>
		</tr>
		
		
		<tr >
			<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Subject') ?><font color="red">*</font>  </td>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
			<?php 
			$optionsSubject = array("Submission of Reportable Lab Results"=>"Submission of Reportable Lab Results","Report of the Lab Order"=>"Report of the Lab Order");
			echo $this->Form->input('subject', array('options'=>$optionsSubject,'empty'=>'Please Select','style'=>'width:250px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'subject')); ?></td>
		</tr>
		
		<tr >
			<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('MRN') ?></td>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
			<?php echo $this->Form->input('patient_uid', array('type'=>'text','style'=>'width:250px','id' => 'patient_uid')); ?></td>
		</tr>
		
		<tr >
			<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Patient Name') ?></td>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
			<?php echo $this->Form->input('patient_name', array('type'=>'text','style'=>'width:250px','id' => 'patient_name')); ?></td>
		</tr>
		
		
		
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Message') ?> </td>
			
			<td valign="middle" class="tdLabel" id="boxSpace" colspan="3">
		
				<?php echo $this->Form->textarea('message', array('value'=>"Please find the enclosed lab results",'class' => '','id' => 'message','rows'=>'10','cols'=>10));
						//echo $this->Fck->fckeditor(array('Compose','message'), $this->Html->base,'','100%','400'); 
				 ?>
				<input class="blueBtn" type=hidden value="" name="message_enc" id="message_enc">
			</td>
		</tr>
		<!-- 
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace" width="60px">Add to patient medical records</td>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
			<?php //echo $this->Form->input('',array('empty'=>__('Select'),'options'=>$users));
 ?></td>
		</tr> -->
		
		
		<tr><td valign="middle"   class="btn">
		<?php //echo $this->Form->hidden('is_patient',array('value'=>0,'id' => 'is_patient'));?>
		
        </td><td align="right"><!-- <input class="blueBtn" name="Reset" type="reset" onclick="resetForm('composefrm'); return false;" /> -->
        <input class="blueBtn"  type=submit value="Send" name="Send" onclick="encryptData()">
			</td>
		</tr>
		</table>
<?php echo $this->Form->end();?>		
<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']);?>
<script>

var getUserUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "getUsers","admin" => false)); ?>";
var server_path="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$root_name[0].'js/fckeditor/' ?>";
//var server_path = "http://localhost/DrmHope/js/fckeditor/";
var is_patient = 0;
function getUsersList(to_type){
	if(to_type == 'Patient'){
		is_patient = 1;
		$('#is_patient').val(is_patient);
	}else{
		is_patient = 0;
		$('#is_patient').val(is_patient);
	}
$.ajax({
	type: 'POST',
	url: getUserUrl,
	data: 'to_type='+to_type,
	dataType: 'html',
	success: function(data){
		var options = createDropDown(data);
		$('#SelectRight').html(options);
	},
	error: function(message){
	//
	} 
});
}
function encryptData(){
	//$('#subject').val(CryptoJS.AES.encrypt($('#subject').val(), hashKey));
	var Editor2 = FCKeditorAPI.GetInstance('message');
	var mess = CryptoJS.AES.encrypt(Editor2.GetHTML(), hashKey);
	mess = mess.toString();
    Editor2.SetHTML('AHAGYAJNAGHJKGHGHGJJKHGFFFTUIKIJKJHGFRERETRTYYUYUHGGHGHFTRUI=+');
    $('#message_enc').val(mess);
}

function createDropDown(data){
 	var options = '';
 	data = JSON && JSON.parse(data) || $.parseJSON(data);
	$.each(data, function(index, name) {
		//index = index.replace('"',''); alert(index);
	    options += '<option value=' + index + '>' + name + '</option>';
	  });
	return options;
}

$(document).ready(function(){
	var oFCKeditor = new FCKeditor('message') ;
	oFCKeditor.BasePath = server_path;
	oFCKeditor.Height = "300" ; 
	oFCKeditor.Width = "900";
	oFCKeditor.ReplaceTextarea() ;
	/*$("#to").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","full_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true//is_ammendment
	});*/
	
	
	});
$(function() {
    $("#MoveRight,#MoveLeft").click(function(event) {
    	
        var id = $(event.target).attr("id");//MoveRight
        var selectFrom = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";//#selectLeft
        var moveTo = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";//#selectRight
    
        var selectedItems = $(selectFrom + " :selected").toArray();//empty
        //var selectedItems="pankaj";
       
        $(moveTo).append(selectedItems);
        selectedItems.remove;
    });
});

$(function() {//$isAmmendment = array('0'=>'Subject','1'=>'Amendment','2'=>'Refferal Summary','3' => 'Reminder', '4' => 'Lab Requisition','Lab Report');
    $("#is_ammendment").change(function(event) {
    	if($("#is_ammendment").val() == '0'){
        	$("#is_subject_show").show();
        	$("#is_ammendment_show").hide();
        }else if($("#is_ammendment").val() == '1'){
        	$("#is_ammendment_show").show();
        	$("#is_subject_show").hide();
        }else if($("#is_ammendment").val() == "2"){
        	$("#subject").val('Refferal Summary');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "3"){
        	$("#subject").val('Reminder');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "4"){
        	$("#subject").val('Lab Requisition');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "5"){
        	$("#subject").val('Lab Report');
        	$("#is_subject_show").show();
        }
    });
});
$(function() {
	

	$( "#send_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	});

});
</script>