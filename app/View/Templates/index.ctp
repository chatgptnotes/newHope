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
				<?php echo __('Add Template Category', true); ?>
			</h3>
			<span> <?php
			echo $this->Html->link(__('Back', true),array('controller' => '', 'action' => '', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
			?>
			</span>
		</div>
		<form name="templatecategoryfrm" id="templatecategoryfrm" action="<?php echo $this->Html->url(array("action" => "index")); ?>" method="post" >
	
		
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
     <tr>
	  <td class="form_lables">
	   <?php echo __('Template Category',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	         echo $this->Form->input('TemplateCategories.name', array('class' => 'validate[required,custom[name]]','id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=> 'off'));
	   ?>
	   
	  </td>
	 </tr>
 	 <tr>
	  <td class="form_lables">
           <?php echo __('Description',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('TemplateCategories.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'description', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
		</form>
		
		
		</div>
		
		
		
