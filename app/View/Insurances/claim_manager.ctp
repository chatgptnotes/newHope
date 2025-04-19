<?php 
echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4','inline_msg','jquery.blockUI'));
?>
<style>
.selectedRow {
	background-color: #24483C; /* #64F3C8*/
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Claim Manager'); ?>
	</h3>
	<span><?php 
		echo $this->Html->link(__('Back'), array('controller'=>'Landings','action' =>'index'), array('escape' => false,'class'=>'blueBtn'));
		?></span>
</div>
<?php echo $this->Form->create('Billing',array('controller'=>'Billings','action'=>'liveClaimsFeed','id'=>'liveClaimsFeed','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<!--  <table style="border: 1px solid rgb(76, 94, 100); margin: 10px;"
	width="100%">
	<tr>
		<td style="padding-left: 35px"><strong><?php echo __('Provider'); ?> </strong>
		</td>
		<td width="23%"><?php echo $this->Form->input('doctor_name', array('class' => 'textBoxExpnd','id' => 'doctor_name')); 
		echo $this->Form->hidden('doctor_id', array('type'=>'text','id'=>'doctor_id'));
		?>
		</td>
		<!-- <td>
			<?php //echo $this->Form->input('suffix1', array('options'=>array(""=>__('Please Select Type'),"CSJ"=>__('C.S.J. Sisters of St. Joseph'),"DC"=>__('D.C. Doctor of Chiropractic'),'class' => 'textBoxExpnd','id' => 'suffix'))); ?>
		</td>
		<td>
			<?php //echo $this->Form->input('suffix1', array('options'=>array(""=>__('Please Select Type'),"CSJ"=>__('C.S.J. Sisters of St. Joseph'),"DC"=>__('D.C. Doctor of Chiropractic'),'class' => 'textBoxExpnd','id' => 'suffix'))); ?>
		</td>
		// to end here of html
		<td><strong><?php echo __('Claim Status'); ?> </strong></td>
		<td width="20%" style="padding-right: 1%;"><?php echo $this->Form->input('claim_status', array('empty' => 'Please Select','options'=>Configure::read('claim_status'),'class'=>'textBoxExpnd ','style'=>"width:250px",'id' => 'suffix')); ?>
		</td>
	</tr>
	<tr>
		<td width="20%" style="padding-left: 35px"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td width="20%"><?php echo $this->Form->input('lookup_name', array('type'=>'text','id'=>'lookup_name','class'=>'textBoxExpnd ')); ?>
		</td>
		<td><strong><?php echo __('Insurance'); ?> </strong></td>
		<td width="20%" style="padding-right: 1%;"><?php echo $this->Form->input('tariff_standard_id', array('tariff_standard_id','options'=>$tariffStandards,'empty'=>'Please Select')); ?>
		</td>
	</tr>
	<tr>
		<td width="20%" style="padding-left: 35px"><strong><?php echo __('From Date'); ?>
		</strong></td>
		<td class="tddate"><?php echo $this->Form->input('from',array('type'=>'text','id'=>"from",'class'=>'textBoxExpnd dateCalender','autocomplete'=>'off','readonly'=>'readonly'));?>
		</td>
		<td width="20%"><strong><?php echo __('To Date'); ?> </strong></td>
		<td class="tddate"><?php echo $this->Form->input('to',array('type'=>'text','id'=>"to",'class'=>'textBoxExpnd dateCalender','autocomplete'=>'off','readonly'=>'readonly'));?>
		</td>

	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td align="right"><?php echo $this->Form->button('Clear',array('class'=>'blueBtn','id'=>'clear'));?>
		</td>
		<td align="left"><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'Submit'));?>
		</td>
	</tr>

</table> -->
<?php echo $this->Form->end(); ?>
<table style="margin: 10px;" width="100%" id="claimTable" align="center"
	cellspacing="0">
	<tr class="row_title">
		<!--<td class="tdLabel"  id="boxSpace"><?php echo __(' ')?></td>-->
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Claim')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Physician')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Patient')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Primary')?></strong></td>
		<!-- <td class="tdLabel"  id="boxSpace"><?php echo __('PRT')?></td> -->
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Secondary')?></strong></td>
		<!-- <td class="tdLabel"  id="boxSpace"><?php echo __('SRT')?></td>-->
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Amount')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('File With')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Submission')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Status')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Hold Notes')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Action')?></strong></td>
		<td class="tdLabel"  id="boxSpace"><strong><?php echo __('Generate EDI')?></strong></td>
	</tr>

	<?php //debug($pairData);//exit;
	$cnt=0; 
	 if(!empty($pairData)){
		foreach($pairData as $data){ 


	?>
	<tr class="">
		<!--<td><?php echo __(' ')?></td>-->
		<td class="tdLabel"  id="boxSpace"><?php if(!empty($data['Encounter']['id'])) echo $data['Encounter']['id'];
		else echo __('N/A');	?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo 	$data['User']['first_name']." ".$data['User']['last_name'];?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo 	$data['Patient']['lookup_name'];?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo 	$data['NewInsurance']['tariff_standard_name'];?></td>
		<!-- <td class="tdLabel"  id="boxSpace"><?php echo __('');?></td>-->
		<td class="tdLabel"  id="boxSpace"><?php echo 	$data['Secondary']['0']['tariff_standard_name']?></td>
		<!-- <td class="tdLabel"  id="boxSpace"><?php echo __('');?></td>-->
		<td class="tdLabel"  id="boxSpace"><?php echo 	$data['Encounter']['payment_amount']?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo 	$data['Encounter']['file_with']?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo __('Submission')?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo __('Status')?></td>
		<td class="tdLabel"  id="boxSpace"><?php echo __('Hold Notes')?></td>
		<?php if(!empty($data['Encounter']['new_insurance_id'])){?>
		<td class="tdLabel"  id="boxSpace"><?php echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png',array('title'=>'edit')),array('controller'=>'Insurances','action'=>'addNewEncounter',$Patients_id,$data['Encounter']['id'],'edit'),array('class'=>'','id'=>'add','escape'=>false));?>
		</td>
		<?php }else{?>
		<td class="tdLabel"  id="boxSpace"><?php echo $this->Html->link($this->Html->image('/img/icons/add-icon.gif',array('title'=>'add')),array('controller'=>'Insurances','action'=>'addNewEncounter',$Patients_id,$data['NewInsurance']['id'],'add'),array('class'=>'','id'=>'add','escape'=>false));?>
		</td>
		<?php }?>
		<?php if(!empty($data['Encounter']['id'])){?>
		<td class="tdLabel"  id="boxSpace"><?php echo $this->Html->link($this->Html->image('/img/icons/xml-icon.png',array('title'=>'Generate')),'javascript:void(0)',
				array('onClick'=>'generateEDI('.$data['NewInsurance']['patient_id'].','.$data['NewInsurance']['tariff_standard_id'].','.$data['Encounter']['id'].','.$data['NewInsurance']['id'].','.$cnt.');',
				'class'=>'edi','id'=>'edi_'.$cnt,'escape'=>false));?><?php if($data['Batch']['file_created']=='1'){?> <span
			id='download_<?php echo $cnt?>'> <?php echo $this->Html->link($this->Html->image("icons/download.png",array('id'=>'show_'.$cnt,'alt'=>'Download EDI','title'=>'Download EDI','width'=>'20','height'=>'18')),
array('action'=>'downloadEdi',$data['Batch']['batch_name']),array('escape'=>false ,'style'=>'display:block;')); }?>
		</span>
		</td>
		<?php //$getBatch['Batch']['batch_name'] 
		}?>
	</tr>
	<?php }$cnt++;
}else{?>
<td colspan=15><?php echo "No Records Found";?>
		</td>

<?php }?>
</table>

