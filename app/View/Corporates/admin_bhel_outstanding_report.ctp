<script>
	$(function() {
		$("#from").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
		});
	});	

	
</script>


<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js')); ?>
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td {
	padding: 0px;
}

.tabularForm th {
   
    padding: 5px 0px;
   
}
textarea {
	width: 100px;
}

.inner_title span {
	margin: -33px 0 0 !important;
}

.inner_menu {
	padding: 10px 0px;
}

.inner_title span {
	margin: 0px !important;
	float: none;
}
.tdLabel2 img{ float:none !important;}
</style>


<?php  echo $this->element("corporate_billing_report");?>
<div class="inner_title">
	<h3 style="float: left;">BHEL Outstanding Report</h3>
	
	<div style="float: right;">
		<span style="float: right;"> <?php
		echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Corporates','action'=>'bhel_outstanding_report','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get')); 
		echo $this->Html->link('Back',array("controller"=>'reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
		echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	
		?>
		</span>

	</div>

	<div class="clr"></div>
	<div style="float: left; padding-top: 20px;">
		<table width="" cellpadding="0" cellspacing="0" border="0"
			class="tdLabel2" style="color: #b9c8ca;">
			<tr>
				<td style="color: #000;"><?php
				
				echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'], 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'));
				?> <span><?php
                echo __("From : ").$this->Form->input('BhelReport.from', array('id'=>'from','value'=>$this->request->query['from'] ,'label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
				</span> <span><?php 
                echo __("To : ").$this->Form->input('BhelReport.to', array('id'=>'to','label'=> false,'value'=>$this->params->query['to'], 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
				</span>				
				<span id="look_up_name" class="LookUpName"> <?php
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));
				?>
				</span>
				<span><?php 
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array()),array('controller'=>'Corporates','action'=>'bhel_outstanding_report','admin'=>true),
		        array('escape' => false,'title'=>'Back to List'));
						?> </span>
				</td>
			</tr>
		</table>
	</div>

</div>
<div class="clr ht5"></div>

