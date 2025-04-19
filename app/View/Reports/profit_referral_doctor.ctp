<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css'/*,'jquery.autocomplete.css'*/,'tooltipster.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js'/*,'jquery.autocomplete.js'*/,'jquery.tooltipster.min.js')); ?>
   
 <style>
 .vitalImage {
  background:url("<?php echo $this->webroot ?>img/icons/vital_icon.png") no-repeat center 2px;  
  cursor: pointer;
}
.textBoxExpndd {
    background: rgba(0, 0, 0, 0) -moz-linear-gradient(center top , #f1f1f1, #fff) repeat scroll 0 0 !important;
    border: 1px solid #214a27;
    color: #000;
    font-size: 13px;
    height: 23px;
    line-height: 20px;
    outline: 0 none;
    resize: none;
    width: 90.3%;
}
 </style>
 
 <script>
	$( document ).ready(function () {
		$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});
	});
</script>
<div class="clr ht5"></div>
 <div class="clr ht5"></div>
 <div class="inner_title">
	<h3>
		<?php echo __('Profit Report', true); ?>
	</h3>
    <div style="float:right;">
				<span style="float:right;">
				
				<?php		//echo $this->Form->submit(__('Generate Excel Report'),array( 'id'=>'','controller'=>'Reports','action'=>'profit_referral_doctor_xls','style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false));
			/* echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	 */	
					?>
		</span>
	</div>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('profitReferralDoctorfrm',array('type' => 'get','url'=>array('controller'=>'Reports','action'=>'profit_referral_doctor','admin'=>false),'id'=>'profitReferralDoctorfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			)); ?>
			  
<table border="0"  cellpadding="0" valign="top"
	cellspacing="0" width="100%" align="center">
	<tr width="50%" >
		<td width="19%"><?php
			echo __("Patient Name:")."&nbsp;".$this->Form->input('lookup_name', array('id' =>'lookup_name','placeholder'=>'Select Patient','value'=>$this->params->query['lookup_name'],'class'=>'textBoxExpndd','label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px;'));
			echo $this->Form->hidden('pid', array('label'=>false,'id'=>'pid','value'=>$this->params->query['pid']));?>
			
		</td>
		
		<!--  <td  width="9%"> 
		<?php  echo "Team:".$this->Form->input('Consultant.market_team',array('empty'=>__('Please Select'),'options' =>$marketing_teams,'label'=>false ,'class'=>'textBoxExpnd','id'=>'team' ,'value'=>$this->params->query['market_team']));?>
		</td>-->
		<td width="12%" ><?php echo $this->Form->input('dateFrom1',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom1",'autocomplete'=>'off','label'=>false,'div'=>false,'value'=>$this->params->query['dateFrom1'],'name'=>'dateFrom1','placeholder'=>'Date from'));?>
		</td>
		<td width="12%" ><?php echo $this->Form->input('dateTo1',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo1",'autocomplete'=>'off','label'=>false,'div'=>false,'value'=>$this->params->query['dateTo1'],'name'=>'dateTo1','placeholder'=>'Date To'));?>
		</td>
		<td  width="9%"> 
		<?php  echo $this->Form->input('type',array('empty'=>__('Select Payment'),'options' =>array('S'=>'Spot','B'=>'Backing','Both'=>'Both'),'label'=>false ,'class'=>'textBoxExpnd','id'=>'v_type','value'=>$this->params->query['type']));?>
		</td>
		<!--  <td  width="12%" ><?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",'value'=>$this->params->query['dateFrom'],'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'B Date From'));?>
		</td>	
				<td  width="12%" >	<?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",'value'=>$this->params->query['dateTo'],'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'B Date To')); ?></td>
		-->
		<td width="7%"><div style="text-align:center;">	
			<?php echo $this->Form->submit(__('Search'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));?>
		</td>
		<td width="2"><?php 
			echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'profit_referral_doctor'),array('escape'=>false, 'title' => 'refresh'));?> 
        </td>
        </td>
        <td style="float: right"><?php 
			echo  __("Doctor Name :")."&nbsp;".$this->Form->input('', array('name'=>'first_name_search','value'=>$this->params->query['first_name_search'],'type'=>'text','class'=>'textBoxExpndd','id' =>'first_name_search','style'=>'width:130px;','autocomplete'=>'off')); 
			echo $this->Form->hidden('doctorId', array('label'=>false,'id'=>'doctorId','value'=>$this->params->query['doctorId']));
			?>
		</td>
		<td width="7%"><div style="text-align:center;">	
			<?php echo $this->Form->submit(__('Search'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));?>
		</div>
        <td width="2"><?php 
			echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'profit_referral_doctor'),array('escape'=>false, 'title' => 'refresh'));?> 
        </td>
	</tr>
	</table> 
	<?php echo $this->Form->end(); ?>
