<?php echo $this->Html->css(array(/*'jquery.fancybox-1.3.4.css',*/'jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array(/*'jquery.fancybox-1.3.4',*/'inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js'));
  echo $this->Html->script(array('jquery.fancybox.js' ));
	echo $this->Html->css(array('jquery.fancybox' ));
        ?>
<style>
 
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

tr .selectedRowColor  td{
    background: #C1BA7C;
}
 
textarea {
    width: 85px;
}

.tdLabel2 img{ float:none !important;}
</style>
<?php //echo $this->element("corporate_billing_report");?>
 <div class="clr">&nbsp;</div>
<div class="inner_title">
	<h3 style="float: left;">WCL Report Monthwise</h3>
     <div style="float:right;">
		<span style="float:right;">
		<?php
			echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Corporates','action'=>'wcl_report_monthwise','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get', 'style'=> 'float:left;')); 
			echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right;margin-left:10px;'));  
			echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));		
		?>
		</span>
	</div>
	<div class="clr"></div>
</div>
<div class="clr">&nbsp;</div>
<div style="float: left; padding-bottom:15px;">
	<table cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color: #b9c8ca;">
		<tr>
			<td style="color:#000;">
				<?php echo __("Patient Name : ").$this->Form->input('lookup_name', array('id'=>'lookup_name','value'=>$this->params->query['lookup_name'],
					'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'));?> 
				<span>
	    			<?php echo __("Status: ").$this->Form->input('status', array('id'=>'status','name'=>'status','type'=>'select',
	    				'empty'=>'Please Select','options'=>array(Configure::read('onDischargeStatus')),
	    					'value'=>$status,'label'=> false, 'div' => false, 'error' => false));
	    			?>
	    		</span>
	    		<span>
	    			<?php echo __("SubLocation: ").$this->Form->input('sub_location', array('id'=>'sub_location','name'=>'sub_location','type'=>'select',
	    				'empty'=>'Please Select','options'=>$subLocations,'value'=>$subLocationId,'label'=> false, 'div' => false, 'error' => false));
	    			?>
	    		</span>
	    		<?php 
				$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                                        '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
                 	for($i=2010;$i<=date('Y')+5;$i++){
            			$yearArray[$i] = $i; 
            		}
            	?>

				<span>
		    		<?php echo __("Month : ").$this->Form->input('month',array('empty'=>'Please Select','options'=>$monthArray,
                                                        'class'=>' ','div' => false, 'error' => false,'label'=>false,'default'=>date('m'))); ?>
		    	</span>
		    	<span>
		    		<?php echo __("Year: ").$this->Form->input('year',array('empty'=>'Please Select','options'=>$yearArray,
                                                        'class'=>' ','div' => false, 'error' => false,'label'=>false,'default'=>date('Y')));?>
		    	</span>
				<span id="look_up_name" class="LookUpName"> 
					<?php echo $this->Form->submit(__('Search'),array('style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false));?>
				</span>
				<span>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'admin_wcl_report'),
							array('escape'=>false, 'title' => 'refresh'));
						echo $this->Form->end();
					?>
				</span>
			</td>
		</tr>
	</table>
