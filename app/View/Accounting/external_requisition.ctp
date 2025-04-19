<?php echo $this->Html->script(array('jquery.blockUI')); 
	 echo $this->Html->script(array('inline_msg'));?>
<style>
.textBoxExpnd {
    width: 48%;
}
</style>
<div class="inner_title">
	<h3><?php echo __('External Requisition Commission', true); ?></h3>
</div>

<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('ExternalRequisitionCommission',array('id'=>'externalRequisition',
		'url'=>array('controller'=>'Accounting','action'=>'ExternalRequisition','admin'=>false)));?>
<?php echo $this->Form->hidden('',array('id'=>'no_of_rows','value'=>'0'));?>
<table border="0" class="formFull myTable" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr id="row_1">
		<td><?php echo __('Select Service Provider:');?><font style="color:Red">*</font></td>
		<td>
		<?php echo $this->Form->input(null,array('id'=>"provider_id",'type'=>'select','class'=>'validate[required,custom[mandatory-select]]',
				'label'=>false,'options'=>array($serviceProvider),'empty'=>'Please Select','name'=>"data[service_provider_id]"));
			echo $this->Form->hidden(null,array('value'=>$categoryId,'name'=>"data[service_category_id]"));?>
		</td>

		<td><?php echo __('Services :')?><font style="color:Red">*</font></td>
		<td>
			<?php echo $this->Form->input(null,array('id'=>'serviceName','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off',
				'class' => 'validate[required,custom[mandatory-enter]] serviceName','name'=>"data[ExternalRequisitionCommission][0][service_name]"));
				echo $this->Form->hidden(null,array('id'=>'hiddenId_0','name'=>"data[ExternalRequisitionCommission][0][service_id]"));?>
		</td>
		<td><?php echo __('Private Charges :'); ?><font style="color:Red">*</font></td>
		<td><?php echo $this->Form->input(null,array('type'=>'text','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd private_amount',
				'id' => 'privateAmount','label'=> false, 'div' => false,'autocomplete'=>'off','name'=>"data[ExternalRequisitionCommission][0][private_amount]")); ?>
		</td>
		<td><?php echo __('CGHS Charges :'); ?><font style="color:Red">*</font></td>
		<td><?php echo $this->Form->input(null,array('type'=>'text','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd',
				'id' => 'cghsAmount','label'=> false, 'div' => false,'autocomplete'=>'off','name'=>"data[ExternalRequisitionCommission][0][cghs_amount]")); ?>
		<span style="float: right;">
			<?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addMore",'title'=>'Add1','class'=>'addMore','onclick'=>'AddMore()'));?>
		</span>
		</td>
	</tr>	
</table>
<table width="100%">
	<tr>
		<td align="right">
			<?php echo $this->Form->submit(__('Save'), array('class'=>'blueBtn','div'=>false,'id'=>'submit')); 
     		echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'admin_menu',"admin" => true, '?' => array('type'=>'master')),
			 array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));?>
     	</td>
	</tr>
