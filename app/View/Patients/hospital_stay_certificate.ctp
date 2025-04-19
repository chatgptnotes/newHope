<style>

.message{
	
	font-size: 15px;
}
.table_format {
    padding: 3px !important;
    width: 60%;
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
</style> 

<div class="Row inner_title" style="float: left; width: 100%; clear:both">
		<div style="font-size: 20px; font-family: verdana; color: darkolivegreen;" >			 
			<?php echo "Hospital Stay Certificate" ;?>
		</div>
	<span>
	<?php echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
	<?php if($stayData['HospitalStayCertificate']['id'] !='') { 
		echo $this->Html->link(__('Print Preview'),'#',
		     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'hospital_stay_certificate',$patient['Patient']['id'],'print'))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    
    }?>
	</span>
</div>


<p class="ht5"></p> 


<?php
echo $this->Form->create('HospitalStayCertificate',array('type' => 'file','id'=>'ClaimSubmitForm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('id',array('id'=>'recId','value'=>$stayData['HospitalStayCertificate']['id'],'autocomplete'=>"off"));
echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$patient['Patient']['id'],'autocomplete'=>"off"));


$admission_date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
$discharge_date= $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),true);

$unserData = unserialize($stayData['HospitalStayCertificate']['stay_info']);

?>

