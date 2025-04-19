<div class="inner_title">
<h3>&nbsp; <?php echo __('Radiology - Import Data', true); ?></h3>
<span>
 
 <?php
 echo $this->Html->link(__('Back', true),array('controller' => 'Radiologies', 'action' => 'index', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php $website=$this->Session->read("website.instance");
if($website=='kanpur'||$website=='hope'){
?>
 <div align="center">
 <a style="text-decoration:underline;" href="<?php echo $this->Html->url('/files/radiology_import_structure.xls');?>">Click here for download the Format </a>
 </div> 
 <?php }else {?>
 <div align="center">
 <a style="text-decoration:underline;" href="<?php echo $this->Html->url('/files/vadodara_radiology_import_structure.xls');?>">Click here for download the Format </a>
 </div> 
 <?php }?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('importData',array('enctype' => 'multipart/form-data'));?>
<table align="center">
<?php $website=$this->Session->read("website.instance");
if($website=='kanpur'|| $website=='hope'){
?>
<tr>
<td><?php echo __('Select Tariff',true); ?></td>
<td><?php
		echo $this->Form->input('tariffId',array('id'=>'tariff','type'=>'select','options'=>$tariffStandard,'class'=>'','default'=>$privateID,'label'=>false));
		?></td>
</tr>
     <tr>
		<td>Select the File:&nbsp;</td>
	    		<td>   <?php 
		       	 	echo $this->Form->input('import_file', array('id'=>'import_file','label'=> false, 'div' => false, 'error' => false,'type'=>"file"));
		        ?></td>
	 
	 
	    		<td><input name="submit" type="Submit" value="Submit" class="blueBtn save" tabindex="2"/></td>
	  </tr>

<?php }else{?>

	<tr>
		<td>Select the File:&nbsp;</td>
	    		<td>   <?php 
		       	 	echo $this->Form->input('import_file', array('id'=>'import_file','label'=> false, 'div' => false, 'error' => false,'type'=>"file"));
		        ?></td>
	 
	 
	    		<td><input name="submit" type="Submit" value="Submit" class="blueBtn save" tabindex="2"/></td>
	</tr>
<?php }?>
</table>
 			 
<?php echo $this->Form->end();?>  
<script type="text/javascript">
$(".save").click(function(){
	 var retVal = confirm("Do you want to continue ?");
	   if( retVal == true ){ 
		  return true;
	   }else{
		  return false;
	   }
}); 
</script>
