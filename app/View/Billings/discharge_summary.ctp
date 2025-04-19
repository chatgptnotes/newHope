<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery.fancybox-1.3.4')); ?>
<style>
	body{padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
	.heading{font-weight:bold; padding-bottom:10px; font-size:14px; }
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:14px;   font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px 7px;}
	select{border:1px solid #999999; padding:4px 7px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.title ul{
		color: #000000;
		font-size: 13px;
		font-weight: normal;
		padding-bottom: 10px;
		text-decoration: none;
	}
	#add-medicine{
		padding: 0px;
		float:left;
		text-decoration:none;
		float:none;
	}
	
	#add-medicine:hover{
		color: #3B77A9;
		text-decoration:underline;
		}
		
		.title a {
    color: #000 !important;
}
        .tdLabel {
        color: black;
        }



        
.row_format a {
    color: #000 !important;
    font-size: 13px !important;
    }
.tempSearch {
  
    color: #fff;
   
}


/* textaere  css  */

	 #present-cond_desc {
    width: 98%;
    min-height: 150px;
    border: 1px solid #999;
    padding: 5px 7px;
    background-color: #fff; /* Ensures background remains white */
    outline: none; /* Removes default focus border */
    resize: none; /* Prevents resizing if needed */
    overflow: auto; /* Enables scroll if content overflows */
}		
	
