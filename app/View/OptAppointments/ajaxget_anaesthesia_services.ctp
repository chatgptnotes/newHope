<?php 
    if($surgeon){
?>
<label>
  <span><?php echo __('Service'); ?><font color="red"> *</font>:</span>
  <?php echo $this->Form->input(null,array('name' => 'surgen_tariff_list_id', 'id'=> 'surgen_tariff_list_id', 'empty'=>__('Select Service'),'options'=> $services, 'label' => false, 'div' => false, 'style'=>'width:190px;', 'class' => 'required safe'));?>
</label>

<?php
}else{ 
?>
<label>
  <span><?php echo __('Service'); ?><font color="red"> *</font>:</span>
  <?php 
echo $this->Form->input(null,array('name' => 'anaesthesia_tariff_list_id', 'id'=> 'anaesthesia_tariff_list_id', 'empty'=>__('Select Service'),'options'=> $services, 'label' => false, 'div' => false, 'style'=>'width:190px;', 'class' => 'required safe'));?>
</label>

<?php
    }
?>