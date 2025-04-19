
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Content</td>
	</tr>
	<tr width="100%">
		<td><table>
				<tr id='showObjAdd1'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchObj','class'=>'')); ?>
					</td>
					<td><?php if(!empty($objective)){ echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplateObj();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));}
								echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'addObj','style'=>'padding-left:5px;cursor:pointer'));?>
					</td>
				</tr>
				<tr style="display: none" id='showObjAdd'>
					<td><?php echo $this->Form->input('add',array('type'=>'text','label'=>false,'name'=>'subTitle','id'=>'objText')); ?>
					</td>
					<td><?php echo $this->Html->link('Submit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'addObjectiveData','class'=>'Bluebtn')); ?>
					
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelObj','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<tr style="display: none" id='editObjAdd'>
					<td><?php echo $this->Form->input('edit',array('type'=>'text','label'=>false,'name'=>'subEditTitle','id'=>'objEditText')); ?>
						<?php echo $this->Form->hidden('id',array('id'=>'editIdobj'))?>
					</td>
					<td><?php echo $this->Html->link('Update','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'editObjjectiveData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelObjText','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table id="objectiveTableNew">

					</td>
					</tr>
					<?php if(!empty($objective)){?>
					<tr>
						<td>Template for Physical Examination</td>
						<td colspan="2"></td>
					</tr>
					<?php foreach($objective as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'edito')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editObj')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>$data['NoteTemplateText']['id']."_".$data['NoteTemplateText']['template_id'],'class'=>'deleteObj')); ?>
					</td>
					</tr>
					<?php }
						}?>
				</table>
				</table>
				</td>
				</tr>
				</table>
				<div id="pageNavPositionObj" align="left"></div>
				<script>
				<?php  if(!empty($objective)) { ?>
				var pagerObj = new Pager('objectiveTableNew', 5); 
				pagerObj.init(); 
				pagerObj.showPageNav('pagerObj', 'pageNavPositionObj'); 
				pagerObj.showPage(1);
			<?php } ?>
//---------show add From
$('#addObj').click(function(){
	var copyText=$('#searchObj').val();
	$('#objText').val(copyText);
	$('#showObjAdd').show();
	$('#showObjAdd1').hide();
});
$('#CancelObj').click(function(){
	$('#showObjAdd').hide();
	$('#showObjAdd1').show();
});
$('#CancelObjText').click(function(){
	$('#showObjAdd').hide();
	$('#showObjAdd1').show();
	$('#editObjAdd').hide();
});
//---------------------------
$('#addSub').click(function(){
	$('#showSubAdd').show();
	$('#showSubAdd1').hide();
});
//------Copy text-------------
$('.edito').click(function(){
	var id=$(this).attr('id');
	//var currentVal=$('#objectShow').val();
	var currentValCloncial=$('#objectDataNew').val();
	$('#objectDataNew').val($.trim(currentValCloncial)+" "+id);
	$('#objectDataNew').focus();
	id="";
});
//***********************Save Template Text********************************
$('#addObjectiveData').click(function(){
	var contentType="objective";
	var templateID="<?php echo $objectiveID;?>"
	var templateText=$('#objText').val();
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
        	  $('#objectiveDisplay').html(data);
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editObj').click(function(){
var currentId=$(this).attr('id');
$('#editObjAdd').show();
$('#showObjAdd1').hide();
var splitData=currentId.split('_');
$('#objEditText').val(splitData[1]);
$('#editIdobj').val(splitData[2]);
 
$('#editObjjectiveData').click(function(){
	
	var contentTypeO="objective";
	var templateIDO="<?php echo $objective[0]['NoteTemplateText']['template_id']?>"
	var templateTextO=$('#objEditText').val();
	var idO=$('#editIdobj').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeO+"/"+templateIDO+"/"+templateTextO+"/"+idO,
    success: function(data){
    	alert('Updated successfully');
    	$('#busy-indicator').hide('slow');
    	$('#objectiveDisplay').show();
    	  $('#objectiveDisplay').html(data);
    },
	});
	
});
return false;
	
});
//*************************************delete the text************************************************
$('.deleteObj').click(function(){
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
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+"objective",
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#objectiveDisplay').html(data);
    },
	});
	} else {
		 return false;
	}	
});
function searchTemplateObj(){
	var searchString=$('#searchObj').val();
	if(searchString==''){
		alert('Please enter value to search');
		return false;
	}
	var templateID="<?php echo $objectiveID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "searchTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'objective'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#objectiveDisplay').html(data);
    },
	});
}
</script>