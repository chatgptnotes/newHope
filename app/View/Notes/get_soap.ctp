
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Content</td>
		<?php //echo $this->Form->hidden('',array('id'=>'searchSubIds'));?>
	</tr>
	<tr width="100%">
		<td><table>
				<tr id='showSubAdd1'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchSub','class'=>'')); ?>
					</td>
					<td><?php  if(!empty($subjective)){ echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplateSub();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));}
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
					<td><?php echo $this->Html->link('Update','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'EditSubjectiveData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelSubEdit','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table id='subTable'>

					</td>
					</tr>
					<?php if(!empty($subjective)){?>
					<tr>
						<td>Template for HPI</td>
						<td colspan="2"></td>
					</tr>
					<?php foreach($subjective as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'edit')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editSub')); ?>
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
				</table>
				</td>
				</tr>
				</table>
				<div id="pageNavPosition" align="left"></div>
				<script>
				<?php if(!empty($subjective)) { ?>
				var pager = new Pager('subTable', 5); 
				pager.init(); 
				pager.showPageNav('pager', 'pageNavPosition'); 
				pager.showPage(1);
			<?php } ?>
//---------show add From
$('#addSub').click(function(){
	$('#showSubAdd').show();
	var copyText=$('#searchSub').val();
	$('#subText').val(copyText);
	$('#showSubAdd1').hide();
});
$('#CancelSubEdit').click(function(){
	$('#showSubAdd').hide();
	$('#showSubAdd1').show();
	$('#editSubAdd').hide();
	
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
	var currentValClincial=$('#hpiTextNew').val();
	$('#subShow').val('');
	$('#subShow').val(currentVal+" "+id);
	$('#hpiTextNew').val(currentValClincial+" "+id);
	$('#subShow').focus();
	id="";
	currentVal='';

});
//***********************Save Template Text********************************
$('#addSubjectiveData').click(function(){
	var contentType="subjective";
	var templateID="<?php echo $subjectiveID;?>";
	var templateText=$('#subText').val();
	if(templateText==''){
		alert('Please enter value to save');
		return false;
	}
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentType+"/"+templateID+"/"+templateText,
    success: function(data){
    	$('#busy-indicator').hide('slow');
  	  $('#subjectiveDisplay').html(data);
    return false;
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editSub').click(function(){
var currentId=$(this).attr('id');
$('#editSubAdd').show();
$('#showSubAdd1').hide();
var splitData=currentId.split('_');
$('#subEditText').val(splitData[1]);
$('#editId').val(splitData[2]);

$('#EditSubjectiveData').click(function(){
	
	var contentTypeE="subjective";
	var search=$('#search').val();
	var templateIDE="<?php echo $subjective[0]['NoteTemplateText']['template_id']?>"
	var templateTextE=$('#subEditText').val();
	var idE=$('#editId').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeE+"/"+templateIDE+"/"+templateTextE+"/"+idE,
    success: function(data){
        alert('Updated successfully');
    	$('#busy-indicator').hide('slow');
    	$('#subjectiveDisplay').show();
    	  $('#subjectiveDisplay').html(data);
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
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+'subjective',
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#subjectiveDisplay').html(data);
    },
	});
	} else {
		 return false;
	}
});
function searchTemplateSub(){
	var searchString=$('#searchSub').val();
	if(searchString==''){
		alert('Please enter value to search');
		return false;
	}
	var templateID="<?php echo $subjectiveID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "searchTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'subjective'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#subjectiveDisplay').html(data);
    },
	});
}
	

</script>