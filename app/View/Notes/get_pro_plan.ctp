
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Content</td>
	</tr>
	<tr width="100%">
		<td><table>
				<tr id='showRosAdd1'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchRos','class'=>'')); ?>
					</td>
					<td><?php if(!empty($ros)){ echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplateRos();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));}
								echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'addRos','style'=>'padding-left:5px;cursor:pointer'));?>
					</td>
				</tr>
				<tr style="display: none" id='showRosAddd'>
					<td><?php echo $this->Form->input('add',array('type'=>'text','label'=>false,'name'=>'subTitle','id'=>'rosText')); ?>
					</td>
					<td><?php echo  $this->Html->link('Submit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'addRosData','class'=>'Bluebtn')); ?>
					
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelRos','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<tr style="display: none" id='editRosAdd'>
					<td><?php echo $this->Form->input('edit',array('type'=>'text','label'=>false,'name'=>'subEditTitle','id'=>'rosEditText')); ?>
						<?php echo $this->Form->hidden('id',array('id'=>'editIdros'))?>
					</td>
					<td><?php echo $this->Html->link('Update','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'editRosData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelRos','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table id='rosTable'>

					</td>
					</tr>
					<?php if(!empty($ros)){?>
					<tr>
						<td>Template for Review of System</td>
						<td colspan="2"></td>
					</tr>
					<?php foreach($ros as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'editR')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editRos')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>$data['NoteTemplateText']['id']."_".$data['NoteTemplateText']['template_id'],'class'=>'deleteRos')); ?>
					</td>
					</tr>
					<?php }
						}?>
				</table>
				</table>
				</td>
				</tr>
				</table>
				<div id="pageNavPositionRos" align="left"></div>
				<script>
				<?php if(!empty($ros)) { ?>
				var pagerRos = new Pager('rosTable', 5); 
				pagerRos.init(); 
				pagerRos.showPageNav('pagerRos', 'pageNavPositionRos'); 
				pagerRos.showPage(1);
			<?php } ?>
//---------show add From
$('#addRos').click(function(){
	$('#showRosAddd').show();
	$('#showRosAdd1').hide();
});
$('#CancelRos').click(function(){
	$('#showRosAddd').hide();
	$('#showRosAdd1').show();
});
//---------------------------
$('#addSub').click(function(){
	$('#showAsseAddd').show();
	$('#showAsseAdd1').hide();
});
//------Copy text-------------
$('.editR').click(function(){
	var id1=$(this).attr('id');
	var currentVal=$('#procedure_note').val();
	$('#procedure_note').val(currentVal+" "+id1);
	$('#procedure_note').focus();
	id1="";
});
//***********************Save Template Text********************************
$('#addRosData').click(function(){
	var contentType="procedure";
	var templateID="<?php echo $rosID?>"
	var templateText=$('#rosText').val();
	if(templateText==''){
		alert('Please enter value to save');
		return false;
	}
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateTextProcedure","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentType+"/"+templateID+"/"+templateText,
    success: function(data){
        	$('#busy-indicator').hide('slow');
        	  $('#ProcedureDisplay').html(data);
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editRos').click(function(){
var currentId=$(this).attr('id');
$('#editRosAdd').show();
$('#showRosAdd1').hide();
var splitData=currentId.split('_');
$('#rosEditText').val(splitData[1]);
$('#editIdros').val(splitData[2]);
$('#editRosData').click(function(){
	
	var contentTypeR="procedure";
	var templateIDR="<?php echo $ros[0]['NoteTemplateText']['template_id']?>"
	var templateTextR=$('#rosEditText').val();
	var idR=$('#editIdros').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateTextProcedure","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeR+"/"+templateIDR+"/"+templateTextR+"/"+idR,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#ProcedureDisplay').html(data);
    },
	});
	
});
return false;
	
});
//*************************************delete the text************************************************
$('.deleteRos').click(function(){
	var r = confirm("Are you sure you want delete it.");
	if (r == true) {
	var currentId=$(this).attr('id');
	var spData=currentId.split('_');
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteTemplateTextProcedure","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+"procedure",
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#ProcedureDisplay').html(data);
    },
	});
	} else {
		 return false;
	}	
});
function searchTemplateRos(){
	var searchString=$('#searchRos').val();
	if(searchString==''){
		alert('Please enter value to search');
		return false;
	}
	var templateID="<?php echo $rosID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "searchTemplateTextProcedure","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'procedure'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#ProcedureDisplay').html(data);
    },
	});
}
</script>