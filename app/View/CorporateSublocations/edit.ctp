<div class="inner_title">
 <h3><?php echo __('Edit Corporate Sublocation', true); ?></h3>
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
<form name="corporatesublocationfrm" id="corporatesublocationfrm" action="<?php echo $this->Html->url(array("action" => "edit")); ?>" method="post" onSubmit="return Validate(this);">
        <?php 
             echo $this->Form->input('CorporateSublocation.id', array('type' => 'hidden')); 
             echo $this->Form->input('CorporateSublocation.credit_type_id', array('type' => 'hidden', 'value' => 1));
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" style="width:60% !important;"  align="center">
    <!--     <tr>
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
	<td>
         <?php 
          //echo $this->Form->input('CorporateSublocation.corporate_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $corporates, 'empty' => 'Select Corporate', 'id' => 'corporate', 'label'=> false, 'div' => false, 'error' => false));
        ?>
         <?php 
	          echo $this->Form->input('CorporateSublocation.tariff_standard_id', array('empty'=>'Please Select','class' => 'validate[required,custom[mandatory-select]]','options'=>$tariffstandard,'id' => 'tariffId', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
         </td>
          <td></td>
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
	   <td></td>
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
        <td></td>
	</tr>
		<tr>
	<td class="form_lables" align="left" valign="top">
	
	<?php echo __('Note',true); ?>
	
	</td>
	  <td align="center"><font color="green">
       Primary contact to intimate by SMS the admission of corporate patient e.g., Area Medical officer (AMO) of WCL area or CGHS dispensary incharge( Mention only one contact)</font>
        </td>
         <td></td>
	</tr>
	<tr>
	    <td class="form_lables" align="left" valign="top">
		<?php echo __('Doctor`s Name',true); ?>

		</td>
		<td id="spdid">
		<?php $getDoctorName=unserialize($this->request->data['CorporateSublocation']['dr_name']);
			  $getMobileNo=unserialize($this->request->data['CorporateSublocation']['mobile']);
		$countCssd  = 1 ;	
		if(isset($getDoctorName) && !empty($getDoctorName)){			
			$countor  = count($getDoctorName) ;
		}else{
			$countor  = 1 ;
		}
		for($keycssd=0;$keycssd<$countor;){
			 
			$spdValue= isset($getDoctorName[$keycssd])?$getDoctorName[$keycssd]:'' ;
			$qtySpd= isset($getMobileNo[$keycssd])?$getMobileNo[$keycssd]:'' ;
			$idSpd= isset($getData['PreferencecardSpditem'][$keycssd]['id'])?$getData['PreferencecardSpditem'][$keycssd]['id']:'' ;
			?>
		<table width="100%" >
			<tr id="NoteDiv_spd<?php echo $keycssd?>">
			<td>
		        <?php 				 
		          echo $this->Form->input('', array('type'=>'text','class' => 'spdtext ', 'id' => 'spd_'.$keycssd,'name'=> 'data[dr_name]['.$keycssd.']', 'label'=> false, 'div' => false,'style'=>'width:200px;', 'error' => false,'value'=>$spdValue));
			  echo " Mobile No.: ".$this->Form->input('', array('type'=>'text','id' => 'spdqt_'.$keycssd,'name'=> 'data[mobile]['.$keycssd.']','maxlength'=>'10', 'label'=> false,'class' => 'qtyCls validate[required,custom[phone,minSize[10],onlyNumber]]', 'div' => false,'style'=>'width:150px;', 'error' => false,'value'=>$qtySpd));
			 // echo $this->Form->hidden('',array('type'=>'hidden','name'=> 'data[PreferencecardSpditemid]['.$keycssd.']','value'=>$idSpd,'label'=>false,'id'=>'PreferencecardSpditemid_'.$keycssd));
			  ?>
			  <span class="currentRemoveSpd" id="currentRemoveSpd_<?php echo $keycssd;?>"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span>
			</td>
			</tr>
		</table>
		<?php $countCssd++;
		$keycssd++;
				}?>
	</td>
	<td valign="top">
		<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addButton_spd'));?>
	<!-- <input name="" type="button" id="addButton_spd" value="Add More"
						class="blueBtn" style="text-align:right"/>  -->
		
		
			</td>
	</tr>
	

	<tr>
	  <td colspan="3" align="center">
          <font color="red">(Enter multiple mobile no. with comma separated of one doctor-Ex.(111111111,000000000))</font>
        </td>
	</tr>
        <tr>
	<td colspan="3" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){
//for SPD add & remove button
		var counter_spd = '<?php echo $keycssd;?>';		 
		  $("#addButton_spd").click(function () {	 				 
	          var newNoteDiv_spd = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_spd' + counter_spd);
	          var spd_row = '<td><input class="spdtext" type="text" id="spd_'+ counter_spd +'" name="data[dr_name]['+counter_spd+']"  style="width:200px">';
	          var qt_row = ' Mobile No.: <input type="text" id="spdqt_'+ counter_spd +'" name="data[mobile]['+counter_spd+']" class="qtyCls validate[required,custom[phone,minSize[10],onlyNumber]]" "maxlength"="10" style="width:150px">';
	          var img_row = '<span class=currentRemoveSpd id=currentRemoveSpd_'+counter_spd+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>';
			    		 			
	newNoteDiv_spd.append(spd_row + qt_row+img_row);		 
	newNoteDiv_spd.appendTo("#spdid");		
				 			 
	counter_spd++;
	//if(counter_spd > 1) $('#removeButton_spd').show('slow');
     });

	/*$("#removeButton_spd").click(function () {
		counter_spd--;			 
    	$("#NoteDiv_spd" + counter_spd).remove();
 		if(counter_spd == 1) $('#removeButton_spd').hide('slow');
  });*/
	$(document).on('click','.currentRemoveSpd', function() {
		if(confirm("Do you really want to delete this record?")){
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		var setToSpdId=$('#PreferencecardSpditemid_'+ID).val();		
		$("#NoteDiv_spd"+ID).remove();		
		if(setToSpdId)delete_item('SPD',setToSpdId);	
		}else{
			return false;
		}	
	});

  //for OR add & remove button
	});
  </script>