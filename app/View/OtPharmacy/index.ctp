
<style>
.td_second{
	border-left-style:solid; 
	padding-left: 15px; 
	background-color: #404040; 
	color:#ffffff;
	width:5%;
}
</style>

<div class="inner_title">
<h3> &nbsp; <?php echo __(' OT Pharmacy Manager', true); ?></h3>
	
    <div align="right">
 <?php
 //echo $this->Html->link(__('Import Data', true),array('controller' => 'pharmacy', 'action' => 'import_data', 'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
?>
</div>
</div>

<table width="100%"  cellspacing='0' cellpadding='0' >
<tr>
	<td  valign="top" class="td_second">
	<?php echo $this->element('ot_pharmacy_menu');?>
	</td>

	<td>
	<table cellpadding="0" cellspacing="0" width="100%" class="formFull" style="margin-top:25px;">
		<tr>
		<td><?php echo  $this->Html->link('Sales Bill',array('controller'=>'OtPharmacy','action'=>'sales_bill'),array('alt' => 'Add Item'));?></td>
		</tr>
	</table>
	</td>
</tr>
</table>