</table>
<?php echo $this->Form->end()?>
<?php if(!empty($commissionData)){?>
<table width="99%"><tr><td align="center" width="50%" id="message-display"></td><td></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<thead>
		<tr> 
			<th align="center" valign="top" style="text-align: center;"><?php echo __("Service Provider");?></th> 
			<th align="center" valign="top" style="text-align: center;"><?php echo __("Service Name");?></th> 
			<th align="center" valign="top" style="text-align: center;"><?php echo __("Private Charges");?></th> 
			<th align="center" valign="top" style="text-align: center;"><?php echo __("CGHS Charges");?></th> 
			<th align="center" valign="top" style="text-align: center;"><?php echo __("Actions");?></th> 
		</tr> 
	</thead>
	
	<tbody>
	<?php foreach($commissionData as $key=> $data) { ?>
		<tr id="row_<?php echo $commissionId = $data['ExternalRequisitionCommission']['id']; ?>" fieldno="<?php echo $key; ?>">
			<td align="left" style= "text-align: center;">
				<?php echo $data['ServiceProvider']['name']; ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;">
				<?php echo $data['Radiology']['name']; ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;" id="show-private_<?php echo $commissionId;?>">
				<?php echo $this->Number->currency($data['ExternalRequisitionCommission']['private_amount']); ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;" id="show-cghs_<?php echo $commissionId;?>">
				<?php echo $this->Number->currency($data['ExternalRequisitionCommission']['cghs_amount']); ?>
			</td>
			<td valign="top" style="text-align: center;" id="show-icon_<?php echo $commissionId;?>">
				<?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Commission'),
				'title'=> __('Edit Commission'),'onclick'=>"editCommission($commissionId,'edit')")),'javascript:void(0);', array('escape' => false));
				echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Commission'),
				'title'=> __('Delete Commission'),'onclick'=>"editCommission($commissionId,'delete')")),'javascript:void(0);',array('escape' => false));?>
			</td>
	  	</tr>
	  	<tr id="showInputRow_<?php echo $commissionId = $data['ExternalRequisitionCommission']['id']; ?>" style="display:none;">
			<td align="left" style= "text-align: center;">
				<?php echo $data['ServiceProvider']['name']; ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;">
				<?php echo $data['Radiology']['name']; ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;">
				<?php echo $this->Form->input(null,array('type'=>'text','class'=>'validate[required,custom[onlyNumber]] textBoxExpnd private_amount',
				'id'=>'privateAmount_'.$commissionId,'value'=>!empty($data['ExternalRequisitionCommission']['private_amount'])?$data['ExternalRequisitionCommission']['private_amount']:"",
				'label'=> false, 'div' => false,'autocomplete'=>'off','name'=>"data[ExternalRequisitionCommission][private_amount][$commissionId]")); ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;">
				<?php echo $this->Form->input(null,array('type'=>'text','class'=>'validate[required,custom[onlyNumber]] textBoxExpnd cghs_amount',
				'id'=>'cghsAmount_'.$commissionId,'value'=>!empty($data['ExternalRequisitionCommission']['cghs_amount'])?$data['ExternalRequisitionCommission']['cghs_amount']:"",
				'label'=> false, 'div' => false,'autocomplete'=>'off','name'=>"data[ExternalRequisitionCommission][cghs_amount][$commissionId]")); ?>
			</td>
			<td class="tdLabel"  style= "text-align: center;">
			<?php echo $this->Html->link($this->Html->image('icons/save_histo_template.png', array('alt' => __('Update Commission'),
					'title' => __('Update Commission'),'onclick'=>"save($commissionId,'update')")),'javascript:void(0);', array('escape' => false));
				echo $this->Html->link($this->Html->image('icons/cross.png', array('alt' => __('Cancel'),'title' => __('Cancel'),
				'onclick'=>"editCommission($commissionId,'cancel')")),'javascript:void(0);', array('escape' => false));?>
			</td>
	  	</tr>
	 <?php }?>
	</tbody>