</style>
	<?php
			echo $this->Html->script(array('jquery.autocomplete'));
  			echo $this->Html->css('jquery.autocomplete.css');
			echo $this->Form->create('DischargeSummary',array(''=>array('controller'=>'billings','action'=>'discharge_summary',$patient_id),'id'=>'patientnotesfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
		 	echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
		 	echo $this->Form->hidden('diagnosis_id',array('value'=>$diagnosis['id']));
		 	echo $this->Form->hidden('id');
	?>
 <?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="error">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php }  ?>	

<div class="inner_title">
<h3>&nbsp; <?php echo __('Discharge Summary', true); ?></h3>
<span>
	
<?php   if($patient['Patient']['is_discharge'] =='1') {
				echo $this->Html->link(__('Print Summary'),
			'#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'dischargeSummaryPrintNew',$patient_id,'?'=>array('is_print_investigation'=>$diagnosis['is_print_investigation'])))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
		   }?>
    <?php 
    

	      echo $this->Html->link(__('Print Preview'),'#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'discharge_summary_print',$patient_id,'?'=>array('is_print_investigation'=>$diagnosis['is_print_investigation'])))."', '_blank',
					           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
			
    ?>

</span>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#fff;padding:10px;">
 
  	<tr>
  	    
	  	<td>
       	  <?php //echo $this->element('print_patient_header'); ?> 
       	  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
          <tr>
            <td width="107"><strong>Name:</strong></td>
            <td width="327" align="left"><?php  if(empty($patient[0]['lookup_name'])) echo $patient['Initial']['name'].' '.$patient['Patient']['lookup_name']; else echo $patient[0]['lookup_name'];?></td>
            <td width="70" align="left"><strong>Reg ID:</strong></td>
            <td width="267"><?php echo $patient['Patient']['admission_id'];?></td>
            </tr>
          <tr>
            <td valign="top"><strong>Address:</strong></td>
            <td><?php echo $address;?></td>
            <td align="left" valign="top"><strong>Age/Sex:</strong></td>
            <td align="left" valign="top"><?php echo $patient['Patient']['age']." Yrs / ".ucfirst($patient['Patient']['sex']);?></td>
            </tr>
          <tr>
            <td valign="top"><strong>Treating Consultant:</strong></td>
            <td><?php /*if(empty($treatingConsultantData['Initial']['initial_name'])){
            	$getInitial='Dr.';
            }else{
				$getInitial=$treatingConsultantData['Initial']['initial_name'];
				}*/
            echo $treatingConsultantData['Initial']['initial_name'].$treatingConsultantData[0]['fullname'] ;?></td>
            <td align="left" valign="top"><strong>DOA:</strong></td>
            <td align="left" valign="top"><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
          </tr>
            <?php 
  		  	  $otherConsultant = unserialize($patient['Patient']['other_consultant']);
  		  	?>
          <tr>
            <td  valign="top"><strong>Other Consultants:</strong></td>
            <td width="200px"><?php 
         
            foreach($doctors as $keyArr=>$getDoc){
				if($keyArr == $patient['Patient']['doctor_id']){
					unset($doctors[$keyArr]);
				}
			}
			$doctors=array_filter($doctors);
			echo  $this->Form->input('doctor_id',array('options'=>$doctors, 'multiple'=>true,'selected'=>$otherConsultant,'id' => 'doctor_id')); 
            
           ?>
            
            </td>
            <td align="left" valign="top"><strong>Date Of Discharge:</strong></td>
            <td align="left" valign="top"><?php if(!empty($patient['FinalBilling']['discharge_date']) && $patient['FinalBilling']['discharge_date']!="0000-00-00 00:00:00"){
            	$getDODDate=$patient['FinalBilling']['discharge_date'];           
            }else if(!empty($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date']!="0000-00-00 00:00:00"){
				//else part by swapnil - 18.02.2016 if discharge_date is not present in finalbilling, retrieve date from patient
				$getDODDate=$patient['Patient']['discharge_date'];
			}else{
				$getDODDate=date('Y-m-d H:i:s'); 
			}
			
            echo $this->DateFormat->formatDate2Local($getDODDate,Configure::read('date_format'),true); ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>Reason Of Discharge:</strong></td>
            <td><?php 	$reason =isset($this->data['DischargeSummary']['reason_of_discharge'])?$this->data['DischargeSummary']['reason_of_discharge']:$patient['FinalBilling']['reason_of_discharge'];
							echo $this->Form->input('DischargeSummary.reason_of_discharge', array('value'=>$reason,'div' => false,'label' => false,'empty'=>__('Please select'),'style'=>'width:228px;',
   											 'options'=>array('Recovered'=>'Recovered','DischargeOnRequest'=>'Discharge On Request','DAMA'=>'DAMA','Death'=>'Death'),'id' => 'mode_of_discharge'));
  		 /*    if($patient['FinalBilling']['reason_of_discharge'] == "Recovered") {
  		       //echo __('Regular Discharge');
  		     } 
  		     if($patient['FinalBilling']['reason_of_discharge'] == "DischargeOnRequest") {
  		       echo __('Discharge On Request');
  		     }
  		     if($patient['FinalBilling']['reason_of_discharge'] == "DAMA") {
  		       echo __('Discharge Against Medical Advice');
  		     }
  		     if($patient['FinalBilling']['reason_of_discharge'] == "Death") {
  		       echo __('Death');
  		     }*/
  		  ?>
                 
            </td>
            <td align="left" valign="top"><strong>Corporate Type:</strong></td>
            <td align="left" valign="top"><?php echo $patient['TariffStandard']['name']; ?></td>
          </tr>
</table>
<div>&nbsp;</div>
       	  
        </td>
  	</tr>  
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title">Diagnosis</td>
  </tr> 
          <!--BOF diagnosis template template -->   
			<tr>     
				<td width="100%" align="left" valign="top" >
					<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
						<tr>
							<td width="27%" align="left" valign="top">
									<div align="center" id = 'temp-busy-indicator' style="display:none;">	
										&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
									</div>	
									<div id="templateArea-diagnosis">
										 <?php echo $this->requestAction('doctor_templates/add/diagnosis'); ?>			
										 		 
									</div>
										<?php //echo $this->element('chatgpt',array('templateType'=>'diagnosis')); ?>
							</td>	    	    		
							<td width="70%" align="left" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
									  <tr>
										<td width="20">&nbsp;</td>	
										<td valign="top" colspan="4">
												<?php 
													$finalDiagnosis = ($this->data['DischargeSummary']['final_diagnosis'])?$this->data['DischargeSummary']['final_diagnosis']:$diagnosis['final_diagnosis'];
													echo $this->Form->textarea('final_diagnosis', array('id' => 'final_diagnosis','value'=>$finalDiagnosis,'rows'=>'20','style'=>'width:98%')); 
													echo $this->Js->writeBuffer();
												?>
										</td>			                    
									 </tr>
								  </table>
							  </td>
						</tr>
					</table>
				</td>
			</tr>
		<!--EOF  diagnosis template -->  
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title">Treatment on Discharge:</td>
  </tr>
 <!--BOF medicine  -->
 
		 		<tr>		 		   
		       	  <td width="100%" valign="top" align="left" style="padding:8px;" colspan="4"><!--
		              <table width="100%" border="0" cellspacing="0" cellpadding="0">		                
		                 row 1                 
		               <tr>
		               	<td width="100%" valign="top" align="left" colspan="6">
		               		<table width="100%" border="0" cellspacing="0" cellpadding="0" id='DrugGroup'>
								<tr>
								  <td width="20%" height="20" align="left" valign="top">Name of Medication</td>
								  <td width="20%" height="20" align="left" valign="top">Unit</td>									  
								  <td width="20%" align="left" valign="top">Route</td>								  
								  <td width="20%" align="left" valign="top">Dose</td>
								  <td width="20%" align="left" valign="top">Quantity</td>
								  <td width="20%" align="left" valign="top">No of Days</td>
								</tr>
			               		<?php  
			               			if(isset($this->data['PharmacyItem']) && !empty($this->data['PharmacyItem'])){
			               				$count  = count($this->data['PharmacyItem']) ;
			               			}else{
			               				$count  = 3 ;
			               			}	               			
			               			for($i=0;$i<$count;){
			               				 
			               				$drugValue= isset($this->data['PharmacyItem'][$i])?$this->data['PharmacyItem'][$i]:'' ;
			               				$pack= isset($this->data['pack'][$i])?$this->data['pack'][$i]:'' ;
			               				$routeValue= isset($this->data['route'][$i])?$this->data['route'][$i]:'' ;
			               				$frequency= isset($this->data['dose'][$i])?$this->data['dose'][$i]:'' ; //no of days
			               				$doseValue = isset($this->data['frequency'][$i])?$this->data['frequency'][$i]:'' ;
			               				$quantity = isset($this->data['quantity'][$i])?$this->data['quantity'][$i]:'' ;//Quantity
			               			?>
				               			<tr id="DrugGroup<?php echo $i;?>">
						                  <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText','id'=>"drug$i",'name'=> 'drug[]','value'=>$drugValue,'autocomplete'=>'off','counter'=>$i)); ?>                        	 
						                  </td> 
						                  <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('type'=>'text','class' => 'drugPack','id'=>"drug$i",'name'=> 'Pack[]','value'=>$pack,'autocomplete'=>'off','counter'=>$i)); ?>                        	 
						                  </td>  
										  <td   align="left" valign="top">
						                  		<?php 
										 			  
										 		$routes_options = array('IV'=>'IV','IM'=>'IM','S/C'=>'S/C','P.O'=>'P.O','P.R'=>'P.R','P/V'=>'P/V','R.T'=>'R.T','Oral'=>'Oral');
										  		echo $this->Form->input('', array('options'=>$routes_options,'empty'=>'Please select','class' => '','id'=>"route$i",'name' => 'route[]','value'=>$routeValue)); ?>
						                  </td>						                 
						                  <td   align="left" valign="top">
						                  		<?php
											  	$fre_options = array('SOS'=>'SOS','OD'=>'OD','BD'=>'BD','TDS'=>'TDS','QID'=>'QID','HS'=>'HS','L/A'=>'L/A');
											  	
										  		echo $this->Form->input('', array('options'=> $fre_options,'empty'=>'Please select','class' => '','id'=>"frequency$i",'name' => 'frequency[]','value'=>$doseValue)); ?>
						                  </td>
						                   <td  align="left" valign="top">
						                  		<?php											  	
										  		echo $this->Form->input('', array('type'=>'text','class' => '','id'=>"quantity$i",'name' => 'quantity[]','value'=>$quantity)); ?>
						                  </td>
						                   <td   align="left" valign="top">
						                  		<?php echo $this->Form->input('', array('type'=>'text','class' => '','id'=>"dose$i",'name' => 'dose[]','value'=>$frequency)); ?>
						                  </td>
						                 
						           		</tr>	
			               			<?php
			               				$i++ ;
			               			}
			               			$timeArr = array('1'=>'1am','2'=>'2am','3'=>'1am','4'=>'1am','5'=>'1am','6'=>'1am','7'=>'1am','8'=>'1am','9'=>'1am','10'=>'1am','11'=>'1am','12'=>'1am' );
			               		?> 		
			               		       
		                 row 3 end 
		             
		            </table>
		          </td>
		        </tr>
				<tr>                	
						<td align="center" colspan="5">
							<input type="button" id="addButton" value="Add more"> 
							<?php if($count > 0){?>
						 		<input type="button" id="removeButton" value="remove">
						 	<?php }else{ ?>
						 		<input type="button" id="removeButton" value="remove" style="display:none;">
						 	<?php } ?>
						 </td>
					</tr>				
		      </table>
		      --><!--BOF new code for medicine timing-->
		      
		      <table class=" " style="text-align:left;" width="100%"> 		 			
		 		<tr>
		 		   
		       	  <td width="100%" valign="top" align="left" style="padding:8px;" colspan="4">
		              <table width="100%" border="0" cellspacing="0" cellpadding="0">
		                
		                <!-- row 1 -->                
		               <tr>
		               	<td width="100%" valign="top" align="left" colspan="6">
		               		<table width="100%" border="0" cellspacing="0" cellpadding="0" id='DrugGroup'>
								<tr>
								  <td width="11%" height="20" align="left" valign="top">Name of Medication</td>	
								  <td width="11%" height="20" align="left" valign="top">Unit</td>
								  <td width="11%" height="20" align="left" valign="top">Remark</td>								  
								  <td width="11%" align="left" valign="top">Route</td>								  
								  <td width="11%" align="left" valign="top">Dose</td>		
								  <td width="11%" align="left" valign="top">Quantity</td>						 
								  <td width="11%" align="left" valign="top">No. of Days</td>	
								  <td width="11%" align="center" valign="top">Start Date</td>							  
								  <td width="11%" align="center" valign="top">Timing</td>
								  <td width="3%" align="center" valign="top">Is SMS</td>
								</tr>
								<tr>
								  <td width="11%" height="20" align="left" valign="top">&nbsp;</td>								  
								  <td width="11%" height="20" align="left" valign="top">&nbsp;</td>
								  <td width="11%" height="20" align="left" valign="top">&nbsp;</td>
								  <td width="11%" align="left" valign="top">&nbsp;</td>								  
								  <td width="11%" align="left" valign="top">&nbsp;</td>								 
								  <td width="11%" align="left" valign="top">&nbsp;</td>	
								  <td width="11%" align="left" valign="top">&nbsp;</td>
								  <td width="11%" align="left" valign="top">&nbsp;</td>
								  <td width="11%" align="center" valign="top"> 
									  	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
									  		<tr>
											  <td width="25%" height="20" align="center" valign="top">I</td>								  
											  <td width="25%" align="center" valign="top">II</td>								  
											  <td width="25%" align="center" valign="top">III</td>								 
											  <td width="25%" align="center" valign="top">IV</td>										  
										  </tr>
									  	</table>
								  </td>
								  <td width="3%" align="left" valign="top">&nbsp;</td>
								</tr>
			               		<?php  
			               			if(isset($this->data['PharmacyItem']) && !empty($this->data['PharmacyItem'])){
			               				$count  = count($this->data['PharmacyItem']) ;
			               			}else{
			               				$count  = 3 ;
			               			}	               			
			               			for($i=0;$i<$count;){			               				
			               				$drugValue= isset($this->data['PharmacyItem'][$i])?$this->data['PharmacyItem'][$i]:'' ;
			               				$pack= isset($this->data['pack'][$i])?$this->data['pack'][$i]:'' ;
			               				
			               				$modeValue= isset($this->data['route'][$i])?$this->data['route'][$i]:'' ;
			               				$tabsPerDayValue= isset($this->data['dose'][$i])?$this->data['dose'][$i]:'0' ;
			               				$tabsFrequency = isset($this->data['frequency'][$i])?$this->data['frequency'][$i]:'';
			               				$quantity = isset($this->data['quantity'][$i])?$this->data['quantity'][$i]:'' ;
			               				$remark = isset($this->data['remark'][$i])?$this->data['remark'][$i]:'' ;
			               				$tabsStartDateValue= isset($this->data['start_date'][$i])?$this->data['start_date'][$i]:'' ;
			               				
			               				$firstValue= isset($this->data['first'][$i])?$this->data['first'][$i]:'' ;
			               				$secondValue= isset($this->data['second'][$i])?$this->data['second'][$i]:'' ;
			               				$thirdValue = isset($this->data['third'][$i])?$this->data['third'][$i]:'' ;
			               				$forthValue = isset($this->data['forth'][$i])?$this->data['forth'][$i]:'' ;			               				
			               				$isSmsCheckedValue = ($this->data['is_sms_checked'][$i]=='1')?"checked":'' ;
			               				
			               				$first  ='disabled';
			               				$second ='disabled';
			               				$third  = 'disabled';
			               				$forth  ='disabled';
			               				$hourDiff =0;
			               				//set timer
			               				switch($tabsFrequency){
			               					case "OD":
			               						$first ='enabled';			               									               									               						
			               						break;
			               					case "BD":
			               						$hourDiff =  12;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						break;
			               					case "TDS":
			               						$hourDiff = 6 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						break;
			               					case "QID":
			               						$hourDiff = 4 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						$forth = 'enabled';
			               						break;
			               					case "HS":
			               						$first ='enabled';			               						
			               						break;
			               					case "Twice a week":
			               						$first ='enabled';			               						
			               						break;
			               					case "Once a week":
			               						$first ='enabled';			               						
			               						break;
			               					case "Once fort nightly":
			               						$first ='enabled';			               						
			               						break;
			               					case "Once a month":
			               						$first ='enabled';			               						
			               						break;
			               					case "A/D":
			               						$first ='enabled';			               						
			               						break;
			               				}
			               				//EOF timer
			               			
			               			?>
				               			<tr id="DrugGroup<?php echo $i;?>">
						                  <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'drugText','id'=>"drug$i",'name'=> 'drug[]','value'=>$drugValue,'counter'=>$i)); ?>                        	 
						                  </td> 
						                   <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('size'=>'5','type'=>'text' ,'class' => 'drugPack','id'=>"Pack$i",'name'=> 'Pack[]','value'=>$pack ,'counter'=>$i)); ?>                        	 
						                  </td> 
						                  <td   align="left" valign="top">                  		                       		
						                       <?php echo $this->Form->input('', array('type'=>'text' ,'class' => '','id'=>"remark$i",'name'=> 'remark[]','value'=>$remark ,'counter'=>$i)); ?>                        	 
						                  </td> 						                 
										  <td  align="left" valign="top">
						                  <?php  
												$routes_options = array('IV'=>'IV','IM'=>'IM','S/C'=>'S/C','P.O'=>'P.O','P.R'=>'P.R','P/V'=>'P/V','R.T'=>'R.T','LA'=>'LA');
										  		echo $this->Form->input('', array('options'=>$routes_options,'style'=>"width:75px;",'empty'=>'Select','class' => '','id'=>"mode$i",'name' => 'route[]','value'=>$modeValue)); ?>
						                  </td>
						                  <td  align="left" valign="top">
						                  <?php
											  	$fre_options = array('SOS'=>'SOS','OD'=>'OD','BD'=>'BD','TDS'=>'TDS','QID'=>'QID','HS'=>'HS','Twice a week' => 'Twice a week', 'Once a week'=>'Once a week', 'Once fort nightly'=>'Once fort nightly', 'Once a month'=>'Once a month', 'A/D'=>'A/D');
										  		echo $this->Form->input('', array('options'=> $fre_options, 'empty'=>'Select','class'=>'frequency','id'=>"tabs_frequency_$i",'name' => 'frequency[]','value'=>$tabsFrequency,'style'=>'width:75px;')); ?>
						                  </td>
						                     <td  align="left" valign="top">
						                  		<?php											  	
										  		echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'name' => 'quantity[]','value'=>$quantity)); ?>
						                  </td>
						                   <td  align="left" valign="top">
						                  		<?php echo $this->Form->input('', array('type'=>'text','size'=>2,'class' => '','id'=>"tabs_per_day$i",'name' => 'dose[]','value'=>$tabsPerDayValue)); ?>
						                  </td>
						                  <td  align="left" valign="top">						                  
						                  <?php echo $this->Form->input('', array('type'=>'text','size'=>2,'class' => 'textBoxExpnd  validate[required,custom[mandatory-select]] start_date','id'=>"start_date$i",'name' => 'start_date[]','value'=>$tabsStartDateValue)); ?>
						                  </td>
						                  <td  align="left" valign="top">
						                  		 <?php
													  $timeArr = array('1'=>'1am','2'=>'2am','3'=>'3am','4'=>'4am','5'=>'5am','6'=>'6am','7'=>'7am','8'=>'8am','9'=>'9am','10'=>'10am','11'=>'11am','12'=>'12am',
			               							 				   '13'=>'1pm','14'=>'2pm','15'=>'3pm','16'=>'4pm','17'=>'5pm','18'=>'6pm','19'=>'7pm','20'=>'8pm','21'=>'9pm','22'=>'10pm','23'=>'11pm','24'=>'12pm');
			               							  $disabled = 'disabled'; 
						                  		?>
						                  		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
											  		<tr>
													  <td width="25%" height="20" align="center" valign="top"><?php
													  		  echo $this->Form->input('first_time', array($first,'style'=>'width:60%;','id'=>"first_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'','class' => 'first' , 'label'=> false,
							 					  	   'div' => false,'error' => false,'value'=>$firstValue)); 
													  ?></td>								  
													  <td width="25%" align="center" valign="top"><?php
													   echo $this->Form->input('second_time', array($second,'style'=>'width:60%;','id'=>"second_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'' , 'label'=> false,
							 					  	   'div' => false,'error' => false ,'class'=>'second','value'=>$secondValue));  
													  ?></td>								  
													  <td width="25%" align="center" valign="top"><?php
													  	 echo $this->Form->input('third_time', array($third,'style'=>'width:60%;','id'=>"third_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'','class' => 'third' , 'label'=> false,
							 					  	   'div' => false,'error' => false,'value'=>$thirdValue));
													  ?></td>								 
													  <td width="25%" align="center" valign="top"><?php
													  	echo $this->Form->input('forth_time', array($forth,'style'=>'width:60%;','id'=>"forth_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'' , 'label'=> false,
							 					  	   'div' => false,'error' => false ,'class'=>'forth','value'=>$forthValue));
													  ?></td>										  
												  </tr>
											  	</table>	 
							 			  </td>
							 			  <td valign="top"><?php
							 			  echo $this->Form->checkbox('is_sms_checked', array('id'=>"isSmsChecked_$i",'name' => "is_sms_checked[$i]",'label'=> false,'div' => false,'error' => false ,'class'=>'isSmsChecked','checked'=>$isSmsCheckedValue,'hiddenField' => false));?>
							 			  </td> 			
						           		</tr>	
			               			<?php
			               				$i++ ;
			               			}
			               		?> 		                          	              
		                </table>
		              </td>
		            </tr>                
		                <!-- row 3 end -->
		            <tr>                	
						<td align="right" colspan="5">
							<input type="button" id="addButton" value="Add More"> 
							<?php if($count > 0){?>
						 		<input type="button" id="removeButton" value="Remove">
						 	<?php }else{ ?>
						 		<input type="button" id="removeButton" value="Remove" style="display:none;">
						 	<?php } ?>
						 </td>
					</tr>
		            </table>
		          </td>
		        </tr>
		      </table>
		      <!-- EOF new code for medicine timing -->
		   </td>
		   </tr>
		 	<!--EOF medicine -->
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title">Advice:</td>
  </tr> 
