
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Text</td>
	</tr>
	
	<tr width="100%">
		<td><table>
				<tr id='showSig'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchSign','class'=>'')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplateSign();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));
								echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'addSig','style'=>'padding-left:5px;cursor:pointer'));?>
					</td>
				</tr>
				<tr style="display: none" id='showSubAddSig'>
					<td><?php echo $this->Form->input('add',array('type'=>'text','label'=>false,'name'=>'subTitle','id'=>'subTextSig')); ?>
					</td>
					<td><?php echo $this->Html->link('Submit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'addSubjectiveDataSig','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelSubSig','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<tr style="display: none" id='editSubAddSign'>
					<td><?php echo $this->Form->input('edit',array('type'=>'text','label'=>false,'name'=>'subEditTitleSig','id'=>'subEditTextSig')); ?>
					<?php echo $this->Form->hidden('id',array('id'=>'editIdSign'))?>
					</td>
					<td><?php echo $this->Form->input('Edit',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'EditSubjectiveDataSig','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Form->input('Cancel',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelSubSig','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table>

					</td>
					</tr>
					<?php if(!empty($significantTests)){?>
					<tr>
						<td>Name</td>
						<td colspan="2">Action</td>
					</tr>
					<?php foreach($significantTests as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'editSS')); ?></td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editSubSig')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>$data['NoteTemplateText']['id']."_".$data['NoteTemplateText']['template_id'],'class'=>'deleteSub')); ?>
					</td>
					</tr>
					<?php }
						}?>
						</td>
					</tr>
				</table>
				<script>
//---------show add From
$('#addSig').click(function(){
	$('#showSubAddSig').show();
	$('#showSig').hide();
});
$('#CancelSubSig').click(function(){
	$('#showSubAddSig').hide();
	$('#showSig').show();
});
//---------------------------
$('#addSig').click(function(){
	$('#showSubAddSig').show();
	$('#showSig').hide();
});
//------Copy text-------------
$('.editSS').click(function(){
	var id=$(this).attr('id');
	var currentVal=$('#subShowSig').val();
	$('#subShowSig').val(id+" "+currentVal);
	id="";
});
//***********************Save Template Text********************************
$('#addSubjectiveDataSig').click(function(){
	var contentType="SignificantTests";
	var templateID="<?php echo $significantTestsID;?>";
	var templateText=$('#subTextSig').val();
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentType+"/"+templateID+"/"+templateText,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	 $('#showSignificantTests').html(data);
    return false;
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editSubSig').click(function(){
var currentId=$(this).attr('id');
$('#editSubAddSign').show();
var splitData=currentId.split('_');
$('#subEditTextSig').val(splitData[1]);
$('#editIdSign').val(splitData[2]);

$('#EditSubjectiveDataSig').click(function(){
	
	var contentTypeE="SignificantTests";
	var search=$('#search').val();
	var templateIDE="<?php echo $significantTests[0]['NoteTemplateText']['template_id']?>"
	var templateTextE=$('#subEditTextSig').val();
	var idE=$('#editIdSign').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeE+"/"+templateIDE+"/"+templateTextE+"/"+idE,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#showSignificantTests').html(data);
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
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+"SignificantTests",
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#showSignificantTests').html(data);
    },
	});
	} else {
		 return false;
	}
});
function searchTemplateSign(){
	var searchString=$('#searchSign').val();
	var templateID="<?php echo $ccID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "searchTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'SignificantTests'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#showSignificantTests').html(data);
    },
	});
}
</script>