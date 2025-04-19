<div class="inner_title">
<h3>&nbsp; <?php echo __('Interactive View - Import Data', true); ?></h3> 
</div>
  
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('nursings',array('action'=>'import_iv_categories','type' => 'file'));?>
<table align="center">
	<tr>
		<td>Select the File:&nbsp;</td>
	    		<td>   <?php 
		       	 	echo $this->Form->input('import_file', array('id'=>'import_file','label'=> false, 'div' => false, 'error' => false,'type'=>"file"));
		        ?></td>
	 
	 
	    		<td>
	    <?php 
	    	echo $this->Form->submit('Submit',array('class'=>'blueBtn'));
	    ?>		
	    	 </td>
	</tr>

</table>
 			 
<?php echo $this->Form->end();?>  