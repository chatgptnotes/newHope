
 
<div class="inner_title">
<h3><?php echo __('Add Accounting', true); ?></h3>
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
	<?php echo __('Class',true); ?><font color="red">*</font>
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
        <?php echo __('Status',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Location.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Effective',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Location.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Asset',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.zipcode', array('class' => 'validate[required,custom[customzipcode]]', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Chargeable',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          	echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Nonchargeable',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          	echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Is Active',true); ?><font color="red">*</font>
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
<script>
	 
/*var editor = CKEDITOR.replace( 'LocationFooter',
		{
	filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',			 
	filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserWindowWidth : '1000',
	filebrowserWindowHeight : '700'
					
});
CKFinder.setupCKEditor( editor, '/ckfinder/' );*/

</script>