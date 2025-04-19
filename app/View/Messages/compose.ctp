<?php  echo $this->Html->script('aes.js'); ?>
<!--  <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>  -->
<script>
var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";
var encrypted = CryptoJS.AES.encrypt("Pawan", hashKey);//alert(encrypted);

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

.mover {
	width: 20px;
}

.movel {
	width: 20px;
}

.select {
	width: 150px;
}

.tbl {
	border: 1px solid #3E474A;
	padding-bottom: 5px;
}

.t1 label {
	color: #E7EEEF;
	font-size: 13px;
	margin-right: 10px;
	padding-top: 7px;
	text-align: right;
	width: 97px;
}

.radio {
	margin-right: -300px;
}

.lblcls {
	float: inherit;
}

.btn {
	margin-right: 30px;
}

.tddate img {
	float: inherit;
}

#MoveRight {
    float: left;
    margin: 20px 10px 0 23px;
}
#moveleft {
    float: left;
    margin: 20px 0 0;
}

.td_line{
	margin-top: -25px;
	margin-bottom: -31px;
}

.td_second{
	border-left-style:solid; 
	padding-left: 20px; 
	
}

</style>

<?php
//echo $this->Html->script('jquery.autocomplete');
//echo $this->Html->css('jquery.autocomplete.css');

?>

