<?php 
    echo $this->Html->css(array(/*'jquery.fancybox-1.3.4.css',*/'jquery.autocomplete.css','colResizable.css'));  
    echo $this->Html->script(array(/*'jquery.fancybox-1.3.4',*/'inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js'));  
     echo $this->Html->script(array('jquery.fancybox.js' ));
	echo $this->Html->css(array('jquery.fancybox' ));
?> 
<style> 
textarea 
{
	width: 60px;
}

.tabularForm th {
   
    padding: 5px 0px;
   
}
tr .selectedRowColor  td{
    background: #C1BA7C;
}

.inner_title span{margin:0px !important; float:none;}
.tdLabel2 img{ float:none !important;}
</style>
<?php  echo $this->element('corporate_billing_report');?>
<div class="inner_title">
	<h3 style="float: left;">ECHS Report</h3>
<div style="float:right;">
				<span style="float:right;">
					<?php
					echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Corporates','action'=>'echs_report','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get', 'style'=> 'float:left;')); 
				        echo $this->Html->link('Back',array("controller"=>'reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
				 echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));		
					?>
				</span>
	
			</div>

	<div class="clr"></div>
	<div style="float: left;padding-top:20px;">
		<table width="" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color: #b9c8ca;">
			<tr>
				<td style="color: #000;"><?php
				echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'], 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'))."&nbsp;&nbsp;"
				?> <span><?php
                echo __("From : ").$this->Form->input('EchsReport.from', array('id'=>'from','value'=>$this->request->query['from'],'label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
				</span> <span><?php 
                echo __("To : ").$this->Form->input('EchsReport.to', array('id'=>'to','value'=>$this->request->query['to'],'label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
				</span> <span id="look_up_name" class="LookUpName"> <?php 
							echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false)); ?>
				</span> <span><?php 
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array()),array('controller'=>'Corporates','action'=>'echs_report','admin'=>true),
		        array('escape' => false,'title'=>'Back to List'));
				echo $this->Form->end();		?> </span>
				</td>
			</tr>
		</table>
	</div>

