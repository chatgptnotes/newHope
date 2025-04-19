<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<?php echo $this->Html->css(array('internal_style','jquery.autocomplete'));?>
<div class="inner_title">
	<h3>
		<?php echo __('Add Template Sub Category', true); ?>
	 </h3>
	<span> <div style="float: right;">
			<?php 
			$action = $this->params->query['action'];
			$patientId = $this->params->query['patientId'];
			$noteId = $this->params->query['noteId'];
			//echo $this->Form->input(__('Add', true),array('type' => 'button','class'=>'blueBtn','id'=>'addCategory','label'=>false,'div'=>false));
			if(empty($patientId)){
				echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
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
<table border="0" cellpadding="0" cellspacing="0" width="60%"
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
		echo $this->Form->create('templatecategoryfrm',array('id'=>'templatecategoryfrm','url'=>array('controller'=>'Templates',"action" => "editTemplateContent",$template_category_id,'?'=>$this->request->query),'inputDefaults'=>array('div'=>false,'label'=>false,)));
		echo $this->Form->hidden('TemplateSubCategories.id');
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Template Category',true); ?><font color="red">*</font> </td>
			<td><?php   
			echo $category_option['TemplateCategories']['name'] ;
			echo $this->Form->hidden('TemplateSubCategories.template_category_id',array('value'=>$template_category_id));
			//echo $this->Form->input('TemplateSubCategories.template_category_id', array('options' => $category_option, 'empty' => 'Select', 'id' => 'template_category_id', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'javascript:category_onchange()','autocomplete'=> 'off','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
			</td>
		</tr>
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Speciality',true); ?><font color="red">*</font> </td>
			<td><?php 
				echo $this->Form->input('TemplateSubCategories.template_speciality_id',array('options'=>array('1'=>'Family Medicine'))); 
			?>
			</td>
		</tr>
		<?php if($category_option['TemplateCategories']['name']=='Systematic Examination'){?>
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Single organ system examination types',true); ?> </td>
			<?php $options = array(''=>'Please Select','General Multi-System Examination'=>'General Multi-System Examination','Cardiovascular'=>'Cardiovascular','Ears, Nose, Mouth, and Throat'=>'Ears, Nose, Mouth, and Throat','Eyes'=>'Eyes','Genitourinary (Female)'=>'Genitourinary (Female)','Genitourinary (Male)'=>'Genitourinary (Male)','Hematologic/Lymphatic/Immunologic'=>'Hematologic/Lymphatic/Immunologic','Musculoskeletal'=>'Musculoskeletal','Neurological'=>'Neurological','Psychiatric'=>'Psychiatric','Respiratory'=>'Respiratory','Skin'=>'Skin');?>
			<td><?php 
				echo $this->Form->input('TemplateSubCategories.organ_system',array('options'=>$options)); 
			?>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Template Name',true); ?><font color="red">*</font> </td>
			<td><?php 
				echo $this->Form->input('TemplateSubCategories.note_template_id',array('options'=>$notesTemplate ,'style'=>'width:66.3%')); 
			?>
			</td>
		</tr>
		
		 
		<?php if($category_option['TemplateCategories']['name']!='HPI'){?>
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Whether negative (red) is required?',true); ?></td>
			<td><?php echo $this->Form->input('TemplateSubCategories.is_negative', array('type'=>'checkbox','id' => 'is_negative','label'=>false));?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Textbox is required?',true); ?></td>
			<td><?php echo $this->Form->input('TemplateSubCategories.is_textbox', array('type'=>'checkbox','id' => 'is_textbox','label'=>false));?></td>
		</tr>
		
		<tr>
			<td colspan='2' class="form_lables"><?php echo __('Parent Category',true); ?> <font color="red">*</font> </td>
			<td><?php 
			echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub',
	  		'options'=>$subCategory,'empty' => 'Select','label'=> false,'class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd' ));
					?>
			</td>
		 </tr>
		 <tr>
			<td class="form_lables"><?php echo __('Sub Category',true); ?> <font color="red">*</font> </td>
			<td><?php echo $this->Form->checkbox('TemplateSubCategories.is_default',array('value'=>$subCatData['TemplateSubCategories']['is_default']));?>Is Default</td>
			<td><?php 
			 
			echo $this->Form->textarea('TemplateSubCategories.sub_category', array('class' => 'validate[required,custom[customdescription]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'sub_category', 'label'=> false, 'div' => false, 'error' => false));
			
			//echo $this->Form->button('Add more',array('title'=>'Add more content box','id'=>'add-more-content'));
			?> 
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td class="form_lables">&nbsp;</td>
			<td><?php echo $this->Form->checkbox('TemplateSubCategories.has_dropdown',array('class'=>'has_dropdown','id'=>'hasDropdown','value'=>$subCatData['TemplateSubCategories']['has_dropdown']));?>Dropdown Required ?</td>
			<td id="dropdownTD">
				<?php
				$extraSubcategory=unserialize($subCatData['TemplateSubCategories']['extraSubcategory']);
				$extraSubcategoryDesc=unserialize($subCatData['TemplateSubCategories']['extraSubcategoryDesc']);
				$extraSubcategoryDescNeg=unserialize($subCatData['TemplateSubCategories']['extraSubcategoryDescNeg']);
				$redNotAllowed=unserialize($subCatData['TemplateSubCategories']['redNotAllowed']);
				 
				//$redNotAllowed = array_values($redNotAllowed); // reset array indexing to match loop 
				
				?>
				<table id="dropDownReq" width="100%">
					<tr>
						<td align="center" colspan="3"><input type="button" value="Add options" class="addButton" id="addButton"></td>
						<!-- <td><input type="button" value="Remove dropdown" class="removeButton" id="removeButton"></td> -->
					</tr>
					<?php 
					if(!empty($extraSubcategory)){
						$count=count($extraSubcategory);
					}else{
						$count=0;
					}
					$redNotAllowed = array_values($redNotAllowed);
					$r= 0  ;  
					for($i=0;$i<$count;){ 
						$checked=''; 
						$value=0;
						foreach($redNotAllowed as $redAllowed=>$redAllowedVal){ 
							if( $i==$redAllowed){  
								if($redNotAllowed[$redAllowed]=='1'){ 
									$value=1;
									//unset($redNotAllowed[$redAllowed]);
									$checked='checked';
								}else{
									$checked='';
								} 
								break;
							}
						} 
						$r++ ;
					?>
					<tr class="newEle" id="dropDownTR_<?php echo $i?>">
						<td><?php echo $this->Form->input('',array('name'=>'TemplateSubCategories[extraSubcategory][]','id'=>'addTextbox_'.$i,'type'=>'text','class'=>'textBoxExpnd addTextbox validate[required,custom[mandatory-enter]]','value'=>$extraSubcategory[$i],'placeholder'=>'Option Text'));?></td>
						<td><?php echo $this->Form->textarea('',array('name'=>'TemplateSubCategories[extraSubcategoryDesc][]','id'=>'addTextarea_'.$i, 'rows' => '1','style'=>'width:100px','value'=>$extraSubcategoryDesc[$i],'placeholder'=>'Positive Sentence'));  ?></br>
						<?php echo $this->Form->textarea('',array('name'=>'TemplateSubCategories[extraSubcategoryDescNeg][]','id'=>'addTextareaNeg_'.$i, 'rows' => '1','style'=>'width:100px','value'=>$extraSubcategoryDescNeg[$i],'placeholder'=>'Negative Sentence'));  ?></td>
						<td><?php echo $this->Form->checkbox('',array('value'=>$value,'name'=>'TemplateSubCategories[redNotAllowed]['.$i.']','class'=>'redNotAllowed','id'=>'redNotAllowed_'.$i,'checked'=>$checked ));?>Red Not Allowed</td>
						<td><?php echo $this->Html->image('cross.png',array('class'=>'removeButton','id'=>'removeButton_'.$i,'title'=>'Remove current row','style'=>'float:right;')); ?></td>
					</tr>
					<?php $i++;    } ?>
				</table>
			</td>
		 </tr>
		 
		<tr>
			<td></td>
			<td colspan="2" align="">
				<div style="margin-top: 10px;">
					<input type="submit" value="Submit" class="blueBtn" id="submit">
				</div>
			</td>
		</tr> 
	</table>
</form>  

<script>
      
	jQuery(document).ready(function(){
		count_dropdown='<?php echo $count;?>';
//alert($("#hasDropdown").val());

		if($( "#hasDropdown" ).is(':checked') == true){
			$("#dropdownTD").show();
		}else{
			$("#dropdownTD").hide();
		}
		
		$("#templatecategoryfrm").validationEngine();
	 	$("#parent-add-link").click(function(){
		 	$("#parent-add").toggle();
		 	$("#template-content").hide();
		});
	 	$("#template-content-link").click(function(){
		 	$("#template-content").toggle();
		 	$("#parent-add").hide();
		});
		counter = 2  ;
		$("#add-more-content").click(function(){
			contentHtml  =  '<tr id="content-'+counter+'"><td><td>';
			contentHtml  += '<textarea id="sub_category" rows="10" cols="35" class="validate[required,custom[customdescription]] textBoxExpnd" name="data[TemplateSubCategories][sub_category]['+counter+']"></textarea>';
			//contentHtml  += '<input type="hidden" value="0" id="TemplateSubCategoriesIsDefault_" name="data[TemplateSubCategories][is_default][]">';
			contentHtml  += '<input type="checkbox" id="TemplateSubCategoriesIsDefault" value="1" name="data[TemplateSubCategories][is_default]['+counter+']">';
			contentHtml  += '<?php echo $this->Html->image('cross.png',array('id'=>'remove-more-content','title'=>'Remove current row','style'=>'float:right;')); ?>';
			contentHtml  += '</td></td></tr>'; 
			$("#add-content").append(contentHtml);
			counter++ ;
		});

		$("#remove-more-content").click(function(){
			id  = $(this).attr('id');
			$("#content-"+id).remove();
			counter-- ; 
		});
	});
//--------//

	$(document).on('click','.addButton', function() { 
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		
		$("#dropDownReq")
		.append($('<tr>').attr({'class':'newEle','id':'dropDownTR_'+count_dropdown})
				.append($('<td>').append($('<input>').attr({'placeholder':'Option Text','id':'addTextbox_'+count_dropdown,'class':'textBoxExpnd addTextbox validate[required,custom[mandatory-enter]]','type':'text','name':'TemplateSubCategories[extraSubcategory][]'})))
	    		.append($('<td>').append($('<textarea>').attr({'placeholder':'Positive Sentence','id':'addTextarea_'+count_dropdown,'class':'','rows':'1','name':'TemplateSubCategories[extraSubcategoryDesc][]','style':'width:100px'}))
	    						 .append($('</br>'))
	    						 .append($('<textarea>').attr({'placeholder':'Negative Sentence','id':'addTextareaNeg_'+count_dropdown,'class':'','rows':'1','name':'TemplateSubCategories[extraSubcategoryDescNeg][]','style':'width:100px'})))
				.append($('<td>').append($('<input>').attr({'value':'1','class':'redNotAllowed','type':'checkbox','name':'TemplateSubCategories[redNotAllowed]['+count_dropdown+']','id':'redNotAllowed_'+count_dropdown,'hiddenField':'false'})).append('Red Not Allowed'))
				.append($('<td>')
    					.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    					.attr({'class':'removeButton','id':'removeButton_'+count_dropdown,'title':'Remove current row'}).css('float','right'))))

	    //if($('.newEle').length>0)$('#removeButton').show('slow');	   
    	count_dropdown++;
	});

	$(document).on('click','.removeButton', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#dropDownTR_"+ID).remove();
		/*$('.newEle').last().remove();
		if($('.newEle').length=='0')$('#'+currentId).hide('slow');*/
	 });

	$(document).on('click','.has_dropdown', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		if($('#'+currentId).is(':checked') == true ){
			$('#dropdownTD').show();
		}else{
			$('.newEle').remove();
			$('#dropdownTD').hide();	 
		}
	});

	$(document).on('change','.addTextbox', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		
		if($(this).val() !=''){
			$('#addTextarea_'+ID).addClass('validate[required,custom[mandatory-enter]]');
			$('#addTextareaNeg_'+ID).addClass('validate[required,custom[mandatory-enter]]');
	    }else{
	    	$('#addTextarea_'+ID).removeClass('validate[required,custom[mandatory-enter]]');
	    	$('#addTextareaNeg_'+ID).removeClass('validate[required,custom[mandatory-enter]]');
	    	jQuery('#addTextarea_'+ID).validationEngine('hide');
	    	jQuery('#addTextareaNeg_'+ID).validationEngine('hide');
	        }
		
	 });

		
	 $( ".addTextbox" ).each(function() {
		 currentId=$(this).attr('id');
		 splitedId=currentId.split('_');
		 ID=splitedId['1'];
		 if($(this).val() !=''){
				$('#addTextarea_'+ID).addClass('validate[required,custom[mandatory-enter]]');
				$('#addTextareaNeg_'+ID).addClass('validate[required,custom[mandatory-enter]]');
	     }else{
	    	$('#addTextarea_'+ID).removeClass('validate[required,custom[mandatory-enter]]');
	    	$('#addTextareaNeg_'+ID).removeClass('validate[required,custom[mandatory-enter]]');
	    	jQuery('#addTextarea_'+ID).validationEngine('hide');
	    	jQuery('#addTextareaNeg_'+ID).validationEngine('hide');
	     }
		 				
	 });
</script>
