
<style>
.light:hover {
	background-color: #F7F6D9;
	/* text-decoration:none;
	    color: #000000;  */
}

.labTable {
	width: 100%;
	display: block;
}

.Tbody {
	width: 100%;
	height: 250px;
	display: list-item;
	overflow: auto;
}

.opd {
	background-color: #A4D7F2
}

.ipd {
	background-color: #86EFC5
}

.tabularForm {
	background-color: none;
}
</style>
<?php
echo $this->Html->css ( array (
		'tooltipster.css'
) );
echo $this->Html->script ( array (
		'jquery.tooltipster.min.js'
) );

?>
<?php if(!empty($testOrdered)) { ?>
<table width="100%"
	cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row"
	style="overflow: scroll;">

<button id="downloadBtn" style=" background: green; color: white; ">Download Excel</button>
	<tr class="light fixed">
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Sr.No.</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Patient
			Info</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Incl.
			<?php echo $this->Form->input('incl_master',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'incl_master','class'=>'incl_master'));?>
		</th>
		<th align="center" valign="top"
			style="text-align: center; padding: 0px; padding-left: 5px; padding-right: 5px;">ReqNo.</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Svc.Type</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Services</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Req.By</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Date</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Status</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Sample
			Taken <?php

			echo $this->Form->input ( 'sample_master', array (
			'type' => 'checkbox',
			'div' => false,
			'label' => false,
			'id' => 'sample_master',
			'class' => 'sample_master'
	) );
	/* echo $this->Html->image ( 'barcode-icon.png', array (
	 'id' => 'bar_image'
	) ); */
	/*
	 * echo $this->Html->link($this->Html->image('barcode-icon.png','javascript:void(0)',array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'NewLaboratories','action'=>'printSample',1))."',
	 * '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;")));
	*/
	?>
		</th>
		<th
			style="text-align: center; padding: 0px; padding-left: 5px; padding-right: 5px; vertical-align: middle;"><label
			style="white-space: nowrap;" class="tooltip tooltipClassDyn"
			title="Bar Code"><?php echo $this->Html->image ( 'barcode-icon.png', array ('title'=>'Bar Code','alt'=>'Bar Code','id' => 'bar_image','style'=>'float:none;width:15px;height:25px;')); ?>
		</label></th>

		<!--
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Received <?php echo $this->Form->input('received_master',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'received_master','class'=>'received_master'));?></th>
		<th align="center" valign="top"
			style="text-align: center; padding: 0px; padding-left: 5px; padding-right: 5px;">Completed <?php echo $this->Form->input('complted_master',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'complted_master','class'=>'complted_master'));?></th>
		<th align="center" valign="top"
			style="text-align: center; padding: 0px; padding-left: 5px; padding-right: 5px;">Re-Test <?php echo $this->Form->input('retest_master',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'retest_master','class'=>'retest_master'));?></th>
		  -->
		<!--  <th width="1%" align="center" valign="top" style="text-align: center; max-width:'1%'; min-width:'1%';">&nbsp;</th>-->
		<!--
				<th width="5%" align="center" valign="top" style="text-align: center;">PayNow <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></th>
			-- >
		
	<!-- </thead> -->

	</tr>
	<!-- <tbody class="Tbody"> -->

	<?php
	$srno = $this->params->paging ['LaboratoryTestOrder'] ['limit'] * ($this->params->paging ['LaboratoryTestOrder'] ['page'] - 1);
	// $srno = 1;
	// debug($testOrdered);exit;
	foreach ( $testOrdered as $key => $value ) {
		$patientId = $value ['Patient'] ['id'];
		$patientName = $value ['Patient'] ['lookup_name'];
		$LabTestOrderId = $value ['LaboratoryTestOrder'] ['id'];
		$LabTestOrderPatientId = $value ['LaboratoryTestOrder'] ['patient_id'];
		$paid_amount = $value ['LaboratoryTestOrder'] ['paid_amount'];
		$amount = $value ['LaboratoryTestOrder'] ['amount'];
		$laboratoryID = $value ['Laboratory'] ['id'];
		if (! empty ( $paid_amount ) && $paid_amount > 0) {
			$disabled = false;
		} else {
			$disabled = true;
		}
		// For Status

		if (($value ['LaboratoryTestOrder'] ['showEdit']) && (! $value ['LaboratoryTestOrder'] ['received']) && ((! $value ['LaboratoryTestOrder'] ['completed']))) {
			$status = 'Sample Taken';
		} else if (($value ['LaboratoryTestOrder'] ['showEdit']) && ($value ['LaboratoryTestOrder'] ['received']) && ((! $value ['LaboratoryTestOrder'] ['completed']))) {
			$status = 'Received ';
		} else if (($value ['LaboratoryTestOrder'] ['showEdit']) && ($value ['LaboratoryTestOrder'] ['received']) && (($value ['LaboratoryTestOrder'] ['completed']))) {
			$status = 'Completed ';
		} else {
			$status = 'Pending ';
		}

		// toolTip
		$toolTip = '<b>Name: </b>' . $value ['Patient'] ['lookup_name'] . '</br>
					<b>Ward: </b>' . $value ['Ward'] ['name'] . '</br>
					<b>Romm: </b>' . $value ['Room'] ['name'] . '</br>
					<b>Bed No: </b>' . $value ['Room'] ['bed_prefix'] . ' ' . $value ['Bed'] ['bedno'] . '</br>';

		/* foreach($value['LaboratoryTestOrder'] as $subValue){ */
		?>
	<?php

	if ($value ['Patient'] ['admission_type'] == 'OPD') {
			$backGround = 'opd';
		} else {
			$backGround = 'ipd';
		}
		?>
	<tr class="<?php echo $backGround?>">
		<td align="center"><?php
		if ($lastPatientId != $patientId) {
			echo ++ $srno;
		}
		?>
		</td>
		<td><?php
		if ($lastPatientId != $patientId) {
			// $srno;
			?> <span class="tooltip lookupName" title="<?php echo $toolTip; ?>"  personId='<?php echo $value['Patient']['id']; ?>' style="cursor:pointer"> <?php echo $value['Patient']['lookup_name'] .'<br> ('. $value['Patient']['admission_id'] .')';?>
		</span> <?php } ?>
		</td>
		<?php

		if (($value ['LaboratoryTestOrder'] ['showEdit'])) {
			$disabledIncl = false;
		} else {
			$disabledIncl = true;
		}

		$labType = $value ['Laboratory'] ['lab_type'];
		?>
		<?php
		if($value['LaboratoryResult']['laboratory_test_order_id']){
			$imgTick = $this->Html->image ( '/img/icons/icon_tick.gif' );
			$isResult='Yes';
		} else {
			$imgTick = "";
			$isResult='No';
		}
		?>
		<td align="center">
			<div style="float: left">
				<?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'incl_'.$LabTestOrderId,'value'=>$LabTestOrderId,'class'=>'incl_checkbox','div'=>false,'label'=>false,'disabled'=>$disabledIncl,'lab_type'=>$labType,'patientId'=>$LabTestOrderPatientId,'isResult'=>$isResult));?>
			</div>
			<div style="float: right">
				<?php echo $imgTick?>
			</div>
		</td>
		<td align="center"><?php echo $value['LaboratoryTestOrder']['req_no'];?>
		</td>
		<td align="center"><?php echo __('LAB')?></td>
		<td><?php echo $value['Laboratory']['name'];//echo $subValue['id']?></td>
		<td><?php echo $value[0]['name']?></td>
		<td><?php
		// echo $this->DateFormat->formatDate2Local($subValue['start_date'],Configure::read('date_format'),true);
		echo $this->DateFormat->formatDate2Local ( $value ['LaboratoryTestOrder'] ['start_date'], Configure::read ( 'date_format' ), false );
		?></td>
		<td><?php echo __($status)?></td>
		<td align="center"><?php
		// privateTariffName
		/*
		 * if((strtolower($value['TariffStandard']['name']) == Configure::read('privateTariffName')) && ($value['Patient']['admission_type'] == 'OPD')){
		 * if(($paid_amount == $amount) && !$value['LaboratoryTestOrder']['showEdit'] ) {
		 * $disabledShowEdit = false; //ENABLE
		* }else if(($paid_amount == $amount) && ($value['LaboratoryTestOrder']['showEdit'])){
		 * $disabledShowEdit = true; //disable
		* }else{
		 * $disabledShowEdit = true; //disable
		* }
		* }else{
		*/
		/* if (($paid_amount == $amount) && ! $value ['LaboratoryTestOrder'] ['showEdit']) {
			$disabledShowEdit = false; // ENABLE
		} else if (($paid_amount == $amount) && ($value ['LaboratoryTestOrder'] ['showEdit'])) {
			$disabledShowEdit = true; // disable
		} else {
			$disabledShowEdit = true; // disable
		}
		$disabledShowEdit = false; // ENABLE */
		if (! $value ['LaboratoryTestOrder'] ['showEdit']) {
			$disabledShowEdit = false; // ENABLE
			$staken = 0;
		}else{
			$disabledShowEdit = true; // disable
			$staken = 1;
		}
		/* } */

		?> <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'value'=>$LabTestOrderId,'id'=>"sample_".$LabTestOrderId,'samTaken'=>$staken,'class'=>"sample_checkbox",'patientId'=>$patientId,'disabled'=>$disabledShowEdit,'checked'=>$value['LaboratoryTestOrder']['showEdit']));?>
		</td>
		<?php 
			if (($value ['LaboratoryTestOrder'] ['showEdit'])) {
				$disabledBarCode = false;
			} else {
				$disabledBarCode = true;
			}
			?>
		<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'value'=>$LabTestOrderId,'id'=>"barCode_".$LabTestOrderId,'class'=>"barCode",'patientId'=>$patientId ,'disabled'=>$disabledBarCode,'reqNo'=>$value['LaboratoryTestOrder']['req_no'],'disabled'=>$disabledBarCode));?>
		</td>
		<?php

		/* 	if (($value ['LaboratoryTestOrder'] ['showEdit']) && (! $value ['LaboratoryTestOrder'] ['received'])) {
			$disabledRecived = false;
		} else {
			$disabledRecived = true;
		} */
		?>
		<!--  	<td align="center">
				<?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'value'=>$LabTestOrderId,'id'=>"recv_".$LabTestOrderId,'class'=>"recv_checkbox",'patientId'=>$patientId,'disabled'=>$disabledRecived,'checked'=>$value['LaboratoryTestOrder']['received'],'identity'=>'received'));?>
			</td>-->
		<?php

		if (($value ['LaboratoryTestOrder'] ['received']) && (! $value ['LaboratoryTestOrder'] ['completed'])) {
			$disabledComplet = false;
		} else {
			$disabledComplet = true;
		}
		?>
		<!--  	<td align="center">
				<?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'value'=>$LabTestOrderId,'id'=>"complt_".$LabTestOrderId,'class'=>"complt_checkbox",'patientId'=>$patientId,'disabled'=>$disabledComplet,'checked'=>$value['LaboratoryTestOrder']['completed'],'identity'=>'completed'));?>
			</td>-->
		<?php

		if (($value ['LaboratoryTestOrder'] ['completed']) && ($value ['LaboratoryResult'] ['is_authenticate'] == 1)) {
			$disabledReTest = false; // enable
		} else {
			$disabledReTest = true; // disable
		}
		?>
		<!--  	<td align="center">
				<?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>"reTest_checkbox",'id'=>"reTest_".$LabTestOrderId,'value'=>$LabTestOrderId,'patientId'=>$patientId,'disabled'=>$disabledReTest));?>
			</td>-->
		<!--
				<td align="center" style="min-width:3%; max-width:3%;">
					<?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'value'=>$LabTestOrderId,'id'=>"payNow_".$LabTestOrderId,'class'=>'payNow_checkbox patientId_'.$patientId));?>
				</td>
			-->

		<?php

		echo $this->Form->hidden ( 'paid_amount', array (
				'value' => $paid_amount,
				'id' => 'paidAmount_' . $LabTestOrderId,
				'class' => 'paidAmount'
		) );
		echo $this->Form->hidden ( 'patient_id', array (
				'value' => $patientId,
				'id' => 'patientId_' . $LabTestOrderId,
				'class' => 'patientId'
		) )?>

	</tr>
	<?php
	$lastPatientId = $patientId;
	}
	?>
	<!-- </tbody> -->
