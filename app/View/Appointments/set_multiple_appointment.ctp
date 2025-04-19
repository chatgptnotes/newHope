<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Set Appointment For - '.$patientData['Patient']['lookup_name'] .' '.$patientData['Patient']['admission_id'].' ('.$tariffName.' )'  , true); ?>
	</h3>
	<!-- <span><?php 
		//echo $this->Html->link(__('Back'), array('controller'=>'Landings','action' =>'index'), array('escape' => false,'class'=>'blueBtn'));
		?></span> -->
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('multiAppointment',array('id'=>'multiAppointmentForm',
		'inputDefaults' => array('error' => false,'label'=>false,'div'=>false )));?>
<?php echo $this->Form->input('Patient.tariff_standard_id',array('type'=>'hidden','id'=>'tariff','value'=>$patientData['Patient']['tariff_standard_id'],'div'=>false,'label'=>false)); 
echo $this->Form->input('Patient.patient_id',array('type'=>'hidden','id'=>'tariff','value'=>$patientData['Patient']['id'],'div'=>false,'label'=>false));
echo $this->Form->input('Patient.person_id',array('type'=>'hidden','id'=>'tariff','value'=>$patientData['Patient']['person_id'],'div'=>false,'label'=>false));
echo $this->Form->input('Patient.form_received_on',array('type'=>'hidden','id'=>'tariff','value'=>$patientData['Patient']['form_received_on'],'div'=>false,'label'=>false));
echo $this->Form->input('Patient.location_id',array('type'=>'hidden','id'=>'tariff','value'=>$patientData['Patient']['location_id'],'div'=>false,'label'=>false));?>
<?php $countApp=0;?>
<table>
<tr>
<td>
<table id=multiAppTable>
	<tr>
		<td><b>Treating Consultant</b></td>
		<td><b>Speciality</b></td>
		<td><b>Visit Type</b></td>
		<!--<td><b>Visit Charge</b></td>-->
	</tr>
	<?php if (empty($currentAppointment)){
			
	
		?>
	   <tr id=multiRow_0>
		<td><?php echo $this->Form->input('Appointment.doctor_id.', array('empty'=>__('Please Select'),'options'=>$doctorlist,'div'=>false,'label'=>false,
 							'class' => "textBoxExpnd validate[required,custom[mandatory-select]] ",'id' => 'doctor_id_0','class'=>' textBoxExpnd validate[required,custom[mandatory-select]]  doctorApp',
							'value'=>Configure::read('default_doctor_selected') ));?>
		</td>
		<td>
		<?php echo $this->Form->input('Appointment.department_id.', array('empty'=>__('Please Select'),'options'=>$departments,
					'id'=>'department_id_0','div'=>false,'label'=>false,'class' => 'textBoxExpnd department_id', 'disabled'=>'disabled','value'=>''));
		echo $this->Form->input('Appointment.department_id.',array('type'=>'hidden','id'=>'department_id-0','div'=>false,'label'=>false));?>
		</td>
		<td>
			<?php echo $this->Form->input('Appointment.treatment_type.', array('empty'=>__('Please Select'),'options'=>$opdoptions,'label'=>false,
 								'class' => "textBoxExpnd validate[required,custom[mandatory-select]] visitApp",'div'=>false,
								'disabled'=>'disabled','id' => 'opd_id_0' ));?>
		</td>
		<!--<td>
			<font size="3px" color="#F48F5B" style="font-weight: bold;">
				<?php echo $this->Form->input('Appointment.visit_charge.',array('type'=>'hidden','id'=>'visit_input_0','div'=>false,'label'=>false));?>
				<span id="visit_charge_0"></span>
			</font>
		</td>-->
	</tr>
		   
	<?php 
      }else {
foreach ($currentAppointment as $key => $value) {  
      	?>

  
	<tr id=multiRow_<?php echo $key;?>>
				<td><?php echo $this->Form->input('Appointment.doctor_id.', array('empty'=>__('Please Select'),'options'=>$doctorlist,'div'=>false,'label'=>false,
		 							'class' => "textBoxExpnd validate[required,custom[mandatory-select]] ",'id' => 'doctor_id_'.$key,'class'=>' textBoxExpnd validate[required,custom[mandatory-select]]  doctorApp',
									'value'=>$value['Appointment']['doctor_id'] ));?>
				</td>
				<td>
				<?php echo $this->Form->input('Appointment.department_id.', array('empty'=>__('Please Select'),'options'=>$departments,
							'id'=>'department_id_'.$key,'div'=>false,'label'=>false,'class' => 'textBoxExpnd department_id', 'disabled'=>'disabled',
							'value'=>$value['Appointment']['department_id']));
				echo $this->Form->input('Appointment.department_id.',array('type'=>'hidden','id'=>'department_id-'.$key,'div'=>false,'label'=>false,
					'value'=>$value['Appointment']['department_id']));?>
				</td>
				<td>
					<?php echo $this->Form->input('Appointment.treatment_type.', array('empty'=>__('Please Select'),'options'=>$opdoptions,'label'=>false,
		 								'class' => "textBoxExpnd validate[required,custom[mandatory-select]] visitApp",'div'=>false,
										'disabled'=>'disabled','id' => 'opd_id_'.$key,'value'=>$value['Appointment']['visit_type'] ));?>
				</td>
				<td><?php echo $this->Html->image('icons/cross.png',array('id'=>'removeButton_'.$key,'class'=>'removeButton','title'=>'Remove Consultant'));?> 
				</td>
			</tr>
	<?php }}?>
