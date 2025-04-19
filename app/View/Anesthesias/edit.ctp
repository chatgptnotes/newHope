<div class="inner_title">
 <h3><?php echo __('Edit Anesthesia', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#anesthesiafrm").validationEngine();
	});

</script>

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
<form name="anesthesiafrm" id="anesthesiafrm" action="<?php echo $this->Html->url(array("action" => "edit")); ?>" method="post" onSubmit="return Validate(this);">
        <?php
              echo $this->Form->input('Anesthesia.id', array('type' => 'hidden'));
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
	  <td class="form_lables">
	   <?php echo __('Name',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php
	          echo $this->Form->input('Anesthesia.name', array('class' => 'validate[required,custom[name]]','id' => 'anesthesianame', 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->textarea('Anesthesia.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'customdescription', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	  <td class="form_lables">
	   <?php echo __('Category',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php
	          echo $this->Form->input('Anesthesia.anesthesia_category_id', array('style' => 'width:450px;','class' => 'validate[required,custom[mandatory-select]]', 'options' => $anesthesiacategory, 'empty' => 'Select Anesthesia Category', 'id' => 'anesthesia_category_id', 'label'=> false, 'div' => false, 'error' => false, 'onchange'=> $this->Js->request(array('action' => 'getAnesthesiaSubcategory'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changesubcategory', 'data' => '{anesthesia_category:$("#anesthesia_category_id").val()}', 'dataExpression' => true))));
	   ?>
	  </td>
	 </tr>
	 <tr>
	  <td class="form_lables">
	   <?php echo __('Subcategory',true); ?>
	  </td>
	  <td id="changesubcategory">
	   <?php
	          echo $this->Form->input('Anesthesia.anesthesia_subcategory_id', array('id' => 'anesthesia_subcategory_id', 'empty' => 'Select Anesthesia Subcategory', 'options' => $anesthesiasubcategory, 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>


        <tr>
	<td colspan="2" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>