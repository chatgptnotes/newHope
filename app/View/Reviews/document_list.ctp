

<?php
 echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
  ?>
  
<div class="inner_title">
	<h3>Document List</h3>
	
	<span>
		<?php echo $this->Html->link(__('Back'),array('action' => 'index' ), array('class'=>'blueBtn'));
			 ?>
	</span>
</div>



<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center background: none repeat scroll 0 0 #3E474A;">

			
				  
				  <tr class="row_title">

<td class=" " align="right" width="20%"><strong><label><?php echo __('Checkbox') ?> </label></strong></td> 
<td class=" " align="right" width="20%"><strong><label><?php echo __('Date') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Type') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Category') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Person') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Description') ?> </label></strong></td>



</tr>
  <tr class="row_gray">
<td valign="top">
					<?php 
					  echo $this->Form->input('', array('checked'=> $nc,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][][]','value'=>'')); ?>&nbsp;
									
					</td>

<td class=" " align="right" width="20%"><strong><label><?php echo __('Date') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Type') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Category') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Person') ?> </label></strong></td>
<td class=" " align="right" width="20%"><strong><label><?php echo __('Description') ?> </label></strong></td>
</tr>
</table>
 
