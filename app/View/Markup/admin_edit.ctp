
 
<div class="inner_title">
<h3><?php echo __('Edit Markup', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
<!--<form name="locationfrm" id="locationfrm" action="<?php echo $this->Html->url(array("controller" => "", "action" => "", "admin" => true)); ?>" method="post"  >
--><?php echo $this->Form->create('Location',array("action" => "add", "admin" => true,'type' => 'file','id'=>'locationfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php
	     		 
	            echo $this->Form->hidden('Location.facility_id', array('type'=>'text','class' => 'validate[required,custom[facilityname]]',  'value'=>$this->Session->read('facilityid'), 'id' => 'facilityname', 'label'=> false, 'div' => false, 'error' => false));
	          
        		echo $this->Form->input('Location.name', array('type'=>'text','class' => 'validate[required,custom[customname]]', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	
	
	
	
	<tr>
	<td class="form_lables" align="right">
        <?php echo __('Is Active',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
          	echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        
      
       
     
       
    
     
   
	
    
	<tr>
	<td colspan="2" align="center">
        <?php 
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
        ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>

	 


</script>