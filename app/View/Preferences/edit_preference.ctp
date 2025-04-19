
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#preferencefrm").validationEngine();
	});
</script>
<div class="inner_title">
<h3><?php echo __('Edit Preference Card', true); ?></h3>
<span>
	<?php  	
		echo $this->Html->link(__('Back'),array("controller" => "Preferences", "action" => "user_preferencecard", $patient_id), array('escape' => false,'class'=>"blueBtn "));
	    /* echo $this->Html->link("Back",array('controller'=>!empty($returnController)?$returnController:'preferences','action'=>'user_preferencecard',$patient_id,$this->request->pass[2]),array('escape'=>false,'class'=>'blueBtn')); */ 
    ?>
</span>
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
<?php  echo $this->Form->create('',array('action'=>'save_preference_card','type'=>'post')); ?>
	
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	
	<tr>
		<td class="form_lables" align="right" width="30%">
		<?php echo __('Preference Card Title',true); ?><font color="red">*</font>
		</td>
		<td width="21%">
	        <?php  echo $this->Form->input('Preferencecard.patient_id', array('type' => 'hidden', 'value'=> $patient_id));
	       		echo $this->Form->input('Preferencecard.card_title', array('type'=>'text','value'=>$getData['Preferencecard']['card_title'],'label'=>false,'style'=>'width:95%;'));
				echo $this->Form->input('Preferencecard.id',array('type'=>'hidden','value'=>$getData['Preferencecard']['id'],'label'=>false,'id'=>'preferenceCardId'));
	        ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="form_lables" align="right" valign="top">
		<?php echo __('Procedure Name'); ?><font color="red">*</font>
		</td>
		<td id="prcedureId">
        <?php $countSurge = 0;
		foreach($getData['Procedure'] as $keySurge=>$keySurgeVal){ 
						$procedureValue= isset($keySurgeVal['Surgery']['name'])?$keySurgeVal['Surgery']['name']:'' ;
						$procedureId= $getData['Procedure'][$keySurge]['Surgery']['id'];
						$preferencecardProcedureid = $getData['PreferencecardProcedure'][$keySurge]['id'];
						?>
						
			<table width="100%" >
				<tr class="block_<?php echo $keySurge?>" id="newNoteDiv_surge<?php echo $keySurge?>">
					<td>
				      <?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'procedure validate[required,custom[mandatory-select]]','value'=>$procedureValue,'id'=>"procedure_".$keySurge,'name'=> "data[procedure][$keySurge]",'style'=>"width:90%;",'label'=>false,'div'=>false));
				     	 	echo '</n>';
				     	   echo $this->Form->hidden('', array( 'class'=>'','id' => "procedureid_".$keySurge,'name'=>"data[procedure_id][$keySurge]", 'value'=>$procedureId ));
				     	   echo $this->Form->hidden('',array('type'=>'hidden','name'=> "data[PreferencecardProcedureid][$keySurge]",'value'=>$preferencecardProcedureid,'label'=>false,'id'=>'PreferencecardProcedureid_'.$keySurge));
				     ?>
				    <span class="currentRemoveSurge" id="currentRemoveSurge_<?php echo $keySurge;?>"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span>
					</td>
				</tr>
	        </table>
	    <?php $countSurge++;}?>
        </td>
        <td valign="top">
				<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true), 'alt'=> __('Add', true),'id'=>'addButton_surg'));?>
		</td>
	</tr>
	
	<tr>
		<td class="form_lables" align="right">
		<?php echo __(Configure::read('doctorLabel'),true); ?><font color="red">*</font>
		</td>
		<td>
	        <?php
		     	echo $this->Form->input('Preferencecard.doctor_id', array('options' => $doctorlist,'value'=>$getData['Preferencecard']['doctor_id'], 'id' => 'doctor_id', 'label'=> false, 'div' => false, 'error' => false,
	          														  'class' => 'validate[required,custom[mandatory-select]]'));
			?>
		</td>
		<td></td>
	</tr>
	
	<tr>
		<td class="form_lables" align="right" valign="top">
		<?php echo __('Instrument Set Name',true); ?><font color="red">*</font>
		</td>
		
		<td id="intrumentid">
		
		<?php $countInstrument  = 1 ;		
		if(isset($getData['PreferencecardInstrumentitem']) && !empty($getData['PreferencecardInstrumentitem'])){
			$countorInstr  = count($getData['PreferencecardInstrumentitem']) ;
		}else{
			$countorInstr  = 1 ;
		}
		for($key=0;$key<$countorInstr;){  
						$instrValue= isset($getData['PreferencecardInstrumentitem'][$key]['item_name'])?$getData['PreferencecardInstrumentitem'][$key]['item_name']:'' ;
						$idIstr= isset($getData['PreferencecardInstrumentitem'][$key]['id'])?$getData['PreferencecardInstrumentitem'][$key]['id']:'' ;?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center" >
			<tr class="block_<?php echo $key?>" id="NoteDiv_<?php echo $key?>">
				<td>
			        <?php 		        
			         echo $this->Form->input('', array('type'=>'text' ,'class' => 'drugText validate[required,custom[mandatory-select]]','id'=>"instrument_$key",'name'=> 'data[instrument]['.$key.']','label'=>false,'div' => false,'value'=>$instrValue,'counter'=>$i,'style'=>"width:90%;")); 
					echo '</n>';
					echo $this->Form->hidden('',array('type'=>'hidden','name'=> 'data[PreferencecardInstrumentitemid]['.$key.']','value'=>$idIstr,'label'=>false,'id'=>"instrumentId_$key"));
					?>
					<span class="currentRemoveIns" id="currentRemoveIns_<?php echo $key;?>"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span>
				</td>
			</tr>
		</table>
		<?php $countInstrument++;
		$key++;
		}?>
			
		</td>
		<td valign="top">
		<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addButton'));?>
		<!--  <input name="" type="button" id="addButton" value="Add More"
							class="blueBtn" style="text-align:right"/> -->
				
		</td>
	</tr>
	
    <tr>
		<td class="form_lables" align="right">
		<?php echo __('Equipment Name',true); ?>
		</td>
		<td>
	        <?php 
	        echo $this->Form->textarea('Preferencecard.equipment_name', array('cols' => '35', 'rows' => '10','style'=>'width:95%;', 'id' => 'equipment', 'value'=>$getData['Preferencecard']['equipment_name'], 'label'=> false, 'div' => false, 'error' => false));
	        ?>
	     </td>
	     <td></td>
	</tr>
     
    <tr>
	    <td class="form_lables" align="right" valign="top">
		<?php echo __('CSSD Name',true); ?>
		</td>
		<td id="spdid">
		<?php $countCssd  = 1 ;	
		if(isset($getData['PreferencecardSpditem']) && !empty($getData['PreferencecardSpditem'])){
			$countor  = count($getData['PreferencecardSpditem']) ;
		}else{
			$countor  = 1 ;
		}
		for($keycssd=0;$keycssd<$countor;){
			 
			$spdValue= isset($getData['PreferencecardSpditem'][$keycssd]['item_name'])?$getData['PreferencecardSpditem'][$keycssd]['item_name']:'' ;
			$qtySpd= isset($getData['PreferencecardSpditem'][$keycssd]['quantity'])?$getData['PreferencecardSpditem'][$keycssd]['quantity']:'' ;
			$idSpd= isset($getData['PreferencecardSpditem'][$keycssd]['id'])?$getData['PreferencecardSpditem'][$keycssd]['id']:'' ;
			?>
		<table width="100%" >
			<tr id="NoteDiv_spd<?php echo $keycssd?>">
			<td>
		        <?php 				 
		          echo $this->Form->input('', array('class' => 'spdtext ', 'id' => 'spd_'.$keycssd,'name'=> 'data[spd]['.$keycssd.']', 'label'=> false, 'div' => false,'style'=>'width:60%;', 'error' => false,'value'=>$spdValue));
			  echo " Qty: ".$this->Form->input('', array('id' => 'spdqt_'.$keycssd,'name'=> 'data[spdqt]['.$keycssd.']', 'label'=> false,'class' => 'qtyCls', 'div' => false,'style'=>'width:48px;', 'error' => false,'value'=>$qtySpd));
			  echo $this->Form->hidden('',array('type'=>'hidden','name'=> 'data[PreferencecardSpditemid]['.$keycssd.']','value'=>$idSpd,'label'=>false,'id'=>'PreferencecardSpditemid_'.$keycssd));
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
		<td class="form_lables" align="right" valign="top">
		<?php if($this->request->pass[1]=="Radiology"){
				 echo __('Radiology Item Name',true); 
	         	 } else if($this->request->pass[1]=="OR") {
				echo __('OR Item Name',true); 
				}else{
				echo __('Lab Item Name',true);
			} 
				?>
		</td>
		<td id="orid">
		<?php  $countLab = 1 ;		     
			      	if(isset($getData['PreferencecardOritem']) && !empty($getData['PreferencecardOritem'])){
				               				$countor  = count($getData['PreferencecardOritem']) ;
				               			}else{
				               				$countor  = 1 ;
				               			}	               			
				               			for($keyor=0;$keyor<$countor;){
				               				 
				               				$orValue= isset($getData['PreferencecardOritem'][$keyor]['item_name'])?$getData['PreferencecardOritem'][$keyor]['item_name']:'' ;
				               				$qtyOr= isset($getData['PreferencecardOritem'][$keyor]['quantity'])?$getData['PreferencecardOritem'][$keyor]['quantity']:'' ;
				               				$idOr= isset($getData['PreferencecardOritem'][$keyor]['id'])?$getData['PreferencecardOritem'][$keyor]['id']:'' ;
				               			
				               			?>
	        <table width="100%" >
		<tr id="NoteDiv_or<?php echo $keyor?>"><td>
	        <?php 
	          echo $this->Form->input('', array('class' => 'ortext','name'=> 'data[or]['.$keyor.']', 'id' => 'or_'.$keyor, 'label'=> false, 'div' => false,'style'=>'width:60%;', 'error' => false,'value'=>$orValue));
		  echo " Qty: ".$this->Form->input('', array('name'=> 'data[orqt]['.$keyor.']', 'id' => 'orqt_'.$keyor, 'label'=> false,'class' => '', 'div' => false,'style'=>'width:48px;', 'error' => false,'value'=>$qtyOr));
	        echo $this->Form->hidden('',array('type'=>'hidden','name'=> 'data[PreferencecardOritemid]['.$keyor.']','value'=>$idOr,'label'=>false,'id'=>'PreferencecardOritemid_'.$keyor));
				    ?>
		  <span class="currentRemoveOr" id="currentRemoveOr_<?php echo $keyor;?>"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span>
			
	
		</td></tr>
		</table>
		<?php $keyor++;
		$countLab++;
		}?>
		</td>
		<td valign="top">
		<!-- <input name="" type="button" id="addButton_or" value="Add More" class="blueBtn" style="text-align:right" />  -->
		<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addButton_or'));?>
		</td>
	</tr>
    <tr>
		<td class="form_lables" align="right" valign="top">
	
		<?php echo __('Medication Name',true); ?>
		<td id="medid">
			<?php  //debug($getPharmacyData);
		        $getUnserializeMedData=unserialize($getData['Preferencecard']['medications']);
		        $getUnserializeQuantityData=unserialize($getData['Preferencecard']['quantity']);
		    
		      foreach($getUnserializeMedData[0] as $keyBoth=>$data){
		        	$newArry[$keyBoth]=$data."_".$getUnserializeQuantityData[0][$keyBoth];	        	        	
			        }
		  
	/*** New delete check **/
	
	if(!empty($getUnserializeMedData['0'])){
	$countAdd=0;
	foreach($getUnserializeMedData['0'] as $keyMed=>$newData){
		$getExplodeData=explode('_',$newArry[$keyMed]);		
		?>
			<table width="100%" >
			<tr id="NoteDiv_med<?php echo $keyMed?>"><td>
		        <?php 
		        echo $this->Form->hidden('', array( 'class'=>'','id' => 'itemCode_0','name'=>'data[itemC]['.$keyMed.']' , 'label'=> false, 'div' => false,'style'=>'width:60%;', 'error' => false));
		          echo $this->Form->input('', array( 'class'=>'medtext textCls','id' => 'med_'.$keyMed,'name'=>'data[med]['.$keyMed.']' , 'label'=> false, 'div' => false,'style'=>'width:60%;', 'error' => false,'value'=>$getPharmacyData[$countAdd]['PharmacyItem']['name']));
		          echo $this->Form->hidden('', array( 'class'=>'','id' => 'drug-id_'.$keyMed,'name'=>'data[drug_id]['.$keyMed.']','value'=>$getExplodeData['0']));
			 	 echo " Qty: ".$this->Form->input('', array('id' => 'medqt_'.$keyMed,'name'=> 'data[medqt]['.$keyMed.']', 'label'=> false,'class' => 'medqtCls', 'div' => false,'style'=>'width:48px;', 'error' => false,'value'=>$getExplodeData['1'])); //validate[required,custom[mandatory-select]]
		      	?>
			  <span name="<?php echo $getUnserializeMedData[0][$keyMed]?>" class="currentRemoveMed" id="currentRemoveMed_<?php echo $keyMed;?>"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span>
			
			</td></tr>
			</table>
			<?php $countorMed++;
			$countAdd++;
			$keyMed++;
			}
			}else{
				$countorMed=1;
				for($keyMed=0;$keyMed<$countorMed;){?>
			<table width="100%" >
			<tr id="NoteDiv_med<?php echo $keyMed?>"><td>
			<?php
			echo $this->Form->hidden('', array( 'class'=>'','id' => 'itemCode_0','name'=>'data[itemC]['.$keyMed.']' , 'label'=> false, 'div' => false,'style'=>'width:60%;', 'error' => false));
			echo $this->Form->input('', array( 'class'=>'medtext textCls','id' => 'med_'.$keyMed,'name'=>'data[med]['.$keyMed.']' , 'label'=> false, 'div' => false,'style'=>'width:148px;', 'error' => false,'value'=>$getExplodeData['0']));
			echo $this->Form->hidden('', array( 'class'=>'','id' => 'drug-id_'.$keyMed,'name'=>'data[drug_id]['.$keyMed.']' ));
			echo " Qty: ".$this->Form->input('', array('id' => 'medqt_'.$keyMed,'name'=> 'data[medqt]['.$keyMed.']', 'label'=> false,'class' => 'medqtCls', 'div' => false,'style'=>'width:48px;', 'error' => false,'value'=>$getExplodeData['1'])); //validate[required,custom[mandatory-select]]
			?>
			  <span name="<?php echo $getUnserializeMedData[0][$keyMed]?>" class="currentRemoveMed" id="currentRemoveMed_<?php echo $keyMed;?>"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span>
			
			</td></tr>
			</table>
			<?php $keyMed++;
			}
			}?>
			
			</td>
			<td valign="top">
				<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addButton_med'));?>
			<!-- <input name="" type="button" id="addButton_med" value="Add More"
						class="blueBtn" style="text-align:right"/> 	 -->
			</td>
		
	</tr>
    <tr>
		<td class="form_lables" align="right">
		<?php echo __('Dressing',true); ?>
		</td>
	
       <td>
        <?php 
        echo $this->Form->textarea('Preferencecard.dressing', array('cols' => '35', 'rows' => '10', 'style'=>'width:95%','id' => 'dressing', 'value'=>$getData['Preferencecard']['dressing'], 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
   
	<td></td>
	</tr>
    <tr>
		<td class="form_lables" align="right">
		<?php echo __('Prep and Position',true); ?>
		</td>
	
        <td>
        <?php 
        echo $this->Form->textarea('Preferencecard.position', array('cols' => '35', 'rows' => '10', 'style'=>'width:95%', 'id' => 'position', 'value'=>$getData['Preferencecard']['position'], 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
   
		<td></td>
	</tr>
    <tr>
		<td class="form_lables" align="right">
		<?php echo __('Notes',true); ?>	</td>
	
        <td>
        <?php 
        echo $this->Form->textarea('Preferencecard.notes', array('cols' => '35', 'rows' => '10', 'style'=>'width:95%', 'id' => 'notes', 'value'=>$getData['Preferencecard']['notes'], 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>

		<td></td>
	</tr>
   	<tr>
		<td colspan="3" align="center">
	        <?php 
	   			//echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
	   			echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
	        ?>
		&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
		</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>

<script>
       $(document).ready(function(){
    	/*   jQuery(document).ready(function(){
   			 
   			jQuery("#labManagerfrm").validationEngine();

   			  
   		});*/
   		/****BOF- When type CSSD item then Value put in quantity***/
		$(document).on('keyup','.spdtext',function(){   	   		
			var currentId=$(this).attr('id');
			splitedVar=currentId.split('_');
			textId=splitedVar[1];
			if($(this).val()!=''){
				$('#spdqt_'+textId).val('1');
			}else{
				$('#spdqt_'+textId).val('');
			}		
		});
   		/****EOF- When type CSSD item then Value put in quantity***/
		
   		/****BOF- When type Lab item then Value put in quantity***/
   		$(document).on('keyup','.ortext',function(){
   			var currentId=$(this).attr('id');
			splitedVar=currentId.split('_');
			textId=splitedVar[1];

			if($(this).val()!=''){
				$('#orqt_'+textId).val('1');
			}else{
				$('#orqt_'+textId).val('');
			}		
			
			});
   		/****EOF- When type Lab item then Value put in quantity***/
   		
   		/****BOF- When type MEdication item then Value put in quantity***/
   			$(document).on('keyup','.medtext',function(){
   				var currentId=$(this).attr('id');
   				splitedVar=currentId.split('_');
   				textId=splitedVar[1];

   				if($(this).val()!=''){
   					$('#medqt_'+textId).val('1');
   				}else{
   					$('#medqt_'+textId).val('');
   				}		
			});
   	/****EOF- When type MEdication item then Value put in quantity***/ 
     		 

		//for instrument add & remove button
	
		 var counter = '<?php echo $key;?>';
				
		   $("#addButton").click(function () {			
	          var newNoteDivIns = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_' + counter).attr("class", 'block_'+counter);
	          var instrument_row = '<td><input class="drugText validate[required,custom[mandatory-select]] " type="text" id="instrument_'+ counter +'" name="data[instrument]['+ counter +']"  style="width:264px">';
	          var img_row = '<span class=currentRemoveIns id=currentRemoveIns_'+counter+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>';
		    	
	        	newNoteDivIns.append(instrument_row+img_row);		 
	        	newNoteDivIns.appendTo("#intrumentid");		
				 			 
	counter++;
	//if(counter >1) $('#removeButton').show('slow');
     });

/*	$("#removeButton").click(function () {
		counter--;			 
    	$("#NoteDiv_" + counter).remove();
 		if(counter == 2) $('#removeButton').hide('slow');
  });*/
	$(document).on('click','.currentRemoveIns', function() {
		if(confirm("Do you really want to delete this record?")){
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		var setToInstrumentId=$('#instrumentId_'+ID).val();		
		$("#NoteDiv_"+ID).remove();	
		if(setToInstrumentId)delete_item('Instruction',setToInstrumentId);
		}else{
			return false;
		}			
	});
  //for SPD add & remove button
		var counter_spd = '<?php echo $keycssd;?>';		 
		  $("#addButton_spd").click(function () {	 				 
	          var newNoteDiv_spd = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_spd' + counter_spd);
	          var spd_row = '<td><input class="spdtext" type="text" id="spd_'+ counter_spd +'" name="data[spd]['+counter_spd+']" >';
	          var qt_row = ' Qty: <input type="text" id="spdqt_'+ counter_spd +'" name="data[spdqt]['+counter_spd+']" class="qtyCls" style="width:48px">';
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
		var counter_or = '<?php echo $keyor;?>';
		 
		   $("#addButton_or").click(function () {	 				 
	          var newNoteDiv_or = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_or' + counter_or);
	          var or_row = '<td><input class="ortext" type="text" id="or_'+ counter_or +'" name="data[or]['+counter_or+']">';
	          var orqt_row = ' Qty: <input type="text" id="orqt_'+ counter_or +'" name="data[orqt]['+counter_or+']" class="validate[required,custom[mandatory-select]] "style="width:48px">';
	          var img_row = '<span class=currentRemoveOr id=currentRemoveOr_'+counter_or+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>';
	    				 			
	newNoteDiv_or.append(or_row + orqt_row+img_row);		 
	newNoteDiv_or.appendTo("#orid");		
				 			 
	counter_or++;
	//if(counter_or > 1) $('#removeButton_or').show('slow');
     });

	/*$("#removeButton_or").click(function () {
		counter_or--;			 
    	$("#NoteDiv_or" + counter_or).remove();
 		if(counter_or == 2) $('#removeButton_or').hide('slow');
  });*/
  $(document).on('click','.currentRemoveOr', function() {
	  if(confirm("Do you really want to delete this record?")){
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];		
		var setToOrId=$('#PreferencecardOritemid_'+ID).val();		
		$("#NoteDiv_or"+ID).remove();		
		if(setToOrId)delete_item('OR',setToOrId);	
		}else{
			return false;
		}			
	});

// for medication add & remove button-
	var counter_med = '<?php echo $keyMed;?>';
	 
	  $("#addButton_med").click(function () {	 				 
        var newNoteDiv_med = $(document.createElement('tr'))
           .attr("id", 'NoteDiv_med' + counter_med);
        var med_row = '<td><input class="medtext" type="text" id="med_'+ counter_med +'" name="data[med]['+counter_med+']"  ><input  type="hidden"  id="drug-id_'+ counter_med +'" name="data[drug_id]['+counter_med+']"   >'; //name="data[spd][]"
        var qt_row = ' Qty: <input type="text" id="medqt_'+ counter_med +'" name="data[medqt]['+counter_med+']"   class=" " style="width:48px">';
        var img_row = '<span class=currentRemoveMed id=currentRemoveMed_'+counter_med+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>'
	newNoteDiv_med.append(med_row + qt_row + img_row);		 
	newNoteDiv_med.appendTo("#medid");		
				 			 
	counter_med++;
	//if(counter_med > 1) $('#removeButton_med').show('slow');
	});
	//for add rmove surgery	
	  var counter_surg = <?php echo $countSurge;?>;
	  $("#addButton_surg").click(function () {				 
	    var newNoteDiv_surge = $(document.createElement('tr')).attr("id", 'newNoteDiv_surge' + counter_surg);
	    var surg_row = '<td><input id="procedure_'+counter_surg+'" class="procedure validate[required,custom[mandatory-select]]" type="text" name="data[procedure]['+counter_surg+']"><input class="procedure" type="hidden" id="procedureid_'+ counter_surg +'" name="data[procedure_id]['+counter_surg+']">'; 
	    var img_row = '<span class=currentRemoveSurge id=currentRemoveSurge_'+counter_surg+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></td>'
	  	newNoteDiv_surge.append(surg_row + img_row);		 
	  	newNoteDiv_surge.appendTo("#prcedureId");		
	  			 			 
	  counter_surg++;
	  });
	  

	$(document).on('click','.currentRemoveMed', function() {
		currentId=$(this).attr('id'); 
	//	name=$(this).attr('name'); 
		
		if(confirm("Do you really want to delete this record?")){
			currentId=$(this).attr('id'); 
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			var setToMedId=$('#preferenceCardId').val();
			var setToMedName=$('#med_'+ID).val();	
		//	var setToMedQty=$('#medqt_'+ID).val();		
			$("#NoteDiv_med"+ID).remove();	
			if(setToMedId)delete_item('MED',setToMedId,ID);	
			}else{
				return false;
			}			
					
	});

	$(document).on('click','.currentRemoveSurge', function() {
		currentId=$(this).attr('id'); 
	//	name=$(this).attr('name'); 
		
		if(confirm("Do you really want to delete this record?")){
			currentId=$(this).attr('id'); 
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			var setToMedId=$('#preferenceCardId').val();
			var setToMedName=$('#procedure_'+ID).val();	
			$("#newNoteDiv_surge"+ID).remove();	
			if(setToMedId)delete_item('Surgery',setToMedId,ID);	
			}else{
				return false;
			}			
					
	});

// remove current row 

	$(".currentRemove").on('click',function () {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#NoteDiv_med"+ID).remove();
		
	 });
	
// end of medication code

  $('.drugText').on('focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") 
           {
		$("#Pack" + counter).val("");
			}
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getdeviceused","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete

$('.spdtext')
	.on(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getspditem","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete



$('.ortext')
	.on(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getoritem","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete


//$('.medtext').on('focus',function() {
//$('.medtext').on('keyup.autocomplete', function(){


	$(document).on('focus','.medtext', function() {
		
		var currentId = $(this).attr("id");
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		
		   if ($(this).val() == "") {
				$("#Pack" + counter).val("");
		   }

		   currentID = $(this).attr('id').split("_")[1];
			 


		 $(this).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PharmacyItem","id&name&drug_id",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {					
				$('#drug-id_'+ID).val(ui.item.id);
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
	
			

		
});//EOF autocomplete

$(document).on('focus','.procedure', function() {
	
	var currentId = $(this).attr("id");
	splitedId=currentId.split('_');
	ID=splitedId['1'];
	currentID = $(this).attr('id').split("_")[1];
		 
	$(this).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","Surgery","id&name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {					
			$('#procedureid_'+ID).val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});

});//EOF autocomplete procedure	
		  
       });//eof ready
       
       $(".Back").click(function(){
    	   $.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "Preferences", "action" => "user_preferencecard", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		 });

     //*********************************************Ajax call to delete Items of all type***************************************
       function delete_item(modelName,preRecordId,IDofRow){ 
       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Preferences", "action" => "deleteItems","admin" => false)); ?>"+"/"+modelName+"/"+preRecordId+"/"+IDofRow;
       $.ajax({	
       	 beforeSend : function() {
       		// this is where we append a loading image
       		$('#busy-indicator').show('fast');
       		},
       		                           
        type: 'POST',
        url: ajaxUrl,
        dataType: 'html',
        success: function(data){
       	  $('#busy-indicator').hide('fast');
         		$("#resultorder").html(" ");  
        },
       	error: function(message){
       		alert("Error in Retrieving data");
        }        
        });
       }
        //**************************************************end of ajax calls****************************************************** 


 </script>
 
