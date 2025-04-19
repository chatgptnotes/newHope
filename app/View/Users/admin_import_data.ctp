<div class="inner_title">
<h3>&nbsp; <?php echo __('User - Import Data', true); ?></h3>
<span>
 
 <?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'index', 'admin' => false), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

 <!-- 	<div align="center">
 	<a style="text-decoration:underline;" href="<?php echo $this->Html->url('/files/vadodara_tarifflist_format.xls');?>">Click here for download the Format </a>
 	</div> -->
 	
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php echo $this->Form->create('importData',array('enctype' => 'multipart/form-data'));?>
<table align="center">

<tr>
		<td>Select the File:&nbsp;</td>
	    		<td>   <?php 
		       	 	echo $this->Form->input('import_file', array('id'=>'import_file','label'=> false, 'div' => false, 'error' => false,'type'=>"file"));
		        ?></td>
	 
	 
	    		<td><input name="submit" type="Submit" value="Submit" class="blueBtn save" tabindex="2" /></td>
	    		
</tr>

</table>
 			 
<?php echo $this->Form->end();?>  

<script type="text/javascript">
/*$(".save").click(function(){
	 var retVal = confirm("Do you want to continue ?");
	   if( retVal == true ){ 
		  return true;
	   }else{
		  return false;
	   }
}); */
</script>