<div class="clr ht5"></div>
<?php if(!empty($patientData)){
 ?>
 <div style="float: left;max-height:500px;overflow:scroll;">   
 <table width="100%" valign="top" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable  sticky" id="item-row"
	style="height: 390px; overflow: scroll;"><!--style="border-bottom:solid 10px #E7EEEF;" -->
<!--<table 
	class="tabularForm labTable resizable sticky" id="item-row"
	style="height: 390px; overflow: scroll;"></table>  $this->Paginator->sort-->
	<tr class="light fixed"> 
		<th width="12%" align="center" valign="top" style="text-align: center;;">Referral Doctor Name</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;"> <?php echo  __('PatientName') .'<br>'.'sex/age';?></th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Address <br> City <br> Payer</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Admission Date <br> Discharge Date</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Marketing Team </th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Is Amount Paid? </th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Spot Amt </th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Spot Payment date </th>
		<th width="20%" align="center" valign="top" style="text-align: center;;">B Amt </th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">B Payment Date </th>
		<th width="10%" align="center" valign="top" style="text-align: center;;">Discount Given </th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Total Bill Paid By Patient</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Total Bill Excluding Expenses</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Referal Profit Percent</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Referal Profit Amount</th>
		<th width="10%" align="center" valign="top" style="text-align: center;">Profit Amount</th> 
		
	</tr> 
	<?php
   $toggle =0;
      if(count($patientData) > 0) {
      	$totalprofit = 0;
      	
       foreach($patientData as $personval){
		$getexcludingExpProfit=0;$ss='';$getProfitPer=0;$getexcludingExp=0;
       $cnt++;
       
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
    <td align="center">
    	<?php echo $personval['referal'];

    	if($personval['referal']=='Direct'){
			$disabled='disabled';
		}else{
			$disabled='';
		}?>
	</td>
    <td align="center">
   		<?php echo $personval['name'].'<br>';?>
		   <?php 
				if($personval['dob'] == '0000-00-00' || $personval['dob'] == ''){
			$age = "";
		}else{
			$date1 = new DateTime($personval['dob']);
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
			$date1_explode = explode("-",$personval['dob']);
			$person_age_year =  $interval->y . " Year";
			$personn_age_month =  $interval->m . " Month";
			$person_age_day = $interval->d . " Day";
			if($person_age_year == 0 && $personn_age_month > 0){
				$age = $interval->m ;
				if($age==1){
					$age=$age . "M";
				}else{
					$age=$age . "M";
				}
			}else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
				$age = $interval->d . " " + 1 ;
				if($age==1){
					$age=$age . "D";
				}else{
					$age=$age . "D";
				}
			}else{
				$age = $interval->y;
				if($age==1){
					$age=$age . "Y";
				}else{
					$age=$age . "Y";
				}
			}
		}//Gender
		if(strtolower($personval['sex'])=='male'){
			$sex= "M";
		}else if(strtolower($personval['sex'])=='female'){
			$sex= "F";
		}else{
			$sex= "Others";
		} 	
		echo $sex.$age;
		?>
    </td>
     <td  align="center" >
		<?php 
		echo $personval['address'].'<br>'.$personval['city'].'<br>'.$personval['tariff_type'];?>
    </td>
     <td  align="center">
 					<?php  $admissDate= $personval['admission_date'];
						echo $this->DateFormat->formatDate2Local($admissDate,Configure::read('date_format'));
						?>
					<?php
						 $disDate = $personval['discharge_date'];
						 echo  $this->DateFormat->formatDate2Local($disDate,Configure::read('date_format'));
						?>
		</td>
     <td  align="center" >
    <?php 
 
    echo $personval['team'];?> </td>
    <td  align="center" > 
    
   <?php   
        if(!empty($personval['paid_amt']))
        {
		 $Yes="Yes"; 
		}
		else{	 	
		     $Yes="No";
	        }
  		echo $this->Form->input('Patient.selection', array('type' => 'select','id'=>$personval['id'],'class'=>'assigned','options' => array('Yes'=>'Yes','No'=>'No'),'selected'=>$Yes , 'label'=>false ,'div'=>false));?> 
    	  </td>
    <td  align="center">
    <?php 

    if($personval['is_approved']){
    	$disabled='disabled';
    	$checked='checked';
    }else{
    	$disabled='';
    	$checked='';
    }
    
 if($personval['type']=='S'){
    	echo 	$personval['paid_amt'].'<br>';
    	$val=$val+ $personval['paid_amt'];
    	echo $this->Form->input('Approved', array('type' => 'checkbox',$checked,$disabled,'class' =>'approved','id'=>'approved_'.$personval['patient_id']."_".$personval['spot_approval_id'],'label' => false,'legend' => false));
	 }else{
			echo '0'.'<br>';;
	 }
    
     ?>		
 </td>
 
  <td  align="center" >
					<?php 
					if($personval['type']=='S'){
							$ss = $personval['voucher_date'];
							echo  $this->DateFormat->formatDate2Local($ss,Configure::read('date_format'));
						  }else{
							echo '--';
						  }
						?>
						</td> 
    <td  align="center" >
    <?php // echo $this->Form->input('b_amount', array('id'=>'bAmt_'.$patient_id,'type' => 'text','label'=>false ,'style'=>"width:100%;",$disabled,'div'=>false,'style'=>"width: 100%;",'class'=>'add_b_amount','value'=>$personval['b_amt']));
				if($personval['type']=='B'){
			    	echo 	$personval['paid_amt'].'<br>';; 
			    	$val1=$val1+ $personval['paid_amt'];
			    	echo $this->Form->input('Approved', array('type' => 'checkbox',$checked,$disabled,'class' =>'approved','id'=>'approved_'.$personval['patient_id']."_".$personval['spot_approval_id'],'label' => false,'legend' => false));
				 }else{
						echo '0'.'<br>';;
				 }
				//echo $this->Form->input('status', array('type' => 'checkbox','class' =>'update_status','id'=>'status_'.$personval['id'],'label' => false,'legend' => false)); ?>
		  </td>
     <td  align="center" >
   
					<?php if($personval['type']=='B'){
							$bb = $personval['voucher_date'];
							echo  $this->DateFormat->formatDate2Local($bb,Configure::read('date_format')); 
						  }else{
							echo '--'.'<br>';;
				 		  }?>
 </td>
      <td  align="center">
   <?php  echo $billData['Bill'][$personval['patient_id']]['discount'];
					?>
 </td>
  
  <td  align="right"><?php 
					  if(!empty($billData['Bill'][$personval['patient_id']]['amount_paid'])){
					   echo $this->Number->format(round($billData['Bill'][$personval['patient_id']]['amount_paid']));
					  }else{
						echo '0';
					  } 
					  $totpatPaid[$personval['patient_id']]=$billData['Bill'][$personval['patient_id']]['amount_paid'];?> </td>
		<td  align="right" ><?php 
								if(!empty($billData['Bill'][$personval['patient_id']]['amount_paid'])){
									//$getDiff = paid_amnt - pharmacy_charges
									$getDiff=$billData['Bill'][$personval['patient_id']]['amount_paid']-$billData['Bill'][$personval['patient_id']]['pharmacyCharges'];
									//finalDiff = $getDiff - (radiology+labcharges)
									$getDiffFinal=$getDiff-($billData['Bill'][$personval['patient_id']]['radCharges']+
															$billData['Bill'][$personval['patient_id']]['labCharges']
															);
									
									$getexcludingExp=$getDiffFinal-$billData['Bill'][$personval['patient_id']]['BloodImplantCharges'];
   										echo $this->Number->format(round($getexcludingExp));   										
 									 }else{
										echo '0';
									}
									$totExcExp[$personval['patient_id']]=$getexcludingExp;
									if(!empty($billData['Bill'][$personval['patient_id']]['pharmacyCharges']))									
										$toolTip.='<b>Phamacy- </b>'.$billData['Bill'][$personval['patient_id']]['pharmacyCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['radCharges']))
										$toolTip.='<b>Radiology- </b>'.$billData['Bill'][$personval['patient_id']]['radCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['labCharges']))
										$toolTip.='<b>Laboratory- </b>'.$billData['Bill'][$personval['patient_id']]['labCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['BloodImplantCharges']))
									
									if($toolTip=='')
										$toolTip='Direct Patient';
									?>
									
									<span valign="middle" class="td_ht tooltip" title="<?php echo $toolTip ?>" ><?php echo $this->Html->image('/img/icons/vital_icon.png')?></span> </td>
									<?php $toolTip='';?>
									<td  align="right"><?php if(!empty($personval['referal_percent'])){
														$getProfitPer=$getexcludingExp*($personval['referal_percent']/100);
														echo $personval['referal_percent'].'%';
													}
								
								 	?> </td>
									 <td  align="right"><?php if(!empty($personval['referal_percent'])){
																$getProfitPer=$getexcludingExp*($personval['referal_percent']/100);
																echo $this->Number->format(round($getProfitPer));
															  }else{
																	echo '0';
															  }
															  
									 ?> </td>
										<td  align="right"><?php if($getexcludingExp){
											$getexcludingExpProfit=$getexcludingExp-
											($billData['Bill'][$personval['patient_id']]['visitCharges']+
												$billData['Bill'][$personval['patient_id']]['surgeonCharges']+
												$billData['Bill'][$personval['patient_id']]['anaesthesiaCharges']/*+
												$personval['spot_amt']+$personval['b_amt']*/);
											echo $this->Number->format(round($getexcludingExpProfit));
										}else echo '0';
										if(!empty($billData['Bill'][$personval['patient_id']]['visitCharges']))									
										$extraToolTip.='<b>Visit charges- </b>'.$billData['Bill'][$personval['patient_id']]['visitCharges'].'<br>';
										if(!empty($billData['Bill'][$personval['patient_id']]['surgeonCharges']))
											$extraToolTip.='<b>Surgeon charges- </b>'.$billData['Bill'][$personval['patient_id']]['surgeonCharges'].'<br>';
										if(!empty($billData['Bill'][$personval['patient_id']]['anaesthesiaCharges']))
											$extraToolTip.='<b>Anaesthesia charges- </b>'.$billData['Bill'][$personval['patient_id']]['anaesthesiaCharges'].'<br>';
										/*if(!empty($personval['spot_amt']))
											$extraToolTip.='<b>S amount- </b>'.$personval['spot_amt'].'<br>';
										if(!empty($personval['b_amt']))
											$extraToolTip.='<b>b amount- </b>'.$personval['b_amt'].'<br>';*/
										if(empty($extraToolTip)){
											$extraToolTip='No Deductions';
										}
									?>
										<span valign="middle" class="td_ht tooltip" title="<?php echo $extraToolTip ?>" ><?php echo $this->Html->image('/img/icons/vital_icon.png')?></span> </td>
																			<?php $extraToolTip='';?>
										<?php  $totalprofit = $getexcludingExpProfit;
								       $total[$personval['patient_id']]=$totalprofit;
								
									 ?>
									 </td>
									 
  								</tr> 
  
  <?php }  
  $queryStr = $this->General->removePaginatorSortArg($queryString);  //for sort column
  $queryStr['from_date'] = $this->DateFormat->formatDate2STDForReport($queryStr['from_date'],Configure::read('date_format'))." 00:00:00";
  $queryStr['to_date'] = $this->DateFormat->formatDate2STDForReport($queryStr['to_date'],Configure::read('date_format'))." 23:59:59"; ?>
  
  <tr> 
	<td  align="center"style="text-align: center;font-weight:bold;"colspan="6">Actual  Amount Receivable </td>			
	<td   align="center"style="text-align: center; font-weight: bold;">
		<?php echo $val ?></td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  echo $val1?>	</td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php foreach($totpatPaid as $tpaid){
			$totalpaid=$totalpaid+$tpaid;
		} 
		 echo $this->Number->format(round($totalpaid)); ?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  foreach($totExcExp as $texp){
			$totalExp=$totalExp+$texp;
		} 
		echo $this->Number->format(round($totalExp));?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>	
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>
    <td  align="center"style="text-align: center;font-weight:bold;">
		<?php foreach($total as $tAmt){
			$totalVal=$totalVal+$tAmt;
		}
		  echo $this->Number->format(round($totalVal)); ?>	</td>
	</tr>
		 
  <?php
      } ?> 
</table>
<?php  } else{   	
  ?>
  <tr>
   <TD colspan="4" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php }?>
<script>
jQuery(document).ready(function(){

$(".approved").click(function(){
	var id = $(this).attr('id');  
	splittedId = id.split("_"); 
	pId = splittedId[1]; 
	vId = splittedId[2];
	 if($(".approved").is(':checked')){
		 $(this).attr('disabled',true);
		$.ajax({
			  type : "POST",
			  //data: 'pid='+pId+"&vId="+vId,
			  url: "<?php echo $this->Html->url(array("controller" => 'reports', "action" => "getspotdata")); ?>"+"/"+pId+"/"+vId,
			 success: function(data){

			 }
		});
	 }
			
	});
$("#dateFrom").datepicker
({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#dateTo").datepicker
 ({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});
$("#dateFrom1").datepicker
({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#dateTo1").datepicker
 ({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	}); 


$('.filter').change(function()	//.checkMe is the class of select having patient's id as the id
	{
		var team = $('#team').val(); 
		//alert(team);
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Reports', "action" => "profit_referral_doctor", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '?market_team=' + team,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$("#container").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
		});
	});


$( ".status_update" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDischargeDate", "admin" => false));?>",
   			data:'id='+splittedId[2]+"&date="+date,
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});
  

	
$(function() {
		/* $("#first_name_search").autocomplete("<?php echo $this->Html->url(array("controller" => "Consultants", "action" => "autocompelete_consultant","admin" => false,"plugin"=>false)); ?>", {
			width: 250, selectFirst:true });*/
});


$("#first_name_search").autocomplete({
	source:"<?php echo $this->Html->url(array("controller" => "Consultants", "action" => "fetch_consultatnt","first_name","admin" => false,"plugin"=>false)); ?>",
	select:function (event, ui) {
		console.log(ui);
		$("#doctorId").val(ui.item.id);
	},
	 messages: {
        noResults: '',
        results: function() {}
	 }	
});

$("#lookup_name").autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name","admin" => false,"plugin"=>false)); ?>",
	select:function( event, ui ) { 						
		//$("#serviceID").val(ui.item.id);								
		//$('#service_group_id').val(ui.item.service_category_id).attr("selected", "selected");	
	},
	messages: {
        noResults: '',
        results: function() {}
	 }
	});

$(function(){
	/* $("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
{
		width: 80,
		selectFirst: true
	}); */
});

});



</script>