<!--BOF advice template -->   
	<tr>     
		<td width="100%" align="left" valign="top" >
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
				<tr>
					<td width="27%" align="left" valign="top">
							<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
							<div id="templateArea-advice">
								 <?php
									 echo $this->requestAction('billings/template_add/advice');
								 ?>					 
							</div>	    	    		 
					</td>	    	    		
					<td width="70%" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
							  <tr>
								<td width="20">&nbsp;</td>	
								<td valign="top" colspan="4">
										<?php 
											echo $this->Form->textarea('advice', array('id' => 'advice_desc'  ,'rows'=>'20','style'=>'width:98%')); 
											echo $this->Js->writeBuffer();
										?>
								</td>			                    
							 </tr>
						  </table>
					  </td>
				</tr>
			</table>
		</td>
	</tr>
<!--EOF advice template -->  
   <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title">Case Summary</td>
  </tr>
  <tr>
    <td width="100%" height="30" align="left" valign="top" ><strong>Presenting Complaints</strong></td>
  </tr> 
  <!--BOF complaints  template -->   
			<tr>     
				<td width="100%" align="left" valign="top" >
					<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
						<tr>
							<td width="27%" align="left" valign="top">
									<div align="center" id = 'temp-busy-indicator' style="display:none;">	
										&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
									</div>	
									<div id="templateArea-complaints">
										 <?php
											 echo $this->requestAction('doctor_templates/add/complaints'); 
										 ?>					 
									</div>	 
									<?php //echo $this->element('chatgpt',array('templateType'=>'complaints')); ?>     	    		 
							</td>	    	    		
							<td width="70%" align="left" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
									  <tr>
										<td width="20">&nbsp;</td>	
										<td valign="top" colspan="4">
												<?php
													$complaints = ($this->data['DischargeSummary']['complaints'])?$this->data['DischargeSummary']['complaints']:$diagnosis['complaints']; 
													echo $this->Form->textarea('complaints', array('id' => 'complaints_desc','value'=>$complaints,'rows'=>'20','style'=>'width:98%')); 
													echo $this->Js->writeBuffer();
												?>
										</td>			                    
									 </tr>
								  </table>
							  </td>
						</tr>
					</table>
				</td>
			</tr>
		<!--EOF complaints template --> 
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title">Examination</td>
  </tr>
  <tr>
		    <td width="100%" align="left" valign="top">
		    	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl" align="center">
				      <tr>
				       
				                  	<td valign="top" width="15%">Temp:  
				                  		<?php
											//$temp = ($this->data['DischargeSummary']['temp'])?$this->data['DischargeSummary']['temp']:$diagnosis['TEMP'];
											//$pr = ($this->data['DischargeSummary']['pr'])?$this->data['DischargeSummary']['pr']:$diagnosis['PR'];
											//$rr = ($this->data['DischargeSummary']['rr'])?$this->data['DischargeSummary']['rr']:$diagnosis['RR'];
											//$bp = ($this->data['DischargeSummary']['bp'])?$this->data['DischargeSummary']['bp']:$diagnosis['BP'];
											
											$temp = $diagnosis['TEMP'];
											$pr = $diagnosis['PR'];
											$rr = $diagnosis['RR'];
											$bp = $diagnosis['BP'];
											
											$spo2 =  $diagnosis['spo2'];
				                  		
                        	 				echo $this->Form->input('temp',array('legend'=>false,'label'=>false ,'id' => 'TEMP','size'=>2,'value'=>$temp));  
                        	 			?>
										&#8457;
				                  	</td>
										<td valign="top" width="15%">P.R: 
				                  		<?php	
                        	 				echo $this->Form->input('pr',array('legend'=>false,'label'=>false,'id' => 'PR','size'=>2,'value'=>$pr));  
                        	 			?>/Min
				                  	</td> 
									 
				                  	<td valign="top" width="15%">R.R: 
				                  		<?php	
                        	 				echo $this->Form->input('rr',array('legend'=>false,'label'=>false,'id' => 'RR','size'=>2,'value'=>$rr));  
                        	 			?>/Min
				                  	</td>
				                  	<td valign="top" width="20%">BP: 
				                  		<?php	
                        	 				echo $this->Form->input('bp',array('legend'=>false,'label'=>false ,'id' => 'BP','size'=>8,'value'=>$bp));  
                        	 			?>mm/hg
				                  	</td>
				                  	<td valign="top" width="35%">SPO<sub>2</sub>: 
				                  		<?php	
                        	 				echo $this->Form->input('spo2',array('legend'=>false,'label'=>false ,'id' => 'spo2','size'=>8,'value'=>$spo2));  
                        	 			?>% in Room Air
				                  	</td>
				                  </tr>
				      </table>
			</td> 
			</tr><!--New HTMl with body param-->
			 
			
			
			<!--BOF General examination  template -->   
						<tr>     
							<td width="100%" align="left" valign="top" >
								<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
									<tr>
										<td width="27%" align="left" valign="top">
												<div align="center" id = 'temp-busy-indicator' style="display:none;">	
													&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
												</div>	
												<div id="templateArea-examine">
													 <?php
														 echo $this->requestAction('doctor_templates/add/examine'); 
													 ?>					 
												</div>	
												<?php //echo $this->element('chatgpt',array('templateType'=>'examine')); ?>    	    		 
										</td>	    	    		
										<td width="70%" align="left" valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
												  <tr>
													<td width="20">&nbsp;</td>	
													<td valign="top" colspan="4">
															<?php
																$general_examine = ($this->data['DischargeSummary']['general_examine'])?$this->data['DischargeSummary']['general_examine']:$diagnosis['general_examine']; 
																echo $this->Form->textarea('general_examine', array('id' => 'general_examine','value'=>$general_examine,'rows'=>'20','style'=>'width:98%')); 
																echo $this->Js->writeBuffer();
															?>
													</td>			                    
												 </tr>
											  </table>
										  </td>
									</tr>
								</table>
							</td>
						</tr>
				<!--EOF general examination template -->  
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title">Investigations:</td>
  </tr>
