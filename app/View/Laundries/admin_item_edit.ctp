<div class="inner_title">
<h3>&nbsp; <?php echo __('Edit Items in Laundry', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#itemfrm").validationEngine();
	});

 
</script>
</br></br>
<form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "item_edit/",$this->data['LaundryItem']['id'],'admin'=>true )); ?>" method="post" >
	<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <!-- <tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item code<font color="red">*</font></td>
		<td width="250"><?php 
        echo $this->data['LaundryItem']['item_code'];
		echo $this->Form->hidden('LaundryItem.item_code', array('id' => 'item_code', 'label'=> false, 'div' => false, 'error' => false,'value'=>$this->data['LaundryItem']['item_code']));
		echo $this->Form->hidden('LaundryItem.id', array('id' => 'item_code', 'label'=> false, 'div' => false, 'error' => false,'value'=>$this->data['LaundryItem']['id']));
		?>
		</td>
	 </tr> -->
	  <tr>
	    <td width="100" valign="middle" class="tdLabel" id="boxSpace">Item Name<font color="red">*</font></td>
		<td width="250"><?php 
        echo $this->Form->input('LaundryItem.name', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false)  );
		echo $this->Form->hidden('LaundryItem.id', array('label'=> false, 'div' => false, 'error' => false)  );?></td>
	</tr>	   
	  
	</table>
	<!-- billing activity form end here -->

	<p class="ht5"></p>
	   <p class="ht5"></p>
	   <div align="center">
	  
		 <div class="btns" style="float:none">
			<?php echo $this->Html->link(__('Cancel', true),array('controller'=>'laundries','action' => 'item_index','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
			&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
		  </div>
		
	 </div>
	</div>
  
</form>




 