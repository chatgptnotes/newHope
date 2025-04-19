<div class="inner_title">
<h3>&nbsp; <?php echo __('Supplier - Import Data', true); ?></h3>
<span>
 
 <?php
 echo $this->Html->link(__('Back', true),array('controller' => 'Pharmacy', 'action' => 'supplier_list', 'inventory' => true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<!-- <div align="center">
 <a style="text-decoration:underline;" href="<?php echo $this->Html->url('/files/tarrif_import_structure.xls');?>">Find format of data for import here</a>
 </div> -->
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('importData',array('type' => 'file'));?>
<table align="center">
	<tr>
		<td>Select the File:&nbsp;</td>
	    		<td>   <?php 
		       	 	echo $this->Form->input('import_file', array('id'=>'import_file','label'=> false, 'div' => false, 'error' => false,'type'=>"file"));
		        ?></td>
	 
	 
	    		<td><input name="submit" type="Submit" value="Submit" class="blueBtn" tabindex="2"/></td>
	</tr>

</table>
 			 
<?php echo $this->Form->end();?>  