</table>
<?php } ?>
<script>
$(document).ready(function(){
	$("#submit").click(function(){
		var validateForm = jQuery("#externalRequisition").validationEngine('validate');
		if(validateForm == true){
			$("#submit").hide();
		}else{
			return false;
		}
	});
	 $( "#serviceName" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "radChargesAutocomplete","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#hiddenId_0').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
});

	function AddMore(){
		var count = parseInt($("#no_of_rows").val())+1; 
		var field = '';
			field += '<tr id="row_'+count+'">';
			field += 	'<td></td>';
			field += 	'<td></td>';
			field += 	'<td><?php echo __('Services :')?><font style="color:Red">*</font></td>';
			field += 	'<td><input type="text" name="data[ExternalRequisitionCommission]['+count+'][service_name]" class="validate[required,custom[mandatory-enter]] serviceName" id="serviceName_'+count+'" autocomplete="false"/> <input type="hidden" name="data[ExternalRequisitionCommission]['+count+'][service_id]" id="hiddenId_'+count+'" /></td>'; 
			field += 	'<td><?php echo __('Private Charges :'); ?><font style="color:Red">*</font></td>';
			field +=	'<td><input type="text" class = "validate[required,custom[onlyNumber]] textBoxExpnd private_amount" name="data[ExternalRequisitionCommission]['+count+'][private_amount]"  id = "privateAmount_'+count+'"/></td>';
			field += 	'<td><?php echo __('CGHS Charges :'); ?><font style="color:Red">*</font></td>';
			field +=	'<td><input type="text" class = "validate[required,custom[onlyNumber]] textBoxExpnd cghs_amount" name="data[ExternalRequisitionCommission]['+count+'][cghs_amount]"  id = "cghsAmount_'+count+'"/></td>';
			field +=	'<td><a class="deleteRow" href="javascript:void(0);" id="deleteRow_'+count+'"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
			field += '</tr>'; 
			
		$(".myTable").append(field);
		$("#no_of_rows").val(count);
	}

	$(document).on('click','.deleteRow',function(){
		currID = $(this).attr('id').split("_")[1];
		$("#row_"+currID).remove();
		
		childAddMoreCnt = $("#no_of_rows").val();
		$("#no_of_rows").val(childAddMoreCnt-1);
	});
	
$(document).ready(function(){
 	$('.addMore').on('click',function(){
		var field = $("#no_of_rows").val();
		 $( ".serviceName" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "radChargesAutocomplete","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) { 
				$('#hiddenId_'+$(this).attr('id').split("_")[1]).val(ui.item.id);
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
	});
});

function editCommission(id,type){
	if(type == "edit"){
		$("#row_"+id).hide();
		$("#showInputRow_"+id).show('slow');
	}else if(type == "delete"){
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "deleteCommissions" ,"plugin"=>false)); ?>"+"/"+id;
		$.ajax({ 
			  url: ajaxUrl,
	  		  beforeSend:function(){ 
	  			 loading(id);
	 		     inlineMsg("message-display",'Deleting Record, please wait..',false);
	 		  },
			  success : function(data){
				  onCompleteRequest(id);
				  $("#row_"+id).hide();
				  $("#showInputRow_"+id).hide();
				  inlineMsg("message-display",'Record deleted successfully',false);
			  }
		});
	}else if(type == "cancel"){
		$("#showInputRow_"+id).hide();
		$("#row_"+id).show();
	}
}
function save(id,type){
	loading(id);
	var commission_id = '';
	if(type == "update"){ 
		commission_id = id;
	} 
	var currentId = "message-display";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "updateCommissions" ,"plugin"=>false)); ?>";
	$.ajax({
		  type: "POST",
		  url: ajaxUrl,
		  data: "id="+commission_id+
		  		"&private_amount="+ $("#privateAmount_"+id).val()+
		  		"&cghs_amount="+ $("#cghsAmount_"+id).val(),

  		  beforeSend:function(){ 
  			if(type == "update"){ 
 		     	inlineMsg(currentId,'Updating Record, please wait..',false);
  			}else{
  				inlineMsg(currentId,'Inserting Record, please wait..',false);
  			}
 		  },
 		  
		  success : function(data){
			   onCompleteRequest(id);
			   var obj = JSON.parse(data); 
				if(obj.status == 'updated'){
					displayText(obj.id,obj.private_amount,obj.cghs_amount); 
					$("#showInputRow_"+id).hide();
					$("#row_"+id).show('slow');
					inlineMsg(currentId,'Record updated successfully..',false);
				}
		  },

		  error: function () {
			  inlineMsg(currentId,'Unable to update record..!!',false);
              onCompleteRequest(id);
          }
	});
}
function displayText(id,private_amount,cghs_amount){
	$("#show-private_"+id).text(private_amount);
	$("#show-cghs_"+id).text(cghs_amount);
}
</script>
