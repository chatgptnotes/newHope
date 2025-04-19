
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
.tabularForm1 th {
    background: #5f686b none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #ffffff !important;
    font-size: 25px;
    padding: 0px 0px;
    text-align: left;
}
.tabularForm1 td {
   /* background: #fff none repeat scroll 0 0;*/
    color: #000;
    font-size: 25px;	
    padding: 0px 0px;
    font-weight: bold;
}
.row_gray {
    background-color: silver;
    border-top: 1px solid #000;
    margin: 0;
    padding: 7px 3px;
}
.row_white {
    background-color: white;
    border-top: 1px solid #000;
    margin: 0;
    padding: 7px 3px;
}
.maleImage {
  background:url("<?php echo $this->webroot ?>img/icons/male.png") no-repeat center 2px;  
  cursor: pointer;
}
.femaleImage {
  background:url("<?php echo $this->webroot ?>img/icons/female.png") no-repeat center 2px;  
  cursor: pointer;
}

</style>
<?php
//echo //$this->Html->css ( array (
		//'tooltipster.css'
//) );
//echo $this->Html->script ( array (
		//'jquery.tooltipster.min.js'
//) );

?>
<?php if(!empty($testOrdered)) { ?>
<table width="100%"
	cellpadding="0" cellspacing="1" border="0"
	class="tabularForm1" id="item-row"
	style="overflow: scroll;">


	<tr class="light fixed">
		<th align="center" valign="top" 
			style="text-align: center;width:5px;padding-right: 5px; padding-left: 5px;"></th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px;">PATIENT</th>
	<!--	<th align="center" valign="top"
			style="text-align: center; padding: 0px; padding-left: 5px;">ReqNo.</th>
		  <th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px;">Services</th>-->
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px;">REQ.BY</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px;">DATE</th>
		<!--  <th align="center" valign="top"
			style="text-align: center; padding-left: 5px;">Status</th>-->
		
<?php 
	$srno = $this->params->paging ['LaboratoryTestOrder'] ['limit'] * ($this->params->paging ['LaboratoryTestOrder'] ['page'] - 1);
	// $srno = 1;
	// debug($testOrdered);exit;
	$i = 0;
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

		?>
	<?php 
	if ($value ['Patient'] ['admission_type'] == 'OPD') {
			$backGround = 'opd';
		} else {
			$backGround = 'ipd';
		}
		
	if($i%2==0){ $grayColor="row_gray";}else{$grayColor ="row_white";} 
		?>
	<tr class="<?php echo $backGround." ".$grayColor;?>">
		
		<?php if($lastPatientId != $patientId) {
			if(strtolower($value['Patient']['sex'])=='male'){ 
				echo '<td class="maleImage"></td>';
			}
			if(strtolower($value['Patient']['sex'])=='female'){
				echo '<td class="femaleImage"></td>';
			}
			if($value['Patient']['sex']==''){ 
				echo '<td class="">&nbsp;</td>';
			}
			?>
		<td>	
			 <span class="tooltip lookupName" title="<?php echo $toolTip; ?>"  personId='<?php echo $value['Patient']['id']; ?>' style="cursor:pointer"> 
			 <?php $patientName = $value['Patient']['lookup_name'];
				   $explodeString = explode(' ', $patientName);
				  echo $explodeString[0]." ".$explodeString[1]." ".$explodeString[2];
			  ?>
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
		<!--<td align="center"><?php echo $value['LaboratoryTestOrder']['req_no'];?></td>
		  <td><?php echo $value['Laboratory']['name'];?></td>-->
		<td><?php 
				$doctorName = $value[0]['name'];
				$stringCut = substr($doctorName, 0, 16);
				$explodeString = explode(',', $stringCut);
				$docName = substr($explodeString[0], 0, strrpos($explodeString[0], ' '));
				$explodeString[0];
				$doc = explode("(",$doctorName);
				echo 'Dr.'.$doc[0];
				//echo ;?></td>
		<td align="center"><?php echo $this->DateFormat->formatDate2Local ( $value ['LaboratoryTestOrder'] ['start_date'], Configure::read ( 'date_format' ), false );?></td>
		<!--<td><?php echo __($status)?></td>-->
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
	$i++; } 
	?>
	<!-- </tbody> -->
</table>




<div class="clr ht5"></div>
<!--  <table align="center">
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
</table>-->

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
   // $("#save").addClass("grayBtn");
	$("#entryMode").removeClass("blueBtn");
  //  $("#entryMode").addClass("grayBtn");
    $("#print").removeClass("blueBtn");
    //$("#print").addClass("grayBtn");
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
			   // $("#save").addClass("grayBtn");
			    
			}else{
				$("#entryMode").removeClass("blueBtn");
		    	//$("#entryMode").addClass("grayBtn");
		    	$("#print").removeClass("blueBtn");
		    	//$("#print").addClass("grayBtn");

		    	$("#save").removeClass("blueBtn");
			   // $("#save").addClass("grayBtn");
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
		    	//$("#entryMode").addClass("grayBtn");
		    	$("#print").removeClass("blueBtn");
		    	//$("#print").addClass("grayBtn");
		    	$("#save").removeClass("blueBtn");
			   // $("#save").addClass("grayBtn");
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
				//$("#entryMode").addClass("grayBtn");	
				return false;//Dont remove
			}
				$("#laboratoryFrm").attr("action", "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'entryMode'));?>"+"?testOrderId="+strUrl);
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
			//$("#save").addClass("grayBtn");
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
			    	//$("#entryMode").addClass("grayBtn");
			    	$("#print").removeClass("blueBtn");
			    	//$("#print").addClass("grayBtn");
			    	$("#save").removeClass("blueBtn");
				   // $("#save").addClass("grayBtn");
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
    			//$("#print").addClass("grayBtn");
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
						//$("#save").addClass("grayBtn");
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
						//$("#save").addClass("grayBtn");
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
				//$("#save").addClass("grayBtn");
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
						//$("#save").addClass("grayBtn");
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