</div>
<div class="clr">&nbsp;</div>
<div id="container">                
<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px; overflow: scroll;">
	<tr>
        <th width="5px"  align="center" style="text-align:center;">No.</th>
        <th width="5px"  align="center" style="text-align:center;">Set</th>
		<th width="120px"  align="center" style="text-align:center;">Name Of Patient</th>
		<th width="100px"  align="center" style="text-align:center;">Name Of Employee<br />(rank)</th>
		<th width="70px"  align="center" style="text-align:center;">Relation with Employee</th>
		<th width="70px"  align="center" style="text-align: center;">Date of Addmision</th>
		<th width="70px"  align="center" style="text-align: center;">Sub Location</th>
		<th width="100px"  align="center" style="text-align: center;">Bill NO</th>
		<th width="70px"  align="center" style="text-align: center;">Date of Discharge</th>
		<th width="80px"  align="center" style="text-align: center;">Hospital Invoice Amt</th>
		<th width="70px" align="center" style="text-align: center;">Bank</th>
        <th width="70px" align="center" style="text-align: center;">Amt Received</th>
		<th width="80px"  align="center" style="text-align: center;">Advance Received</th>
		<th width="60px"  align="center" style="text-align: center;">TDS</th>
		<th width="60px"  align="center" style="text-align: center;">Other Deduction</th>
		<th width="80px" valign="top" align="center" style="text-align:center;">Amount Received Date</th>
		<th width="70px"  align="center"  style="text-align: center;">Bill Submission</th>
		<th width="70px" align="center" style="text-align:center;">Overdue<br />(days)</th>
		<th width="50px"  align="center"  style="text-align: center;">Mul Remark</th>
        <th width="100px"  align="center"  style="text-align: center;">Remark</th>
		<th width="70px"  align="center"  style="text-align: center;">Bill Due <br />Date</th>
		<th width="30px" valign="center" align="center"style="text-align: center; min-width: 21px;">#</th>
		
	</tr>
	<?php 
	 if($results){
		$i=0; 
		$advRecevied=0;
		$tdsAmnt=0;
		foreach($results as $result){
			$i++;
			$bill_id= $result['FinalBilling']['id'];
			$patient_id = $result['Patient']['id']; 
			
			//holds the id of patient
	 ?>
        <tr id="row_<?php echo $patient_id; ?>" class="rowselected">
    		<td width="5px" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
                <td width="5px" align="center" style="text-align:center;">
    			<?php 
    				echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>'IsSettled','id'=>'isSettled_'.$bill_id,'patient_id'=>$patient_id));
    			?>
    		</td> 
                <td width="97px"  align="center" style="text-align:center;">
				<?php 
					echo $result['Patient']['patient_id'];     //Patient name
			     	echo $result['Patient']['lookup_name']; 
			     	?>
		    </td>
		    
			<td width="149px"  align="center"	style="text-align:center;">
			     	<?php echo $result['Patient']['name_of_ip'];  
			       ?>
		     </td>
			     	
		    <td width="144px"  align="center"	style="text-align:center;">
			     	<?php 
			     			echo $result['Patient']['relation_to_employee']."<br>";  ?>
	          </td>
	    
			<td width="91px"  align="center"  style="text-align: center;">
				<?php
			   		 echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission?>
	   </td>
	   <td width="91px"  align="center"  style="text-align: center;">
				<?php
			   		 echo $subLocations[$result['Patient']['corporate_sublocation_id']];?>
	   </td>
	   
		<td width="461px"  align="center" >
			<?php
					echo $this->Form->input('bill_number', array('id'=>'bill_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_bill_number','value'=>$result['FinalBilling']['bill_number']));   //bill no 	
			?>
	    </td>
			     	
		<td width="72px"  align="center">
				<?php 	
					echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge
				?>
	    </td>
	    
		<td width="110px"  align="center">
                    <?php  
                    echo $this->Form->hidden('patientId',array('id'=>'patient_'.$patient_id,'class'=>'patient_id'));
                    //echo $this->Number->currency(ceil($totalAmount[$patient_id]));
                    $hospitalInvoice = $totalAmount[$patient_id];
                    //$hospitalInvoice = $result['FinalBilling']['hospital_invoice_amount'];
                    echo $this->Form->input('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'readonly'=>'readonly','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'cmp_amt_paid','value'=>$hospitalInvoice)); 		
                        ?>
		</td>
		
                <td width="96px"  align="center">
	     	<?php echo  $this->Form->input('bank_id', array('id'=>'bank_'.$bill_id,'type' => 'select','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'bank','value'=>'','empty'=>'Please select','options'=>$banks));
					 
				
			 ?>
		</td>
                
		 <td width="96px"  align="center">
	     	<?php echo  $this->Form->input('package_amount', array('id'=>'package_'.$bill_id,'type' => 'text','autocomplete'=>'off','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>$result['FinalBilling']['package_amount'],'patient_id'=>$patient_id));
					$amntRecieved =$result['FinalBilling']['package_amount'];  // Amount received
				
			 ?>
		</td>
		<td width="104px" >
		    <?php
				$advRecevied = $totalPaid[$patient_id];
				echo $this->Form->hidden('advanced_received',array('class'=>'adv_rec','id'=>"advR_".$bill_id,'value'=>$advRecevied));
				echo $this->Number->currency(ceil($advRecevied));          //advance recevied
			  ?>           
	    </td>
	   
		<td width="183px" align="center" style="text-align: center;">
		    <?php                            // TDS
                        echo $this->Form->input('tds', array('id'=>'tds_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'autocomplete'=>false,'style'=>"width:48px;",'class'=>'add_tds','value'=>''));
                                $tdsAmnt=$result['FinalBilling']['tds'];
                    ?>
		</td>
		<td width="250px"  align="center" style="text-align: center;">
			<table>
					<tr>
						<td>	
							<?php
							  echo $this->Form->input(' ', array('id'=>'otherDeduction_'.$bill_id,'type' => 'text','label'=>false ,'readonly'=>true,
							'div'=>false,'style'=>"width:48px;",'class'=>'add_other_deduction','value'=>$result['FinalBilling']['other_deduction']));
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
							echo $this->Form->input("cmp_paid_date_$patient_id",array('style'=>"width: 65%;",'autocomplete'=>'off','class'=>'textBoxExpnd cmp_paid_date','label'=>false,'value'=>$result['FinalBilling']['cmp_paid_date']));
						}
						?>			
			
		</td>
		
	   <td width="89px"  align="center" style="text-align: center;">   
	      <?php 
	          echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format')); ?>
	   </td>
	   
	   <td width="108px"  align="center" style="text-align: center;">     
		<?php 	$curnt_date = '';
				$discharge_date=explode(' ',$result['Patient']['discharge_date']);
				$diff =$this->General->getDateDifference(trim($discharge_date[0]),date("Y-m-d"));				
	      		echo ($diff);
	     ?>
		</td>
		<td width="" align="center" style="text-align: center;">
			<?php
                        echo $this->Html->link($this->Html->image('icons/notes_error.png',array('patient'=>$result['Patient']['id'],'onclick'=>"addRemarks($patient_id)")),'javascript:void(0);',array('escape' => false,'alt'=>"Remark",'title'=>"Click to add or view remarks"));
                        //echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));
			?>
		</td>
                
        <td align="center" style="text-align: center;">
			<?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1',
					'cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));?>
		</td>
        <td width="118px" align="center" style="text-align: center;">  
			<?php 
				if(empty($result['FinalBilling']['bill_uploading_date'])){
					echo "-";
				}else{
				 	$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
					echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));   //Bill Due date
				}
			?>
		</td>
		<td width="30" align="center"style="text-align: center; min-width: 21px;">
			<table>
				<tr>
					<td style="padding: 0px;">
						<?php 
							echo $this->Html->link($this->Html->image('icons/saveSmall.png'), 'javascript:void(0);',array('escape'=>false,'title'=>'Save',
								'alt'=>'Save','class'=>'saveForm','id'=>'save_'.$bill_id,'patient_id'=>$patient_id));
							echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 'javascript:void(0);',array('escape'=>false,
								'title'=>'Remove from report','alt'=>'Remove from report','class'=>'remove','id'=>'remove_'.$patient_id),__('Are you sure?', true));
							echo "</td>";
							if($result['PatientDocument']['filename']){
								echo "<td>";
								echo $this->Html->link($this->Html->image('icons/download-excel.png'),array('controller'=>'Corporates',
									'action'=>'downloadExcel',$result['Patient']['id'],$result['PatientDocument']['id'],'admin'=>false),
									array('escape' => false,'title' => 'Download Uploaded Excel', 'alt'=>'Download Uploaded Excel'));
								echo "</td>";
							}
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }  ?>
        <tr>
            <td colspan="8" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="8" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="8" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="2"></td>
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="9"></td>
        </tr>
        <?php } ?>
