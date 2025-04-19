 <div id="doctemp_content">
	<?php
	if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"
		align="center">
		<tr>
			<td colspan="2" align="left" class="error"><?php 
			foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
			</td>
		</tr>
	</table>
	<?php } ?>
	<div id="docTemplate">
		<div class="inner_title">
			<h3>
				<?php echo __('Edit Template Category', true); ?>
			</h3>
			<span> <?php
			echo $this->Html->link(__('Back'), array('action' => 'template_category'), array('escape' => false,'class'=>"blueBtn"));
			?>
			</span>
		</div>
		<form name="edittemplatecategoryfrm" id="edittemplatecategoryfrm" action="<?php echo $this->Html->url(array("action" => "edit_template")); ?>" method="post" >
	
		
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
     <tr>
	  <td class="form_lables">
	   <?php echo __('Template Category',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php   echo $this->Form->input('Template.template_category_id', array('style'=>'width:250px; float:left;','empty'=>__('Select'),'options'=>$option,'id'=>'template_category_id','class' => 'textBoxExpnd','label'=>false)); ?>
	 
	     </td>
	 </tr>
 	 <tr>
	  <td class="form_lables">
           <?php echo __('Parent category',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Template.category_name', array('class' => 'validate[required,custom[customdescription]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'category_name', 'label'=> false, 'div' => false, 'error' => false));
        
       echo $this->Form->hidden('Template.id',array('type'=>'text')) ;
      
        ?>
        </td>
	</tr>
        <tr>
        <td></td>
	<td colspan="2" align="left">
	 <input type="submit" value="Submit" class="blueBtn" style="margin-top:10px;">
	</td>
	</tr>
	</table>
		</form>
		</div>
		
		
		
