 <div class="inner_title">
	<h3>
		<?php echo __('Edit Template Sub Category', true); ?>
	</h3>
	<span> <?php
			echo $this->Html->link(__('Back'), array('action' => 'template_sub_category'), array('escape' => false,'class'=>"blueBtn"));
			?>
			</span>
</div>


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
<form name="templatecategoryfrm" id="templatecategoryfrm"
	action="<?php echo $this->Html->url(array("action" => "template_sub_category")); ?>"
	method="post">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<tr>
			<td class="form_lables"><?php echo __('Template Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php  echo $this->Form->input('TemplateSubCategories.template_category_id', array('options' => $option, 'empty' => 'Select', 'id' => 'template_category_id', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'javascript:category_onchange()','autocomplete'=> 'off','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Parent Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub',
	  		'default'=> $data['TemplateSubCategories']['template_id'],'options'=>array($categoryOption),'empty' => 'Select','label'=> false,'class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd' ));
					?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Sub Category',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->textarea('TemplateSubCategories.sub_category', array('class' => 'validate[required,custom[customdescription]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'sub_category', 'label'=> false, 'div' => false, 'error' => false));
			 echo $this->Form->hidden('TemplateSubCategories.id',array('type'=>'text')) ;?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Submit"
				class="blueBtn" id="submit">
			</td>
		</tr>
	</table>
</form>
<script>
     
function category_onchange(){
	var id = $('#template_category_id').val();
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Templates", "action" => "category_onchange","admin" => false)); ?>";
	$.ajax({
	type: 'POST',
	url: ajaxUrl+"/"+id,
	data: '',
	dataType: 'html',
	success: function(data){
	  	data= $.parseJSON(data);
	  	if(data !=''){
	  		$("#category_sub option").remove();
	  		//$("#save").removeAttr('disabled');
		  	$.each(data, function(val, text) {
			  	if(text)
			    $("#category_sub").append( "<option value='"+val+"'>"+text+"</option>" );
			}); 
	  	}else{  
	  		$("#category_sub option").remove();
	  		//$("#save").attr('disabled','disabled');
		  	alert("Data not available");
	  	} 
	  	
	  	    
	},

	error: function(message){
	alert("Internal Error Occured. Unable to set data.");
	} });

	return false;
	}

    

	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#templatecategoryfrm").validationEngine();
	});
</script>