<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
	<tr>
		<td style="text-align: center;"><h3><u>रूग्णालयातील वास्तव्याचा दाखला</u></h3></td>
	</tr>
	<tr>
		<td><p>याद्वारे असे प्रमाणित करण्यात येते की

			 <?php echo $this->Form->input('StayInfo.sponsor_company',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['sponsor_company'])); ?>  येथे  

			<?php echo $this->Form->input('StayInfo.patient_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['patient_name']));; ?> या पदावर नोकरीत असलेल्या व 

			<?php echo $this->Form->input('StayInfo.address',array('type'=>'text','label'=>false,'div'=>false,'value'=>strip_tags($formatted_address))); ?> या पत्त्यावर राहणाऱ्या श्री / श्रीमती / कुमारी 

			<?php echo $this->Form->input('StayInfo.name_of_employeee',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['name_of_ip']));; ?> यांची / यांचा / पत्नी / पती / मुलगा / मुलगी / वडील / आई / सासु / सासरे श्री /श्रीमती 

			<?php echo $this->Form->input('StayInfo.candidate_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['lookup_name']));;; ?> यांच्यावर/ हिच्यावर दि.

			<?php echo $this->Form->input('StayInfo.admission_date',array('type'=>'text','label'=>false,'div'=>false,'id'=>'admission_date','value'=>$admission_date)); ?>  पासुन 

			<?php echo $this->Form->input('StayInfo.discharge_date',array('type'=>'text','label'=>false,'div'=>false,'id'=>'discharge_date','value'=>$discharge_date)); ?> 

			पर्यंत या रूग्णालयात औषधोपचार घेतला आहे </p></td>
	</tr>

</table>
<table class="" border="1" cellpadding="3" cellspacing="1" width="60%" align="center">

	<tr>
		<td>अ.क्र</td>
		<td>वॉर्ड</td>
		<td>दर</td>
		<td>दिवस</td>
		<td>एकूण रूपये</td>
	</tr>
	<?php 
			$generalRate = ($unserData['general_rate'] ) ? $unserData['general_rate'] : $customArray['4000']['rate']  ;
			$generalQty =  ($unserData['general_days'] ) ? $unserData['general_days'] : $customArray['4000']['qty']   ;
			$generalTot = $generalRate * $generalQty ;
			$generalTotal =  ($unserData['general_total'] ) ? $unserData['general_total'] : $generalTot  ;

			$icuRate = ($unserData['icu_room_rate'] ) ? $unserData['icu_room_rate'] : $customArray['7500']['rate']  ;
			$icuQty =  ($unserData['icu_room_days'] ) ? $unserData['icu_room_days'] : $customArray['7500']['qty']   ;

			$icuTot = $icuRate * $icuQty ;
			$icuTotal =  ($unserData['icu_room_total'] ) ? $unserData['icu_room_total'] : $icuTot  ;


			$icuWithVentiRate = ($unserData['icu_room_venti_rate'] ) ? $unserData['icu_room_venti_rate'] : $customArray['9000']['rate']  ;
			$icuWithVentiQty =  ($unserData['icu_room_venti_days'] ) ? $unserData['icu_room_venti_days'] : $customArray['9000']['qty']   ;

			$icuWithVentiTot = $icuWithVentiRate * $icuWithVentiQty ;
			$icuWithVentiTotal =  ($unserData['icu_room_venti_total'] ) ? $unserData['icu_room_venti_total'] : $icuWithVentiTot  ;

	?>
	<tr>
		<td>१</td>
		<td>जनरल वॅार्ड</td>
		<td><?php echo $this->Form->input('StayInfo.general_rate',array('class'=>'wardRate','id'=>'wardRate_1','type'=>'text','label'=>false,'div'=>false,'value'=>$generalRate)); ?></td>
		<td><?php echo $this->Form->input('StayInfo.general_days',array('class'=>'wardDays','id'=>'wardDays_1','type'=>'text','label'=>false,'div'=>false,'value'=>$generalQty)); ?></td>
		<td><?php echo $this->Form->input('StayInfo.general_total',array('class'=>'wardTotal','id'=>'wardTotal_1','type'=>'text','label'=>false,'div'=>false,'value'=>$generalTotal)); ?></td>
	</tr>

<tr>
		<td>२</td>
		<td>जनरल वॅार्डच्या बाजुला बाथरूम नसलेला कक्ष</td>
		<td><?php echo $this->Form->input('StayInfo.general_without_bathroom_rate',array('class'=>'wardRate','id'=>'wardRate_2','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['general_without_bathroom_rate'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.general_without_bathroom_days',array('class'=>'wardDays','id'=>'wardDays_2','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['general_without_bathroom_days'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.general_without_bathroom_total',array('class'=>'wardTotal','id'=>'wardTotal_2','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['general_without_bathroom_total'])); ?></td>
	</tr>

<tr>
		<td>३</td>
		<td>बाथरूमसह स्वतंत्र कक्ष</td>
		<td><?php echo $this->Form->input('StayInfo.private_with_bathroom_rate',array('class'=>'wardRate','id'=>'wardRate_3','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['private_with_bathroom_rate'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.private_with_bathroom_days',array('class'=>'wardDays','id'=>'wardDays_3','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['private_with_bathroom_days'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.private_with_bathroom_total',array('class'=>'wardTotal','id'=>'wardTotal_3','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['private_with_bathroom_total'])); ?></td>
	</tr>

	<tr>
		<td>४</td>
		<td>बाथरूमसह डबल बेडचा कक्ष</td>
		<td><?php echo $this->Form->input('StayInfo.double_bed_with_bathroom_rate',array('class'=>'wardRate','id'=>'wardRate_4','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['double_bed_with_bathroom_rate'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.double_bed_with_bathroom_days',array('class'=>'wardDays','id'=>'wardDays_4','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['double_bed_with_bathroom_days'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.double_bed_with_bathroom_total',array('class'=>'wardTotal','id'=>'wardTotal_4','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['double_bed_with_bathroom_total'])); ?></td>
	</tr>

	<tr>
		<td>५</td>
		<td>बाथरूमसह वातानुकूलीत कक्ष</td>
		<td><?php echo $this->Form->input('StayInfo.air_conditionar_with_bathroom_rate',array('class'=>'wardRate','id'=>'wardRate_5','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['air_conditionar_with_bathroom_rate'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.air_conditionar_with_bathroom_days',array('class'=>'wardDays','id'=>'wardDays_5','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['air_conditionar_with_bathroom_days'])); ?></td>
		<td><?php echo $this->Form->input('StayInfo.air_conditionar_with_bathroom_total',array('class'=>'wardTotal','id'=>'wardTotal_5','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['air_conditionar_with_bathroom_total'])); ?></td>
	</tr>
	<tr>
		<td>६</td>
		<td>अतिदक्षता कक्ष</td>
		<td><?php echo $this->Form->input('StayInfo.icu_room_rate',array('class'=>'wardRate','id'=>'wardRate_6','type'=>'text','label'=>false,'div'=>false,'value'=>$icuRate)); ?></td>
		<td><?php echo $this->Form->input('StayInfo.icu_room_days',array('class'=>'wardDays','id'=>'wardDays_6','type'=>'text','label'=>false,'div'=>false,'value'=>$icuQty)); ?></td>
		<td><?php echo $this->Form->input('StayInfo.icu_room_total',array('class'=>'wardTotal','id'=>'wardTotal_6','type'=>'text','label'=>false,'div'=>false,'value'=>$icuTotal)); ?></td>
	</tr>
	<?php if(!empty($icuWithVentiRate)){ ?>
	<tr>
		<td>७</td>
		<td>अतिदक्षता कक्ष (आय.सी.यु)</td>
		<td><?php echo $this->Form->input('StayInfo.icu_room_venti_rate',array('class'=>'wardRate','id'=>'wardRate_6','type'=>'text','label'=>false,'div'=>false,'value'=>$icuWithVentiRate)); ?></td>
		<td><?php echo $this->Form->input('StayInfo.icu_room_venti_days',array('class'=>'wardDays','id'=>'wardDays_6','type'=>'text','label'=>false,'div'=>false,'value'=>$icuWithVentiQty)); ?></td>
		<td><?php echo $this->Form->input('StayInfo.icu_room_venti_total',array('class'=>'wardTotal','id'=>'wardTotal_6','type'=>'text','label'=>false,'div'=>false,'value'=>$icuWithVentiTotal)); ?></td>
	</tr>
	<?php } ?>

	 <tr>
        <td colspan="4" style="text-align: center;">Total</td>
        <td><?php 
        echo $this->Form->input('StayInfo.total_amount',array('class'=>'total_amount','id'=>'total_amount','type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['total_amount'])); ?></td>
    </tr>
</table>
<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
	<tr>
		<td>----------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
	</tr>
</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
	<tr>
		<td style="text-align: center;"><h3><u>अति आवश्यक प्रमाणपत्र</u></h3></td>
	</tr>
	<tr>
		<td><p>श्री / श्रीमती / कुमारी 

			<?php echo $this->Form->input('StayInfo.patient_name_2',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['lookup_name']));; ?> यांना 

			<?php echo $this->Form->input('StayInfo.hospital_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$this->Session->read('facility'))); ?> या रूग्णालयात 

			<?php echo $this->Form->input('StayInfo.admit_date',array('type'=>'text','label'=>false,'div'=>false,'id'=>'admit_date','value'=>$admission_date)); ?> रोजी तपास असता, त्यांचावर तातडीने 

			<?php echo $this->Form->input('StayInfo.diagnosis',array('type'=>'text','label'=>false,'div'=>false,'id'=>'','value'=>$unserData['diagnosis'])); ?> 

			या कारणासाठी उपचार करण्यासाठी रूग्णालयात दाखल करणे आवश्यक  होते.</p>

			<p>
				प्रमााणित करण्यात येते की, 
				<?php echo $this->Form->input('StayInfo.patient_name_3',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['lookup_name']));; ?>

				यांना रूग्णलयात अति तात्काळ रित्या दाखल केले असता शश्त्रक्रियेकरिता / उपचाराकरिता आवश्यक  असलेली साधने/ उपकरण/ साहित्य ही त्यांचेकरिता आवश्यक  होती ( उदा :— डिस्पोसेल सिरींज, व आयव्ही ) व ती त्यांनाच वापरली असून त्याचा पुन्हा उपयोग होत नाही अथवा केला जात नाही. तसेच, त्यांना दिलेल्या औषधांमध्ये मादक पदार्थ, अल्कोहोल, प्रथिने अन्नघटक (शक्तिवर्धक) या औषधांचा समावेश  करण्यात आलेला नाही 
			</p>
		</td>
	</tr>

</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
	<tr>
		<td><?php	
				echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'saveBtn','style'=>'float:right'));?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
		

<script>
$(document).ready(function(){

	// binds form submission and fields to the validation engine
	$(document).on('click',"#saveBtn",function(){
		var validateForm = $("#ClaimSubmitForm").validationEngine('validate');

		if (validateForm == true)
		{
			$("#saveBtn").hide();
		}else{

			$("#saveBtn").show();
			return false;
		}

	});
	
 	$("#admission_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
       dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	$("#discharge_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	$("#admit_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	$(document).on('keyup','.wardRate,.wardDays',function(){
		var id = $(this).attr('id').split('_')[1];
		var rate = ($('#wardRate_'+id).val()) ? $('#wardRate_'+id).val() : 0 ;
		var days = ($('#wardDays_'+id).val()) ? $('#wardDays_'+id).val() : 0 ;

		var total = rate *  days ;

		$('#wardTotal_'+id).val(total);
		tot = 0;
		$( ".wardTotal" ).each(function( index ) {	
			var amnt = (parseFloat($(this).val())) ? parseFloat($(this).val()) : 0 ;
			tot += amnt ; 
		});
		console.log(tot);	
		if(!isNaN(tot)){
			$("#total_amount").val(tot);
		}else{
			$("#total_amount").val('');
		}
		
	});

	tot = 0;
	$( ".wardTotal" ).each(function( index ) {	
			var amnt = (parseFloat($(this).val())) ? parseFloat($(this).val()) : 0 ;
			tot += amnt ; 
		});
	console.log(tot);	
	if(!isNaN(tot)){
		$("#total_amount").val(tot);
	}else{
		$("#total_amount").val('');
	}


	

});


</script>