<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3','jquery.fancybox-1.3.4'));
echo $this->Html->css(array( 'internal_style.css','jquery.fancybox-1.3.4.css','jquery.ui.all.css','jquery-ui-1.8.16.custom.css'));

if($status == "success"){
	?>

<script> 
		//alert("CCDA generated successfully"); 
		jQuery(document).ready(function() { 
			parent.location.reload(true);
			parent.$.fancybox.close(); 
 
		});
		</script>
<?php   } ?>

<style>
label {
	float: none;
}
</style>

<table border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
	<tr>
		<td>
			<div class="inner_title">
				<div style="float: left">
					<h3>
						<?php echo __('Patient Permissions');?>
					</h3>
				</div>
		
				<div style="text-align: right;">&nbsp;</div>
			</div>
			<div class="clr">&nbsp;</div>
			<?php $option=explode("|",$permit['Patient']['permissions']); 
		
			echo $this->Form->create('Patient',array('inputDefaults'=>array('div'=>false)));
			echo $this->Form->input('id',array('type'=>'hidden','value'=>$id));
			echo $this->Form->input('XmlNote', array( 'selected'=>$option,'options'=>Configure::read('patient_permission_array') ,'multiple'=>'checkbox' ,'class'=>"clr" ,'label' =>false )  ) ;
			?>
			<div class="clr">&nbsp;</div>
			<?php 
			echo $this->Form->submit(__('Submit'), array('label'=> false, 'error' => false,'class'=>'blueBtn','style' =>'float:left;','id'=>'submit'));
			echo $this->Form->end();
			?>
			<div style="padding-left: 20px; padding-top: 5px">
				<i>(Select to share with patient)</i>
			</div>
		</td> 
	</tr>
</table>
<script>
$(function() {
	$('input[type=checkbox]').attr('checked','checked');
}); 
</script>
