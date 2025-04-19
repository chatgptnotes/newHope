<style>

.message{
	
	font-size: 15px;
}
.table_format {
    padding: 3px !important;
}
.rowClass td{
	 background: none repeat scroll 0 0 #ffcccc!important;
}

#patient-info-box{
 	display: none;
    position: absolute;
    right: 0;
    left:992px;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 400px;
    font-size:13px;
    list-style-type: none;
    
}
 .row_format th{
 	 background: #d2ebf2 none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 3px;
    text-align: center;
 }
 .row_format td{
 	padding: 1px;
 }
  
.row_format tr:nth-child(even) {background: #CCC}
.row_format tr:nth-child(odd) {background: #e7e7e7} 
.OrderListbg{height: 20px;padding: 2px;cursor: pointer;}
.LeftService{padding-top: 10px;}
.LeftService ul{overflow-y: auto; max-height: 300px;}
.LeftService ul li {background-color:  #64a194;border-bottom: 1px solid #fff;}
.imgRight {float:right;}
</style> 

<div class="Row inner_title" style="float: left; width: 100%; clear:both">
		<div style="font-size: 20px; font-family: verdana; color: darkolivegreen;" >			 
			<?php echo $getBasicData['Patient']['lookup_name']." - ".$getBasicData['Patient']['admission_id'] ;?>
		</div>
	<span>
		<?php 
    	if($savedData['OpdInvoice']['id']){
    		echo $this->Html->link(__('Print Invoice'),
			'#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Appointments','action'=>'printOpdInvoice',$getBasicData['Patient']['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));

    		echo $this->Html->link(__('Invoice Document', true),array('controller' => 'Appointments', 'action' => 'opdInvoiceDoc',$getBasicData['Patient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
    	}
  	 ?>
	<?php echo $this->Html->link(__('Back', true),array('controller' => 'Appointments', 'action' => 'appointments_management'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
	</span>
</div>


<p class="ht5"></p> 

<?php
echo $this->Form->create('OpdInvoice',array('type' => 'post','id'=>'opdInv','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('id',array('id'=>'opdId','value'=>$savedData['OpdInvoice']['id'],'autocomplete'=>"off"));
echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$getBasicData['Patient']['id'],'autocomplete'=>"off"));
$mahPoliceInvestigation = Configure::read('mah_police_investigation');
?>
 <table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%" align="center" style="width: 60%;">
	
	
	<tr>
		<td align="right" width="20%"><?php echo __('DATE'); ?><font color="red">*</font> </td>
		<td width="2%">:</td> 
		<td width="38%">
			<?php $date =  $this->DateFormat->formatDate2Local($savedData['OpdInvoice']['date'],Configure::read('date_format')) ?>
			<?php echo $this->Form->input('OpdInvoice.date', array('type'=>'text','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'date', 'label'=> false, 'div' => false,
			 'error' => false,'autocomplete'=>'off','value'=>$date));?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('NAME OF PATIENT'); ?></td>
		<td>:</td> 
		<td><?php echo  $getBasicData['Patient']['lookup_name'] ;  ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('AGE/SEX'); ?></td>
		<td >:</td> 
		<td><?php echo  $age."/".ucfirst($getBasicData['Patient']['sex']) ;  ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('MRN NUMBER'); ?></td>
		<td>:</td> 
		<td><?php echo  $getBasicData['Patient']['admission_id'] ;  ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('BUCKLE ID'); ?></td>
		<td>:</td> 
		<td><?php $buckleId = ($savedData['OpdInvoice']['executive_emp_id_no']) ? $savedData['OpdInvoice']['executive_emp_id_no'] : $getBasicData['Patient']['executive_emp_id_no'] ;
				echo $this->Form->input('OpdInvoice.executive_emp_id_no', array('type'=>'text','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','value'=>$buckleId));
		  ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('NAME OF POLICE STATION'); ?></td>
		<td>:</td> 
		<td><?php $nameOfpoliceStation = ($savedData['OpdInvoice']['name_police_station']) ? $savedData['OpdInvoice']['name_police_station'] : $getBasicData['Patient']['name_police_station'] ;
				echo $this->Form->input('OpdInvoice.name_police_station', array('type'=>'text','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','value'=>$nameOfpoliceStation));
		  ?>
		</td>
	</tr>
	
	<tr>
		<td align="right"><?php echo __('DESCRIPTION OF SERVICES'); ?></td>
		<td>:</td> 
		<td><?php 
		$serDesc = ($savedData['OpdInvoice']['service_description']) ? $savedData['OpdInvoice']['service_description'] : 'Comprehensive Police Medical Check-up Package' ;
		echo $this->Form->input('OpdInvoice.service_description', array('type'=>'text','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','value'=>$serDesc));?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><strong> TESTS INCLUDED</strong></td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%">
				<?php 
				$i=1;
				foreach ($mahPoliceInvestigation as $key => $value) { ?>
				<tr>
					<td><?php echo $i ?></td>
					<td >
						<?php echo $this->Form->input('',array('name'=>'data[OpdInvoiceDetail][tests][]','type'=>'text','class'=>'textBoxExpnd','id'=>'','autocomplete'=>"off",'label'=>false,'value'=>$value)); ?>
					</td>
				</tr>
				<?php $i++ ; } ?>
			</table>
			
		</td>
	</tr>
	<!-- <tr>
		<td align="right"><?php echo __('TESTS INCLUDED'); ?></td>
		<td>:</td> 
		<td>
			<?php echo $this->Form->input('OpdInvoice.test_included',array('type'=>'text','class'=>'service textBoxExpnd','id'=>'search-by-service','autocomplete'=>"off",'label'=>false,'placeHolder'=>'Type To Search')); ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<div class="LeftService">
			    <ul id="AddExtraServices" class="" width="30%" style="list-style:decimal;" > 
			    	<?php foreach ($savedData['OpdInvoiceDetail'] as $key => $value) { ?>
			    		<li id = "ServiceList_<?php echo $value['service_id'] ?>" class="OrderListbg">
			    			<span style="width:90%">
			    			<input class="isDuplicate" serviceType="<?php echo $value['service_type'] ?>" type="hidden" name="data[OpdInvoiceDetail][<?php echo $value['service_type'] ?>][]" value="<?php echo $value['service_id'] ?>">

			    			<?php if($value['service_type'] == 'lab'){
			    				echo $value['laboratories']['name']; 
			    			}else if($value['service_type'] == 'rad'){
			    				echo $value['radiologies']['name']; 
			    			}else{
			    				echo $value['tariff_lists']['name']; 
			    			}
			    			?>
			    		</span>
			    		<span style="width:10%">
			    			<a href="javascript:void(0);" class="imgRight" id="delete" onclick="RemoveServiceRow('<?php echo $value['service_id'] ?>');"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" style="float:none;" /></a>
			    		</span>
			    		</li>
			    	<?php } ?>
			    </ul>
		  	</div>
			
		</td>
	</tr> -->


	<tr>
		<td align="right"><?php echo __('TOTAL AMOUNT'); ?></td>
		<td>:</td> 
		<td>
			<?php 
			$totalAMount = ($savedData['OpdInvoice']['total_amount']) ? $savedData['OpdInvoice']['total_amount'] : '3500' ;
			echo $this->Form->input('OpdInvoice.total_amount',array('type'=>'text','class'=>' textBoxExpnd','id'=>'','autocomplete'=>"off",'label'=>false,'value'=>$totalAMount)); ?>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td></td>
		<td><?php	
				echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'saveBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>



<script>
$(document).ready(function(){

	// binds form submission and fields to the validation engine
	$(document).on('click',"#saveBtn",function(){
		var validateForm = $("#opdInv").validationEngine('validate');

		if (validateForm == true)
		{
			$("#saveBtn").hide();
		}else{

			$("#saveBtn").show();
			return false;
		}

	});
	
 	$("#date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate('');?>',
        
	});

	$(document).on('focus', '#search-by-service', function() { 

		$(this).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "combineServices", "admin" => false, "plugin" => false)); ?>",
				minLength: 1,
				placeHolder:false,
				select: function( event, ui ) {                        
					var ServiceId=ui.item.id;                   
					var ServiceName=ui.item.value;  

					if(ui.item.table == 'radiology'){
						var serviceType = 'rad';
					}else if(ui.item.table == 'tariff_list'){
						var serviceType = 'other';
					}else{
						var serviceType = ui.item.table;
					} 

					 var isDuplicate=0; 
	                    $('.isDuplicate').each(function() { 
		                      if($(this).val()== ServiceId ){
		                        isDuplicate++;
		                      }
		                                                   
		               	});

		             	if(isDuplicate>0){

			              alert('Service Already Selected ! Please Select Another Service');
			              $('#search-by-service').val('')
			              return false;
			            }
					
					
				 

					crossImg= '<a href="javascript:void(0);" class="imgRight" id="delete" onclick="RemoveServiceRow('+ServiceId+');"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" style="float:none;" /></a>';
					inputVar  = '<input class="isDuplicate" serviceType="'+serviceType+'" type="hidden" name="data[OpdInvoiceDetail]['+serviceType+'][]" value='+ServiceId+'><input class="" type="hidden" id=serviceAmnt_'+ServiceId+'>';// to maintain hidden values 
				 
					li = $('<li id = ServiceList_'+ServiceId+' class="OrderListbg"><span style="width:90%">'+ ServiceName + inputVar +'</span><span width="10%">' + crossImg+'</span></li>'); 
					li.prependTo('#AddExtraServices');
					this.value = "";
					return false ;  
			},messages: {
				noResults: '',
				results: function() {}
			}
		});
 	});



	
});

function RemoveServiceRow(rowId){ 
		
		$("#ServiceList_"+rowId).remove(); 
	}



</script>