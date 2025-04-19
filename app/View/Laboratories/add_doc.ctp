<?php if($status == "success"){?>
<script> 
			jQuery(document).ready(function() { 
			parent.$.fancybox.close(); 
		});
		</script>
<?php   } ?>

<style>
.inner_title {
	color: #000000;
	display: block;
	font-size: 20px;
	padding: 8px;
	width: 97%;
}
</style>
<div class="inner_title">
	<h3>  <?php echo __('Upload Document' ); ?>  	 </h3>
	<span><?php
	// echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array('alt'=>'Refresh List','title'=>'Refresh List')),
	// "#",array('escape'=>false,'onclick'=>"load_list();"));
	?></span>
</div>
<div style="padding: 65px 0px 0px 157px;">
		<?php echo $this->Form->create('laboratory',array('enctype'=>'multipart/form-data'));?>
		<?php
		
		echo $this->Form->input ( 'upload', array (
				'type' => 'file' 
		) );
		echo $this->Form->hidden ( 'lab_manager_id', array (
				'value' => $this->params->pass [0],
				'id' => 'lab_man_id' 
		) );
		echo $this->Form->hidden ( 'patient_id', array (
				'value' => $this->params->pass [1],
				'id' => 'patient_id' 
		) );
		echo $this->Form->hidden ( 'lab_id', array (
				'value' => $this->params->pass [2],
				'id' => 'lab_id' 
		) );
		echo $this->Form->input ( 'Submit', array (
				'type' => 'submit',
				'id' => 'submit',
				'div' => false,
				'label' => false,
				'class' => 'blueBtn' 
		) );
		?>
		<?php echo $this->Form->end();?>
		</div>