</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row"
	style="top:0px;" overflow: scroll;">
    <tr>
    	<thead>
			<th width="21px" valign="top" align="center" style="text-align:center;">#</th>
	        <th width="5px"  align="center" style="text-align:center;">Set</th>
			<th width="81px" valign="top" align="center" style="text-align:center;">Patient Name</th>
			<th width="83px" valign="top" align="center" style="text-align: center;">Name Of Employee (rank)</th>
			<th width="83px" valign="top" align="center" style="text-align:center;">Relation with Emp. </th>
			<th width="87px"  valign="top" align="center" style="text-align:center;">ECHS Card No</th>
			<th width="82px" valign="top" align="center" style="text-align:center;">Admission<br>Date</th>
			<th width="85px" valign="top" align="center" style="text-align:center;">Bill No.</th>
			<th width="80px" valign="top" align="center" style="text-align:center;">Discharge<br>Date</th>
			<th width="76px" valign="top" align="center" style="text-align:center;">Hospital Invoice Amt</th>
	        <th width="70px" valign="top" align="center" style="text-align:center;">Bank</th>
			<th width="90px"  valign="top" align="center" style="text-align:center;">Amt Received</th>
			<th width="70px" valign="top" align="center" style="text-align:center;">Adv Received</th>
	        <th width="70px" valign="top" align="center" style="text-align:center;">TDS</th>
			<th width="77px" valign="top" align="center" style="text-align:center;">Other<br>Deduction</th>
			<th width="80px" valign="top" align="center" style="text-align:center;">Amount Received Date</th>
			<th width="80px" valign="top" align="center" style="text-align:center;">Bill Submission Date</th>
			<th width="50px"  valign="top" align="center" style="text-align:center;">Mul Remark</th>
	        <th width="100px"  valign="top" align="center" style="text-align:center;">Remark</th>
			<th width="81px" valign="top" align="center" style="text-align:center;">Bill Due Date</th>
			<th width="21px" valign="top" align="center" style="text-align:center;">Action</th>
	   		</thead>
      	</tr>
    
    <?php  $i=0; 
    	foreach($results as $result){	
    	  	$patient_id = $result['Patient']['id'];
    	  	$bill_id = $result['FinalBilling']['id'];
    	  	$i++;
    ?>
    	<tr id="row_<?php echo $patient_id; ?>" class="rowselected">
    		<td width="8px" valign="top" align="right" style="text-align:center;">
    			<?php 
    				echo $i;
                    echo $this->Form->hidden('',array('value'=>$patient_id,'class'=>'patientID','id'=>'patientID_'.$bill_id));
    			?>
    		</td>
            <td width="5px" align="center" style="text-align:center;">
    			<?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>'IsSettled',
    				'id'=>'isSettled_'.$bill_id,'patient_id'=>$patient_id));?>
    		</td>
	    	<td width="81px" style="text-align:right;">
				<?php echo $result['Patient']['lookup_name'];?>
			</td>
			
			<td width="83px" style="text-align:right;">
				<?php echo $result['Patient']['relative_name'];?>
			</td>
			
			<td width="83px" style="text-align:right;">
				<?php echo $result['Person']['relation_to_employee'];?>
			</td>
			
			<td width="87px" style="text-align:center;">
                <?php echo $this->Form->input('cardNo', array('id'=>'card_'.$patient_id,'type' => 'text','label'=>false ,
                		'div'=>false,'style'=>"width: 70%;",'class'=>'add_card','value'=>$result['Patient']['card_no']));?>
			</td>
			
			<td width="83px">
				<?php echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'], Configure::read('date_format'));// Admission Date?> 
			</td>
			
			<td width="84px">
				<?php echo $this->Form->input('bill_number', array('id'=>'bill_'.$bill_id,'autocomplete'=>'off','type'=>'text',
						'style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_bill_number',
						'value'=>$result['FinalBilling']['bill_number'])); // Bill No	
				?>
			</td>
			
			<td width="78px">
				<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'], Configure::read('date_format'));// Discharge Date?>
			</td>
			
			<td width="110px" align="center">
                <?php echo $this->Form->hidden('patientId',array('id'=>'patient_'.$patient_id,'class'=>'patient_id'));
                    echo $this->Form->input('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'readonly'=>'readonly','type'=>'text','label'=>false,
						'div'=>false,'style'=>"width: 100%;",'class'=>'cmp_amt_paid','value'=>$totalAmount[$patient_id])); 		
                 ?>
			</td>
                
			<td width="90px">
            	<?php echo $this->Form->input('bank', array('id'=>'bank_'.$bill_id,'autocomplete'=>'off','type'=>'select','label'=>false,
            			'div'=>false,'style'=>"width: 70%;",'class'=>'bank','empty'=>'Please Select','options'=>$banks)); ?>	
       		</td>
       		
			<td width="90px">
				<?php echo $this->Form->input('package_amount', array('autocomplete'=>'off','id'=>'package_'.$bill_id,'type' =>'text','label'=>false,
				 		'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>'','patient_id'=>$patient_id));?>	
			</td>
			
			<td width="90px" align="center"style="text-align: center;">
				<?php
				echo $this->Form->hidden('advanced_received',array('class'=>'adv_rec','id'=>"advR_".$bill_id,'value'=>$totalPaid[$patient_id]));
				echo $this->Number->currency(ceil($totalPaid[$patient_id])); 
				?>
			  </td>
                
			<td width="76px">
				<?php echo $this->Form->input('tds', array('id'=>'tds_'.$bill_id,'autocomplete'=>'off','type' => 'text','label'=>false ,
						'div'=>false,'style'=>"width: 80%;",'class'=>'add_tds','value'=>''));
				?>
			</td>
			
			<td width="100px">
				<table>
					<tr>
						<td>	
							<?php echo $this->Form->input('', array('autocomplete'=>'off','id'=>'otherDeduction_'.$bill_id,'type' =>'text',
									'label'=>false ,'div'=>false,'style'=>"width: 130%;",'class'=>'add_other_deduction','value'=>''));?>
		 				</td>
					 		<?php $display = ($result['FinalBilling']['other_deduction_modified']==1) ? 'block' : 'none';?>
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
					if(isset($result['FinalBilling']['cmp_paid_date'])){
						$date= $result['FinalBilling']['cmp_paid_date'];
						echo $this->DateFormat->formatDate2Local($date,Configure::read('date_format'));
					}else{
						echo $this->Form->hidden('',array('value'=>$bill_id,'id'=>'bill_'.$patient_id));
						echo $this->Form->input("cmp_paid_date_$patient_id",array('autocomplete'=>false,'style'=>"width: 65%;",
							'class'=>'textBoxExpnd cmp_paid_date','label'=>false,'value'=>$result['FinalBilling']['cmp_paid_date']));
					}
				?>			
			</td>
			<td width="81px" style="text-align:center;">
				<?php echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));?>	
			</td>
			
			<td width="10px" style="text-align:center;">
                <?php echo $this->Html->link($this->Html->image('icons/notes_error.png',array('patient'=>$result['Patient']['id'],
                'onclick'=>"addRemarks($patient_id)")),'javascript:void(0);',array('escape' => false,'alt'=>"Remark",'title'=>"Click to add or view remarks"));?>	
			</td>
                        
            <td style="text-align:center;">
                <?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'autocomplete'=>'off','type'=>'textarea',
                		'label'=>false,'rows'=>'1','cols'=>'2','class'=>'add_remark','value'=>$result['Patient']['remark'])); ?>	
			</td>
			
			<td width="80px" style="text-align:center;">
                <?php 
                    if(empty($result['FinalBilling']['bill_uploading_date'])){
                        echo "-";
                    }else{
                        $bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
                        echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
                    }
                 ?>
			</td>
			
			 <td width="10px" align="center">
			 <?php echo $this->Html->link($this->Html->image('icons/saveSmall.png'), 'javascript:void(0);', 
                      array('escape'=>false,'title'=>'Save','alt'=>'Save','class'=>'saveForm','id'=>'save_'.$bill_id,'patient_id'=>$patient_id));
                   
                  echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 'javascript:void(0);', 
                     array('escape' => false,'title' => 'Remove from report', 'alt'=>'Remove from report','class'=>'remove',
					'id'=>'remove_'.$patient_id),__('Are you sure?', true));

                if($result['PatientDocument']['filename']){
					echo $this->Html->link($this->Html->image('icons/download-excel.png'),array('controller'=>'Corporates','action' =>'downloadExcel',
						$result['Patient']['id'],$result['PatientDocument']['id'],'admin'=>false), 
						array('escape' => false,'title' => 'Download Uploaded Excel', 'alt'=>'Download Uploaded Excel'));
    	  		}?> 
    		</td>
		</tr>
    	 
    <?php } ?>	
        <tr>
            <td colspan="9" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="9" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="9" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="8"></td>
        </tr>
    </table>
	<table align="center">
		<tr>
			<?php //  $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
 			?>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			</TD>
		</tr>
	</table>



