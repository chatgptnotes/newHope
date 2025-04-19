<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<?php echo $this->Html->css(array('internal_style','jquery.autocomplete'));?>
<div class="inner_title">
	<h3>
		<?php echo __('Add Parent Category', true); ?>
	 </h3>
	<span> <div style="float:right;"> <?php
			
			echo $this->Html->link(__('Back', true),array('controller' => 'Templates', 'action' => 'template_sub_category','?'=>array('template_category_id'=>$this->params->query['template_category_id'])), array('escape' => false,'class'=>'blueBtn'));
			?>
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

	<?php 
		echo $this->Form->create('templatecategoryfrm',array('id'=>'templatecategoryfrm','url'=>array('controller'=>'Templates',"action" => "addParentCategory",'?'=>array('template_category_id'=>$this->params->query['template_category_id'])),'inputDefaults'=>array('div'=>false,'label'=>false,)));
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<?php echo $this->Form->input('Template.id',array('type'=>'hidden','id'=>'id','value'=>$id));
		echo $this->Form->input('Template.is_deleted',array('type'=>'hidden','id'=>'is_deleted','value'=>$this->data['Template']['is_deleted']));
		echo $this->Form->input('Template.sort_no',array('type'=>'hidden','id'=>'sort_no','value'=>$this->data['Template']['sort_no']));?>
		<tr>
			<td class="form_lables"><?php echo __('Template Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php   
			echo $category_option['TemplateCategories']['name'] ;
			echo $this->Form->hidden('Template.template_category_id',array('value'=>$this->params->query['template_category_id']));
			//echo $this->Form->input('Template.template_category_id', array('options' => $category_option, 'empty' => 'Select', 'id' => 'template_category_id', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'javascript:category_onchange()','autocomplete'=> 'off','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Speciality',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
				echo $this->Form->input('Template.template_speciality_id',array('options'=>array('1'=>'Family Medicine'))); 
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Single organ system examination types',true); ?>
			</td>
			<?php $options = array(''=>'Please Select','General Multi-System Examination'=>'General Multi-System Examination','Cardiovascular'=>'Cardiovascular','Ears, Nose, Mouth, and Throat'=>'Ears, Nose, Mouth, and Throat','Eyes'=>'Eyes','Genitourinary (Female)'=>'Genitourinary (Female)','Genitourinary (Male)'=>'Genitourinary (Male)','Hematologic/Lymphatic/Immunologic'=>'Hematologic/Lymphatic/Immunologic','Musculoskeletal'=>'Musculoskeletal','Neurological'=>'Neurological','Psychiatric'=>'Psychiatric','Respiratory'=>'Respiratory','Skin'=>'Skin');?>
			<td><?php 
				echo $this->Form->input('Template.organ_system',array('options'=>$options)); 
			?>
			</td>
		</tr>
	 
		<tr>
			<td class="form_lables"><?php echo __('Parent Category',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('Template.category_name',array('type'=>'text','id'=>'category_name', 'label'=> false,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd' ));?></td>
		 </tr>
		 <?php if(strtolower($category_option['TemplateCategories']['name']) == 'hpi'){?>
		 <tr>
			<td class="form_lables"><?php echo __('Sentence',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('Template.sentence',array('type'=>'text','id'=>'sentence', 'label'=> false,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd' ));?></td>
		 </tr>
		 <?php }?>
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

		$("#templatecategoryfrm").validationEngine();
		
	});
	</script>