<div id="container">
	<div class="clr ht5"></div>

	<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px; overflow: scroll;">
		<tr>
		
		
		<thead>
			<th width="21px" valign="top" align="center"
				style="text-align: center;">No.</th>
			<th width="80px" valign="top" align="center"
				style="text-align: center;">Patient name</th>
			<th width="92px" valign="top" align="center"
				style="text-align: center;">Name of Employee</th>
			<th width="60px" valign="top" align="center"
				style="text-align: center;">Relation with Emp</th>

			<th width="54px" valign="top" align="center"
				style="text-align: center;">Staff no</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Admission Date</th>

			<th width="80px" valign="top" align="center"
				style="text-align: center;">Bill No</th>
			</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Discharge Date</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Hospital Invoice Amount</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Amount Recieved</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">20% Adv Recieved</th>

			<th width="65px" valign="top" align="center"
				style="text-align: center;">TDS</th>
			<th width="69px" valign="top" align="center"
				style="text-align: center;">Other Deduct</th>
			<th width="80px" valign="top" align="center" 
			style="text-align:center;">InvoiceDate</th>
			<th width="61px" valign="top" align="center"
				style="text-align: center;">Bill Submission</th>

			<th width="113px" valign="top" align="center"
				style="text-align: center;">Remark</th>
			<th width="62px" valign="top" align="center"
				style="text-align: center;">Bill Due Date</th>
				<th width="21px" valign="top" align="center"
				style="text-align: center;">Action</th>

		</thead>
		</tr>
	 
		<?php $curnt_date = date("Y-m-d");	//for current date
				$i = 0;
				$otherDeduct=0;
				foreach($results as $key=>$result)
				{
					$patient_id = $result['Patient']['id']; 	//holds the id of patient
					$bill_id = $result['FinalBilling']['id'];	//holds the bill id of patient
					$i++;
					?>

		<tr>

			<td align="center" valign="middle" width="23px"
				style="text-align: center;"><? echo $i++; ?></td>

			<td width="81px" valign="middle" align="center"
				style="text-align: center;"><?php echo $result['Patient']['lookup_name'];?>
			</td>

			<td width="95px" valign="middle" align="center"
				style="text-align: center;"><?php echo $result['Person']['name_of_ip'];?>
			</td>

			<td width="62px" valign="middle" align="center"
				style="text-align: center;"><?php echo $result['Person']['relation_to_employee'];?>
			</td>

			<td width="57px" valign="middle" align="center"
				style="text-align: center;"><?php echo $result['Person']['executive_emp_id_no'];?>
			</td>
			<td width="67px" valign="middle" align="center"
				style="text-align: center;"><?php echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission?>
			</td>

			<td width="82px" valign="middle" align="center"
				style="text-align: center;"><?php 
					echo $this->Form->input('bill_number', array('id'=>'bill_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_bill_number','value'=>$result['FinalBilling']['bill_number']));   //bill no 	
			?>  
			</td>
			</td>
			<td width="66px" valign="middle" align="center"
				style="text-align: center;"><?php echo $this->DateFormat->formatDate2Local($result['FinalBilling']['discharge_date'],Configure::read('date_format'));  ?>
			</td>
			<td width="69px" valign="middle" style="text-align:center;" id="amt_<?php echo $bill_id;?>_td">
				<?php  
				echo $this->Form->hidden('patientId',array('id'=>'patient_'.$patient_id,'class'=>'patient_id'));
					echo $this->Form->input('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'cmp_amt_paid','value'=>$result['FinalBilling']['total_amount'])); 		
				?>
			</td>
			

			<td width="67px" valign="middle" align="center"
				style="text-align: center;"><?php	
				 		// Amount Recieved= amount paid by bhel
					echo  $this->Form->input('package_amount', array('id'=>'package_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>$result['FinalBilling']['package_amount']));
					$amntRecieved =$result['FinalBilling']['package_amount'];
				?>	
			</td>

			<td width="66px" valign="middle" align="center" 
				style="text-align: center; "id="adv_<?php echo $bill_id;?>">
				
				<?php 
				$advRcv=$result['FinalBilling']['amount_paid']-($result['FinalBilling']['paid_to_patient']);
				echo $this->Form->hidden('advanced_received',array('class'=>'adv_rec','id'=>"adv_".$bill_id,'value'=>$advRcv));
				echo $advRcv;
				?>
		   </td>
				
			<td width="67px" valign="middle" align="center"
				style="text-align: center;">
				<?php 
						// TDS	
						$tds = $amntRecieved+$tdsAmnt+$advRcv; 		// addition of Amount Recieved & Tds &  Advance Received
		 			   echo $this->Form->input('tds', array('id'=>'tds_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_tds','value'=>$result['FinalBilling']['tds']));
		 			   //$this->Form->input('addrcv', array('id'=>'addrcv_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'value'=>$addRecvTds));
		 			   $tdsAmnt = $result['FinalBilling']['tds']; 
		 			   
				?>
			</td>
			<td width="73px" valign="middle" align="center"
				style="text-align: center;">
			<table>
					<tr>
						<td>	
							<?php
							  echo $this->Form->input(' ', array('id'=>'otherDeduction_'.$bill_id,'type' => 'text','label'=>false ,
							'div'=>false,'style'=>"width: 70%;",'class'=>'add_other_deduction','value'=>$result['FinalBilling']['other_deduction']));
							?>
		 				</td>
					 	<?php 
						$display = ($result['FinalBilling']['other_deduction_modified']==1) ? 'block' : 'none';
						
						?>
		 				<td>
		 					<div id = "flag_<?php echo $bill_id;?>" style="display: <?php echo $display?>">
		 						<?php echo $this->Html->image("test-fail-icon.png",array( 'title'=>'Amount Edited'),array('escape' => false,'div'=>false)); ?>
		 					</div>
		 				</td>
		 			<tr>
		 		</table>	
			</td>
			<td>
		<?php   //InvoiceDate 
						if(isset($result['FinalBilling']['cmp_paid_date']))
						{
							$date= $result['FinalBilling']['cmp_paid_date'];
					  echo $this->DateFormat->formatDate2Local($date,Configure::read('date_format'));
						}
						else
						{	echo $this->Form->hidden('',array('value'=>$bill_id,'id'=>'bill_'.$patient_id));
							echo $this->Form->input("cmp_paid_date_$patient_id",array('style'=>"width: 65%;",'class'=>'textBoxExpnd cmp_paid_date','label'=>false,'value'=>$result['FinalBilling']['cmp_paid_date']));
						}
						?>			
			
		</td>
			<td width="69px" valign="middle" align="center"
				style="text-align: center;"><?php	
				//Bill Submission date
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
				?>
			</td>
			<td width="68px" valign="middle" align="center"
				style="text-align: center;"><?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','title'=>$result['Patient']['remark'],'label'=>false,'rows'=>'1','cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));
				?>
			</td>
			<td width="63px" valign="middle" align="center"
				style="text-align: center;"><?php 
				//Bill Due Date
				$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
				echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
				?>
			</td>
			
			 <td width="10px" align="center" >
				<?php 
				echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('controller'=>'Corporates','action' =>'patient_delete', $result['Patient']['id'],'admin'=>false), 
					array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));

				if($result['PatientDocument']['filename']){
					echo $this->Html->link($this->Html->image('icons/download-excel.png'),array('controller'=>'Corporates','action' =>'downloadExcel',$result['Patient']['id'],$result['PatientDocument']['id'],'admin'=>false),
							array('escape' => false,'title' => 'Download Uploaded Excel', 'alt'=>'Download Uploaded Excel'));
				}?>
    	
    		</td>
		</tr>
		<?php }?>
	</table>
	<table align="center">
		<tr>
			<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			</TD>
		</tr>
	</table>



