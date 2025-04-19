<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<?php echo $this->Html->css(array('internal_style','jquery.autocomplete','validationEngine.jquery.css'));
//echo $this->Html->script(array('jquery.validationEngine','/js/languages/jquery.validationEngine-en'));?>
<div class="inner_title">
	<h3>
		<?php echo __('Add Template Sub Category', true); ?>
	</h3>
	<span>
		<div style="float: right;">
			<?php 
			$action = $this->params->query['action'];
			$patientId = $this->params->query['patientId'];
			$noteId = $this->params->query['noteId'];
			//echo $this->Form->input(__('Add', true),array('type' => 'button','class'=>'blueBtn','id'=>'addCategory','label'=>false,'div'=>false));
			if(empty($patientId)){
				echo $this->Html->link(__('Back', true),array('controller' => 'Templates', 'action' => 'template_sub_category','?'=>array('template_category_id'=>$this->params->query['template_category_id'])), array('escape' => false,'class'=>'blueBtn'));
				
				//echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
			}else{
				if(empty($this->params->query['controller'])){
					echo $this->Html->link(__('Back', true),array('controller' => 'notes', 'action' =>$action,$patientId,$noteId), array('escape' => false,'class'=>'blueBtn'));
				}else{
					echo $this->Html->link(__('Back', true),array('controller' => 'PatientForms', 'action' =>$action,$patientId,$noteId), array('escape' => false,'class'=>'blueBtn'));
				}
			}?>
		</div>
	</span>
</div>

<!-- show if come from Progress Note-->
<?php echo $this->Form->input('',array('type'=>'hidden','id'=>'ros','value'=>$action));?>
<!--  EOD-->
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="95%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<!-- 
<form name="templatecategoryfrm" id="templatecategoryfrm"
	action="<?php echo $this->Html->url(array("action" => "template_sub_category")); ?>"
	method="post"> -->
