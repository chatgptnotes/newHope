<?php echo $this->Html->script(array('jquery.tooltipster.min.js','inline_msg','jquery.blockUI' ));
  echo $this->Html->css(array('tooltipster.css'));
?>

<style>
.text {
	text-align: center !important;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
<?php $optionValue = array("Demographic Details"=>"Demographic Details","Academic Qualification"=>"Academic Qualification","Medical Check-up"=>"Medical Check-up","Pre-Employment Health Check-up"=>"Pre-Employment Health Check-up",
		"Vaccination"=>"Vaccination","ID Proof"=>"ID Proof","Training Records"=>"Training Records","Antecedent Form"=>"Antecedent Form",
		"Performance Appraisal"=>"Performance Appraisal","Experiences Certificate"=>"Experiences Certificate","JD"=>"JD","Hospital Privileging"=>"Hospital Privileging");?>
	<tr>
		<th style="padding-left: 10px;" colspan="5"><?php echo __('Documentation');?>
		</th>
	</tr>
	<tr class="showDoctor" style="display:none;">
		<td width="20%" class="tdLabel">Specilization</td>
		<td width="18%" class="tdLabel" id="specialtyText"></td>
		<td width="17%" class="tdLabel">&nbsp;</td>
	</tr>
	<tr class="showDoctor" style="display:none;">
		<td colspan="1" class="tdLabel"><?php echo __('MCI Registration No.');?></td>
		<td class="tdLabel"><?php echo $this->Form->input('HrDetail.registration_no',array('type'=>'text','class'=>'textBoxExpnd','div' => false, 'error' => false));?>

		</td>
		<td class="tdLabel">Scanned Copy Uploaded</td>
		<td class="tdLabel"><?php 
		echo $this->Form->checkbox('HrDetail.is_scan_uplode ', array('type'=>'checkBox','label'=>false,'class' => 'is_scan_uplode')); ?>
		</td>
	</tr>
	<tr class="showNurse" style="display:none;">
		<td width="20%" class="tdLabel"><?php echo __('Nursing council Registration No.',true);?></td>
		
		<td width="20%" class="tdLabel" ><?php echo $this->Form->input('HrDetail.registration_no',array('type'=>'text','class'=>'textBoxEpnd'));?>
		</td>
		<td width="20%" class="tdLabel"><?php echo __('Scanned Copy Uploaded',true).$this->Form->checkbox('HrDetail.is_scan_uplode ', array('type'=>'checkBox','legend'=>false,'label'=>false,'class' => 'is_scan_uplode')); ?>
		</td>
	
	</tr>
	<tr>
		<td  class="tdLabel"><?php echo __('Total years of experience at the time of joining:',true); ?>
		</td>

		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.total_experience', array('type'=>'text','class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
		<td width="10%" class="tdLabel">&nbsp;</td>
	</tr>
<tr>
		<td colspan="4">
			<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="formFull" id="qualificationMain">	
		<tr>
				<tr>
					<th class="text"><?php echo __('Sr.No');?>
					</th>
					<th ><?php echo __('Documents');?>
					</th>
					<th><?php echo __('Scan Document');?>
					</th>
					<th><?php echo __('Certificate Available');?>
					</th>
					<th><?php echo __('Action');?>
					</th>
				</tr>
				<?php if($hrData){?>
                                <?php $key = 0; ?>
				<?php  foreach($hrData as $value){ //debug($value);?> 
				<tr id="removeHrRow-<?php echo $key; ?>">
					<td class="text"><?php echo $srNoHr = $key+1;?>
					</td>
					<td><?php echo $this->Form->input("HrDocument.qualification_detail.$key.document_type",array('id'=>"document_type-$key",'value'=>$value['HrDocument']['document_type'],'class'=>'textBoxExpnd','options' => $optionValue,'empty'=>'Select', 'disabled' => 'disabled'));?>
					</td>
					<?php  if(!empty($value['HrDocument']['file_name'])){
						$created = $this->DateFormat->formatDate2Local($value['HrDocument']['create_time'],Configure::read('date_format'),true);
					$data = '<b>'.$createdBy['User']['full_name'].'</b>';
					//$data[] = $created;
                        }	?>
					<td class="tooltip" style="cursor: pointer;" title="<?php echo 'Upload On-'.$created.'</br>'.' Uploaded By-'.$data; ?>"><?php if(!empty($value['HrDocument']['file_name'])){ 
					 $fileName = $value['HrDocument']['file_name'];
						echo $this->Html->link($fileName,'/uploads/Documents/'.$fileName,array('escape' => false,'target'=>'__blank','style'=>'text-decoration:underline;'));
					}  	  			       
					?>
					<?php echo $this->Form->input("HrDocument.qualification_detail.$key.file_name",array('type'=>'file','id'=>"HrDetail.file_name-$key",'class' => 'docName textBoxExpnd','autocomplete'=> 'off', 'disabled' => 'disabled','label'=>false,'div'=>false,'style'=>'width:240px;'));?>
					</td>
					<td><?php echo $this->Form->input("HrDocument.qualification_detail.$key.Certificate_details",array('type'=>'textarea', 'rows'=>"2" ,'cols'=>"5",'id'=>"certificates-$key",'value'=>$value['HrDocument']['Certificate_details'], 'disabled' => 'disabled'));?>
					</td>
					<?php if($key == 0) {?>
					<td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addMore','style'=>'float:none;'));?>
					</td>
					<?php } else{ ?>
                                        <td class="text"><?php //echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	   			 					//'alt'=> __('Remove', true),'class'=>'removeRow','style'=>'float:none;','id'=>$key));?>
				    </td> <?php }?>
				</tr>
				<?php $key++; }?>
				<?php }else{?>
				<?php $key = 0;?>
				<tr>
					<td class="text"><?php echo $srNoHr = $key+1;?>
					</td>
					<td><?php echo $this->Form->input("HrDocument.qualification_detail.$key.document_type",array('id'=>"document_type-$key",'value'=>$value['document_type'],'class'=>'textBoxExpnd','options' => $optionValue ,'empty'=>'Select'));?>
					</td>
					<td><?php echo $this->Form->input("HrDocument.qualification_detail.$key.file_name",array('type'=>'file','id'=>"file_name-$key",'class' => 'docName textBoxExpnd','autocomplete'=> 'off','label'=>false,'div'=>false,'style'=>'width:240px;'));?>
					</td>
					<td><?php echo $this->Form->input("HrDocument.qualification_detail.$key.Certificate_details",array('type'=>'textarea', 'rows'=>"2" ,'cols'=>"5",'id'=>"certificates-$key",'value'=>$value['certificates']));?>
					</td>
					
					<td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addMore','style'=>'float:none;'));?>
					</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>

</table>

<script> //console.log('<?php echo json_encode($optionValue);?>');
var srNoHr = isNaN(parseInt('<?php echo $srNoHr;?>')) ? 1 : parseInt('<?php echo $srNoHr;?>');
var optionValue = jQuery.parseJSON('<?php echo json_encode($optionValue);?>');

var HrDetail = '<?php echo json_encode(hrData);?>';


$(function(){
	$('#addMore').click(function () {
		$('#qualificationMain tbody:last')
			.append($('<tr>').attr('id','removeHrRow-'+srNoHr)
				.append($('<td>').text(srNoHr+1).attr('class','text'))
			 		.append($('<td>')
			 			.append($('<select>').attr({'name':'data[HrDocument][qualification_detail]['+srNoHr+'][document_type]','class':'textBoxExpnd','id' : 'document_type-'+srNoHr})
			 					.append(new Option("Select", ""))))
		 		 	 .append($('<td>')
                             .append($('<input>').attr({'name':'data[HrDocument][qualification_detail]['+srNoHr+'][file_name]','type':'file','class' :'textBoxExpnd','autocomplete': 'off', 'id' : 'file_name-'+srNoHr,'style':'width:240px;'})))
                    	.append($('<td>')
		 		 			.append($('<textarea>').attr({'name':'data[HrDocument][qualification_detail]['+srNoHr+'][Certificate_details]','type':'textarea','rows':'2' ,'cols':'5', 'id' : 'certificates-'+srNoHr})))
			 		.append($('<td class="text">').attr('id','Td-'+srNoHr).append($('<span>').attr({'class':'removeRow','id' : srNoHr})
		 		 		 	.append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	   			 					'alt'=> __('Remove', true),'class'=>'removeRowa','style'=>'float:none;'));?>')))
		 );

			$.each( optionValue, function( key, value ) {
				$('#document_type-'+srNoHr).append( new Option(value , key));
				}); 
			$('#year_of_passing-'+srNoHr).datepicker({
    			showOn : "both",
    			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
    			buttonImageOnly : true,
    			changeMonth : true,
    			changeYear : true,
    			yearRange: '-100:' + new Date().getFullYear(),
    			maxDate : new Date(),
    			dateFormat:'<?php echo $this->General->GeneralDate();?>',
    			onSelect : function() {
    			
    			}						
    		});
    		
			srNoHr++;
		$('.removeRow').on('click' , function (){
			$("#removeHrRow-" + $(this).attr('id')).remove();
		});	
	});
        $('.removeRow').on('click' , function (){
		$("#removeHrRow-" + $(this).attr('id')).remove();
	});

    	<?php ?>
		$('.passing_year').datepicker({
			showOn : "both",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
			
			}						
		});	
		$('.tooltip').tooltipster({
            interactive:true,
            position:"right",
        });
});

</script>
