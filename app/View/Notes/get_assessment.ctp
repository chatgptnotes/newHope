
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Content</td>
	</tr>
	<tr width="100%">
		<td><table>
				<tr id='showAsseAdd1'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchAsse','class'=>'')); ?>
					</td>
					<td><?php if(!empty($assessment)){ echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplateAsse();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));}
								echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'addAsse','style'=>'padding-left:5px;cursor:pointer'));?>
					</td>
				</tr>
				<tr style="display: none" id='showAsseAddd'>
					<td><?php echo $this->Form->input('add',array('type'=>'text','label'=>false,'name'=>'subTitle','id'=>'asseText')); ?>
					</td>
					<td><?php echo  $this->Html->link('Submit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'addAsseData','class'=>'Bluebtn')); ?>
					
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelAsse','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<tr style="display: none" id='editAsseAdd'>
					<td><?php echo $this->Form->input('edit',array('type'=>'text','label'=>false,'name'=>'subEditTitle','id'=>'AsseEditText')); ?>
						<?php echo $this->Form->hidden('id',array('id'=>'editIdasse'))?>
					</td>
					<td><?php echo $this->Html->link('Update','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'editAsseData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelAsseEdit','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table id="AssTable">

					</td>
					</tr>
					<?php if(!empty($assessment)){?>
					<tr>
						<td>Template for Assessment</td>
						<td colspan="2"></td>
					</tr>
					<?php foreach($assessment as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'editA')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editAsse')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>$data['NoteTemplateText']['id']."_".$data['NoteTemplateText']['template_id'],'class'=>'deleteAsse')); ?>
					</td>
					</tr>
					<?php }
						}?>
				</table>
				</table>
				</td>
				</tr>
				</table>
				<div id="pageNavPositionAssess" align="left"></div>
				<script>
				<?php if(!empty($assessment)) { ?>
				var pagerAss = new Pager("AssTable", 5); 
				pagerAss.init(); 
				pagerAss.showPageNav('pagerAss', 'pageNavPositionAssess'); 
				pagerAss.showPage(1);
			<?php } ?>
//---------show add From
$('#addAsse').click(function(){
	var copyText=$('#searchAsse').val();
	$('#asseText').val(copyText);
	$('#showAsseAddd').show();
	$('#showAsseAdd1').hide();
});
$('#CancelAsse').click(function(){
	$('#showAsseAddd').hide();
	$('#showAsseAdd1').show();
});
$('#CancelAsseEdit').click(function(){
	$('#showAsseAddd').hide();
	$('#showAsseAdd1').show();
	$('#editAsseAdd').hide();
});
//---------------------------
$('#addSub').click(function(){
	$('#showAsseAddd').show();
	$('#showAsseAdd1').hide();
});
//------Copy text-------------
$('.editA').click(function(){
	var id1=$(this).attr('id');
	var currentVal=$('#AssesShow').val();
	var currentValClincal=$('#AssData').val();
	$('#AssesShow').val(currentVal+" "+id1);
	$('#AssData').val(currentValClincal+" "+id1);
	$('#AssesShow').focus();
	id1="";
});
//***********************Save Template Text********************************
$('#addAsseData').click(function(){
	var contentType="assessment";
	var templateID="<?php echo $assessmentID?>"
	var templateText=$('#asseText').val();
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
        	  $('#assessmentDisplay').html(data);
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editAsse').click(function(){
var currentId=$(this).attr('id');
$('#editAsseAdd').show();
$('#showAsseAdd1').hide();
var splitData=currentId.split('_');
$('#AsseEditText').val(splitData[1]);
$('#editIdasse').val(splitData[2]);
$('#editAsseData').click(function(){
	
	var contentTypeA="assessment";
	var templateIDA="<?php echo $assessment[0]['NoteTemplateText']['template_id']?>"
	var templateTextA=$('#AsseEditText').val();
	var idA=$('#editIdasse').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeA+"/"+templateIDA+"/"+templateTextA+"/"+idA,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	alert('Updated successfully');
    		$('#assessmentDisplay').show();
    	  $('#assessmentDisplay').html(data);
    },
	});
	
});
return false;
	
});
//*************************************delete the text************************************************
$('.deleteAsse').click(function(){
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
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+"Assessment",
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#assessmentDisplay').html(data);
    },
	});
	} else {
		 return false;
	}	
});
function searchTemplateAsse(){
	var searchString=$('#searchAsse').val();
	if(searchString==''){
		alert('Please enter value to search');
		return false;
	}
	var templateID="<?php echo $assessmentID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "searchTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'assessment'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#assessmentDisplay').html(data);
    },
	});
}
</script>