<div class="inner_title">
 <h3><?php echo __('Add Corporate Sublocation', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#corporatesublocationfrm").validationEngine();
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
<form name="corporatesublocationfrm" id="corporatesublocationfrm" action="<?php echo $this->Html->url(array("action" => "add")); ?>" method="post" onSubmit="return Validate(this);" >
        <?php echo $this->Form->input('CorporateSublocation.credit_type_id', array('type' => 'hidden', 'value' => 1)); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" style="width:60% !important;"  align="center">
     <!--    <tr>
	<td class="form_lables">
	<?php echo __('Corporate Location',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('CorporateSublocation.corporate_location_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $corporatelocations, 'empty' => 'Select Corporation Location', 'id' => 'corporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange'=> $this->Js->request(array('action' => 'getCorporate'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changecorporate', 'data' => '{corporatelocationid:$("#corporatelocationid").val()}', 'dataExpression' => true))));
        ?>
        </td>
	</tr> -->
        <tr>
	<td class="form_lables">
	<?php echo __('Corporate',true); ?><font color="red">*</font>
	</td>
	<td >
	 <?php 
	          echo $this->Form->input('CorporateSublocation.tariff_standard_id', array('empty'=>'Please Select','class' => 'validate[required,custom[mandatory-select]]','options'=>$tariffstandard,'id' => 'tariffId', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
       <!--   <select id="corporatename" class="validate[required,custom[mandatory-select]]" name="data[CorporateSublocation][tariff_standard_id]">
          <option value="">Select Corporate</option>
         </select> -->
        </td>
	</tr>
         <tr>
	  <td class="form_lables">
	   <?php echo __('Name',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('CorporateSublocation.name', array('class' => 'validate[required,custom[customname]]','id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->textarea('CorporateSublocation.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'customdescription', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<!--<tr>
	  <td class="form_lables">
           <?php echo __('Doctor Name',true); ?>
		   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('CorporateSublocation.dr_name', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'doc_name', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	  <td class="form_lables">
           <?php echo __('Doctor Mobile No.',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('CorporateSublocation.mobile', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'doctor_name', 'label'=> false, 'div' => false, 'error' => false));
        ?> 
        </td>
	</tr>-->
	<tr>
	<td class="form_lables" align="left" valign="top">
	
	<?php echo __('Note',true); ?>
	
	</td>
	  <td align="center"><font color="green">
       Primary contact to intimate by SMS the admission of corporate patient e.g., Area Medical officer (AMO) of WCL area or CGHS dispensary incharge( Mention only one contact)</font>
        </td>
	</tr>
	  <tr>
	<td class="form_lables" align="left" valign="top">
	<?php echo __('Doctor`s Name',true); ?>
	<font color="red">*</font>
	</td>
	<td>
	<table width="100%" id="spdid">
	<tr><td>
      <span style="float:left">  <?php 
		 
          echo $this->Form->input('', array('class' => 'spdtext textCls validate[required,custom[mandatory-enter]]', 'id' => 'spd_0','name'=> 'data[dr_name][0]', 'label'=> false, 'div' => false,'style'=>'width:200px;', 'error' => false));
	  echo " Mobile No.:<font color='red'>*</font> ".$this->Form->input('', array('id' => 'spdqt_0','name'=> 'data[mobile][0]', 'label'=> false,'maxlength'=>'10','class' => 'qtyCls validate[required,custom[phone,minSize[10],onlyNumber]]', 'div' => false,'style'=>'width:150px;', 'error' => false)); 
        ?></span>
        <?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addButton_spd'));?>	 

	</td></tr>
	</table>
	</td>
	</tr>

	<tr>
	  <td colspan="2" align="center">
          <font color="red">(Enter multiple mobile no. with comma separated of one doctor-Ex.(111111111,000000000))</font>
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

<script>
$(document).ready(function(){
//for SPD add & remove button
		var counter_spd = 1;
		 
		  $("#addButton_spd").click(function () {	 				 
	          var newNoteDiv_spd = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_spd' + counter_spd);
	          var spd_row = '<td><input class="spdtext textCls" type="text" id="spd_'+ counter_spd +'" name="data[dr_name]['+counter_spd+']"  style="width:200px">';
	          var qt_row = ' Mobile No.: <input type="text" id="spdqt_'+ counter_spd +'" name="data[mobile]['+counter_spd+']" class="qtyCls validate[required,custom[phone,minSize[10],onlyNumber]]" "maxlength"="10" style="width:150px">'; 
	          var img_row = '<span class=currentRemoveSpd id=currentRemoveSpd_'+counter_spd+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>';
		      		 			
	newNoteDiv_spd.append(spd_row + qt_row+img_row);		 
	newNoteDiv_spd.appendTo("#spdid");		
				 			 
	counter_spd++;
	//if(counter_spd > 2) $('#removeButton_spd').show('slow');
     });	
	$(document).on('click','.currentRemoveSpd', function() {
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#NoteDiv_spd"+ID).remove();			
	});

});
</script>