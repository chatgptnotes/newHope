<?php 
		if(!empty($item)){
			echo $this->Form->input('InventoryLaundry.item_code', array('class' => 'validate[required,custom[itemcode]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'value'=>$item,'readonly'=>'readonly') );
		} else {
			echo $this->Form->input('InventoryLaundry.item_code', array('class' => 'validate[required,custom[itemcode]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly') );
		}
?>
	
	