</table>
</td>
</tr>
<!--<tr>
<td><b>Total : <span id="total">0</span></b></td>
						<?php echo $this->Form->hidden('Patient.total',array('id'=>'totAmt'));?>
</tr>
<tr>
	<td>
		<span>
			<?php echo 'Pay Amount From Here'.$this->Form->input('Patient.pay_amt',array('type'=>'checkbox','id'=>'pay_charge','div'=>false,'label'=>false))?>
		</span>
	</td>
</tr>-->
<tr>
<td align="right" style="margin-top: 10px; float: right;"><input class="blueBtn" type="button"
				id="addAppButton" value="Add More Appointments" onclick="addFields()">
</td>
</tr>

<tr>
<td><input class="blueBtn" type="submit"
				id="submit" value="Submit" >
</td>
</tr>
</table>
<?php echo $this->Form->end();?>	
				


<script>
$(document).ready(function(){
	 jQuery("#multiAppointmentForm").validationEngine({
            //validateNonVisibleFields: true,
           updatePromptsPosition:true,
        });
	 var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>";
	 if(print){		 
			$("#formReferral").val('yes') ;
			var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'printAdvanceReceipt',$this->params->query['print'])); ?>";
		    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");
		    parent.$.fancybox.close();
	 }
	<?php if($close){ ?>
	
	
	parent.$.fancybox.close();
	
	
	<?php } ?>  
	  
});
$('#submit').click(function() {
	var validatePerson = jQuery("#multiAppointmentForm").validationEngine('validate');
	if (validatePerson)
	{
		 $(this).css('display', 'none');
		 
	}
});