<?php 
echo $this->Form->create('templatecategoryfrm',array('id'=>'templatecategoryfrm','url'=>array('controller'=>'Templates',"action" => "addTemplateContent",$template_category_id,'?'=>$this->request->query),'inputDefaults'=>array('div'=>false,'label'=>false,)));
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="95%" align="center">
	<tr>
		<td class="form_lables" style="width:21%"><?php echo __('Template Category',true); ?>
		</td>
		<td><?php   
		echo $category_option['TemplateCategories']['name'] ;
		echo $this->Form->hidden('TemplateSubCategories.template_category_id',array('value'=>$template_category_id));
			//echo $this->Form->input('TemplateSubCategories.template_category_id', array('options' => $category_option, 'empty' => 'Select', 'id' => 'template_category_id', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'javascript:category_onchange()','autocomplete'=> 'off','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Speciality',true); ?><font
			color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TemplateSubCategories.template_speciality_id',array('options'=>array('1'=>'Family Medicine')));?>
		</td>
	</tr>
	<?php if($category_option['TemplateCategories']['name']=='Systematic Examination'){?>
	<tr>
		<td class="form_lables"><?php echo __('Single organ system examination types',true); ?>
		</td>
		<td><?php echo $this->Form->input('TemplateSubCategories.organ_system',array('options'=>Configure::read('system_organ')));  ?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td class="form_lables"><?php echo __('Template Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TemplateSubCategories.note_template_id',array('options'=>$notesTemplate,'class'=>'validate[required,custom[mandatory-select]]','multiple'=>'multiple','style'=>'height:150px;width:200px;','selected'=>key($notesTemplate)));  ?>
		</td>
	</tr>
	<?php if($category_option['TemplateCategories']['name']!='HPI'){?>
	<tr>

		<td class="form_lables"><?php echo __('Whether negative (red) is required?',true); ?>
		</td>
		<td><?php echo $this->Form->input('TemplateSubCategories.is_negative', array('type'=>'checkbox','id' => 'is_negative','label'=>false));?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td class="form_lables"><?php echo __('Textbox is required?',true); ?>
		</td>
		<td><?php echo $this->Form->input('TemplateSubCategories.is_textbox', array('type'=>'checkbox','id' => 'is_textbox','label'=>false));?>
		</td>
	</tr>
<!-- 
	<tr>

		<td id="parent-add-link"><?php 
		echo $this->Html->link('Add Parent Category','javascript:void(0)',array('escape'=>false,'id'=>"parent-add-link" ,'style'=>'cursor:pointer'));
		?>
		</td>
		<td id="template-content-link"><?php 
		echo $this->Html->link(__('Add Template Content'),'javascript:void(0)',array('escape'=>false,'id'=>"parent-add-link",'style'=>'cursor:pointer'));
		?>
		</td>
	</tr>  -->
	<tr id="parent-add" style="display: none;">
		<td colspan="2">
			<table width="100%">
				<tr>
					<td class="form_lables"><?php echo __('Parent Category',true); ?><font color="red">*</font>
					</td>
					<td><?php echo $this->Form->input('TemplateSubCategories.template',array('type'=>'text','id'=>'category_sub', 'label'=> false,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd' ));?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2" align="">
						<div style="margin-top: 10px;">
							<input type="submit" value="Submit" class="blueBtn submit" id="submit">
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr id="template-content" >
		<td colspan="2">
			<table width="100%" id="add-content">
				<tr>
					<td colspan="2" class="form_lables"><?php echo __('Parent Category',true); ?> <font color="red">*</font>
					</td>
					<td ><?php 
					echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub',
				  		'options'=>$subCategory,'empty' => 'Select','label'=> false,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd' )); ?>
					</td>
				</tr>
				<tr>
					<td class="form_lables" style="width:8%;"><?php echo __('Sub Category',true); ?> <font color="red">*</font> </td>
					<td style="width:13%;"><input type="checkbox" style="float:left"  name="data[TemplateSubCategories][is_default][1]" value="1"/>Is green by default</td>
					<td style="width:30%;">
					<?php 
					echo $this->Form->textarea('', array('name'=>'data[TemplateSubCategories][sub_category][1]','class' => 'validate[required,custom[custom description]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'sub_category', 'label'=> false, 'div' => false, 'error' => false));
					//echo $this->Form->checkbox('',array('name'=>'data[TemplateSubCategories][is_default][1]'));
					//echo $this->Form->button('Add more',array('title'=>'Add more content box','id'=>'add-more-content'));
					?> </td>
					
					<td width="13%"><input type="checkbox" class="has_dropdown"  id="hasDropdown_1" name="data[TemplateSubCategories][has_dropdown][1]" value="1"/>Dropdown Required ?</td>
					
					<td width="40%" id="dropdownTD_1" style="display: none">
						<table id="dropDownReq_1" width="100%">
							<tr>
								<td colspan="3" align="center"><input type="button" value="Add options" class="addButton" id="addButton_1"></td>
								<!-- <td><input type="button" value="Remove dropdown" class="removeButton" id="removeButton_1"></td> -->
							</tr>
							<tr id="removeButtonSub_1" class="newEle_1">
								<td><?php echo $this->Form->input('',array('name'=>'data[TemplateSubCategories][extraSubcategory][1][]','id'=>'addTextbox_1_1','type'=>'text','class'=>' addTextbox validate[required,custom[mandatory-enter]]','placeholder'=>'Option Text'));?></td>
								<td><?php echo $this->Form->textarea('',array('name'=>'data[TemplateSubCategories][extraSubcategoryDesc][1][]','id'=>'addTextarea_1_1', 'rows' => '1','style'=>'width:100px','placeholder'=>'Positive Sentence'));  ?>
								<?php echo $this->Form->textarea('',array('name'=>'data[TemplateSubCategories][extraSubcategoryDescNeg][1][]','id'=>'addTextareaNeg_1_1', 'rows' => '1','style'=>'width:100px','placeholder'=>'Negative Sentence'));  ?></td>
								<td><input type="checkbox" class="redNotAllowed"  id="redNotAllowed_1" name="data[TemplateSubCategories][redNotAllowed][1][]" value="1"/>Red Not Allowed</td>
					
								<td><?php echo $this->Html->image('cross.png',array('class'=>'removeButton','id'=>'removeButton_1','title'=>'Remove current row','style'=>'float:right;')); ?></td>
							</tr>
						</table>
					</td>
					
					<td> <input type="button" value="Add more" class="reset-chart" id="add-more-content"> </td>
				</tr>

			</table>
		</td>
	</tr>
	<tr id="submit-template-content"  >
		<td></td>
		<td colspan="2" align="">
			<div style="margin-top: 10px;">
				<input type="submit" value="Submit" class="blueBtn submit"
					id="submit">
			</div>
		</td>
	</tr>
</table>

</form>

<script>
counter = 2  ;
cntr=2;
	jQuery(document).ready(function(){

		$("#templatecategoryfrm").validationEngine();

	 	$("#parent-add-link").click(function(){
		 	$("#parent-add").toggle();
		 	$("#template-content").hide();
		 	$("#submit-template-content").hide();
		});
	 	$("#template-content-link").click(function(){
		 	$("#template-content").toggle();
		 	$("#submit-template-content").toggle();
		 	$("#parent-add").hide();
		});
		
		/*$("#add-more-content").click(function(){
			contentHtml  =  '<tr id="content-'+counter+'">';
			contentHtml  += '<td>&nbsp;</td>';
			contentHtml  += '<td><input type="checkbox" value="1" id="default_'+counter+'" name="data[TemplateSubCategories][is_default]['+counter+']">Is Default</td>';
			contentHtml  += '<td><textarea id="sub_category" rows="10" cols="35" class="validate[required,custom[customdescription]] textBoxExpnd" name="data[TemplateSubCategories][sub_category]['+counter+']"></textarea></td>';
			contentHtml  += '<td><input type="checkbox" value="1" id="" name="">Dropdown Required ?</td>';
			contentHtml  += '<td><span class="removeCatagory" id=removeCatagory_'+counter+'><?php echo $this->Html->image('cross.png',array('title'=>'Remove current row','style'=>'float:right;')); ?></td>';
			contentHtml  += '</tr>'; 
			$("#add-content").append(contentHtml);
			counter++ ;
		});*/

			
	});
	/*
	$("#remove-more-content").click(function(){
		id  = $(this).attr('id');
		$("#content-"+id).remove();
		counter-- ; 
	});
	*/

$("#add-more-content").click(function(){
	/*	contentHtml  =  '<tr id="content-'+counter+'">';
	contentHtml  += '<td>&nbsp;</td>';
	contentHtml  += '<td><input type="checkbox" value="1" id="default_'+counter+'" name="data[TemplateSubCategories][is_default]['+counter+']">Is Default</td>';
	contentHtml  += '<td><textarea id="sub_category" rows="10" cols="35" class="validate[required,custom[customdescription]] textBoxExpnd" name="data[TemplateSubCategories][sub_category]['+counter+']"></textarea></td>';
	contentHtml  += '<td><input type="checkbox" value="1" id="" name="">Dropdown Required ?</td>';
	contentHtml  += '<td><span class="removeCatagory" id=removeCatagory_'+counter+'><?php echo $this->Html->image('cross.png',array('title'=>'Remove current row','style'=>'float:right;')); ?></td>';
	contentHtml  += '</tr>';*/


	$("#add-content")
	.append($('<tr>').attr({'id':'content-'+counter})
			.append($('<td>'))
			.append($('<td>').append($('<input>').attr({'value':'1','style':'float:left','class':' ','type':'checkbox','name':'data[TemplateSubCategories][is_default]['+counter+']','id':'default_'+counter})).append('Is green by default'))
    		.append($('<td>').append($('<textarea>').attr({'class':'validate[required,custom[customdescription]] textBoxExpnd','rows':'10','cols':'35','id':'sub_category','name':'data[TemplateSubCategories][sub_category]['+counter+']'})))
			.append($('<td>').append($('<input>').attr({'value':'1','class':' has_dropdown','type':'checkbox','name':'data[TemplateSubCategories][has_dropdown]['+counter+']','id':'hasDropdown_'+counter})).append('Dropdown Required ?'))
			
			.append($('<td>').attr({'style':'display:none','id':'dropdownTD_'+counter})
				.append($('<table>').attr({'width':'100%','id':'dropDownReq_'+counter})
					 .append($('<tr>')
				    		.append($('<td colspan="3" align="center">').append($('<input>').attr({'class':'addButton','type':'button','value':'Add options','id':'addButton_'+counter})))
				    		//.append($('<td>').append($('<input>').attr({'class':'removeButton','type':'button','value':'Remove dropdown','id':'removeButton_'+counter})))
				    		)

		    		 .append($('<tr>').attr({'id':'removeButtonSub_'+cntr,'class':'newEle_'+counter})
		    				 .append($('<td>').append($('<input>').attr({'placeholder':'Option Text','class':' addTextbox validate[required,custom[mandatory-enter]]','type':'text','name':'data[TemplateSubCategories][extraSubcategory]['+counter+'][]','id':'addTextbox_'+cntr+'_'+counter})))
		    		    	 .append($('<td>').append($('<textarea>').attr({'placeholder':'Positive Sentence','rows':'1','name':'data[TemplateSubCategories][extraSubcategoryDesc]['+counter+'][]','style':'width:100px','id':'addTextarea_'+cntr+'_'+counter}))
		    		    			 		  .append($('<textarea>').attr({'placeholder':'Negative Sentence','rows':'1','name':'data[TemplateSubCategories][extraSubcategoryDescNeg]['+counter+'][]','style':'width:100px','id':'addTextareaNeg_'+cntr+'_'+counter})))
							 .append($('<td>').append($('<input>').attr({'value':'1','class':'redNotAllowed','type':'checkbox','name':'data[TemplateSubCategories][redNotAllowed]['+counter+'][]','id':'redNotAllowed_'+cntr+'_'+counter})).append('Red Not Allowed'))
							 .append($('<td>')
    								.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    								.attr({'class':'removeButton','id':'removeButton_'+cntr,'title':'Remove current row'}).css('float','right')))))
    		)
			.append($('<td>').attr({'class':'removeCatagory','id':'removeCatagory_'+counter})
					.append('<?php echo $this->Html->image('cross.png',array('title'=>'Remove current row','style'=>'float:center;')); ?>')))

	counter++ ;
	cntr++;
});

$(document).on('click','.removeCatagory', function() { 
    	// if(confirm("Do you really want to delete this record?")){
    		 	CurrentId  = $(this).attr('id');
    			splitedVar=CurrentId.split("_");
    			id=splitedVar[1];
    			$("#content-"+id).remove();
    			//counter-- ;
    	/* }else{
			return false;
         }*/
     });

$(document).on('click','.has_dropdown', function() {
	currentId=$(this).attr('id');
	splitedId=currentId.split('_');
	IDs=splitedId['1'];
	if($('#'+currentId).is(':checked') == true ){
		$('#dropdownTD_'+IDs).show();
	}else{
		$('.newEle_'+IDs).remove();
		$('#dropdownTD_'+IDs).hide();	 
	}
});	

$(document).on('click','.addButton', function() { 
	currentId=$(this).attr('id');
	splitedId=currentId.split('_');
	ID=splitedId['1'];
	
	$("#dropDownReq_"+ID)
	.append($('<tr>').attr({'id':'removeButtonSub_'+cntr,'class':'newEle_'+ID})
			.append($('<td>').append($('<input>').attr({'id':'addTextbox_'+cntr+'_'+ID,'placeholder':'Option Text','class':'addTextbox validate[required,custom[mandatory-enter]]','type':'text','name':'data[TemplateSubCategories][extraSubcategory]['+ID+'][]'})))
    		.append($('<td>').append($('<textarea>').attr({'id':'addTextarea_'+cntr+'_'+ID,'placeholder':'Positive Sentence','rows':'1','name':'data[TemplateSubCategories][extraSubcategoryDesc]['+ID+'][]','style':'width:100px'}))
    						 .append($('<textarea>').attr({'id':'addTextareaNeg_'+cntr+'_'+ID,'placeholder':'Negative Sentence','rows':'1','name':'data[TemplateSubCategories][extraSubcategoryDescNeg]['+ID+'][]','style':'width:100px'})))
    		.append($('<td>').append($('<input>').attr({'value':'1','class':'redNotAllowed','type':'checkbox','name':'data[TemplateSubCategories][redNotAllowed]['+ID+'][]','id':'redNotAllowed_'+counter})).append('Red Not Allowed'))
    		.append($('<td>')
    				.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    						.attr({'class':'removeButton','id':'removeButton_'+cntr,'title':'Remove current row'}).css('float','right'))
    		))	
cntr++;
});

$(document).on('click','.removeButton', function() {
	currentId=$(this).attr('id');
	splitedId=currentId.split('_');
	ID=splitedId['1'];
	$("#removeButtonSub_"+ID).remove();
 });

$(document).on('change','.addTextbox', function() {
	currentId=$(this).attr('id');
	splitedId=currentId.split('_');
	ID1=splitedId['1'];
	ID2=splitedId['2'];
	
	if($(this).val() !=''){
		$('#addTextarea_'+ID1+'_'+ID2).addClass('validate[required,custom[mandatory-enter]]');
		$('#addTextareaNeg_'+ID1+'_'+ID2).addClass('validate[required,custom[mandatory-enter]]');
    }else{
    	$('#addTextarea_'+ID1+'_'+ID2).removeClass('validate[required,custom[mandatory-enter]]');
    	$('#addTextareaNeg_'+ID1+'_'+ID2).removeClass('validate[required,custom[mandatory-enter]]');
    	jQuery('#addTextarea_'+ID1+'_'+ID2).validationEngine('hide');
    	jQuery('#addTextareaNeg_'+ID1+'_'+ID2).validationEngine('hide');
        }
	
 });
</script>
