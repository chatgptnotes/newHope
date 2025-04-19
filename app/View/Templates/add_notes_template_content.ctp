<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<?php echo $this->Html->css(array('internal_style','jquery.autocomplete','validationEngine.jquery.css'));
echo $this->Html->script(array('jquery.validationEngine','/js/languages/jquery.validationEngine-en'));?>
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
		echo $this->Form->create('templatecategoryfrm',array('id'=>'templatecategoryfrm','url'=>array('controller'=>'Templates',"action" => "addNotesTemplateContent",$template_category_id),'inputDefaults'=>array('div'=>false,'label'=>false,)));
		echo $this->Form->hidden('TemplateSubCategories.id');
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<tr>
			<td class="form_lables"><?php echo __('Template Category',true); ?><font
				color="red">*</font>
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
			<td><?php 
				echo $this->Form->input('TemplateSubCategories.template_speciality_id',array('options'=>array('1'=>'Family Medicine'))); 
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Template Name',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
				echo $this->Form->input('TemplateSubCategories.note_template_id',array('options'=>$notesTemplate ,'multiple'=>'multiple','style'=>'width:66.3%')); 
			?>
			</td>
		</tr>
		 
		<tr>
			<td class="form_lables"><?php echo __('Parent Category',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub',
	  		'options'=>$subCategory,'empty' => 'Select','label'=> false,'class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd' ));
					?>
			</td>
		 </tr>
		 <tr>
			<td class="form_lables"><?php echo __('Sub Category',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php 
			 
			echo $this->Form->textarea('TemplateSubCategories.sub_category', array('class' => 'validate[required,custom[customdescription]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'sub_category', 'label'=> false, 'div' => false, 'error' => false));
			echo $this->Form->checkbox('TemplateSubCategories.is_default',array('value'=>$subCatData['TemplateSubCategories']['is_default']));
			//echo $this->Form->button('Add more',array('title'=>'Add more content box','id'=>'add-more-content'));
			?> 
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
		//$("#templatecategoryfrm").validationEngine('validate');
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

	
</script>
