<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td>Template Content</td>
	</tr>
	<tr width="100%">
		<td><table>
				<tr id='showPlanAdd1'>
					<td><?php echo $this->Form->input('searchsub',array('type'=>'text','label'=>false,'name'=>'searchSub','id'=>'searchPlan','class'=>'')); ?>
					</td>
					<td><?php if(!empty($plan)){echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('onClick'=>'searchTemplatePlan();','escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));}
								echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'addPlan','style'=>'padding-left:5px;cursor:pointer'));?>
					</td>
				</tr>
				<tr style="display: none" id='showPlanAdd'>
					<td><?php echo $this->Form->input('add',array('type'=>'text','label'=>false,'name'=>'subTitle','id'=>'planText')); ?>
					</td>
					<td><?php echo $this->Html->link('Submit','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'addPlanData','class'=>'Bluebtn')); ?>
					
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelPlan','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<tr style="display: none" id='editPlanAdd'>
					<td><?php echo $this->Form->input('edit',array('type'=>'text','label'=>false,'name'=>'subEditTitle','id'=>'planEditText')); ?>
						<?php echo $this->Form->hidden('id',array('id'=>'editIdplan'))?>
					</td>
					<td><?php echo $this->Html->link('Update','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'submit','id'=>'editPlanData','class'=>'Bluebtn')); ?>
					</td>
					<td><?php echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','label'=>false,'name'=>'Cancel','id'=>'CancelPlanEdit','class'=>'Bluebtn')); ?>
					</td>
				</tr>
				<table id="planTableNew">

					</td>
					</tr>
					<?php if(!empty($plan)){?>
					<tr>
						<td>Template for Plan</td>
						<td colspan="2"></td>
					</tr>
					<?php foreach($plan as $data){
						if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
					<td><?php echo $this->Html->link($data['NoteTemplateText']['template_text'],'javascript:void(0)',
							array('id'=>$data['NoteTemplateText']['template_text'],'class'=>'editp')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>"edit_".$data['NoteTemplateText']['template_text']."_".$data['NoteTemplateText']['id'],
								'class'=>'editPlan')); ?>
					</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),'javascript:void(0)',
							array('escape'=>false,'id'=>$data['NoteTemplateText']['id']."_".$data['NoteTemplateText']['template_id'],'class'=>'deletePlan')); ?>
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
				<div id="pageNavPositionPlan" align="left"></div>
				<script>
				<?php if(!empty($plan)) { ?>
				var pagerPlan = new Pager('planTableNew', 5); 
				pagerPlan.init(); 
				pagerPlan.showPageNav('pagerPlan', 'pageNavPositionPlan'); 
				pagerPlan.showPage(1);
			<?php } ?>
//---------show add From
$('#addPlan').click(function(){
	var copyText=$('#searchPlan').val();
	$('#planText').val(copyText);
	$('#showPlanAdd').show();
	$('#showPlanAdd1').hide();
});
$('#CancelPlan').click(function(){
	$('#showPlanAdd').hide();
	$('#showPlanAdd1').show();
});
$('#CancelPlanEdit').click(function(){
	$('#showPlanAdd').hide();
	$('#showPlanAdd1').show();
	$('#editPlanAdd').hide();
});
//---------------------------
$('#addPlan').click(function(){
	$('#showSubAdd').show();
	$('#showSubAdd1').hide();
});
//------Copy text-------------
$('.editp').click(function(){
	var id=$(this).attr('id');
	var currentVal=$('#planShow').val();
	var currentValClincial=$('#PlanData').val();
	$('#planShow').val(currentVal+" "+id);
	$('#PlanData').val(currentValClincial+" "+id);
	$('#planShow').focus();
	id="";
});
//***********************Save Template Text********************************
$('#addPlanData').click(function(){
	var contentType="plan";
	var templateID="<?php echo $planID?>"
	var templateText=$('#planText').val();
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
        	  $('#planDisplay').html(data);
    },
	});
});
//**************************Edit Sub text******************************************************
$('.editPlan').click(function(){
var currentId=$(this).attr('id');
$('#editPlanAdd').show();
$('#showPlanAdd1').hide();
var splitData=currentId.split('_');
$('#planEditText').val(splitData[1]);
$('#editIdplan').val(splitData[2]);
 
$('#editPlanData').click(function(){
	
	var contentTypeP="plan";
	var templateIDP="<?php echo $plan[0]['NoteTemplateText']['template_id']?>"
	var templateTextP=$('#planEditText').val();
	var idP=$('#editIdplan').val();
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+contentTypeP+"/"+templateIDP+"/"+templateTextP+"/"+idP,
    success: function(data){
    	alert('Updated successfully');
    	$('#busy-indicator').hide('slow');
    	 $('#planDisplay').show();
    	  $('#planDisplay').html(data);
    },
	});
	
});
return false;
	
});
//*************************************delete the text************************************************
$('.deletePlan').click(function(){
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
    url: ajaxUrl+"/"+spData[0]+"/"+spData[1]+"/"+"plan",
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#planDisplay').html(data);
    },
	});
	} else {
		 return false;
	}	
});
function searchTemplatePlan(){
	var searchString=$('#searchPlan').val();
	if(searchString==''){
		alert('Please enter value to search');
		return false;
	}
	var templateID="<?php echo $planID;?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "searchTemplateText","admin" => false)); ?>";
    $.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
      	},
    type: 'POST',
    url: ajaxUrl+"/"+searchString+'/'+'plan'+"/"+templateID,
    success: function(data){
    	$('#busy-indicator').hide('slow');
    	  $('#planDisplay').html(data);
    },
	});
}
</script>