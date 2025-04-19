<style>
.textBoxExpnd {
    width: 48%;
}
</style>
<div class="inner_title">
	<h3><?php echo __('Add Group', true); ?></h3>
</div>

<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('AccountingGroup',array('id'=>'accountingGroupFrm','name'=>'myForm'/*,'onkeypress'=>"return event.keyCode != 13;"*/,
		'url'=>array('controller'=>'Accounting','action'=>'group_add','admin'=>true)));?>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
			<table width="60%" border="0" cellspacing="0" cellpadding="0" class="formFull"  align="center">
				<tr>
					<td class="tdLabel" width="50%"><?php echo __('Name :'); ?><font style="color:Red">*</font></td>
					<td><?php echo $this->Form->input('AccountingGroup.name',array('class' => 'validate[required,custom[name]] textBoxExpnd inputBox',
							'id' => 'groupname', 'label'=> false, 'div' => false,'autocomplete'=>'off')); ?>
					</td>
				</tr>
				<tr id='code_name'>
					<td class="tdLabel" width="50%"><?php echo __('Alias'); ?></td>
					<td><?php echo $this->Form->input('AccountingGroup.code_name', array('class' => 'textBoxExpnd inputBox','id' =>'codeName', 
							'label'=> false, 'div' => false,'field_no'=>'2', 'error' => false,'autocomplete'=>'off'));?>
						<i>(For configuration purpose only)</i>
					</td>
				</tr>
				<tr>
	     			<td id="sub_type" class="tdLabel"><?php echo __('Under Account Type :'); ?></td>
					<td><?php echo $this->Form->input('AccountingGroup.parent_id',array('type'=>'select','options'=>$groupName,'label'=> false, 'disabled'=>true,
							'div' => false,'empty'=>'Primary', 'id'=>'accountGroup','class'=>'textBoxExpnd inputBox')); ?>
					</td>
				</tr>
				<tr id="account_type">
	     			<td class="tdLabel"><?php echo __('Nature of Group :'); ?><font style="color:Red">*</font></td>
					<td><?php echo $this->Form->input('AccountingGroup.account_type',array('type'=>'select','options'=>Configure::read('account_type'), 
							'label'=> false, 'div' => false,'empty'=>'Please Select','id'=>'accountType','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd inputBox')); ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<?php echo $this->Form->submit(__('Save'), array('class'=>'blueBtn inputBox','div'=>false,'id'=>'submit')); ?>
						<?php $cancelBtnUrl =  array('controller'=>'accounting','action'=>'group_creation');?>
			     		<?php echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?>
     				</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $this->Form->end()?>
<script>
$(document).ready(function(){
	$("#groupname").focus().attr('placeHolder','Enter Group Name');
	jQuery("#accountingGroupFrm").validationEngine({
		//validateNonVisibleFields: true,
		//updatePromptsPosition:true,
	});
});
$("#accountGroup").show();
$('#accountGroup').change(function(){
	var myVal = $(this).val();
	if(myVal == ''){
		$("#account_type").show();
	}else{
		$("#accountType").val('');
		$("#account_type").hide();
	}
});

 $("#groupname").keyup(function() {
	   //toUpper(this);
	});

function toUpper(obj) {
    var mystring = obj.value;
    var sp = mystring.split(' ');
    var wl=0;
    var f ,r;
    var word = new Array();
    for (i = 0 ; i < sp.length ; i ++ ) {
        f = sp[i].substring(0,1).toUpperCase();
        r = sp[i].substring(1).toLowerCase();
        word[i] = f+r;
    }
    newstring = word.join(' ');
    obj.value = newstring;
    return true;  
}
$(document).ready(function(){
	$('.inputBox').keypress('',function(e) {
		CheckisEmpty();
		var id = $(this).attr('id');
	    if(e.keyCode==13){		//key enter
	    	if(id === "groupname"){
	    		CheckisEmpty();
	    		$("#codeName").focus();
	    		e.preventDefault();
	    	}else if(id === "codeName"){
	    		$("#accountGroup").focus();
	    		e.preventDefault();
	    	}else if(id === "accountGroup"){
	    			if($("#accountGroup").val()==''){
	    				$("#accountType").focus();
	    	        	e.preventDefault();
	    			}else{
	    				$("#submit").focus();
	    	    		e.preventDefault();
	    			}
	    	}else if(id==="accountType"){
	    		$("#submit").focus();
	    		e.preventDefault();
	   		}
		}
	});
});
function CheckisEmpty(){
	if($("#groupname").val()!=''){
		$("#codeName").attr('disabled',false);
		$("#accountGroup").attr('disabled',false);
		$("#accountType").attr('disabled',false);
	}else{
		$("#codeName").attr('disabled',true);
		$("#accountGroup").attr('disabled',true);
		$("#accountType").attr('disabled',true);
	}
}
</script>