</table>
</div>
<table align="center">
		<tr>
			<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
			<TD colspan="9" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</TD>
		</tr>
	</table>
<?php 

		function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
		{
			$date = $cur_date;
			$date = strtotime($date);
			$date = strtotime("+$no_days day", $date);
			return date('Y-m-d', $date);
		}
	
?>

<Script>
$(function() {
	var $sidebar   = $(".top-header"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 0;

   /* $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            //$sidebar.stop().animate({
             //   top: $window.scrollTop() - offset.top + topPadding
           // });

            $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
        } else {
            $sidebar.stop().animate({
                top: 0
            });
        }
    });*/
});
	
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

/*$('.add_bill_number').blur(function()
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
});*/

/*$('.add_package_amount').blur(function()
{
        var bill = $(this).attr('id') ;
        splittedId = bill.split("_");
        packageId = splittedId[1];
        patientID = $(this).attr('patient_id');
        var val = $(this).val();
        if($("#bank_"+packageId).val()==''){
            alert("please select bank first");
            $(this).val('');
            $(this).focus();
            return false;
       }
        if(val!=''){ 
            $.ajax({
            url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false));?>"+"/"+packageId+"/"+val+"/"+patientID,
            beforeSend:function(data){
                $('#busy-indicator').show(); 
            }, 
            success: function(data){
                $('#busy-indicator').hide();
            }
            });
        }
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


$('.LookUpName').click(function(){ 
        var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;

                var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "bsnl_report", "admin" => true));?>";
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

$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
		{
				width: 80,
				selectFirst: true
		});

		$( ".bill_uploading_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			onSelect:function(date){
				var idd = $(this).attr('id');
				 splittedId=idd.split('_');
				 var newId = splittedId[3];
				 
				$.ajax({
					type:'POST',
		   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billUploadDate", "admin" => false));?>"+"/"+newId,
		   			data:'id='+newId+"&date="+date,
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


		
		/*$('.add_remark').blur(function() {
			  var patient = $(this).attr('id') ;
			  splittedId = patient.split("_");
			  newId = splittedId[1];
			  //alert(newId);
			  var val = $(this).val();
			  //alert(val);
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
		});*/
		
		$("#fromDate").datepicker
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
				
		 $("#toDate").datepicker
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
/*		
$('.add_tds').blur(function(){
	  var bill = $(this).attr('id') ;
	  splittedId = bill.split("_");
	  tdsId = splittedId[1];
	   var val = $(this).val();
	   var subtract= parseInt($('#amt_'+splittedId[1]).val()); 	// Hospital Amount Recieved 192
		var adv_rcd =parseInt($('#advR_'+splittedId[1]).val()); 	// Advance Recieved coming from database 50
		var tds = ($('#tds_'+splittedId[1]).val() != '') ? parseInt($('#tds_'+splittedId[1]).val()) : 0; 		// TDS amount  0
		var amtRec = parseInt($('#package_'+splittedId[1]).val()); 	// Amount Recieved from CGHS  
		if(isNaN(subtract)){
			subtract=0;
			}
		if(isNaN(amtRec)){
			amtRec=0;
			}
		if(isNaN(adv_rcd)){
			adv_rcd=0;
			}
		if(isNaN(tds)){
			tds=0;
			}
		if(isNaN(val)){
			val=0;
			}
		var totalAmnt = parseInt(subtract) -(parseInt(amtRec)+parseInt(adv_rcd)+parseInt(tds));
		if(isNaN(totalAmnt)){
			totalAmnt=0;
		}
		$('#tds_'+splittedId[1]).val(tds);
		$('#otherDeduction_'+splittedId[1]).val(totalAmnt);
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "updatePackageAmount", "admin" => false));?>"+'/'+splittedId[1],
		type: 'POST',
		data : '&tds='+val+'&package_amount='+amtRec+'&other_deduction='+totalAmnt,
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
		}
	});
});



$('.add_other_deduction').keyup(function(){
	  var bill = $(this).attr('id') ;
	  splittedId = bill.split("_");
	  OtherDeductionId = splittedId[1];
	  var val = $(this).val();
	  var flag = 1;
	
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getModifiedOtherDeduction", "admin" => false));?>"+"/"+flag+"/"+val+"/"+OtherDeductionId,
	
		beforeSend:function(data){
		$('#busy-indicator').show();
				
		},
		success: function(data){ 
			var bullet = '<?php echo $this->Html->image("icons/test-fail-icon.png.png");?>';
			$("#flag_"+splittedId[1]).show();
			$('#busy-indicator').hide();
		}
	});
});*/

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


function addRemarks(patientID){ 
    $.fancybox({
        'width' : '80%',
        'height' : '', 
        'autoScale': false,
        'transitionIn': 'fade',
        'transitionOut': 'fade',
        'type': 'iframe',
        'href': "<?php echo $this->Html->url(array("action" => "getRemarkForCorporateReport",'admin'=>false)); ?>"+'/'+patientID+'/WCL Remark'
   });
}
</script>