</div>

<?php 

function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
{
	$date = $cur_date;
	$date = strtotime($date);
	$date = strtotime("+$no_days day", $date);
	return date('Y-m-d', $date);
}


?>



<!--*******************************************************************************************************************-->


<Script>
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

$('.add_bill_number').blur(function()
{var bill = $(this).attr('id'); 
	splittedId = bill.split("_");
	
	newId = splittedId[1]; 
	var val = $(this).val(); //alert(newId);
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getBillNo", "admin" => false));?>"+"/"+newId+"/"+val,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
		}
	});
});

$('.cmp_amt_paid').blur(function()
{var bill = $(this).attr('id'); 
	splittedId = bill.split("_");
	
	newId = splittedId[1]; 
	var val = $(this).val(); //alert(newId);

	var patientId = $('.patient_id').attr('id');
	spliPatientId = patientId.split("_");
	newPatientId = spliPatientId[1];
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getBillamt", "admin" => false));?>"+"/"+newId+"/"+val+"/"+newPatientId,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
		}
	});
});

$( ".cmp_paid_date").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		var idd = $(this).attr('id');
		 splittedId=idd.split('_'); 
		 var bill_id = $("#bill_"+splittedId[3]).val(); 
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "CMPpaidDate", "admin" => false));?>"+"/"+bill_id,
   			data:'id='+bill_id+"&date="+date,
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


$('.add_package_amount').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  packageId = splittedId[1];
			 
			  var val = $(this).val();

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false));?>"+"/"+packageId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
						
			     }
			});
			}
			);

$('.add_remark').blur(function()
		  {
			  var patient = $(this).attr('id') ;
			  splittedId = patient.split("_");
			  newId = splittedId[1];
			  
			  var val = $(this).val();
			 

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+newId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
			     }
			
			});
			}
			);
			



$('.LookUpName').click(function()
		  {
		  	//alert("OK");
		  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
		  	//alert(lookup_name);
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "bhel_outstanding_report", "admin" => true));?>";
				$.ajax({
				url : ajaxUrl + '?lookup_name=' + lookup_name,
				beforeSend:function(data){
				$('#busy-indicator').show();
			},
				success: function(data){
					$('#busy-indicator').hide();
					$("#container").html(data).fadeIn('slow');
					
				}
				});
			});


		

$("#lookup_name").autocomplete("<?php echo $this->Html->url(
				array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
		{
				width: 80,
				selectFirst: true
			}); 


$('.add_other_deduction').keyup(function(){
				  var bill = $(this).attr('id') ;
				  splittedId = bill.split("_");
				  OtherDeductionId = splittedId[1];
				  var val = $(this).val();
				  var flag  = 1;
               //alert(val);
				$.ajax({
					url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getModifiedOtherDeduction", "admin" => false));?>"+"/"+flag+"/"+val+"/"+OtherDeductionId,
						//data:"flag="+flag+"&value="+val+"&id="+OtherDeductionId,
					beforeSend:function(data){
					$('#busy-indicator').show();
							
					},
					success: function(data){ 
						var bullet = '<?php echo $this->Html->image("icons/test-fail-icon.png.png");?>';
						$("#flag_"+splittedId[1]).show();
						$('#busy-indicator').hide();
					}
				});
			});

$('.other_deduction').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  deductionId = splittedId[1];
			  
			  var val = $(this).val();

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getOtherDeduction", "admin" => false));?>"+"/"+deductionId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				
			},
			
			success: function(data){ 
				//alert(data);
						$('#busy-indicator').hide();
			     }
			});
			}
			);

$('.add_tds, .add_package_amount,.adv_rec').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  Id = splittedId[1];
			  var val = $(this).val();
			   
				var invoice=$('#amt_'+Id).val();//from database
				var advs=$('#adv_'+Id).text();//from database
				
				var tds=parseInt($('#tds_'+Id).val());//alert(tds);
				var packAmout = parseInt($('#package_'+Id).val());
				if(isNaN(invoice)){
					invoice=0;
				}
				if(isNaN(tds)){
					tds=0;
				}
				if(isNaN(packAmout)){
					packAmout=0;
				}
				var add = tds+packAmout+parseInt(advs);//	alert(add)	
				var total=parseInt(invoice)-add;
				//alert(total);
				if(isNaN(total)){
					total=0;
				}
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getTds", "admin" => false));?>"+"/"+Id+"/"+tds,
			
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
						$('#otherDeduction_'+Id).val(total);
						$.ajax({
							url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getOtherDeduction", "admin" => false));?>"+"/"+Id+"/"+total,
							});	
						
						
						
						
			     }
			});
			}
			);
$(function() {
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});
});	

</Script>