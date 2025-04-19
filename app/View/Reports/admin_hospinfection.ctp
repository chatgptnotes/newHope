<div class="inner_title">
	<h3>
		<?php echo __('Hospital Aquired Infection Tracking', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'admin_hospinfection','type'=>'post'));?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="left">

	<tr>

		<td align="right" width="50%">
			<?php echo __('Month') ?> :
		</td>
		
		<td class="row_format">
			<?php 
                                $monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December');
		    		echo  $this->Form->input(null, array('name' => 'reportMonth', 'class' => '','style'=>"width:100px", 'id' => 'reportMonth', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$monthArray, 'empty'=> 'Select', 'value' =>$reportMonth));
		    	?>
		</td>
	</tr>
	<tr>

		<td align="right" width="50%">
			<?php echo __('Micro-organism type') ?> :
		</td>
		<td class="row_format" align="left">
			<?php 
		    		 echo  $this->Form->input(null, array('name' => 'reportType', 'class' => '','style'=>"width:100px", 'options' => array('VRE' => 'VRE', 'MRSA' => 'MRSA'), 'id' => 'reportType', 'label'=> false, 'div' => false, 'empty'=> 'Select', 'error' => false,'autocomplete'=>false, 'value' =>$data1));
		    	?>
		</td>
	</tr>
	<tr>
		<td class="row_format" align="center" colspan="2">
			<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
		</td>

	</tr>

</table>
<?php echo $this->Form->end();
if(isset($ward)){
?>

<div>
	<h3>
		HAI report for the month of
		<?php echo $monthArray[$reportMonth];?>
	</h3>
</div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th style="text-align: center;" width=20%>
			<?php echo __('Micro-Organisms', true); ?>
		</th>
		<th style="text-align: center;" width=25%>
			<?php echo __('Room', true); ?>
		</th>
		<th style="text-align: center;" width=35%>
			<?php echo __('Employee name', true); ?>
		</th>
	</tr>
	<?php if(isset($ward) && empty($ward)){?>
	<tr>
		<td align="center" colspan='3' border='none'>No Data Recorded
	</tr>
	<?php  }else{ ?>
	<?php $cnt==0; 
foreach ($ward as $key => $value) { ?>
	<tr> <?php if($cnt == 0){?>
		<td align="center" rowspan="<?php echo count($ward)?>">
			<?php if($cnt==0){ echo $data1;} $cnt++;?>
		</td>
		<?php }?>
		<td align="center">
			<?php echo $key; ?>
		</td>
		<td align="center">
			<?php for($l=0;$l<count($ward[$key]);$l++)
   					 { ?> </br> <?php  echo $ward[$key][$l];?> <?php	 }?>
		</td>




	</tr>
	<?php }} ?>
</table>

<div class="btns">
	<?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
</div>
<?php } ?>