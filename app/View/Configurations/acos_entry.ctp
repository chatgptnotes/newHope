
		
<div class="inner_title">
	<h3>
		<?php echo __('Acos Form', true); ?>
	</h3>
</div>
<div class="clr ht5"></div>
<?php 
if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"> <?php 
		foreach($errors as $key=>$errorsval){ 
         echo $errorsval;
        echo "<br/>";
         //echo $errors;
     }
     ?></td>
	</tr>
</table>
<?php } ?>
<?php echo $this->Form->create('Acos',array('url'=>array('controller'=>'Configurations','action'=>'acos_entry'),'type'=>'post',
			'id'=>'acosEntry','inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false))); ?>
<table width="50%" align="center" border="0" cellspacing="10" cellpadding="0" class="formFull">
	<tr class="">
		<td colspan="4" align="center" width="30%"><?php echo $this->Form->input('Process',array('id'=>'','options'=>array('0'=>'Controller','1'=>'Action'),'default'=>'1','type'=>'radio','class'=>'select','fieldset'=>false,'legend'=>false,'div'=>false,)); ?>
			</td>
	</tr>	
	<tr class="show"  style="display:none;">
        <td colspan="3" class="row_format" ><strong><?php echo __("Controller");?></strong><font color="red">*</font></td>
       <td width="30%"><?php echo $this->Form->input('Acos.controller', array('label'=>false,'type'=>'text',
					'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd ','id' => '','autocomplete'=>"off"));?>
			</td>
	</tr>
	<tr class="show" style="display:none;" id="controller">
		<td colspan="3" class="row_format action"  ><strong> <?php echo __('Action')?></strong><font color="red">*</font></td>
		<td colspan="3" class="row_format contro"  ><strong> <?php echo __('Controller')?></strong><font color="red">*</font></td>
		<td width="30%"><?php echo $this->Form->input('Acos.alias', array('label'=>false,'type'=>'text',
					'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd ','id' => 'control','autocomplete'=>"off"));?>
			</td>
	</tr>
	<tr class="show" style="display:none;" >
		<td colspan="3" class="row_format" ><strong> <?php echo __('Is viewable'); ?></strong></td>
		<td width="30%"><?php echo $this->Form->input('Acos.is_viewable',array('id'=>'','type'=>'checkBox','class'=>'')); ?>
			</td>
	</tr>
	<tr class="show" style="display:none;">
		<td  colspan="3" class="row_format"><strong> <?php echo __('Is permission Need');  ?></strong></td>
		
		<td width="30%"><?php echo $this->Form->input('Acos.is_permission_need',array('id'=>'','type'=>'checkBox','class'=>'')); ?>		
			</td>
	</tr>
	<tr class="show" style="display:none;" id= "Label" >
		<td  colspan="3" class="row_format"><strong> <?php echo __('Label');  ?></strong></td>
		<td width="30%"><?php echo $this->Form->input('Acos.label', array('label'=>false,'type'=>'text','maxLength'=>'200',
					'class' => 'textBoxExpnd ',id=> "Label",'autocomplete'=>"off"));?>
			</td>
	</tr>
	<tr class="show" style="display:none;" id="desc" >
		<td  colspan="3" class="row_format"><strong> <?php echo __('Description');  ?></strong></td>
		<td width="30%"><?php echo $this->Form->input('Acos.desc', array('label'=>false,'type'=>'text','maxLength'=>'255',
					'class' => 'textBoxExpnd ',id=>"desc",'autocomplete'=>"off"));?>
			</td>
	</tr>
</table>

<table width="50%">
		<tr>
			<td class="row_title" align="right"><?php
		echo $this->Form->submit(__('Submit'),array('style'=>'margin: 0 10px 0 0;','class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'submit'));
			 //echo $this->Html->link(__('Cancel',true),array('action'=>'couponBatchGeneration'),array('escape' => false,'id'=>'add-cancel','class'=>'blueBtn'));
			?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
<script>

jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#acosEntry").validationEngine();
	$(".show").show() ;
	$('.contro').hide();
$('.select:radio').click(function(){ 
	if($(this).val() =='1'){ 
		$(".show").val('');
		$('.show').show();
		$('.contro').hide();
		$('.action').show();
		}else{ 
			$('.show').hide();
		}
	if($(this).val() =='0'){ 
		$("#controller").val('');
		$("#controller").show();
		$(".contro").val('');
		$('.action').val('');
		$(".contro").show();
		$("#Label").val('');
		$("#desc").val('');
		$("#Label").show();
		$("#desc").show();
		$(".action").hide();
		$("#control").val('');
		}
});
});</script>