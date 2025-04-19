<?php echo $this->Html->css('internal_style.css'); ?>		
<table  border="0" cellspacing="0" cellpadding="0" class="formFull new">
	<tr>
		<th><?php echo __("Lab Master List") ; ?></th>
	</tr>
	<tr>
		<td><?php   foreach($multiorderlab as $getDataRecives){?>
			<table  border="0" cellspacing="0" cellpadding="0" class="formFull new">
					<tr>
						<th><?php echo $getDataRecives['MultipleLabMaster']['title']; ?></th>
					</tr>
					<?php  $explodeList=explode(',',unserialize($getDataRecives['MultipleLabMaster']['name'])); 
					foreach($explodeList as $explodeLists){?>
					<tr>
					    <td style="padding-left: 10px;"><?php echo $explodeLists;?></td>
					</tr>
					<?php }?>
					<tr>
						<td align="center"><?php echo $this->Html->link(__('Remove'), array('action' => 'delete_lab_master_item',$getDataRecives['MultipleLabMaster']['id']), array('class'=>'blueBtn','div'=>false,'escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));?></td>
					</tr>
			</table>
			<?php }?>
		</td>
	</tr>
</table>
