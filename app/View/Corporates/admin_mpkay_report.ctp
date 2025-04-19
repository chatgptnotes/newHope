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
			dateFormat: 'dd/mm/yy'		
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy'			
		});
	});	

	
</script>
<?php  
  echo $this->Html->script(array('jquery.fancybox.js' ));
	echo $this->Html->css(array('jquery.fancybox' )); 
  echo $this->Html->css(array(/*'jquery.fancybox-1.3.4.css',*/'jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array(/*'jquery.fancybox-1.3.4',*/'inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js')); ?>
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td {
	padding: 0;
}

.tabularForm th {
   
    padding: 5px 0px;
   
}
tr .selectedRowColor  td{
    background: #C1BA7C;
}

textarea {
	width: 90px;
}

.inner_title span {
	margin: -33px 0 0 !important;
}

.inner_menu {
	padding: 10px 0px;
}
.inner_title span{margin:0px !important; float:none;}
.tdLabel2 img{ float:none !important;}

</style>
<?php echo $this->element('corporate_billing_report');?>
<div class="inner_title">
    <h3 style="float: left;">MPKAY Outstanding Report</h3>
	<div style="float:right;">
        <span style="float:right;">
            <?php
              echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Corporates','action'=>'mpkay_report','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get', 'style'=> 'float:left;')); 
                        echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));			
            echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
        '?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));		
                ?> 
        </span> 
	</div>
	<div class="clr"></div>