</table>

<!--download excel @7387737062-->
<srcipt>
    <!--// Disable pagination to fetch all data-->

</srcipt>

<script>
$(document).ready(function () {
    $('#item-row').DataTable({
        "paging": false,  // Disable pagination to load all data
        "searching": false,
        "info": false
    });
});
    document.getElementById("downloadBtn").addEventListener("click", function () {
        var table = document.getElementById("item-row");
        var rows = table.rows;
        var csv = [];
        
        for (var i = 0; i < rows.length; i++) {
            var cols = rows[i].querySelectorAll("td, th");
            var rowData = [];
            for (var j = 0; j < cols.length; j++) {
                rowData.push(cols[j].innerText);
            }
            csv.push(rowData.join(",")); // Join each row with comma
        }

        // Create a CSV string
        var csvString = csv.join("\n");
        var blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
        
        // Create a link to download the CSV
        var link = document.createElement("a");
        var url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "table_data.csv");
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>


<table width="100%">
	<tr>
		<td colspan="4" align="center"><?php

		echo $this->Paginator->prev ( __ ( '« Previous', true ), array (
			'update' => '#records',
			'complete' => "onCompleteRequest('tabularForm','class');",
			'before' => "loading('tabularForm','class');"
	), null, array (
			'class' => 'paginator_links'
	) );
	?> <span class="paginator_links"> <?php  echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span> <?php

		echo $this->Paginator->next ( __ ( 'Next »', true ), array (
			'update' => '#records',
			'complete' => "onCompleteRequest('tabularForm','class');",
			'before' => "loading('tabularForm','class');"
	), null, array (
			'class' => 'paginator_links'
	) );

	echo $this->Js->writeBuffer ();
	?>
		</td>
	</tr>
</table>


<div class="clr ht5"></div>
<table align="center">
	<tr>
		<td>
		
	<?php
	if ($this->Session->read ( 'role' ) != 'External Radiologist'){ 
		echo $this->Html->link ( __ ( 'Entry Mode' ), 'javascript:void(0)', array (
			'id' => 'entryMode',
			'escape' => false,
			'class' => 'blueBtn'
		) ) . "&nbsp";
		echo $this->Html->link ( __ ( 'Save' ), 'javascript:void(0)', array (
				'escape' => false,
				'class' => 'blueBtn Save',
				'id' => 'save'
		) ) . "&nbsp";
	}
		echo $this->Html->link ( __ ( 'Print' ), 'javascript:void(0)', array (
				'id' => 'print',
				'escape' => false,
				'class' => 'blueBtn'
		) ) . "&nbsp";
	 
	?>
		</td>
	</tr>
</table>

<?php } else { echo "Sorry, No Record Found"; 
} ?>
<?php