<!--******************************************* table closed ************************************************************************************-->
<?php 

function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
{
	$date = $cur_date;
	$date = strtotime($date);
	$date = strtotime("+$no_days day", $date);
	return date('Y-m-d', $date);
}


?>
<!--******************************************* functions closed ************************************************************************************-->

<Script>
jQuery(document).ready(function() {
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
 

$(function() {

    var $sidebar   = $(".top-header"), 
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 0;

    /*$window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
             

            $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
        } else {
            $sidebar.stop().animate({
                top: 0
            });
        }
    });*/
    
});

/*
$('.add_package_amount').blur(function()
{
    var bill = $(this).attr('id') ;
    splittedId = bill.split("_");
    packageId = splittedId[1];
    patientID = $(this).attr('patient_id');
    if($("#bank_"+packageId).val()==''){ 
      alert("please select bank first");
      $(this).val('');
      $(this).focus();
      return false;
  }
    var val = $(this).val();
    //alert(val);

  $.ajax({
  url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false));?>"+"/"+packageId+"/"+val+"/"+patientID,

  beforeSend:function(data){
          $('#busy-indicator').show();
          <?php //echo $this->Html->image('/ajax-loader.gif') ?>	
  },

  success: function(data){
                          $('#busy-indicator').hide();
       }
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
        
        
$('.add_remark').blur(function()
		  {
			  var patient = $(this).attr('id') ;
			  splittedId = patient.split("_");
			  newId = splittedId[1];
			  //alert(newId);
			  var val = $(this).val();
			  //alert(val);

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "getRemark", "admin" => false));?>"+"/"+newId+"/"+val,
			
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
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "echs_report", "admin" => true));?>";
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
$('.add_other_deduction').blur(function(){
	  var bill = $(this).attr('id') ;
	  splittedId = bill.split("_");
	  OtherDeductionId = splittedId[1];
	  var val = $(this).val();
	  var flag  = 1;

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
			

$( ".bill_uploading_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		var idd = $(this).attr('id');
		 splittedId=idd.split('_');
		 var billDueId = splittedId[3];
		 
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billDueDate", "admin" => false));?>"+"/"+billDueId,
   			data:'id='+billDueId+"&date="+date,
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

$('.add_tds').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  tdsId = splittedId[1];
			  //alert(tdsId);
			  var val = $(this).val();
			  //alert(val);
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getTds", "admin" => false));?>"+"/"+tdsId+"/"+val,
			
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

*/
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
/*
$('.add_tds, .add_package_amount,.adv_rec').blur(function()
		  {
			  var id = $(this).attr('id') ;
			  
			  splitedvar=id.split("_");
				ID = splitedvar[1];
                                
                        if($("#bank_"+ID).val()==''){ 
                            alert("please select bank first");
                            $(this).val('');
                            $(this).focus();
                            return false;
                        }
                        
			   var val = $(this).val();
				var invoice=$('#amt_'+ID).val(); 											// Hospital Amount
				var tds=($('#tds_'+ID).val() != '' ) ? parseInt($('#tds_'+ID).val()): 0; 	// if null it will display tds 0
				var packAmout = parseInt($('#package_'+ID).val());
				if(isNaN(invoice)){
					invoice=0;
				}
				if(isNaN(tds)){
					tds=0;
				}
				if(isNaN(packAmout)){
					packAmout=0;
				}	
				// Amount Recieved
				var add = tds+packAmout;	
				var total=parseInt(invoice)-add;
				$('#tds'+splitedvar[1]).val(tds);
				//alert(total);
				if(isNaN(total)){
					total=0;
				}
                        if(val!='' && val!='0'){
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getTds", "admin" => false));?>"+"/"+ID+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){ 
						$('#busy-indicator').hide();
						$('#otherDeduction_'+splitedvar[1]).val(total);

						$.ajax({
							url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getOtherDeduction", "admin" => false));?>"+"/"+ID+"/"+total
							});	
			     }
			}); 
			}
                        }
			);
});

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
 
function addRemarks(patientID){ 
    $.fancybox({
        'width' : '80%',
        'height' : '', 
        'autoScale': false,
        'transitionIn': 'fade',
        'transitionOut': 'fade',
        'type': 'iframe',
        'href': "<?php echo $this->Html->url(array("action" => "getRemarkForCorporateReport",'admin'=>false)); ?>"+'/'+patientID+"/ECHS Remark"
   });
}
</script>