<?php  echo $this->Html->script('fckeditor/fckeditor');  ?>
<?php echo $this->Form->create('Compose',array('type' => 'file','id'=>'composefrm','inputDefaults' => array( 'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));

if(strtolower($this->Session->read('role')) != strtolower('patient')){
	echo $this->Form->hidden('is_patient',array('value'=>0,'id' => 'is_patient'));
}else{
	echo $this->Form->hidden('is_patient',array('value'=>1,'id' => 'is_patient'));
}
?>

<div class="inner_title" style="margin-bottom: 25px; ">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Compose') ?>
	</h3>
</div>

<table width="100%"  cellspacing='0' cellpadding='0' class="td_line">
	<tr>
		<td valign="top" width="5%" class="mailbox_div" >
<!-- 			<div > -->
				<?php if(empty($type))
 					echo $this->element('mailbox_index');
 				?>
 				
<!-- 			</div> -->
		</td>
		<td class="td_second" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull" style="margin-top: -50px;">
				
<!--				<tr>
 					<td> -->
<!-- 						<h3> --> 
<!-- 							&nbsp; -->
							<?php //echo __(' Compose', true); ?>
<!-- 						</h3> --> 
<!-- 					</td> 
				</tr>-->
				
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px" style="padding: 40px;" >
						<?php echo __('Type') ?>
						<font color="red">*</font>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php
					$To = array('Normal'=>'Normal','Urgent'=>'Urgent','Provider'=>'Provider');
			                         echo $this->Form->input('type', array('style'=>'width:150px; float:left;','options'=>$To,'empty'=>__('Please select'), 'id'=>'type','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
					</td>
				</tr>
				<?php if($this->Session->read('role') != 'Patient'){?>
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('To') ?><font
						color="red">*</font>
					</td>
					<?php
			
					  /* if(!empty($defaultSelection['Patient']['id'])){
						$users1[$defaultSelection['Patient']['id']]=$defaultSelection['Patient']['lookup_name'];
			
					}
					 */
					?>
					<td valign="middle" class="tdLabel" id="boxSpace" class="select" width="400px;"><?php  
					
					//echo $this->Form->input('to', array('multiple' => 'multiple','style'=>'width:150px; float:left;','options'=>array(), 'options'=>$users1, 'id'=>'SelectRight'));
					echo $this->Form->input('to', array('multiple' => 'multiple','style'=>'width:150px; float:left; margin:0 3px 0 0;','options'=>$users, 'id'=>'SelectRight'));
					?> <input id="MoveRight" type="button" value=" >> " /> <input
						id="MoveLeft" type="button" value=" << " />
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php
					if(!empty($defaultSelection[0]['Patient']['id'])){
						$checkPatient='checked';
					}  
					echo $this->Form->input('to_new', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter]]',
							'style'=>'width:150px; float:left; margin-left:-61px','options'=>array(),'id'=>'SelectLeft'));
					?> <input id="to_type_" type="hidden" value=""
						name="data[Compose][to_type]">
						<input id="ToTypeMedics" class="lblcls" type="radio" value="Medics" style="float: none"
						onclick="getUsersList(this.value)" name="data[Compose][to_type]" checked="checked" > <label
						for="ToTypeMedics" class="lblcls">Provider</label>
						 <input	id="ToTypePatient" class="lblcls" type="radio" value="Patient"
						style="float: none" 
						onclick="getUsersList(this.value)" name="data[Compose][to_type]"> <label
						for="ToTypePatient" class="lblcls">Patient</label>
						<input	id="ToTypeStaff" class="lblcls" type="radio" value="Staff"
						style="float: none" 
						onclick="getUsersList(this.value)" name="data[Compose][to_type]"> <label
						for="ToTypeStaff" class="lblcls">Staff</label>
					</td>
					</tr>	
					 <?php 
			                         }else{?> 
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('To ') ?><font
						color="red">*</font>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace" class="select" width="400px;"
						style="float: left;"><?php 
						echo $this->Form->input('to', array('multiple' => 'multiple','style'=>'width:150px; float:left;','options'=>$users , 'id'=>'SelectRight'));
						?> <input id="MoveRight" type="button" value=" >> " /> <input
						id="MoveLeft" type="button" value=" << " />
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"
						style="float: left; margin-left: 40px;"><?php 
						echo $this->Form->input('to_new', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter]] ','style'=>'width:150px; float:left; margin-left:-124px;','options'=>array(),'id'=>'SelectLeft'));
						?> <?php }?> <?php // echo $this->Form->radio('to_type',array('Medics'=>'Medics','Patient'=>'Patient'),array('legend'=>false,'onclick'=>'getUsersList(this.value)','id'=>'to_type','style'=>'float:none', 'class'=>'lblcls'));?>
						<?php //echo$this->Form->label('to_type', 'Text of your label', array('label'=>'radioBtn'))?>
			
					</td>
			
			
			
			
			
				</tr>
				<?php //if($this->Session->read('role') != 'Patient'){?>
				<!-- <tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Action') ?>
					</td>
					<td width="550px"><table style="margin-left: 20px"; width="393px">
							<tr>
								<td width="26%"><?php echo $this->Form->input('call_patient', array('type' => 'checkbox','id' => 'call_patient','value'=>1,));
								echo $this->Form->label('name', 'Call Patient',array('class'=>'lblcls'));?>
								</td>
			
								<td width="32%"><?php echo $this->Form->input('collect_balance', array('type' => 'checkbox','id' => 'collect_balance','value'=>1,));
								echo $this->Form->label('name', 'Collect Balance',array('class'=>'lblcls'));?>
								</td>
			
								<td width="41%"><?php echo $this->Form->input('call_patient', array('type' => 'checkbox','id' => 'call_patient','value'=>1,));
								echo $this->Form->label('name', 'Create Portal Login',array('class'=>'lblcls'));?>
								</td>
								<td width=""><?php //echo $this->Form->input('call_patient', array('type'=>'checkbox','id' => 'call_patient','value'=>1,'label' => 'Call Patient','div'=>false)); ?>
								</td>
								<td width=""><?php //echo $this->Form->input('collect_balance', array('type'=>'checkbox','id' => 'collect_balance','value'=>1,'label' => 'Collect Balance','div'=>false)); ?>
								</td>
								<td width=""><?php //echo $this->Form->input('create_account', array('type'=>'checkbox','id' => 'create_account','value'=>1,'label' => 'Create Portal Login','div'=>false)); ?>
								</td>
							</tr>
						</table>
					</td>
			
				</tr>
			
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Due In Days') ?><font
						color="red">*</font>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('due_in_days', array('type'=>'text','style'=>'width:134px','id' => 'due_in_days','class' => 'validate[required,custom[onlyNumber]]')); ?>
					</td>
			
				</tr>
				<?php //} else{ $redStar ='<font color="red">*</font>';
			//} 
			
			 
			?>
			 -->
			<!-- 
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Reference Patient') ?>
						<?php// echo $redStar; ?>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php 
					/* if(!empty($defaultSelection['Patient']['id'])){
						$u_id=$defaultSelection['Patient']['patient_id'];
					}
					else{
						$u_id=$u_id;
					}
						if(!empty($u_id)){
							echo $this->Form->input('reference_patient', array('type'=>'text','style'=>'width:134px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'reference_patient','value'=>$u_id,'readonly'=>'readonly'));
						}elseif(!empty($username))
						{
							echo $this->Form->input('reference_patient', array('type'=>'text','style'=>'width:134px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'reference_patient','value'=>$username,'readonly'=>'readonly'));
						}else if(!empty($messagePatientId)){
							echo $this->Form->input('reference_patient', array('type'=>'text','style'=>'width:134px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'reference_patient','value'=>$messagePatientId,'readonly'=>'readonly'));
						}else
						{
							echo $this->Form->input('reference_patient', array('type'=>'text','style'=>'width:134px	','class' => '','id' => 'reference_patient','value'=>$u_id));
						} */
						?>
					</td>
				</tr> 
				
				 --> 
				 
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Subject/Amendment') ?><font
						color="red">*</font>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php
					$isAmmendment = array('0'=>'Subject','1'=>'Amendment','2'=>'Referral  Summary','3' => 'Reminder', '4' => 'Lab Requisition','5'=> 'Lab Report');
					echo $this->Form->input('is_ammendment', array('style'=>'width:150px; float:left;','options'=>$isAmmendment,'empty'=>__('Please select'), 'id'=>'is_ammendment','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
					</td>
				</tr>
			
			
				<tr id="is_subject_show" style="display: none">
					<td valign="middle" id="is_subject_showtxt" class="tdLabel"
						id="boxSpace" width="60px"><font color="red">*</font>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('subject', array('type'=>'text','style'=>'width:250px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'subject')); ?>
					</td>
				</tr>
			
				<tr id="is_ammendment_show" style="display: none">
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Ammendment') ?><font
						color="red">*</font>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('subject_ammendment', array('type'=>'text','style'=>'width:250px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'subject')); ?>
					</td>
				</tr>
			
			
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Message') ?>
					</td>
			
					<td valign="middle" class="tdLabel" id="boxSpace" colspan="3"><?php echo $this->Form->textarea('message', array('class' => '','id' => 'message','rows'=>'10','cols'=>'10'));
					//echo $this->Fck->fckeditor(array('Compose','message'), $this->Html->base,'','100%','400');
					?> <input class="blueBtn" type=hidden value="" name="message_enc"
						id="message_enc">
					</td>
				</tr>
				<!-- 
				<tr>
					<td valign="middle" class="tdLabel" id="boxSpace" width="60px"><?php echo __('Date') ?>
					</td>
			
					<td valign="middle" class="tddate" id="boxSpace"><?php echo $this->Form->input('send_date', array('type'=>'text','style'=>'margin-left: 18px;','id' => 'send_date','class'=>'textBoxExpnd')); ?>
					</td>
			
				</tr>
				 -->
				<!-- 
					<tr>
						<td valign="middle" class="tdLabel" id="boxSpace" width="60px">Add to patient medical records</td>
						
						<td valign="middle" class="tdLabel" id="boxSpace">
						<?php echo $this->Form->input('',array('empty'=>__('Select'),'options'=>$users));
			 ?></td>
					</tr> -->
			
			
				<tr>
					<td valign="middle" class="btn">
						<input class="blueBtn" type=submit id="Send" value="Send" name="Send">
					</td>
					<td>
						<!-- <input class="blueBtn" name="Reset" type="reset" onclick="resetForm('composefrm'); return false;" /> -->
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<?php echo $this->Form->end();?>
<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']); ?> 

<script>

var getUserUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "getUsers","admin" => false)); ?>";
var server_path="<?php echo FULL_BASE_URL."/".$root_name[0].'js/fckeditor/' ?>";
//var server_path = "http://localhost/DrmHope/js/fckeditor/";
//var is_patient = 0;
function getUsersList(to_type){
	 
	/*if(to_type == 'Patient'){
		is_patient1 = 1;
		$('#is_patient').val(is_patient1);
	}else{
		is_patient0 = 0;
		$('#is_patient').val(is_patient0);
	}*/

	$("#SelectLeft").empty();
	$.ajax({
		type: 'POST',
		url: getUserUrl,
		data: 'to_type='+to_type,
		dataType: 'html',
		beforeSend:function(){
			    // this is where we append a loading image
			$('#busy-indicator').show('fast');
		}, 	
		success: function(data){
			//alert(data);
			//var options = createDropDown(data);
			data = JSON && JSON.parse(data) || $.parseJSON(data);
			$("#SelectRight").html('');
			$.each(data, function(val, text) {
				$("#SelectRight").append( "<option value='"+val+"'>"+text+"</option>" );
			});
			//alert(options);
			//$('#SelectRight').html(options);
			$('#busy-indicator').hide('fast');
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

$('#Send').click(function() {
	var validateMessage = jQuery("#composefrm").validationEngine('validate');
	if(validateMessage){
		encryptData();
		return validateMessage;
	}
	
});

$(function() {//$isAmmendment = array('0'=>'Subject','1'=>'Amendment','2'=>'Referral  Summary','3' => 'Reminder', '4' => 'Lab Requisition','Lab Report');

	if($("#is_ammendment").val() == '0'){
        // $("#is_subject_show").show();
        //	$("#is_ammendment_show").hide();
       	//$("#subject").val('Subject');
       	$("#is_subject_show").show();
       }else if($("#is_ammendment").val() == '1'){
       	//$("#is_ammendment_show").show();
       	//$("#is_subject_show").hide();
       	//$("#subject").val('Amendment');
       	$("#is_subject_show").show();
       }else if($("#is_ammendment").val() == "2"){
       	//$("#subject").val('Referral  Summary');
       	$("#is_subject_show").show();
       }else if($("#is_ammendment").val() == "3"){
       	//$("#subject").val('Reminder');
       	$("#is_subject_show").show();
       }else if($("#is_ammendment").val() == "4"){
       	//$("#subject").val('Lab Requisition');
       	$("#is_subject_show").show();
       }else if($("#is_ammendment").val() == "5"){
       	//$("#subject").val('Lab Report');
       	$("#is_subject_show").show();
       }

    
    $("#is_ammendment").change(function(event) {
    	if($("#is_ammendment").val() == '0'){
         // $("#is_subject_show").show();
         //	$("#is_ammendment_show").hide();
        	//$("#subject").val('Subject');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == '1'){
        	//$("#is_ammendment_show").show();
        	//$("#is_subject_show").hide();
        	//$("#subject").val('Amendment');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "2"){
        	//$("#subject").val('Referral  Summary');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "3"){
        	//$("#subject").val('Reminder');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "4"){
        	//$("#subject").val('Lab Requisition');
        	$("#is_subject_show").show();
        }else if($("#is_ammendment").val() == "5"){
        	//$("#subject").val('Lab Report');
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
$(function(){
	var userRole = '<?php echo $this->Session->read('role')?>';
	if(userRole != 'Patient'){
		$("#reference_patient").removeClass("validate[required,custom[mandatory-enter]] textBoxExpnd");
	}
});
$('#is_ammendment')
.change(
		function (){
			vaccin_name = $('#is_ammendment').text();
			if(vaccin_name=='Please select'){
				$("#is_subject_show").hide();
			}
		  
			public_name = $('#is_subject_showtxt').text();
			
			var e = document.getElementById("is_ammendment");
			var strUser = e.options[e.selectedIndex].text;
	        if(strUser=='Please select'){
				$("#is_subject_show").hide();
			}
	        var vacc_ary = strUser.split("-");
	        public_name = public_name.replace(public_name,vacc_ary[0]);
	        $('#is_subject_showtxt').html(public_name);			
			
		})
</script>