$(document).on('change','.doctorApp', function(){
	var selectedDoc=$(this).attr('id').split('_')[2];
	var selectedVal='';
		selectedVal=$('#opd_id_'+selectedDoc+' option:selected').val();
		//resetTariff(selectedDoc);
	if($(this).val()){
	    $.ajax({
	      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
	      context: document.body,          
	      success: function(data){
	    	  if(!isNaN(selectedDoc)){ 
		       $('#department_id_'+selectedDoc).val(parseInt(data)); 
		       $('#department_id-'+selectedDoc).val(parseInt(data)); 
		       $('#opd_id_'+selectedDoc).attr('disabled',false);
	    	  }
	      }
	    });
	}else{
		if(!isNaN(selectedDoc)){		      			
			$('#department_id_'+selectedDoc).val(''); 
		    $('#department_id-'+selectedDoc).val(''); 
			$('#opd_id_'+selectedDoc).val('');
			$('#visitCharge_'+selectedDoc).text('');
			$('#visit_charge_'+selectedDoc).hide();
			$('#opd_id_'+selectedDoc).attr('disabled',true);
		}
	}
   });

  <?php  if (empty($currentAppointment)){ ?>
		var counterApp='<?php echo $countApp+1;?>';
   <?php }else{ ?>
    	var counterApp='<?php echo $key+1;?>';
   <?php  } ?>
	
	function addFields(){
		var appendOption= "<option value=''>Please Select</option>";
		$("#multiAppTable")
		.append($('<tr>').attr({'id':'multiRow_'+counterApp})
			.append($('<td>').append($('<select>').attr({'id':'doctor_id_'+counterApp,'class':'textBoxExpnd validate[required,custom[mandatory-select]] doctorApp','type':'select','name':'Appointment[doctor_id][]','div':false,'label':false,'error':false}).append(appendOption)))
			.append($('<td>').append($('<select>').attr({'id':'department_id_'+counterApp,'disabled':'disabled','class':'textBoxExpnd department_id','type':'select','name':'Appointment[department_id][]','div':false,'label':false,'error':false}).append(appendOption)))
			.append($('<input>').attr({'type':'hidden','id':'department_id-'+counterApp,'class':'textBoxExpnd validate[required,custom[mandatory-enter]]','name':'Appointment[department_id][]'}))
			.append($('<td>').append($('<select>').attr({'id':'opd_id_'+counterApp,'disabled':'disabled','class':'textBoxExpnd validate[required,custom[mandatory-select]] visitApp','type':'select','name':'Appointment[treatment_type][]','div':false,'label':false,'error':false}).append(appendOption)))
			//.append($('<input>').attr({'type':'hidden','id':'opd_val_'+counterApp,'name':'Appointment[treatment_type][]'}))
			/*.append($('<td>').append($('<font>').attr({'size':"3px" , 'color':"#F48F5B" , 'style':"font-weight: bold;"}).append($('<span>').attr({'id':'visit_charge_'+counterApp})).append($('<input>').attr({'type':'hidden','id':'visit_input_'+counterApp,'name':'Appointment[visit_charge][]'}))))*/
			.append($('</span></font></td>'))
			.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
					.attr({'class':'removeButton','id':'removeButton_'+counterApp,'title':'Remove current row'}).css('float','right')))
			.append($('</tr>'))
			);
		
		var doctorList = <?php echo json_encode($doctorlist);?>;
		$.each(doctorList, function(val, text) {
		    $('#doctor_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
		});
	
		var departmentList=<?php echo json_encode($departments);?>;
		$.each(departmentList, function(val, text) {
		    $('#department_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
		});
	
		var visitList=<?php echo json_encode($opdoptions);?>;
		$.each(visitList, function(val, text) {
		    $('#opd_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
		});  
		counterApp++;
	}

	$(document).on('change','#opd_id ,.visitApp',function(){
		var selectedDoc=$(this).attr('id').split('_')[2];
		var selectedVal='';var visitType='';var doctor_id='';			
		if(!isNaN(selectedDoc)){
			selectedVal=$('#opd_id_'+selectedDoc+' option:selected').val();
		}
		if(!isNaN(selectedDoc)){
			$('#visit_charge_'+selectedDoc).hide();
			$('#visit_input_'+selectedDoc).hide();
			
		}
		if(!isNaN(selectedDoc)){
			visitType=$('#opd_id_'+selectedDoc).val();
			doctor_id=$('#doctor_id_'+selectedDoc).val();
		}
		var tarifId=$('#tariff').val();
		var privateTarif="<?php echo $privateID?>";
		if(tarifId!=privateTarif)
			$('#pay_charge').attr('checked',false);
		<?php if($this->Session->read('website.instance')=='vadodara' ){?>
		$('#submit').hide();
		if(selectedVal){
		$.ajax({
        	url: "<?php echo $this->Html->url(array("controller" => 'Persons', "action" => "getTariffAmount")); ?>"+"/"+visitType+"/"+doctor_id+"/"+tarifId,
        	context: document.body,	        	
			success: function(data){
				if(data !== undefined && data !== null){
					data1 = jQuery.parseJSON(data);
					if(data1.charges!=false){
						if( typeof(data1.charges.TariffCharge)!='undefined' && data1.charges!=false ){
							if(typeof(data1.charges['TariffCharge']['id'])!='undefined'){
								if(data1.charges['TariffCharge']['nabh_charges']){
									if(!isNaN(selectedDoc)){
										$('#visit_charge_'+selectedDoc).show();
										$('#visit_input_'+selectedDoc).show();
										$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffCharge']['nabh_charges']);
										$('#visit_input_'+selectedDoc).val(data1.charges['TariffCharge']['nabh_charges']);
										calTotal();
									}
									
								}else if(data1.charges['TariffCharge']['non_nabh_charges']){
									if(!isNaN(selectedDoc)){
										$('#visit_charge_'+selectedDoc).show();
										$('#visit_input_'+selectedDoc).show();
										$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffCharge']['non_nabh_charges']);
										$('#visit_input_'+selectedDoc).val(data1.charges['TariffCharge']['non_nabh_charges']);
										calTotal();
									}
								}
								$('#location_id').val(data1.charges['User']['location_id']);
							}						
						}else if( typeof(data1.charges.TariffAmount)!='undefined' && data1.charges!=false ){
								if(data1.charges['TariffAmount']['id']){
								if(data1.charges['TariffAmount']['nabh_charges']){
									if(!isNaN(selectedDoc)){
										$('#visit_charge_'+selectedDoc).show();
										$('#visit_input_'+selectedDoc).show();
										$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffAmount']['nabh_charges']);
										$('#visit_input_'+selectedDoc).val(data1.charges['TariffAmount']['nabh_charges']);
										calTotal();
									}
								}else if(data1.charges['TariffAmount']['non_nabh_charges']){
									if(!isNaN(selectedDoc)){
										$('#visit_charge_'+selectedDoc).show();
										$('#visit_input_'+selectedDoc).show();
										$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffAmount']['non_nabh_charges']);
										$('#visit_input_'+selectedDoc).val(data1.charges['TariffAmount']['non_nabh_charges']);
										calTotal();
									}
								}
							}
						}
					}else{
						$('#pay_charge').attr('checked',false);
					 }
					
				 }
				$('#submit').show();
			} 
        });
		}
        <?php }?>
		
	});	
	$(document).on('click','.removeButton', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#multiRow_"+ID).remove();	
		counterApp--;
		calTotal();
	});
	
	function calTotal(){
		var total=0;
			for(var i=0;i<=counterApp;i++){				
					amt=parseInt($('#visit_input_'+i).val());
					if(isNaN(amt))
						amt=0;
					total=parseInt(total)+parseInt(amt);
				
			}

			$('#total').text(total);
			$('#totAmt').val(total);
		}

			</script>