</div>
<div class="clr ht5"></div>
<table width="50%" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color: #b9c8ca;">
	<tr>
		<td style="color: #000;">
			<?php echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name',
				'value'=>$this->params->query['lookup_name'],'label'=>false,'div'=>false,'error'=>false,'autocomplete'=>false,'class'=>'name'));
			?>
			<span>
				<?php echo __("From : ").$this->Form->input('MpkayReport.from', array('id'=>'from','value'=>$this->request->query['from'],
					'label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
			</span>
			<span>
				<?php echo __("To : ").$this->Form->input('MpkayReport.to', array('id'=>'to','value'=>$this->params->query['to'],
						'label'=>false,'div'=>false, 'error' => false))."&nbsp;&nbsp;"?>
			</span>				
			<span id="look_up_name" class="LookUpName">
				<?php echo $this->Form->submit(__('Search'),array('style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false));?>
			</span>
			<span>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array()),array('controller'=>'Corporates',
						'action'=>'mpkay_report','admin'=>true),array('escape' => false,'title'=>'Back to List'));
				?>
			</span>
		</td>
	</tr>
</table>
<div id="container">
	<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px; overflow: scroll;">
		<tr>
		<thead>
            <th width="19px" valign="top" align="center" style="text-align: center;">No.</th>
            <th width="5px"  align="center" style="text-align:center;">Set</th>
			<th width="74px" valign="top" align="center" style="text-align: center;">Sanction ID No.</th>
			<th width="65px" valign="top" align="center" style="text-align: center;">Name of Patient</th>
			<th width="64px" valign="top" align="center" style="text-align: center;">Name of<br>Emp<br>(Rank)</th>
			<th width="55px" valign="top" align="center" style="text-align: center;">Relation with Emp</th>
			<th width="58px" valign="top" align="center" style="text-align: center;">Main <br>Member <br>UHID No.</th>
			<th width="64px" valign="top" align="center" style="text-align: center;">Date Of Admission</th>
			<th width="70px" valign="top" align="center" style="text-align: center;">Bill No</th>
			<th width="65px" valign="top" align="center" style="text-align: center;">Discharge Date</th>
			<th width="61px" valign="top" align="center" style="text-align: center;">Hospital Invoice Amount</th>
			<th width="59px" valign="top" align="center" style="text-align: center;">Bank</th>
                        <th width="59px" valign="top" align="center" style="text-align: center;">Amount Recieved</th>
			<th width="64px" valign="top" align="center" style="text-align: center;">Advance</th>
			<th width="58px" valign="top" align="center" style="text-align: center;">TDS</th>
			<th width="57px" valign="top" align="center" style="text-align: center;">Other Deduct</th>
			<th width="56px" valign="top" align="center" style="text-align: center;">Bill Submission</th>
			<th width="80px" valign="top" align="center" style="text-align:center;">Amount Received Date</th>
         	<th width="57px" valign="top" align="center" style="text-align: center;">Unit<br> Name</th>
			<th width="50px" valign="top" align="center" style="text-align: center;">Mul Remark</th>
                        <th width="100px" valign="top" align="center" style="text-align: center;">Remark</th>
			<th width="66px" valign="top" align="center" style="text-align:center;">Bill Due Date</th>
			<th width="5px" valign="top" align="center" style="text-align: center;">#</th>
		</thead>
		</tr>
	 
		<?php $curnt_date = date("Y-m-d");	//for current date
			$i = 0;
			$otherDeduct=0;
			foreach($results as $key=>$result)
			{
				$patient_id = $result['Patient']['id']; 	//holds the id of patient
				$bill_id = $result['FinalBilling']['id'];   	//holds the bill id of patient
				$i++;
			?>

			<tr id="row_<?php echo $patient_id; ?>" class="rowselected">
				<td align="center" valign="middle" width="19px" style="text-align: center;">
				       <?php echo $i; ?>
				</td>
			<td width="5px" align="center" style="text-align:center;">
    			<?php 
    				echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>'IsSettled','id'=>'isSettled_'.$bill_id,'patient_id'=>$patient_id));
    			?>
    		</td>	
				<td width="74px" valign="middle" align="center" style="text-align: center;">
				
				      <?php 
				       echo $this->Form->input('sanction', array('id'=>'sanction_'.$patient_id,'autocomplete'=>'off','title'=>$result['Patient']['sanction_no'],
				      'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70px;",'class'=>'sanction_id','value'=>$result['Patient']['sanction_no'])); 
                      ?>
                </td>
                 
				<td width="65px" valign="middle" align="center" style="text-align: center;">
				      <?php echo $result['Patient']['lookup_name'];?>
				</td>
				
				<td width="64px" valign="middle" align="center" style="text-align: center;">
				      <?php echo $result['Person']['name_of_ip'];?>
				</td>
				
				<td width="55px" valign="middle" align="center" style="text-align: center;">
				      <?php echo $result['Person']['relation_to_employee'];?>
				</td>
				
				<td width="58px" valign="middle" align="center" style="text-align: center;">
				     <?php echo $this->Form->input('cardNo', array('id'=>'card_'.$patient_id,'type' => 'text','autocomplete'=>false,
                                     'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_card','value'=>$result['Patient']['card_no']));?>
				</td>
				
				<td width="64px" valign="middle" align="center" style="text-align: center;">
				     <?php echo $result['Patient']['form_received_on'];?>
				</td>
				
				<td width="70px" valign="middle" align="center" style="text-align: center;">
				  <?php
					echo $this->Form->input('bill_number', array('id'=>'bill_'.$bill_id,'autocomplete'=>'off','type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_bill_number','value'=>$result['FinalBilling']['bill_number']));   //bill no 	
			?>  
				</td>
				
				<td width="65px" valign="middle" align="center" style="text-align: center;">
				    <?php echo $result['Patient']['discharge_date'];  ?>
				</td>
				
				<td width="110px"  align="center">
                    <?php  
                    echo $this->Form->hidden('patientId',array('id'=>'patient_'.$patient_id,'class'=>'patient_id'));
                    //echo $this->Number->currency(ceil($totalAmount[$patient_id]));
                    $hospitalInvoice = $totalAmount[$patient_id];
                    //$hospitalInvoice = $result['FinalBilling']['hospital_invoice_amount'];
                    echo $this->Form->input('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'cmp_amt_paid','value'=>$hospitalInvoice)); 		
                        ?>
		</td>
		       <td width="96px"  align="center">
                        <?php echo  $this->Form->input('bank_id', array('id'=>'bank_'.$bill_id,'autocomplete'=>'off','type' => 'select','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'bank','value'=>'','empty'=>'Please select','options'=>$banks));
                                 ?>
                        </td>
		        <td width="59px" valign="middle" align="center" style="text-align: center;">
		       <?php	 
					echo  $this->Form->input('package_amount', array('id'=>'package_'.$bill_id,'autocomplete'=>'off','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>'','patient_id'=>$patient_id));
					$amntRecieved =$result['FinalBilling']['package_amount'];
				?>	
		        </td>   
		        
		        <td width="64px" valign="middle" align="center" style="text-align: center; min-width: 65px;" id="adv_<?php echo $bill_id;?>">
		        
		            <?php 
				       $advRcv = $totalPaid[$patient_id];
				       echo $this->Form->hidden('advanced_received',array('class'=>'adv_rec','id'=>"advR_".$bill_id,'value'=>$advRcv));
				       echo $advRcv;
				    ?>
		        </td>
                
		 		<td width="58px" valign="middle" align="center" style="text-align: center;">
		 		    <?php 
						// TDS	
						$tds = $amntRecieved+$tdsAmnt+$advRcv; 		// addition of Amount Recieved & Tds &  Advance Received
		 			   echo $this->Form->input('tds', array('autocomplete'=>false,'id'=>'tds_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_tds','value'=>''));
		 			   //$this->Form->input('addrcv', array('id'=>'addrcv_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'value'=>$addRecvTds));
		 			   $tdsAmnt = $result['FinalBilling']['tds']; 
		 			   
				?>
                 </td>
         
				<td width="57px" valign="middle" align="center" style="text-align: center;">
				  <table>
					<tr>
						<td>	
							<?php
							  echo $this->Form->input(' ', array('autocomplete'=>false,'id'=>'otherDeduction_'.$bill_id,'type' => 'text','label'=>false ,
							'div'=>false,'style'=>"width: 70%;",'class'=>'add_other_deduction','value'=>''));
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
							echo $this->Form->input("",array('autocomplete'=>false,"id"=>"cmp_paid_date_$patient_id",'style'=>"width: 65%;",'class'=>'textBoxExpnd cmp_paid_date','label'=>false));
						}
						?>			
			
		</td>
				<td width="56px" valign="middle" align="center" style="text-align: center;"><?php	
					//Bill Submission date
					echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));?>
			   </td>
			   
			   <td width="57px" valign="middle" align="center" style="text-align: center;">
			        <?php echo $this->Form->input('unit', array('id'=>'unit_'.$result['Person']['id'],'autocomplete'=>false,
			        	 'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 50px;", 'class'=>'unit_name','title'=>$result['Person']['unit_name'],'value'=>$result['Person']['unit_name']));
			         ?>
			   </td>
			   
                            <td width="" valign="middle" align="center"	style="text-align: center;">
                                <?php 
                                    echo $this->Html->link($this->Html->image('icons/notes_error.png',array('patient'=>$result['Patient']['id'],'onclick'=>"addRemarks($patient_id)")),'javascript:void(0);',array('escape' => false,'alt'=>"Remark",'title'=>"Click to add or view remarks"));
                                    //echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'autocomplete'=>false,'type'=>'textarea','title'=>$result['Patient']['remark'],'label'=>false,'rows'=>'1','cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));
                          ?>
			    </td>
                            
                            <td width="" valign="middle" align="center"	style="text-align: center;">
				    <?php 
				         echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'autocomplete'=>false,'type'=>'textarea','title'=>$result['Patient']['remark'],'label'=>false,'rows'=>'1','cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));
			      ?>
			    </td>
			    <td width="66px" valign="top" align="center" style="text-align: center;"><?php 
						//Bill Due Date
						if(empty($result['FinalBilling']['bill_uploading_date'])){
							echo "-";
						}else{
							$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
							echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
						}
				?></td>
				
				<td width="10px" align="center" > 
    			
				<?php echo $this->Html->link($this->Html->image('icons/saveSmall.png'), 'javascript:void(0);', 
                                     array('escape' => false,'title' => 'Save', 'alt'=>'Save','class'=>'saveForm','id'=>'save_'.$bill_id,
                                         'patient_id'=>$patient_id));
                                
                                echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 'javascript:void(0);', 
                                     array('escape' => false,'title' => 'Remove from report', 'alt'=>'Remove from report','class'=>'remove','id'=>'remove_'.$patient_id),__('Are you sure?', true));

                                if($result['PatientDocument']['filename']){
					echo $this->Html->link($this->Html->image('icons/download-excel.png'),array('controller'=>'Corporates','action' =>'downloadExcel',$result['Patient']['id'],$result['PatientDocument']['id'],'admin'=>false),
						array('escape' => false,'title' => 'Download Uploaded Excel', 'alt'=>'Download Uploaded Excel'));
				}?>
    	
    		</td>
			</tr>
		<?php  }?>
        <tr>
            <td colspan="10" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="10" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="10" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="9"></td>
        </tr>
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

 $('.add_package_amount').focus(function(){
            var id = $(this).attr('id').split("_")[1];
            if($("#bank_"+id).val()!=''){

            }else{
                alert("please select bank first");
                $(this).val('');
                $(this).focus();
                return false;
            }
        });
 /*       
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
*/
$('.cmp_amt_paid').blur(function()
{var bill = $(this).attr('id'); 
	splittedId = bill.split("_");
	
	newId = splittedId[1]; 
	var val = $(this).val(); //alert(newId);

	var patientId = $('.patient_id').attr('id');
	spliPatientId = patientId.split("_");
	newPatientId = spliPatientId[1];
	
	/*$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getBillamt", "admin" => false));?>"+"/"+newId+"/"+val+"/"+newPatientId,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
		}
	});*/
});
 
$( ".cmp_paid_date").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
});

/*
$('.add_package_amount').blur(function() {
        var bill = $(this).attr('id') ;
        splittedId = bill.split("_");
        packageId = splittedId[1];
        patientId = $(this).attr('patient_id');
        var val = $(this).val();
        if($("#bank_"+packageId).val()==''){
            alert("please select bank first");
            $(this).val('');
            $(this).focus();
            return false;
        }
        if(val!=''){
            $.ajax({
            url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false));?>"+"/"+packageId+"/"+val+"/"+patientId,

            beforeSend:function(data){
                    $('#busy-indicator').show();
                    <?php //echo $this->Html->image('/ajax-loader.gif') ?>	
            },

            success: function(data){
                                    $('#busy-indicator').hide();

                 }
            }); 
        }
      });

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
			


*/
$('.LookUpName').click(function()
		  {
		  	//alert("OK");
		  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
		  	//alert(lookup_name);
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "mpkay_report", "admin" => true));?>";
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

/*
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
        if($("#bank_"+packageId).val()==''){
        alert("please select bank first");
        $(this).val('');
        $(this).focus();
        return false;
    }
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  Id = splittedId[1];
			  var val = $(this).val();
			   
				var invoice=$('#amt_'+Id).text();//from database
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
				if(isNaN(total)){
					total=0;
				}
				//alert(total);
				
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
            */
           
  
$(".add_package_amount").keyup(function(){
    var id = $(this).attr('id').split("_")[1];
    var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
    var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
    var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
    var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');
    
    var tdsAdvOtherSum = advAmt + tdsAmt;
    var collectMoney = hospAmt - tdsAdvOtherSum;
    
    if(amtRec > collectMoney){
        alert("you could not able to collect amount more than Rs."+collectMoney); 
        $("#otherDeduction_"+id).val('');
        $(this).val('');
        $(this).focus();
        return false;
    }
    if($("#isSettled_"+id).is(':checked') == true){
        $("#otherDeduction_"+id).val(collectMoney - amtRec);
    }else{
        $("#otherDeduction_"+id).val('');
    }
});

$(".IsSettled").click(function(){
    var id = $(this).attr('id').split("_")[1];
    var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
    var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
    var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
    var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');

    var tdsAdvOtherSum = advAmt + tdsAmt;
    var collectMoney = hospAmt - tdsAdvOtherSum;
    
    if($("#isSettled_"+id).is(':checked') == true){
        if(amtRec > collectMoney){
            alert("you could not able to collect amount more than Rs."+collectMoney); 
            $("#otherDeduction_"+id).val('');
            $(this).val('');
            $(this).focus();
            return false;
        }
        $("#otherDeduction_"+id).val(collectMoney - amtRec);
    }else{
        $("#otherDeduction_"+id).val('');
    }
});

$(".add_tds").keyup(function(){
    var id = $(this).attr('id').split("_")[1];
    var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
    var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
    var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
    var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');
    var otherDeduction = parseInt($("#otherDeduction_"+id).val()!=''?$("#otherDeduction_"+id).val():'0');
    
    var tdsAdvOtherSum = advAmt + tdsAmt;
    var collectMoney = hospAmt - tdsAdvOtherSum;
    
    if((collectMoney - amtRec)>0 && $("#isSettled_"+id).is(':checked') == true){
        $("#otherDeduction_"+id).val(collectMoney - amtRec);
    }else{
        var remainAmount = (tdsAmt - otherDeduction);
        if($("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(0);
            $("#package_"+id).val((amtRec)-remainAmount);
        } 
    }
     
    if($("#isSettled_"+id).is(':checked') == false){
        var tdsAdvOtherSum = advAmt + (amtRec + otherDeduction);
        var collectMoney = hospAmt - tdsAdvOtherSum; 
        if(tdsAmt > collectMoney){
            alert("Could not able to collect tds amount more than Rs."+collectMoney); 
            $("#otherDeduction_"+id).val('');
            $(this).val('');
            $(this).focus();
            return false;
        }
    } 
});


$(".saveForm").click(function(){ 
    var patientId = $(this).attr('patient_id');
    var id = $(this).attr('id').split("_")[1];
    var bank_id = $("#bank_"+id).val();
    var total_amount = $("#amt_"+id).val();
    var tds = $("#tds_"+id).val();
    var other_deduction = $("#otherDeduction_"+id).val();
    var amount_received = $("#package_"+id).val();
    var bill_no = $("#bill_"+id).val();
    var invoice_date = $("#cmp_paid_date_"+patientId).val(); 
    var remark = $("#remark_"+patientId).val(); 
    var isSettled = ($("#isSettled_"+id).is(':checked') == true)?'1':'0';
    var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
    
    if(amount_received == ''){
        alert("please enter amount");
        return false;
    } 
    
    if(invoice_date == ''){
        alert("please select date");
        return false;
    } 
    
    $.ajax({
        type: 'POST',
        url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getAmountReceived", "admin" => false));?>"+"/"+id,
        data: 'bank_id='+bank_id+'&total_amount='+total_amount+'&advance_amount='+advAmt+'&amount='+amount_received+'&tds='+tds+'&other_deduction='+other_deduction+'&patient_id='+patientId+'&bill_no='+bill_no+'&invoice_date='+invoice_date+'&remark='+remark+'&is_setteled='+isSettled,
        beforeSend:function(data){  
            $('#busy-indicator').show();    
        },
        success: function(data){  
            var obj = jQuery.parseJSON( data );
            if(obj == 1){ 
                window.location.reload();
            }else if(obj == 2){
                $("#row_"+patientId).remove();
                $('#busy-indicator').hide();
            }else{
                alert("something went wrong, please try again..!!");
                $('#busy-indicator').hide();
            } 
        }
    }); 
});


$(".rowselected").click(function(){
    var id = $(this).attr('id').split("_")[1];
    $(".rowselected").each(function(key, value){
        $(this).removeClass('selectedRowColor');
    });
    $("#row_"+id).addClass('selectedRowColor');
});

$(".remove").click(function(){
    var patientId = $(this).attr('id').split("_")[1]; 
    $.ajax({
        url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "hideFromReportList", "admin" => false));?>"+"/"+patientId,
        beforeSend:function(data){
            $('#busy-indicator').show(); 
        }, 
        success: function(data){
            $('#busy-indicator').hide();
            $("#row_"+patientId).remove();
        }
    });
});


 $('.add_card').blur(function()
{
    var patientId = $(this).attr('id').split("_")[1] ;
    var val = $(this).val(); 
      $.ajax({
        url : "<?php echo $this->Html->url(array("controller" => 'Patients', "action" => "getCardNo", "admin" => false));?>"+"/"+patientId+"/"+val,

        beforeSend:function(data){
          $('#busy-indicator').show();
        },

        success: function(data){
              $('#busy-indicator').hide();
         }
      });
});

 $('.sanction_id').blur(function()
{
    var patientId = $(this).attr('id').split("_")[1] ;
    var val = $(this).val(); 
      $.ajax({
        url : "<?php echo $this->Html->url(array("controller" => 'Patients', "action" => "updateSanctionNo", "admin" => false));?>"+"/"+patientId+"/"+val,

        beforeSend:function(data){
          $('#busy-indicator').show();
        },

        success: function(data){
              $('#busy-indicator').hide();
         }
      });
});


function addRemarks(patientID){ 
    $.fancybox({
        'width' : '80%',
        'height' : '', 
        'autoScale': false,
        'transitionIn': 'fade',
        'transitionOut': 'fade',
        'type': 'iframe',
        'href': "<?php echo $this->Html->url(array("action" => "getRemarkForCorporateReport",'admin'=>false)); ?>"+'/'+patientID+"/MPKAY Remark"
   });
}
</Script>