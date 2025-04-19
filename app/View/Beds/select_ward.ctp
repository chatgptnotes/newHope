<form name="cityfrm" id="cityfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "add", "admin" => true)); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Select Ward'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php 
	        echo $this->Form->input('Ward.id', array('options'=>$wardsData,'empty'=>__('Please select'), 'id' => 'wardname', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
	
	</table>
</form>