<script>
var pager = new Pager('claimTable', 20); 
var selectedRowId = '';
$(document).ready(function(){
	<?php if(!empty($patientData)) { ?>
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
	<?php } ?>
	
	$( '.selectable' ).click(function (){
		selectedRowId = '';
		if($( '.'+$(this).attr('class').split(' ')[0] ).hasClass('selectedRow') === true){
			$( '.'+$(this).attr('class').split(' ')[0] ).removeClass('selectedRow');
		}else{
			$( '.'+$(this).attr('class').split(' ')[0] ).addClass('selectedRow');
			selectedRowId = $(this).attr('class').split(' ')[0] ;
			
		}
		if($( document ).find('.selectable').hasClass('selectedRow') === true){
			$( document ).find('.selectable').removeClass('selectedRow');
			$( '.'+$(this).attr('class').split(' ')[0] ).addClass('selectedRow');
			selectedRowId = $(this).attr('class').split(' ')[0] ;
		}
	});

$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true
});
$("#doctor_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'doctor_name,doctor_id'
});

$(".dateCalender")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange : '-73:+0',
			//maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});
$('#expFile').click(function (){
	var ajaxUrl = '<?php echo $this->Html->url(array("controller" => "Billings", "action" => "liveClaimReport","admin" => false)); ?>';
	 
	   var dataToSend = {'patientData' : <?php echo json_encode($patientData); ?> } ;
	    $.ajax({
         type: 'POST',
         url: ajaxUrl,
         data: dataToSend,        
         error: function(message){
             alert("Internal Error Occured. Unable To Generate Report.");
             return false ;
         },        
         });
});
$('#printSuperBill').click(function(){
	if(selectedRowId == ''){
		alert('Please Select Claim');
		return false;
	}
			$.fancybox({
				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'href' : '<?php echo $this->Html->url(array("controller"=>"Billings","action"=>"printSuperBill"));?>'+"/"+selectedRowId,
	
			});
});