<!--BOF Investigation template -->   
	<tr>     
		<td width="100%" align="left" valign="top" >
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
				<tr>
					<td width="27%" align="left" valign="top">
							<div align="center" id = 'temp-busy-indicator' style="display:none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>	
							<div id="templateArea-investigation">
								 <?php
									 echo $this->requestAction('billings/investigation_template_add/investigation');
								 ?>					 
							</div>	    	    		 
					</td>	    	    		
					<td width="70%" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
							  <tr><td width="20"></td>
                                                        <td valign="top" colspan="4">
                                                            <?php if(isset($diagnosis['is_print_investigation']) && $diagnosis['is_print_investigation'] == '1'){ $checked = "checked"; } else { $checked = ''; }?> 
                                                            <?php echo $this->Form->input('is_print_investigation',array('type'=>'checkbox','label'=>false,'div'=>false,'value'=>$diagnosis['is_print_investigation'],'checked'=>$checked))."Print Recent Investigation only"; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
								<td width="20">&nbsp;</td>	
								<td valign="top" colspan="4">
				
								<?php   
								 
										$lab_ordered ='';
									//	if(empty($this->data['DischargeSummary']['investigation'])){
											foreach($testOrdered as $dept =>$testName){    
                           	foreach($testName as $name){			
                                $lab_ordered .=  $name['date'].":-".$name['name'].': '.$name['results']."\n\n";
                            }
							  			}  
									//	}/*else{
											
										//$lab_ordered = $this->data['DischargeSummary']['investigation']; 
											
										//}*/
										
										
										echo $this->Form->textarea('investigation', array('id' => 'investigation_desc'  ,'rows'=>'19','style'=>'width:98%','value'=>$lab_ordered)); 
										echo $this->Js->writeBuffer();
										?>
								</td>			                    
							 </tr>
						  </table>
					  </td>
				</tr>
			</table>
		</td>
	</tr>
