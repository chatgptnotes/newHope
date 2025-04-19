
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Text</td>
	</tr>
	
	<tr width="100%">
		<td><table>
				<tr id='showSubAdd1'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchSub','class'=>'')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplateSub();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));
								echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'addSub','style'=>'padding-left:5px;cursor:pointer'));?>
					</td>
				</tr>
				<tr style="display: none" id='showSubAdd'>
					<td><?php echo $this->Form->input('add',array('type'=>'text','label'=>false,'name'=>'subTitle','id'=>'subText')); ?>
					</td>
					<td><?php echo $this->Html->link('Submit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'addSubjectiveData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelSub','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<tr style="display: none" id='editSubAdd'>
					<td><?php echo $this->Form->input('edit',array('type'=>'text','label'=>false,'name'=>'subEditTitle','id'=>'subEditText')); ?>
					<?php echo $this->Form->hidden('id',array('id'=>'editId'))?>
					</td>
					<td><?php echo $this->Html->link('Edit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'EditSubjectiveData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelSub','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table>

					</td>
					</tr>
					<?php if(!empty($cc)){?>
					<tr>
						<td>Name</td>
						<td colspan="2">Action</td>
					</tr>
					<?php foreach($cc as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'edit')); ?></td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editSub')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>$data['NoteTemplateText']['id']."_".$data['NoteTemplateText']['template_id'],'class'=>'deleteSub')); ?>
					</td>
					</tr>
					<?php }
						}
						?>
						</td>
					</tr>
				</table>
				<script>
//---------show add From
$('#addSub').click(function(){
	$('#showSubAdd').show();
	$('#showSubAdd1').hide();
});
$('#CancelSub').click(function(){
	$('#showSubAdd').hide();
	$('#showSubAdd1').show();
});
//---------------------------
$('#addSub').click(function(){
	$('#showSubAdd').show();
	$('#showSubAdd1').hide();
});
//------Copy text-------------
$('.edit').click(function(){
	var id=$(this).attr('id');
	var currentVal=$('#subShow').val();
	$('#subShow').val(id+" "+currentVal);
	id="";
});
//***********************Save Template Text********************************

$('#addSubjectiveData').click(function(){
	var contentType="ChiefCompalint";
	var templateID="<?php echo $ccID;?>";
	var templateText=$('#subText').val();
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentType+"/"+templateID+"/"+templateText,
    success: function(data){
    	$('#busy-indicator').hide('slow');
  	  $('#showCheifComplaints').html(data);
    return false;
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editSub').click(function(){
var currentId=$(this).attr('id');
$('#editSubAdd').show();
var splitData=currentId.split('_');
$('#subEditText').val(splitData[1]);
$('#editId').val(splitData[2]);

$('#EditSubjectiveData').click(function(){
	
	var contentTypeE="ChiefCompalint";
	var search=$('#search').val();
	var templateIDE="<?php echo $cc[0]['NoteTemplateText']['template_id']?>"
	var templateTextE=$('#subEditText').val();
	var idE=$('#editId').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeE+"/"+templateIDE+"/"+templateTextE+"/"+idE,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#showCheifComplaints').html(data);
    },
	});
	
});
return false;
	
});
//*************************************delete the text************************************************
$('.deleteSub').click(function(){
	var r = confirm("Are you sure you want delete it.");
	if (r == true) {
	var currentId=$(this).attr('id')
	var spData=currentId.split('_');
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "deleteTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+"ChiefCompalint",
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#showCheifComplaints').html(data);
    },
	});
	} else {
		 return false;
	}
});
function searchTemplateSub(){
	var searchString=$('#searchSub').val();
	var templateID="<?php echo $ccID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "searchTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'ChiefCompalint'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#showCheifComplaints').html(data);
    },
	});
}
</script>