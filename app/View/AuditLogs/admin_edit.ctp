
<style>
.tableformat {
	border: 1px solid #4C5E64;
	margin-left: 77px;
	margin-right: -4px;
	margin-top: 0;
	padding: 0;
	width: 526px;
}

.table1 {
	border: 1px solid #4C5E64;
	margin-bottom: 20px;
	margin-top: 20px;
	padding: 0;
	width: 550px;
}

.btn {
	margin-left: 545px;
}
</style>

<div class="inner_title">
	<h3>
		<div style="float: left">
			<?php echo __('Edit Logs'); ?>
		</div>
		<div style="float: right;">
			<?php
			echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="550"
	margin-bottom="26px;" ;
	align="center" class="table1">

	<?php $cnt=0;
	foreach($data as $var => $data){
	foreach($data as $key => $value){
?>

	<?php if($cnt%2 == 0){?>
	<tr class="row_gray">
		<?php }else { ?>
	
	
	<tr>
		<?php }?>
		<td class="row_format"><strong> <?php echo $key; ?>
		</strong>
		</td>
		<td><?php echo $value;?>
		</td>
	</tr>
	<?php 
	if($cnt==5){
break;
}$cnt++;
}
}?>
</table>
<div class="clr">
	<?php echo $this->Form->create('AuditDeltaLog',array('id'=>'editfrm','controller'=>'AuditLogs',
			'inputDefaults' => array(
											        'label' => false,
											        'div' => false,
											        'error'=>false )));?>

	<?php $counter =0;
	foreach($auditdelta as $key=>$auditdelta){
$increment =0;
foreach($auditdelta as $var=>$audit){
		$cnt==0; if($cnt%2 == 0){?>
	<table border="0" cellpadding="0" cellspacing="0" align="right "
		class="tableformat" class="tabledata">

		<?php }else { ?>
		<table border="0" cellpadding="0" cellspacing="0" align="left"
			class="tableformat">

			<?php } foreach($audit as $variab=>$audit){   ?>
			<tr>
				<?php if($increment==0) //echo $this->Form->hidden('deltaLogs.'.$variab.$counter,array('type'=>'text','div'=>false,'label'=>false,'value'=>$audit));
			echo $this->Form->hidden("tt][$counter][AuditDeltaLog][audit_delta_$variab]",array('type'=>'text','div'=>false,'label'=>false,'value'=>$audit));
			if($increment==1)
				echo $this->Form->hidden("tt][$counter][AuditDeltaLog][audit_id]",array('type'=>'text','div'=>false,'label'=>false,'value'=>$audit));
			echo $this->Form->hidden("tt][$counter][AuditDeltaLog][created_by]",array('type'=>'text','div'=>false,'label'=>false,'value'=>$this->Session->read('userid')));
			echo $this->Form->hidden("tt][$counter][AuditDeltaLog][create_time]",array('type'=>'text','div'=>false,'label'=>false,'value'=>date("Y-m-d H:i:s")));
			?>
				<td class="row_format"><strong> <?php echo $variab; ?>
				</strong>
				</td>
				<td><?php if($increment == 3 || $increment == 4){ 
					//	echo $this->Form->input('deltaLogs.'.$variab.$counter,array('type'=>'text','div'=>false,'label'=>false,'value'=>$audit));
					echo $this->Form->input("tt][$counter][AuditDeltaLog][changed_$variab]",array('type'=>'text','div'=>false,'label'=>false,'value'=>$audit));

				}
				else echo $audit;
				?>
				</td>
			</tr>
			<?php $increment++; 
	} ?>
		</table>




		<?php  $cnt++; 
} $counter++;
}?>




		<?php $this->Form->end();?>
		</div>
		<table class="btn">
			<tr>
				<td><?php echo $this->Html->link(__('Cancel'),array('action'=>'admin_audit_logs'), array('valign'=> 'right','class'=>'blueBtn','div'=>false)); ?></td>
				<td><?php echo $this->Form->submit(__('Submit'), array('valign'=> 'right','class'=>'blueBtn','div'=>false)); ?></td>
			</tr>
		</table>

	</table>