<!--EOF Investigation template --> 
  <tr>
  	<td width="100%" align="left" valign="top" >
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
				<tr>
					<td width="27%" align="left" valign="top" class="title"	>
							Abnormal Investigation  	    		 
					</td>	    	    		
					<td width="70%" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
							 
              <tr>
								<td width="20">&nbsp;</td>	
								<td valign="top" colspan="4">
				
								<?php   echo $this->Form->textarea('abnormal_investigation', array('id' => 'abnormal_investigation'  ,'rows'=>'19','style'=>'width:98%')); 
									
										?>
								</td>			                    
							 </tr>
						  </table>
					  </td>
				</tr>
			</table>
		</td>
  </tr>

  <tr>
    <td align="left" valign="top" class="title"  > <?php echo $this->Html->link('OT Notes',array('controller'=>'NewOptAppointments','action'=>'otevent',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?></td>
  </tr>
  <?php 
     
    //if(!empty($otList) && empty($this->data['DischargeSummary']['id'])){
 
    if(!empty($otList)){
    		$k=0;
    		  
		  foreach($otList as $key=> $otArr ){
		 
			  $ot = $otArr['OptAppointment'];
		      $sergeryName  = $otArr['Surgery']['name'] ;
		 ?>
		  <tr>
		    <td align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
		      <tr><!--
		        <td width="34" align="center" valign="middle"><strong>.</strong></td>
		        --><td width="173" align="left">Date</td>
		        <td width="29" align="center">:</td>
		        <td width="535"><?php  
		       		 //$surgery_schedule_date = ($this->data['DischargeSummary']['surgery_schedule_date'])?$this->data['DischargeSummary']['surgery_schedule_date']:$ot['schedule_date']." ".$ot['start_time'];
		       		 
		       		  $surgery_schedule_date = $ot['starttime'];
		       		 //BOF pankaj
					// $splittedSurgeryDate = explode(" ",$surgery_schedule_date); 
					 //EOF pankaj 
					 $surgery_schedule_date  = $this->DateFormat->formatDate2Local($surgery_schedule_date,Configure::read('date_format'),true);
					// $surgery_schedule_date  .= " ".!empty($splittedSurgeryDate[1])?$splittedSurgeryDate[1]:'00:00:00';
					 echo $this->Form->hidden('',array('name'=>'data[DischargeSurgery]['.$k.'][opt_appointment_id]','value'=>$ot['id']));
		        	 echo $this->Form->input('',array('name'=>'data[DischargeSurgery]['.$k.'][surgery_schedule_date]','type'=>'text','class' => 'validate[required,custom[mandatory-date]] surgery-date','id'=>'surgery-date'.$k,'value'=>$surgery_schedule_date,'style'=>"width:185px;"));
		        ?></td>
		      </tr>
		      <tr>
		        <!--<td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Procedure</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        
		        	$surgery_desc = ($this->data['DischargeSummary']['surgery_desc'])?$this->data['DischargeSummary']['surgery_desc']:$sergeryName;
		        	echo $this->Form->input('', array('type'=>'text','name'=>'data[DischargeSurgery]['.$k.'][surgery_desc]','id' => 'surgery_desc','style'=>'width:98%','value'=>$sergeryName,'readonly'=>'readonly'));
		        	?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Surgeon</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top">
		        	<?php 
		        		$surgon_id = ($this->data['DischargeSummary']['surgon_id'])?$this->data['DischargeSummary']['surgon_id']:$ot['doctor_id'];
		        		echo $this->Form->input('surgon_id',array('name'=>'data[DischargeSurgery]['.$k.'][surgon_id]','type'=>'select','empty'=>'Please select','options'=>$surgonList,
		        		'class' => 'validate[optional,custom[mandatory-select]]','style'=>"width:200px;",'value'=>$surgon_id));
		        	?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Anaesthetist</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        		$anaesthesian_id = ($this->data['DischargeSummary']['anaesthesian_id'])?$this->data['DischargeSummary']['anaesthesian_id']:$ot['department_id'];
		        		echo $this->Form->input('',array('name'=>'data[DischargeSurgery]['.$k.'][anaesthesian_id]','type'=>'select','empty'=>'Please select','options'=>$anaList,
		        		'class' => ' ','style'=>"width:200px;",'value'=>$anaesthesian_id));
		        	 ?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Anaesthesia</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        	$anaesthesia = ($this->data['DischargeSummary']['anaesthesia'])?$this->data['DischargeSummary']['anaesthesia']:$ot['anaesthesia'];
		        	echo $this->Form->textarea('anaesthesia', array('name'=>'data[DischargeSurgery]['.$k.'][anaesthesia]','id' => 'anaesthesia','value'=>$anaesthesia,'rows'=>'5','style'=>'width:98%'));
		         ?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Description</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        	$description = ($this->data['DischargeSummary']['description'])?$this->data['DischargeSummary']['description']:$ot['description'];
		        	echo $this->Form->textarea('description', array('name'=>'data[DischargeSurgery]['.$k.'][description]','id' => 'description','value'=>$description,'rows'=>'5','style'=>'width:98%'));
		         ?></td>
		      </tr>
		    </table></td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
		  <?php $k++;} 
    //EOF if
    }/*else{
    	 
    	 $otCount = count($dischargeOT)>0?count($dischargeOT):1;
    	for($g=0;$g<$otCount;$g++){
		  ?>
		  <tr>
		    <td align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
		      <tr>
		        <!--<td width="34" align="center" valign="middle"><strong>.</strong></td>
		        --><td width="173" align="left">Date</td>
		        <td width="29" align="center">:</td>
		        <td width="535"><?php  
		       		 //$surgery_schedule_date = ($dischargeOT[$g]['DischargeSurgery']['surgery_schedule_date'])?$dischargeOT[$g]['DischargeSurgery']['surgery_schedule_date']:date('Y-m-d H:i:s');
		       		 $surgery_schedule_date = $dischargeOT[$g]['DischargeSurgery']['surgery_schedule_date'];
		       		 //BOF pankaj
		       		 if($surgery_schedule_date){
						 $splittedSurgeryDate = explode(" ",$surgery_schedule_date);
			       		 //EOF pankaj
			       		 $surgery_schedule_date  = $this->DateFormat->formatDate2Local($surgery_schedule_date,Configure::read('date_format'),true);
						 echo $this->Form->input('',array('name'=>'data[DischargeSurgery]['.$g.'][surgery_schedule_date]','type'=>'text','class' => 'surgery-date','value'=>$surgery_schedule_date,'style'=>"width:185px;"));
		       		 }else{ 
		       		 	echo $this->Form->input('',array('name'=>'data[DischargeSurgery]['.$g.'][surgery_schedule_date]','type'=>'text','class' => 'surgery-date','style'=>'width:185px;','value'=>''));
		       		 }
		        	 echo $this->Form->hidden('',array('name'=>'data[DischargeSurgery]['.$g.'][id]','value'=>$dischargeOT[$g]['DischargeSurgery']['id']));
		        	 
		        ?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Procedure</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php  
		        	$surgery_desc = !empty($dischargeOT[$g]['DischargeSurgery']['surgery_desc'])?$dischargeOT[$g]['DischargeSurgery']['surgery_desc']:'';
		        	echo $this->Form->input('', array('type'=>'text','name'=>'data[DischargeSurgery]['.$g.'][surgery_desc]','id' => 'surgery_desc','value'=>$surgery_desc,'value'=>$surgery_desc));
		        	?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Surgeon</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top">
		        	<?php 
		        		$surgon_id = $dischargeOT[$g]['DischargeSurgery']['surgon_id'];		        	
		        		echo $this->Form->input('surgon_id',array('name'=>'data[DischargeSurgery]['.$g.'][surgon_id]','type'=>'select','empty'=>'Please select','options'=>$surgonList,
		        		'class' => '','style'=>"width:200px;",'value'=>$surgon_id));
		        	?></td>
		      </tr>
		      <tr>
		        <!--<td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Anaesthetist</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        		$anaesthesian_id = $dischargeOT[$g]['DischargeSurgery']['anaesthesian_id'];		        	
		        		echo $this->Form->input('',array('name'=>'data[DischargeSurgery]['.$g.'][anaesthesian_id]','type'=>'select','empty'=>'Please select','options'=>$anaList,
		        		'class' => '','style'=>"width:200px;",'value'=>$anaesthesian_id));
		        	 ?></td>
		      </tr>
		      <tr>
		        <!--<td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Anaesthesia</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        	$anaesthesia = $dischargeOT[$g]['DischargeSurgery']['anaesthesia'];
		        	echo $this->Form->textarea('anaesthesia', array('name'=>'data[DischargeSurgery]['.$g.'][anaesthesia]','id' => 'anaesthesia','value'=>$anaesthesia,'rows'=>'5','style'=>'width:98%'));
		         ?></td>
		      </tr>
		      <tr><!--
		        <td align="center" valign="middle"><strong>.</strong></td>
		        --><td>Description</td>
		        <td align="center" valign="top">:</td>
		        <td align="left" valign="top"><?php 
		        	$description = $dischargeOT[$g]['DischargeSurgery']['description'];
		        	echo $this->Form->textarea('description', array('name'=>'data[DischargeSurgery]['.$g.'][description]','id' => 'description','value'=> $description,'rows'=>'5','style'=>'width:98%'));
		         ?></td>
		      </tr>
		    </table></td>
		  </tr>  
		  <tr><td>&nbsp;</td></tr>
		  <?php 
    		}
    	}*/?>
	<tr>
    <td height="30" align="left" valign="top"  class="title"><strong>Stay Notes:</strong> 

    	<?php 
    	if($this->data['DischargeSummary']['present_condition']){
    		echo $this->Html->link(__('Print Stay Notes'),
			'#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printStayNotes',$patient_id))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    	}
    	 ?></td>
   
  </tr> 
  <!--BOF General examination  template -->   
						<tr>     
							<td width="100%" align="left" valign="top" >
								<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
									<tr>
										<td width="27%" align="left" valign="top">
												<div align="center" id = 'temp-busy-indicator' style="display:none;">	
													&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
												</div>	
												<div id="templateArea-present-cond">
													 <?php
														 echo $this->requestAction('notes/add/present-cond'); 
													 ?>					 
												</div>	
												<?php echo $this->element('chatgpt',array('templateType'=>'present-cond')); ?>    	    		 
										</td>	    	    		
										<td width="70%" align="left" valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
												  <tr>
													<td width="20">&nbsp;</td>	
													<td valign="top" colspan="4">

													 <!-- Editable div -->
													 <!-- Editable div -->
        <div id="present-cond_desc" contenteditable="true" >
            <?php echo htmlspecialchars_decode($present_condition); ?>
        </div>
															<?php
																$present_condition = ($this->data['DischargeSummary']['present_condition'])?$this->data['DischargeSummary']['present_condition']:$noteRecord['Note']['present_condition']; 
																
																echo $this->Form->textarea('present_condition', array(
																	'id' => 'present_condition_hidden',
																	'value' => $present_condition,
																	'rows' => '20',
																	'style' => 'width:98%; display:none;'
																));
																echo $this->Js->writeBuffer();
															?>
													</td>				                    
												 </tr>
											  </table>
										  </td>
									</tr>
								</table>
							</td>
						</tr>
				<!--EOF general examination template -->  
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>

  <tr>
    <td width="100%" align="left" valign="top" class="title">Stay Medicines:</td>
  </tr>

  <tr>
  	<td width="100%">
  			<table cellpadding="4" cellspacing="0" border="1" width="100%">
  				<tr>
  					<td><strong>Name of Medication</strong></td>
  					<td><strong>Date</strong></td>
  				</tr>
  				<?php foreach ($stayMedicine as $key => $value) {?>
  				<tr>
  					<td><?php echo $value['PharmacyItem']['name'] ?></td>
  					<td><?php echo $this->DateFormat->formatDate2Local($value['PharmacySalesBill']['create_time'],Configure::read('date_format'),false);?></td>
  				</tr>
  			<?php  } ?>
  			</table>
  	</td>
  </tr>
    <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>

  <tr>
    <td align="left" valign="top" class="title"><?php 
    	echo ucwords("Treatment during hospital stay:") ;
    	echo $this->Html->link(__('(Add More)'),'javascript:void(0)',array('class'=>'logout_section','escape'=>false,'id'=>'add-medicine')) ; 
    ?>
    </td>

 </tr> 
    
    <tr>
    <td align="left" valign="top">
    	<ul>

    	
        	<?php $r=0;        	
        			foreach($completeDrugArr as $keyDrug=>$drugName){						
        				echo "<li id='NoteDiv_$r'>".$drugName."<span class='currentRemoveIns' id='currentRemoveIns_$r'>".$this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array())."</span></li>" ;
        				echo $this->Form->hidden('hidden_medication',array('id'=>'MedId_'.$r,'value'=>$keyDrug));
        		  $r++;}
        		  
            ?>
        </ul> 
    </td>
  </tr> 

  <tr>
    <td align="left" valign="top">
    	<?php 
    		echo "The condition of patient at the time of discharge was :     ";  
    		echo $this->Form->input('condition_on_discharge',array('type'=>'select','options'=>array('satisfactory'=>'Satisfactory','unsatisfactory'=>'Unsatisfactory'),'id'=>'condition_on_discharge','style'=>"width:185px;",'div'=>false));?>
    		<?php 
    		if($this->data['DischargeSummary']['satisfactory_on_discharge']){
				$getShow='inline';
			}else{
				$getShow='none';}
			?>
			
    		<span style="padding-left:10px;">
    	<?php
			echo $this->Form->input('resident_doctor_id',array('type'=>'select','empty'=>'Please select','options'=>$docList,'class' => 'validate[required,custom[mandatory-select]]','style'=>"width:200px;"));
		?></span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
      <tr>
      	<td width="34" align="center" valign="middle"><strong>.</strong></td>
        <td width="173" align="left">Review on<font color="red">*</font></td>
        <td width="29" align="center">:</td>
        <!--code add  by Pooja Charde-->
        <td width="535">
  <?php 
    echo $this->Form->input('review_on', array(
        'type' => 'text',
        'id' => 'review_on',
        'class' => 'validate[required,custom[mandatory-date]]',
        'style' => "width:185px;",
        'value' => date('d/m/Y') // Format the date as "day/month/year"
    ));
  ?>