echo $this->Form->create ( 'NewLaboratory', array (
		'controller' => 'new_laboratories',
		'action' => 'none',
		'id' => 'laboratoryFrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false
		)
) );
?>
<table>
	<tr>
		<td><?php echo $this->Form->input("labPostData",array('id'=>'labPostData','type'=>'hidden')) ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>


<script>
var barcodeDisabledArr = new Array();
var sampleDisabledArr = new Array();
var tempSample = "";
$(document).ready(function(){
	
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right",
 	});
	$("#save").removeClass("blueBtn");
    $("#save").addClass("grayBtn");
	$("#entryMode").removeClass("blueBtn");
    $("#entryMode").addClass("grayBtn");
    $("#print").removeClass("blueBtn");
    $("#print").addClass("grayBtn");
    /*
	$(function(){  //incl checkbox enable when sample checkbox get enables by user
		$(".sample_checkbox").click( function() {
			id = $(this).attr('id');
			new_id = id.split("_");
		    if (!$(this).is(":checked")){
		      $("#incl_"+new_id[1]).attr("disabled",true);
		      $("#incl_"+new_id[1]).prop("checked",false);
		    }
		    else{
		      $("#incl_"+new_id[1]).removeAttr("disabled");
		    }
		 });
	});
*/
	$(function(){  //incl checkbox enable when sample checkbox get enables by defualt checked 
		$(".sample_checkbox").each ( function() {
			id = $(this).attr('id');
			new_id = id.split("_");
		    if (!$(this).is(":checked")){
		      $("#incl_"+new_id[1]).attr("disabled",true);
		      $("#incl_"+new_id[1]).prop("checked",false);
		    }
		    else{
		      $("#incl_"+new_id[1]).removeAttr("disabled");
		    }
		 });
	});
	
	$(function(){  //enable pay bill if any pay now checkbox get checked
		$(".payNow_checkbox").click( function() {
			var checked = ''; 
			$(".payNow_checkbox").each(function(){
				if ($(this).is(":checked")){
					checked = 1;
					return false;
				}
			});
			if(checked == 1){
				$("#payBill").removeClass("grayBtn");
			    $("#payBill").addClass("blueBtn");
			}else{
				$("#payBill").removeClass("blueBtn");
			    $("#payBill").addClass("grayBtn");
			}
		 });
	});

	$(function(){	//slect/deselect all checkboxes
		$('#incl_master').click(function(event) {  		//on click
		    if(this.checked) { 							// check select status
		        $('.incl_checkbox').each(function() { 	//loop through each checkbox
		        	if($(this).attr('disabled') != 'disabled'){
	            		this.checked = true;  	
		        	}			//select all checkboxes with class "incl_checkbox"           
		        });
		    }else{
		        $('.incl_checkbox').each(function() { 	//loop through each checkbox
		            this.checked = false; 				//deselect all checkboxes with class "incl_checkbox"                      
		        });        
		    }
		});
	});

	$(function(){
		 $(".incl_checkbox").click(function () {
		     if (!$(this).is(":checked")){
		         $("#incl_master").prop("checked", false);
		     }else{
	         var flag = 0;
	         $(".incl_checkbox").each(function(){
	             if(!this.checked)
	             flag=1;
	         })             
		     	
		     }
		 });
	});

	$(function(){
		$(".incl_checkbox , .incl_master").click(function(){
			var checked ='';
			var chkHisto = new Array();
			var chkPatient = new Array();
			var chkRegular = new Array();
			var isRetest = false;
			$(".incl_checkbox").each(function(){
				if($(this).is(":checked")){
					checked = 1;
					return false;
				}
			});
			if(checked == 1){
				$("#entryMode").removeClass("grayBtn");
			    $("#entryMode").addClass("blueBtn");
			    $("#print").removeClass("grayBtn");
			    $("#print").addClass("blueBtn");

			    $("#save").removeClass("blueBtn");
			    $("#save").addClass("grayBtn");
			    
			}else{
				$("#entryMode").removeClass("blueBtn");
		    	$("#entryMode").addClass("grayBtn");
		    	$("#print").removeClass("blueBtn");
		    	$("#print").addClass("grayBtn");

		    	$("#save").removeClass("blueBtn");
			    $("#save").addClass("grayBtn");
			}

			$(".incl_checkbox").each(function(){
		    	
		        if( $(this).is(':checked')){
		        	chkPatient.push($(this).attr('patientId'));
		        	if($(this).attr('isRetest') == 'Yes')
		        		isRetest = true;
		        }
		        if($(this).is(':checked') && $(this).attr('lab_type') =='2'){
		        	chkHisto.push($(this).attr('lab_type'));
		        }
		        if($(this).is(':checked') && $(this).attr('lab_type') !='2'){
		        	chkRegular.push($(this).attr('lab_type'));
			    }
		    });
			var strHisto = chkHisto.join('_');
			var strRegular = chkRegular.join('_');
			var lengthFisto = chkHisto.length;
			var samePatientId = chkPatient.allValuesSame();
			if(lengthFisto >= 2 || (samePatientId == false) || (strHisto && strRegular)){
				$("#entryMode").removeClass("blueBtn");
		    	$("#entryMode").addClass("grayBtn");
		    	$("#print").removeClass("blueBtn");
		    	$("#print").addClass("grayBtn");
		    	$("#save").removeClass("blueBtn");
			    $("#save").addClass("grayBtn");
			}
		});	
	});
	
	$("#entryMode").click(function(){
		
			var chkHisto = new Array();
			var chk1Array = new Array();
			var chkPatient = new Array();
			var chkRegular = new Array();
			
		    $(".incl_checkbox").each(function(){
		    	
		        if( $(this).is(':checked')){
		        	chk1Array.push($(this).val());
		        	chkPatient.push($(this).attr('patientId'));
		        }
		        if($(this).is(':checked') && $(this).attr('lab_type') =='2'){
		        	chkHisto.push($(this).attr('lab_type'));
		        }
		        
		        if($(this).is(':checked') && $(this).attr('lab_type') !='2'){
		        	chkRegular.push($(this).attr('lab_type'));
			    }
		    });
		    var samePatientId = chkPatient.allValuesSame();
			var strUrl = chk1Array.join('_');

			var strHisto = chkHisto.join('_');
			var strRegular = chkRegular.join('_');
			var lengthFisto = chkHisto.length;
			 
			if(!strUrl || lengthFisto >= 2 || (samePatientId == false) || (strHisto && strRegular) ){
				$("#entryMode").removeClass("blueBtn");
				$("#entryMode").addClass("grayBtn");	
				return false;//Dont remove
			}
			 
			if(strHisto != ''){
				$("#laboratoryFrm").attr("action", "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'histoEntryMode'));?>"+"?testOrderId="+strUrl);
			}else{
				$("#laboratoryFrm").attr("action", "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'entryMode'));?>"+"?testOrderId="+strUrl);
			}
			$("#labPostData").val(strUrl);
			$( "#laboratoryFrm" ).submit();
	});
	Array.prototype.allValuesSame = function() {
	    for(var i = 1; i < this.length; i++){
	        if(this[i] !== this[0])
	            return false;
	    }
	    return true;
	}
	$("#payBill").click(function(){
		var payArray = new Array();
		var patientArray = new Array();
		var patient_id = '';
		
		$(".payNow_checkbox").each(function(){
			if($(this).is(':checked'))
			{
				cls = $(this).attr('class');
				p_id = cls.split(" patientId_");
				patient_id = p_id[1];
				/*idd = $(this).attr('id');
				new_id = idd.split("_");*/
				payArray.push($(this).val());
				//patientArray.push(this.value);
			}
		});
		/*alert(patient_id);
		alert(patientArray);*/
		var form_value = payArray.join(',');
		//var form_value = payArray; 
		var url = "<?php echo $this->Html->url(array('controller'=>'billings','action'=>'multiplePaymentModeIpd'));?>"+"/"+patient_id;
		//window.location.href = url ;
	});		
	

	$("#save").click(function(){

		var chk1Array = new Array();
		var chk2Array = new Array();
		var chk3Array = new Array();
		var chk4Array = new Array();
		var chk5Array = new Array();
		var samePatient = new Array();
		
	
		$(".sample_checkbox").each(function(){
			if($(this).attr('disabled') != 'disabled'){
		        if( $(this).is(':checked')){
		        	chk2Array.push($(this).val());
		        	samePatient.push($(this).attr('patientId'));
		        }
			}
		})
			var samePatientId = samePatient.allValuesSame();
		 
		var strUrl2 = chk2Array.join('_');
		    $(".incl_checkbox").each(function(){
	        if( $(this).is(':checked')){
	        	chk1Array.push($(this).val());
	        }
	    });
		var strUrl = chk1Array.join('_');

		$(".recv_checkbox").each(function(){
			if($(this).attr('disabled') != 'disabled'){
		        if($(this).is(':checked')){
		        	chk3Array.push($(this).val());
		        }
			}
		})
		var strUrl3 = chk3Array.join('_');

		$(".complt_checkbox").each(function(){
			if($(this).attr('disabled') != 'disabled'){
		        if($(this).is(':checked')){
		        	chk4Array.push($(this).val());
		        }
			}
		})
		var strUrl4 = chk4Array.join('_');

		$(".reTest_checkbox").each(function(){
		        if($(this).is(':checked')){
		        	chk5Array.push($(this).val());
		        }
		})
		var strUrl5 = chk5Array.join('_');

		if((strUrl))
		return false;//Dont remove
		 
		if((!strUrl2) && (!strUrl3) && (!strUrl4) && (!strUrl5) || (samePatientId == false)){
			$("#save").removeClass("blueBtn");
			$("#save").addClass("grayBtn");
			return false;//Dont remove
		}
	
		var sampleArray = new Array();
		var receiveArray = new Array();
		var completeArray = new Array();
		var reTestArray = new Array();
				
		$(".sample_checkbox").each(function(){
			if(!$(this).is(':disabled'))
			{
				if($(this).is(':checked'))
				{
					idd = $(this).attr('id');
					new_id = idd.split("_");
					var test_order_id = new_id[1];		//holds test order ids
					var pateintId = $(this).attr('patientId');
					var item = { testOrderId : test_order_id, patientId: pateintId };
					sampleArray.push(item);				
				}
			}
		});
		/*
		$(".recv_checkbox").each(function(){
			if(!$(this).is(':disabled'))
			{ 
				if($(this).is(':checked'))
				{
					idd = $(this).attr('id');
					new_id = idd.split("_"); 
					var test_order_id = new_id[1];		//holds test order ids
					var pateintId = $(this).attr('patientId');
					var item = { testOrderId : test_order_id, patientId: pateintId };
					receiveArray.push(item);				
				}
			}
		});
		
		$(".complt_checkbox").each(function(){
			if(!$(this).is(':disabled'))
			{
				if($(this).is(':checked'))
				{
					idd = $(this).attr('id');
					new_id = idd.split("_");
					var test_order_id = new_id[1];		//holds test order ids
					var pateintId = $(this).attr('patientId');
					var item = { testOrderId : test_order_id, patientId: pateintId };
					completeArray.push(item);
				}				
			}
		});
		*/
		AjaxUrl = "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'AddSample'));?>";
		$.ajax({
			type : "POST",
			data : "sample=" + JSON.stringify(sampleArray)+"&received=" + JSON.stringify(receiveArray)+"&complete=" + JSON.stringify(completeArray),
			url  : AjaxUrl,
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$("#records").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}	
			});


/*
		$('.reTest_checkbox').each(function(){
			if($(this).is(':checked')){
				
				var patientId = $(this).attr('patientId');
				var lab_test_order_id = $(this).val();
				var item = { lab_test_order_id : lab_test_order_id, patientId: patientId };
				reTestArray.push(item);
			}
		});

			$.ajax({
				  type : "POST",
				  data: "reTest=" + JSON.stringify(reTestArray),
				  url: "<?php echo $this->Html->url(array("controller" => "new_laboratories", "action" => "reTest", "admin" => false)); ?>",
				  beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){
						$("#records").html(data).fadeIn('slow');
						$('#busy-indicator').hide();
					}		  
			});
			*/

		});
