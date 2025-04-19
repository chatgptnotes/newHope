<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#RoomAddForm").validationEngine();
	});
	
</script>
<?php echo $this->Form->create('Room', array('id'=>'RoomAddForm','url'=>array('controller'=>'rooms','action'=>'add',$wardId))); ?>

<div class="inner_title">
 
	<h3>	
			<div style="float:left"><?php echo __('Add Room').' - '.ucfirst($wardName); ?></div>			
			
	</h3>
	<div class="clr"></div>
</div>
   <p class="ht5"></p>
	   <!-- two column table start here -->
	  
                            
<table width="40%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td width="150" height="35" valign="middle" id="boxSpace1" align="right">Room Name: <font color="red">*</font></td>
	<td width="" align="left" valign="middle">
		<?php echo $this->Form->input('Room.name',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter-only]]','legend'=>false,'label'=>false,'id' => 'name'));?></td>
  </tr>
  <tr>
	<td width="150" height="35" valign="middle" align="right" id="boxSpace1">Room Type:<font color="red">*</font> </td>
	<td width="" align="left" valign="middle">
		<?php 
		echo $this->Form->input('',array('options'=>Configure::read('roomtType'),'type'=>'select' ,'name'=>'data[Room][room_type]','legend'=>false,'label'=>false,'id' => 'room_type'));?></td>
  </tr>
  <tr>
	<td height="35" valign="middle" id="boxSpace1" align="right">Bed Prefix:<font color="red">*</font></td>
	<td align="left" valign="middle">
		<?php echo $this->Form->input('Room.bed_prefix',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter-only]]','legend'=>false,'label'=>false,'id' => 'bed_prefix'));?></td>
  </tr>
  <tr>
	<td height="35" valign="middle" id="boxSpace1" align="right">No. of Beds:<font color="red">*</font></td>
	<td align="left" valign="middle">
		<?php echo $this->Form->input('Room.no_of_beds',array('type'=>'text','class' => 'validate[required,custom[onlyNumber]]','legend'=>false,'label'=>false,'id' => 'no_of_beds'));?></td>
  </tr>
</table>
                                     
                             
					<!-- two column table end here -->
<div align="center">
<?php 
	 
echo $this->Html->link(__('Back'),array('controller'=>'rooms','action' => 'index',$wardId,'admin'=>false), array('escape' => false,'class'=>'blueBtn'));?>
<input class="blueBtn" type="submit" value="Save" id="save">
</div>    
                    <div class="clr ht5">&nbsp;</div>
 <?php echo $this->Form->end(); ?>                   