</td>


      </tr>
      <tr>
      	<td  align="center" valign="middle"><strong>.</strong></td>
        <td>Resident On Discharge<font color="red">*</font></td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php
			echo $this->Form->input('resident_doctor_id',array('type'=>'select','empty'=>'Please select','options'=>$docList,'class' => 'validate[required,custom[mandatory-select]]','style'=>"width:200px;"));
		?></td>
      </tr>
      <tr>
      	<td  align="center" valign="middle"><strong>.</strong></td>
        <td>Enable SMS Alert</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php	echo $this->Form->checkbox('is_sms_check',array('class'=>'blueBtn','error'=>false,'div'=>false,'label'=>false));?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top">
        <?php echo $this->Form->submit('Save', array(
            'class' => 'blueBtn',
            'error' => false,
            'div' => false,
            'label' => false,
            'onclick' => 'saveContent()'
        )); ?>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="border-top:1px solid #cccccc;">&nbsp;</td>
  </tr> 
  <tr>
    <td align="right" valign="top"><a href="#patientnotesfrm" style="color:#000;">BACK TO TOP</a></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
	<tr>
		<td>
			<p>
			    <span style="font-size: 20px; font-weight: bold;">📲 Hey everyone! Exciting news! We now have access to ChatGPT within our software. 🎉</span>
			    <br>
			    <span>Follow these simple steps to start using it:</span>
			</p>
			<ol>
			    <li>For OPD patients, go to the Epen page and click the "Fetch data" button. For IPD patients, go to the discharge summary page and click the "Fetch data" button.</li>
			    <li>Look for the "discharge summary" title in the template box above (for IPD patients) or the "OPD summary" title (for OPD patients).</li>
			    <li>Click on the respective title to open the template.</li>
			    <li>To utilize ChatGPT, click the magnifying glass icon next to the template.</li>
			    <li>Edit the prompt and hit the “Message ChatGPT” button.</li>
			    <li>ChatGPT will process your query and provide a response in no time. Remember, ChatGPT is designed to assist you, so feel free to ask any questions or seek help with any topic.</li>
			</ol>
			<p>
			    <span>Let's make the most of this powerful tool and enhance our productivity! 💪</span>
			    <br>
			    <span>If you encounter any issues or have further questions, don't hesitate to reach out to our support team.</span>
			    <br>
			    <span>Happy chatting!</span>
			</p>
		</td>
		<td>
				<?php echo $this->Html->image('/img/icons/chatgptinfo.jpeg',array('width'=>'200px','height'=>'200px')); ?>
		</td>
	</tr>
	<tr>
    <td align="left" valign="top" style="border-top:1px solid #cccccc;" colspan="2">&nbsp;</td>
  </tr> 
  <tr>
		    <td colspan="2">
		    	<p>
					    <span>Dear User,</span>
					    <br>
					    <span>We appreciate your use of our software. Here's a quick guide on how to delete frequent templates from different sections of the discharge summary:</span>
					</p>
				<ol>
				    <li>If you wish to remove templates from the 'Stay Notes' section, navigate to the 'Master' section of the software, and select 'Notes Template'.</li>
				    <li>For the removal of templates in the 'Examination' section, please go to the 'Master' section, and then choose 'Initial Assessment'.</li>
				    <li>Similarly, to delete templates in the 'Diagnosis' section, you need to visit the 'Master' section and select 'Initial Assessment'.</li>
				</ol>
				<p>
				    <span>Remember, managing your templates efficiently can help streamline your workflow. If you need any further assistance, please feel free to reach out to us.</span>
				</p>
				<p>
				    <span>Best Regards,</span>
				    <br>
				    <span>Your Software Team</span>
				</p>
			</td>
  </tr> 