/*
		$("#sample_master").change(function(){
			if($(this).is(':checked',true)){
				$(".sample_checkbox").each(function(){
					if($(this).attr('disabled') != 'disabled'){
						if(!$(this).is(":checked")){
					         $(".sample_checkbox").prop("disabled", false);
					     }else{
				         var flag = 0;
				         $(".sample_checkbox").each(function(){
				             if(!this.checked)
				             flag=1;
				         })             
					     	
					     }
					}
				});
			}	
		});
		*/
		$(function(){	//slect/deselect all checkboxes
			$('#sample_master').click(function(event) { 
				var chkPatient = new Array(); 		 
			    if(this.checked) { 							// check select status
			        $('.sample_checkbox').each(function() { 	//loop through each checkbox
			        	if($(this).attr('disabled') != 'disabled'){
		            		this.checked = true;  	
			        	}			//select all checkboxes with class "sample_checkbox"           
			        });
			    }else{
			        $('.sample_checkbox').each(function() { 	//loop through each checkbox
			        	if($(this).attr('disabled') != 'disabled'){
			            	this.checked = false;
			        	} 				//deselect all checkboxes with class "sample_checkbox"      
			        });
			        $('.sample_checkbox').each(function() { 	//loop through each checkbox
			        	if($(this).attr('checked') != 'checked' && $(this).attr('disabled') == 'disabled'){
				        	$(this).removeAttr("disabled");
			        	} 				//deselect all checkboxes with class "sample_checkbox"      
			        });        
			    }
			    $(".sample_checkbox").each(function(){
			    	
			        if( $(this).is(':checked')){
			        	chkPatient.push($(this).attr('patientId'));
			        }
			    });
				var samePatientId = chkPatient.allValuesSame();
				if((samePatientId == false)){
					$("#entryMode").removeClass("blueBtn");
			    	$("#entryMode").addClass("grayBtn");
			    	$("#print").removeClass("blueBtn");
			    	$("#print").addClass("grayBtn");
			    	$("#save").removeClass("blueBtn");
				    $("#save").addClass("grayBtn");
				}
			});
		});

		$("#bar_image").click(function(){
			getAddItemRate();
		});

		function getAddItemRate(){
			var sampleArray = new Array();
			$(".barCode").each(function(){
				if(!$(this).is(':disabled') && $(this).is(':checked'))
				{
					sampleArray.push(this.value);		
				}
				});	
				var string = sampleArray.join('_');
			$.fancybox({
				'width' : '80%',
				'height' : '90%',
				'autoScale' : true,
				'transitionIn' :'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller"=>"new_laboratories", "action" => "printSample")); ?>"+"/"+string,
			});
		}//end of function

		$('#print').click(function(){
			var idArray = new Array();
			var isResult = false;
			var chkPatient = new Array();

			$(".incl_checkbox").each(function(){
		        if( $(this).is(':checked') )
		        {
		        	chkPatient.push($(this).attr('patientId'));
		        	if($(this).attr('isResult') == 'No')
		        		isResult = true;
	        		
		        	idArray.push($(this).val());
		        }
		    });
			var samePatientId = chkPatient.allValuesSame();
			var string = idArray.join('_');
			if(isResult === false){
				$("#print").removeClass("grayBtn");
	    		$("#print").addClass("blueBtn");
			}
			if(!string)
				return false;
			if(!string || isResult === true || (samePatientId == false) ){
				$("#print").removeClass("blueBtn");
    			$("#print").addClass("grayBtn");
				return false;
			}


			var printUrl='<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab'));?>';
			var printUrl=printUrl +"?testOrderId="+string;
			var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
		});

		/*
		$(function(){
			  
			  var onSampleResized = function(e){  
			    var table = $(e.currentTarget); //reference to the resized table
			  };  

			 $("#item-row").colResizable({
			    liveDrag:true,
			    gripInnerHtml:"<div class='grip'></div>", 
			    draggingClass:"dragging", 
			    onResize:onSampleResized
			  });    
			  
			});
		*/
		$(document).on('click','.barCode',function(){		 
			var patientId = $(this).attr('patientid');
			var reqNo = $(this).attr('reqNo');
			  if($(this).is(':checked',true)){
	        	$('.barCode').each(function() { 	
					if($(this).attr('reqNo') != reqNo && $(this).attr('disabled') != 'disabled'){	 
						var thisId = $(this).attr('id');
						splittedArr = thisId.split("_");
						barcodeDisabledArr.push(splittedArr[1]);
						$(this).attr('disabled',true);
					}
				});

				$("#save").removeClass("grayBtn");
				$("#save").addClass("blueBtn");
				tempBarcode = patientId;
				
				}else{	//if uncheck
					var flag = 0;
					$('.barCode').each(function() { 	
						if($(this).is(':checked') == true && $(this).attr('disabled') != 'disabled'){
							flag = 1;
						}
					}); 
					if(flag == 0){	//if all unchecked
						$.each(barcodeDisabledArr, function (key, value) {
							$("#barCode_"+value).attr('disabled',false);
						});
						tempBarcode = "";
						$("#save").removeClass("blueBtn");
						$("#save").addClass("grayBtn");
					}
				}
		});
		$(document).on('click','.sample_checkbox',function(){		//to disable or enable the checkbox of another patient
			var patientId = $(this).attr('patientid');
			  if($(this).is(':checked',true)){
	        	$('.sample_checkbox').each(function() { 	
					if($(this).attr('patientid') != patientId && tempSample != patientId  && $(this).attr('disabled') != 'disabled'){	//only once for single patient
						var thisId = $(this).attr('id');
						splittedArr = thisId.split("_");
						sampleDisabledArr.push(splittedArr[1]);
						$(this).attr('disabled',true);
					}
				});

				$("#save").removeClass("grayBtn");
				$("#save").addClass("blueBtn");
				tempSample = patientId;
				
				}else{	//if uncheck
					var flag = 0;
					$('.sample_checkbox').each(function() { 	
						if($(this).is(':checked') == true && $(this).attr('disabled') != 'disabled'){
							flag = 1;
						}
					}); 
					 
					if(flag == 0){	//if all unchecked
						$.each(sampleDisabledArr, function (key, value) {
							$("#sample_"+value).attr('disabled',false);
						});
						tempSample = "";
						$("#save").removeClass("blueBtn");
						$("#save").addClass("grayBtn");
					}
					
					$('.sample_checkbox').each(function() { 	 
						if($(this).attr('samtaken')==1){
							$(this).attr('disabled',true);
						}else{
							$(this).is(':checked',false);
							$(this).attr('disabled',false);
						}
					});
				}
		});

		$(document).on('click','.incl_checkbox',function(){		//to disable or enable the checkbox of another patient
			var patientId = $(this).attr('patientid');
			  if($(this).is(':checked',true)){
	        	$('.incl_checkbox').each(function() { 	
					if($(this).attr('patientid') != patientId && tempSample != patientId  && $(this).attr('disabled') != 'disabled'){	//only once for single patient
						var thisId = $(this).attr('id');
						splittedArr = thisId.split("_");
						sampleDisabledArr.push(splittedArr[1]);
						$(this).attr('disabled',true);
					}
				});

				$("#save").removeClass("blueBtn");
				$("#save").addClass("grayBtn");
				tempSample = patientId;
				
				}else{	//if uncheck
					var flag = 0;
					$('.incl_checkbox').each(function() { 	
						if($(this).is(':checked') == true && $(this).attr('disabled') != 'disabled'){
							flag = 1;
						}
					}); 
					 
					if(flag == 0){	//if all unchecked
						$.each(sampleDisabledArr, function (key, value) {
							$("#incl_"+value).attr('disabled',false);
						});
						tempSample = "";
						$("#save").removeClass("blueBtn");
						$("#save").addClass("grayBtn");
					}
					
				}
		});
		$(document).on("click",".lookupName", function(){
			var personId = $(this).attr('personId');
			$("#patientId").val(personId);
			$("#Submit").trigger('click');
		});
					
	});	//end of document ready
	
</script>