$('.action').click(function (){
	var recordId = $(this).attr('id');
	$('.'+recordId).toggle();
});

$(".status_drops").change(function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	recordId = splittedVar[1];
	value = $(this).val();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "liveClaimsFeed",$patient_id, "admin" => false)); ?>"+"/"+recordId,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){					  
			  //$('#busy-indicator').hide('fast');
			  inlineMsg(currentId,'Updated');
			  ids = currentId.split("_");
			  $('.'+ids[1]).toggle();
			  $('.td_'+ids[1]).html(value);
			  onCompleteRequest();
		  }
	});		 
});

function loading(){
	 $('#claimTable').block({ 
        message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please Wait...</h1>', 
        css: {            
            padding: '5px 0px 5px 18px',
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px',               
            color: '#fff',
            'text-align':'left' 
        },
        overlayCSS: { backgroundColor: '#cccccc' } 
    }); 
}

function onCompleteRequest(){
	$('#claimTable').unblock(); 
}
});
function  generateEDI(pId,tarifStdId,encounterId,insuranceId,clkId){
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "generateClaim","admin" => false)); ?>";
	var currentId='edi_'+clkId;
	var save='saveSingleFile';
    $.ajax({	
	   	 beforeSend : function() {
	   			$('#busy-indicator').show('fast');
	   		},		                           
	     type: 'POST',
	     url: ajaxUrl+"/"+pId+"/"+'1500'+"/"+tarifStdId+"/"+encounterId+"/"+save,
	     dataType: 'html',
	     success: function(data){   
	    	 $('#busy-indicator').hide('fast');
	   	 inlineMsg(currentId,'EDI Generated');
	   	location.href="<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "claimManager")); ?>"
	   	+"/"+pId;
	 // $('#download_'+clkId).show();
	     },
		 error: function(message){
				alert("Error in Retrieving data");
	     }        
     }); 
}
</script>