</table>




<?php echo $this->Form->end(); ?>
 <?php $splitDate = explode(' ',$patient['Patient']['form_received_on']);?>
<script>
var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
var explode = admissionDate.split('-');

			jQuery(document).ready(function(){

					
			 $('.drugText').live('focus',function()
			  {   
			  		var counter = $(this).attr("counter");
			  		if($(this).val()==""){
			  			$("#Pack"+counter).val("");
			  		}
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 
				  	})          ;	 
				    
					  
			});//EOF autocomplete
			
			 $('.drugPack').live('focus',function()
			  {   
			  		var counter = $(this).attr("counter");			  		
			  		//var drugName=$("#drug"+counter).val();
			  		
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPack","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
					    
						width: 250,
						 selectFirst: false,
						 extraParams: {drug:$("#drug"+counter).val() },
				  	});	 
				    
					  
			});//EOF autocomplete
				$(".drugText").addClass("validate[optional,custom[onlyLetterNumber]]");			  
				//add n remove drud inputs
				 var counter = <?php echo $count?>;
			 
			  /*  $("#addButton").click(function () {		 				 
					 
					$("#patientnotesfrm").validationEngine('detach'); 
					var newCostDiv = $(document.createElement('tr'))
					     .attr("id", 'DrugGroup' + counter);
					var route_option = '<select id="route'+counter+'" class="" name="route[]"><option value="">Please Select</option><option value="1">IV</option><option value="0">IM</option><option value="2">S/C</option><option value="3">P.O</option><option value="2">P.R</option><option value="3">P/V</option><option value="3">R.T</option></select>';
					var fre_option = '<select id="frequency'+counter+'" class="" name="frequency[]"><option value="">Please select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option></select>';
					var quality_opt = '<td><input type="text" value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
					var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '" class=" drugText validate[optional,custom[onlyLetterNumber]] ac_input" name="drug[]" autocomplete="off"></td><td><input  type="text" value="" id="Pack' + counter + '" size="16" class=" drugPack validate[optional,custom[onlyLetterNumber]] ac_input" name="Pack[]" autocomplete="off" counter='+counter+'></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt+'<td><input type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td>';
					           		 			
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");		
					$("#patientnotesfrm").validationEngine('attach'); 			 			 
					counter++;
					if(counter > 0) $('#removeButton').show('slow');
			     });*/
				//BOF new changes for medicine timing
				//BOF timer
				$('.frequency').live('change',function(){
					
					id 	= $(this).attr('id');
					 
					currentCount 	= id.split("_");
					currentFrequency= $(this).val();
					$('#first_'+currentCount[2]).val('');
					$('#second_'+currentCount[2]).val('');
					$('#third_'+currentCount[2]).val('');
					$('#forth_'+currentCount[2]).val('');
					 
					//set timer
       				switch(currentFrequency){       					
       					case "BD":     	
       						$('#first_'+currentCount[2]).removeAttr('disabled');
       						$('#second_'+currentCount[2]).removeAttr('disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');       					 
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
       						break;
       					case "TDS":
       						$('#first_'+currentCount[2]).removeAttr('disabled');
       						$('#second_'+currentCount[2]).removeAttr('disabled');
       						$('#third_'+currentCount[2]).removeAttr('disabled');       						  						
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
       						break;
       					case "QID":
       						$('#first_'+currentCount[2]).removeAttr('disabled');
       						$('#second_'+currentCount[2]).removeAttr('disabled');
       						$('#third_'+currentCount[2]).removeAttr('disabled');
       						$('#forth_'+currentCount[2]).removeAttr('disabled');       						
       						break;
       					case "OD":
       					case "HS":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Once fort nightly":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Twice a week":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Once a week":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Once a month":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "A/D":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break          					
       				}
					
				});	
				
				$('.first').live('change',function(){	
					currentValue 	= Number($(this).val()) ;
					id 			 	= $(this).attr('id');
					currentCount 	= id.split("_");
					currentFrequency= $('#tabs_frequency_'+currentCount[1]).val();
					hourDiff		= 0 ;					 
					//set timer
       				switch(currentFrequency){       					
       					case "BD":
       						hourDiff = 12 ;
       						break;
       					case "TDS":
       						hourDiff = 6 ;
       						break;
       					case "QID":
       						hourDiff = 4 ;
       						break;       					
       				}			
					
					switch(hourDiff){
						case 12:						 
							$('#second_'+currentCount[1]).val(currentValue+12);
							break;
						case 6:						 
							$('#second_'+currentCount[1]).val(currentValue+6);
							$('#third_'+currentCount[1]).val(currentValue+12);
							break;
						case 4: 
							$('#second_'+currentCount[1]).val(currentValue+4);
							$('#third_'+currentCount[1]).val(currentValue+8);
							$('#forth_'+currentCount[1]).val(currentValue+12);
							break;
						}
				});
				//EOF timer 
				//EOF new changes for medicine timing
			    $("#addButton").click(function () {		 				 
					 
					$("#diagnosisfrm").validationEngine('detach'); 
					var newCostDiv = $(document.createElement('tr'))
					     .attr("id", 'DrugGroup' + counter);  
					//var route_option = '<select id="mode'+counter+'" style="width:80px" class="" name="mode[]"><option value="">Select</option><option value="1">IV</option><option value="0">IM</option><option value="2">S/C</option><option value="3">P.O</option><option value="2">P.R</option><option value="3">P/V</option><option value="3">R.T</option></select>';
					var route_option = '<select id="mode'+counter+'" style="width:75px" class="" name="route[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
					var fre_option = '<select id="tabs_frequency_'+counter+'" style="width:75px" class="frequency" name="frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
					var quality_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
					//BOF timer
					var options = '<option value=""></option>';
					for(i=1;i<25;i++){
						if(i<13){
							str = i+'am';
						}
						else {
							str = (i-12)+'pm';
						}						
						options += '<option value="'+i+'"'+'>'+str+'</option>';
					}
					//EOF Timer
									
					//var timer	= '<td><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="disabled" name="drugTime['+counter+'][]">'+options+'</select><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="disabled" name="drugTime['+counter+'][]">'+options+'</select><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="disabled" name="drugTime['+counter+'][]">'+options+'</select></td>';				

					timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';								  
					timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
					timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
					timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
					timer = timerHtml1+timerHtml2+timerHtml3+timerHtml4+'</tr></table></td>';	
					 
					var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '"  class=" drugText validate[optional,custom[onlyLetterNumber]] ac_input" name="drug[]" autocomplete="off" counter='+counter+'></td><td><input size="5" type="text" value="" id="Pack' + counter + '"  class=" drugPack validate[optional,custom[onlyLetterNumber]] ac_input" name="Pack[]" autocomplete="off" counter='+counter+'></td><td><input  type="text" value="" id="remark' + counter + '"  class="" name="remark[]"   counter='+counter+'></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt+'<td><input type="text" value="0" size="2" id="tabs_per_day'+counter+'" class="" name="dose[]"></td><td><input  type="text" value="" id="start_date' + counter + '"  class=" validate[required,custom[mandatory-select]] textBoxExpnd start_date" name="start_date[]" autocomplete="off" counter='+counter+'></td>'+timer+'<td><input  type="checkbox"  value="1"  id="isSmsChecked_' + counter + '" class="isSmsChecked" name="is_sms_checked['+counter+']" autocomplete="off" counter='+counter+' ></td>';
					
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");		
					$("#diagnosisfrm").validationEngine('attach'); 			 			 
					counter++;
					if(counter > 0) $('#removeButton').show('slow');
			     });
			     
			     $("#removeButton").click(function () {
						/*if(counter==3){
				          alert("No more textbox to remove");
				          return false;
				        }   */			 
						counter--;			 
				 
				        $("#DrugGroup" + counter).remove();
				 		if(counter == 0) $('#removeButton').hide('slow');
				  });
				  //EOF add n remove drug inputs
				
			 
				 
				function remove_icd(val){				
					var ids= $('#icd_ids').val();
					//alert(ids+'|'+val);
					tt = ids.replace(val+'|','');
					//alert(tt);
					$('#icd_ids').val(tt);
					$('#icd_'+val).remove();				
				}

				 jQuery("#patientnotesfrm").validationEngine();	
				 var condDischarge1=$('#condition_on_discharge').val();
				 if(condDischarge1=='satisfactory'){
				 	//$('#satisfactory_on_discharge').show();
				 }else{
					// $('#satisfactory_on_discharge').hide();
					 $('#satisfactory_on_discharge').val('');
				 }
				 $('#condition_on_discharge').click(function () {
					 var condDischarge=$(this).val();
					 if(condDischarge=='satisfactory'){
					 	//$('#satisfactory_on_discharge').show();
					 }else{
						// $('#satisfactory_on_discharge').hide();
						 $('#satisfactory_on_discharge').val('');
					 }
				 });
	});
	//script to include datepicker
		$(function() {
			$("#addButton").click(function(){
		        $(".start_date").datepicker({
		        	showOn: "both",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',
					minDate: new Date(),					
					dateFormat: '<?php echo $this->General->GeneralDate();?>', 
		        });
    		});
			$(".start_date").datepicker({
				showOn: "both",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				minDate: new Date(),
				dateFormat: '<?php echo $this->General->GeneralDate();?>',	
				
			});	
		  
			$( "#review_on" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy HH:II',
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				onSelect:function(){$(this).focus();}
			});

			$( ".surgery-date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy HH:II',
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				onSelect:function(){$(this).focus();}
			});

			//BOF fancybox for add more treatment during hospitalization
			$('#add-medicine').click(function(){
				    var patient_id = <?php echo $patient_id; ?> ;
					$.fancybox({
			            'width'    : '80%',
					    'height'   : '80%',
					    'autoScale': true,
					    'transitionIn': 'fade',
					    'transitionOut': 'fade',
					    'type': 'iframe',
					    'href': "<?php echo $this->Html->url(array("controller" => "billings", "action" => "notesadd")); ?>"+'/'+patient_id+'?page=discharge',
					    'onClosed': function () {window.location.reload();} 
				    });
					$(window).scrollTop(100);  
				    return false ;
			  });
			//EOF fancybox
								
			$('.currentRemoveIns').click( function() {
				if(confirm("Do you really want to delete this Medication?")){
				currentId=$(this).attr('id'); 
				splitedId=currentId.split('_');
				ID=splitedId['1'];
				//console.log(ID);
				var MedId=$('#MedId_'+ID).val();
				//console.log(MedId);
				$("#NoteDiv_"+ID).remove();	
				if(MedId)delete_item('med',MedId);
				}else{
					return false;
				}			
			});
			  
		});

		  //*********************************************Ajax call to delete Items of all type***************************************
	       function delete_item(modelName,preRecordId){ 
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "billings", "action" => "deleteItems","admin" => false)); ?>"+"/"+modelName+"/"+preRecordId;
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
	
	
	
	<script>
	<!--changes done  by Pooja Charde-->
	
function saveContent() {
    // Get content from the editable div
    let content = document.getElementById("present-cond_desc").innerHTML;
    
    // Set the content into the hidden textarea before form submission
    document.getElementById("present_condition_hidden").value = content;
}

// Ensure the div retains data after form submission
document.addEventListener("DOMContentLoaded", function() {
    let textareaContent = document.getElementById("present_condition_hidden").value;
    if (textareaContent.trim() !== "") {
        document.getElementById("present-cond_desc").innerHTML = textareaContent;
    }
});
</script>
<!--changes done  by Pooja Charde-->
<script>
    $(document).ready(function () {
        $('#mode_of_discharge').change(function () {
            var mode = $(this).val();
            if (mode === 'DAMA') {
                $('#condition_on_discharge').val('unsatisfactory'); // "Unsatisfactory" auto-select hoga
            } else {
                $('#condition_on_discharge').val('satisfactory'); // "Satisfactory" auto-select hoga
            }
        });
    });
</script>
